<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Prochart;
use app\home\model\Process;
use app\home\model\Upfile;
use app\home\model\Tapply;

class Teapply extends Base
{
    /**
     * @Description: 判断是不是教师权限
     * @DateTime:    2018/11/27 10:36
     * @Author:      fyd
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 显示界面
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
     */
    public function show(){
        $this->isTeacher();

        /********************************************************************/
        $proc = new Prochart();
        $proname = "题目申报";
        $res = $proc->doCheck($proname);
        if(!$res){
            $this->error("当前时间不可以进行".$proname."操作","../flow");
        }
        /********************************************************************/

        $teapply = new Tapply();
        $profess = $teapply->showProfess();
        $year = getSenior();
        $years = [
            $year-1,$year-2,$year-3,$year-4,$year-5
        ];
        $nature = $teapply->getNature();
        $source = $teapply->getSource();
        $this->assign('profess',$profess);
        $this->assign('nature',$nature);
        $this->assign('source',$source);
        $this->assign('years',$years);
        return $this->fetch('Tapply/showApply');
    }

    /**
     * @Description: 显示该教师已经申请过的内容
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
     */
    public function index(){
        $this->isTeacher();
        $teapply = new Tapply();
        $id = session('uid');
        $xq = getSenior();
        $titlenum = $teapply->getTitleNum($id);  //允许的个数
        $appliedNum = $teapply->getAppliedNum($id,$xq);  //已经提交申请的数目
        $leftNum = $titlenum-$appliedNum;
        $page=input('page');
        $limit=input('limit');
        $list = $teapply->show($id,$xq,$page,$limit);
        $count=count($list);
        for($i=0;$i<$count;$i++){
            $list[$i]['kid']=$i+1;
        }

        if($count){
            echo echoJson(0,"获取成功",$appliedNum,$list,$titlenum,$leftNum);
        }else{
            echo echoJson(1,"获取失败",$appliedNum,$list,$titlenum,$leftNum);
        }
    }

    /**
     * @Description: 获取往年题目信息
     * @DateTime:    2018/12/14 20:18
     * @Author:      fyd
     */
    public function told(){
        $this->isTeacher();
        $teapply = new Tapply();
        $id = session('uid');
        if(isset($_POST['year'])){
            $year = $_POST['year'];
        }else{
            $year = getSenior()-1;
        }
        $page=input('page');
        $limit=input('limit');
        $count = $teapply->getOldNum($id,$year);
        $list = $teapply->showOld($id,$page,$limit,$year);
        for($i=0;$i<$count;$i++){
            $list[$i]['kid']=$i+1;
        }

        if($count){
            echo echoJson(0,"获取成功",$count,$list);
        }else{
            echo echoJson(1,"获取失败",$count,$list);
        }
    }



    /**
     * @Description: 添加数据
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
     */
    public function add(){
        $this->isTeacher();
        $teapply = new Tapply();
        $teaid = session('uid');
        $xq = getSenior();
        $titlenum = $teapply->getTitleNum($teaid);  //允许的个数
        $appliedNum = $teapply->getAppliedNum($teaid,$xq);  //已经提交申请的数目
        if($titlenum<=$appliedNum){
            falsePro(3,"您已经没有剩余名额了！");
            exit;
        }
        $data = [
            'title'         =>  $_POST['title'],
            'nature'        =>  $_POST['nature'],
            'source'        =>  $_POST['source'],
            'isnew'         =>  $_POST['isnew'],
            'isprac'        =>  $_POST['isprac'],
            'teaid'         =>  $teaid,
            'proid'         =>  $_POST['proid'],
            'belongsenior'  =>  getSenior()
        ];

        $res = $teapply->add($data);
        if($res == 1){
            falsePro(0,"添加成功");
        }elseif($res==2){
            falsePro(2,"题目重复");
        }elseif($res==3){
            falsePro(2,"信息不得为空！");
        }else{
            falsePro(1,"添加失败");
        }

    }

    /**
     * @Description: 删除数据
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function del(){
        $this->isTeacher();
        $teapply = new Tapply();
        $id = $_POST['id'];
        $res = $teapply->del($id);
        if($res==1){
            falsePro(0,"删除成功");
        }elseif($res==2){
            falsePro(2,"已经通过申请，不可删除");
        }elseif($res==3){
            falsePro(3,"id不存在");
        }else{
            falsePro(1,"删除失败");
        }
    }

    /**
     * @Description: 修改申请信息
     * @DateTime:    2018/11/27 10:38
     * @Author:      fyd
     */
    public function edit(){
        $this->isTeacher();
        $id = $_POST['id'];
        $data = [
            'title'     =>  $_POST['title'],
            'nature'    =>  $_POST['nature'],
            'source'    =>  $_POST['source'],
            'isnew'     =>  $_POST['isnew'],
            'isprac'    =>  $_POST['isprac'],
            'proid'     =>  $_POST['proid']
        ];
        $xq = getSenior();
        $teapply = new Tapply();
        $res = $teapply->edit($id,$data,$xq);
        if($res == 1){
            falsePro(0,"修改成功");
        }elseif($res == 2){
            falsePro(2,"题目出现重复");
        }elseif($res==3){
            falsePro(3,"已经通过申请，不可以再修改");
        }else{
            falsePro(1,"修改失败");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 显示教师确认学生界面
     * @DateTime:    2018/11/29 21:50
     * @Author:      fyd
     */
    public function showSelectStu(){
        $this->isTeacher();

        /********************************************************************/
        $proc = new Prochart();
        $proname = "老师选学生";
        $res = $proc->doCheck($proname);
        if(!$res){
            $this->error("当前时间不可以进行".$proname."操作","../flow");
        }
        /********************************************************************/
        return $this->fetch("Tapply/showSelectStu");
    }

    /**
     * @Description: 教师选择学生
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function selectStu(){
        $this->isTeacher();
        $ta = new Tapply();
        $teaid = session('uid');
        $xq = getSenior();
        $page=input('page');
        $limit=input('limit');
        $list = $ta->showSelectStu($teaid,$xq,$page,$limit);
        for($i=0;$i<count($list);$i++){
            $list[$i]['kid']=$i+1;
        }
        $count = $ta->selectStuCount($teaid,$xq);
        if($count){
            echo echoJson(0,"获取成功",$count,$list);
        }else{
            echo echoJson(1,"获取失败",$count,$list);
        }
    }

    /**
     * @Description: 选择学生,需要对应的id
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function chooseTitle(){
        $this->isTeacher();

        $ta = new Tapply();
        $id = $_POST['id'];
//        $id = 1;
        $res = $ta->chooseTitle($id);

        switch ($res){
            case 2:
                falsePro(2,"这一项已经通过申请！");
                break;
            case 1:
                falsePro(0,"确认成功");
                break;
            case 0:
                falsePro(1,"确认失败");
                break;
            default:
                falsePro(3,"未知错误");
                break;
        }
    }

    /******************************************************************************************************************/
    /**
     * @Description: 对于上传任务书的处理
     * @DateTime:    2018/12/16 11:29
     * @Author:      fyd
     */
    public function upassign(){
        $file = request()->file('file');
        $typeid = 1;
        $typename = "rws";
        $year = getSenior(); //获取学年
        $filename = $_FILES["file"]["name"]; //获取文件名
        $ext = getExt($filename); //获取文件后缀
        $processid = $_POST['id'];// 获取对应的过程id
        //根据过程id获取学号、姓名和课题名称
        $process = new Process();
        $processInfo = $process->getProcessInfo($processid);
        $stuidcard = $processInfo["stuidcard"];
        $stuname = $processInfo["stuname"];
        $title = $processInfo["title"];
        //上传到移动到指定目录下
        if($file){
            $path = "." . DS . "upload". DS . $typename . DS . $year;
            $insertpath = "public" . DS . "upload". DS . $typename . DS . $year;
            //必须转为gbk格式才可以
            $cupname = $stuidcard."+".$stuname."+".$title."-任务书";
            $upname = iconv("UTF-8","gbk",$cupname);
            $validate["ext"] = "doc,docx,pdf";
            $info = $file
                ->validate($validate)
                ->move($path,$upname);
            if($info){
                // 进行数据库插入操作
                $data = [
                    "filename"      =>      $cupname,
                    "filepath"      =>      $insertpath,
                    "fileext"       =>      $ext,
                    "belongsenior"  =>      getSenior(),
                    "processid"     =>      $processid,
                    "type"          =>      $typeid
                ];
                $up = new Upfile();
                $res = $up->addassign($data);
                if($res==1){
                    falsePro(0,"上传成功");
                }elseif ($res==2){
                    falsePro(0,"成功覆盖！");
                }elseif ($res==0){
                    falsePro(1,"请重新提交");
                }

            }else{
                falsePro(1,$file->getError());
            }
        }else{
            falsePro(1,"文件不存在");
        }
    }

    /**
     * @Description: 下载文件
     * @DateTime:    2018/12/17 7:02
     * @Author:      fyd
     */
    public function downAssign(){
        $processid = $_GET['id']; //获取过程id
        $type = 1;
        $senior = getSenior();
        $up = new Upfile();
        $info = $up->downassign($processid,$type,$senior);

        if(!$info){
            echo "<script>alert('数据不存在！')</script>";
            echo "<script>window.close();</script>";
            exit;
        }

        $file_name1 = $info["filename"];
        $file_name = iconv('UTF-8','GB2312',$file_name1);
//        $file_dir = ROOT_PATH.$info["filepath"].DS.$file_name1.".".$info["fileext"];
        $file_dir = "..".DS.$info["filepath"].DS.$file_name1.".".$info["fileext"];
        $file_lj1 = str_replace("\\","/",$file_dir);
        $file_lj=iconv('UTF-8','GB2312',$file_lj1); //必须转化成中文
        if(!file_exists($file_lj)){
            echo "<script>alert('文件不存在！')</script>";
            echo "<script>window.close();</script>";
            exit;
        }else{
            //打开文件
            $file1 = fopen($file_lj, "r");
            //输入文件标签
            header("Content-type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Accept-Length: ".filesize($file_lj));
            header("Content-Disposition: attachment; filename=".$file_name.".".$info["fileext"]);
            echo fread($file1, (filesize($file_lj)==0)?1:filesize($file_lj));
            fclose($file1);
            echo "<script>alert('下载成功！')</script>";
            exit;
        }
    }


    /******************************************************************************************************************/
}