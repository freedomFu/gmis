<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Process;
use app\home\model\Prochart;
use app\home\model\Upfile;
use app\home\model\Sselect;
use app\home\model\Tapply;

class Stuselect extends Base
{
    /**
     * @Description: 判断是不是学生权限
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    private function isStudent(){
        if(session('auth')!=1){
            $this->error("您没有权限操作！","../login");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 显示学生已经提交题目数据
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    public function show(){
        $this->isStudent();

        /********************************************************************/
        $proc = new Prochart();
        $proname = "学生选题";
        $res = $proc->doCheck($proname);
        if(!$res){
            $this->error("当前时间不可以进行".$proname."操作","../flow");
        }
        /********************************************************************/

        $stuid = session('uid');
        $ss = new Sselect();
        $isAllowSave = $ss->checkIsAllow($stuid);
        $this->assign('isallsave',$isAllowSave); //是否还允许保存
        return $this->fetch('sselect/showMySelected');
    }
    /**
     * @Description: 获取json数据
     * @DateTime:    2018/11/30 5:43
     * @Author:      fyd
     */
    public function mySelectedJson(){
        $this->isStudent();
        $ss = new Sselect();
        $page=input('page');
        $limit=input('limit');
        $xq = getSenior();
        $stuid = session('uid');
        $list = $ss->showSubmit($stuid,$xq,$page,$limit);
        $count = $ss->countSubmit($stuid,$xq);
        for($i=0;$i<$count;$i++){
            $list[$i]['kid']=$i+1;
            $allow = $list[$i]['isallow']; //是否已通过允许
            $submit = $list[$i]['issubmit']; //是否已经提交
            if($submit==0) {
                $list[$i]['state'] = "未提交";
            }elseif ($submit==1 & $allow==0){
                $list[$i]['state'] = "已提交";
            }elseif ($allow==1){
                $list[$i]['state'] = "已通过";
            }
        }
        echo echoJson(0,"获取成功",$count,$list);
    }

    /******************************************************************************************************************/

    /**
     * @Description: 显示学生通过的数据
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    public function showMyTitle(){
        $this->isStudent();
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->checkUp($stuid,$xq);
        $this->assign("isUp",$res);
        return $this->fetch('sselect/showMyTitle');
    }

    /**
     * @Description: 通过数据的json
     * @DateTime:    2018/12/1 15:44
     * @Author:      fyd
     */
    public function myTitleJson(){
        $this->isStudent();
        $ss = new Sselect();
        $page=input('page');
        $limit=input('limit');
        $xq = getSenior();
        $stuid = session('uid');
        $list = $ss->getAllow($stuid,$xq,$page,$limit);
        $count = $ss->countAllow($stuid,$xq);
        for($i=0;$i<$count;$i++){
            $list[$i]['kid']=$i+1;
        }

        echo echoJson(0,"获取成功",$count,$list);
    }

    /******************************************************************************************************************/

    /**
     * @Description: 选题页面
     * @DateTime:    2018/12/1 15:44
     * @Author:      fyd
     */
    public function showSelect(){
        $this->isStudent();

        /********************************************************************/
        $proc = new Prochart();
        $proname = "学生选题";
        $res = $proc->doCheck($proname);
        if(!$res){
            $this->error("当前时间不可以进行".$proname."操作","../flow");
        }
        /********************************************************************/

        $teapply = new Tapply();
        $stuid = session('uid');
        $ss = new Sselect();
        $isAllowSave = $ss->checkSave($stuid);
        $profess = $teapply->showProfess();
        $this->assign('profess',$profess);
        $this->assign('isallsave',$isAllowSave); //是否还允许保存
        return $this->fetch("Sselect/stuSelect");
    }

    /**
     * @Description: 查询题目
     * @DateTime:    2018/11/27 10:27
     * @Author:      fyd
     */
    public function showApplyTitle(){
        $this->isStudent();
        $stuid = session('uid');
        $sselect = new Sselect();
        $senior=getSenior();
        $page=input('page');
        $limit=input('limit');

        if(isset($_POST['professid'])){
            $professid = $_POST['professid'];
        }else{
            $professid = 0;
        }

        if(isset($_POST['titlekey'])){
            $titlekey = $_POST['titlekey'];
        }else{
            $titlekey = "";
        }

        $list = $sselect->showApplyTitle($professid,$titlekey,$senior,$page,$limit);
        $listcount = count($list);
        for($i=0;$i<$listcount;$i++){
            $titleid = $list[$i]['id'];
            $proid = $list[$i]['proid'];
            $list[$i]['proname'] = $sselect->getProfessName($proid);
            $list[$i]['total'] = $sselect->getCount($titleid);
            $list[$i]['pick'] = $sselect->getPick($titleid,$stuid);
            $list[$i]['kid']=$i+1;
        }
        $count = $sselect->countApplyNum($professid,$titlekey,$senior);
        $auth = session('auth');
        if($auth==1){
            echo echoJson(0,"提取成功",$count,$list);
        }else{
            echo echoJson(1,"无数据",$count,$list);
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 打勾
     * @DateTime:    2018/11/26 15:51
     * @Author:      fyd
     */
    public function saveOne(){
        $this->isStudent();
        $sselect = new Sselect();
        $stuid = session('uid');
        $dataid = $_POST['id'];
        $xq = getSenior();
        $res = $sselect->saveOne($stuid,$dataid,$xq);

        switch ($res){
            case 1:
                falsePro(0,"选题成功，请及时提交");
                break;
            case 0:
                falsePro(1,"失败");
                break;
            case 2:
                falsePro(2,"不能多余三个呀");
                break;
            case 3:
                falsePro(3,"已经通过，不可申请");
                break;
            case 4:
                falsePro(3,"数据重复");
                break;
            case 5:
                falsePro(4,"申请数量过多");
                break;
        }
    }

    /**
     * @Description: 取消勾
     * @DateTime:    2018/11/26 16:39
     * @Author:      fyd
     */
    public function delOne(){
        $this->isStudent();
        $sselect = new Sselect();
        $stuid = session('uid');
        $dataid = $_POST['id'];
//        $dataid = 44;
        $xq = getSenior();

        $res = $sselect->delOne($stuid,$dataid,$xq);
        if($res==1){
            falsePro(0,"删除成功");
        }elseif($res==0){
            falsePro(1,"删除失败");
        }elseif ($res==2){
            falsePro(2,"未找到数据，请刷新重试");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 修改权重
     * @DateTime:    2018/12/1 9:45
     * @Author:      fyd
     */
    public function changeWeigh(){
        $this->isStudent();
        $id = $_POST['id'];
        $weigh = $_POST['weigh'];

        $ss = new Sselect();
        $res = $ss->changeWeigh($id,$weigh);

        if($res==1){
            falsePro(0,"修改成功");
        }elseif($res==2){
            falsePro(2,"未知错误");
        }elseif($res==0){
            falsePro(1,"修改失败");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 提交数据
     * @DateTime:    2018/11/27 10:28
     * @Author:      fyd
     */
    public function submitData(){
        $this->isStudent();
        $sselect = new Sselect();
        $id = $_POST['id'];
        $stuid = session('uid');
        $xq = getSenior();
        $res = $sselect->submitData($stuid,$xq,$id);
        switch ($res){
            case 1:
                falsePro(0,"提交成功");
                break;
            case 0:
                falsePro(1,"提交失败");
                break;
            case 2:
                falsePro(2,"未找到数据");
                break;
            case 3:
                falsePro(2,"权重不合法，请修改权重");
                break;
            default:
                falsePro(3,"操作错误");
                break;
        }
    }

    /**
     * @Description: 上传开题报告
     * @DateTime:    2018/12/17 13:59
     * @Author:      fyd
     */
    public function upopreport(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->upload(2,"ktbg","开题报告","doc,docx,pdf",$res);
        }else{
            falsePro(1,"未知错误");
        }

    }

    /**
     * @Description: 上传毕设论文
     * @DateTime:    2018/12/17 14:24
     * @Author:      fyd
     */
    public function upmypaper(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->upload(3,"bslw","毕设论文","doc,docx,pdf",$res);
        }else{
            falsePro(1,"未知错误");
        }

    }

    /**
     * @Description: 上传毕设论文
     * @DateTime:    2018/12/17 14:24
     * @Author:      fyd
     */
    public function upmycode(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->upload(4,"bscl","毕设材料","zip,rar,7z",$res);
        }else{
            falsePro(1,"未知错误");
        }
    }

    /**
     * @Description: 下载开题报告
     * @DateTime:    2018/12/17 15:16
     * @Author:      fyd
     */
    public function downopreport(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->download($res,2);
        }else{
            echo "<script>alert('未知错误');</script>";
        }
    }

    /**
     * @Description: 下载毕设论文
     * @DateTime:    2018/12/17 15:16
     * @Author:      fyd
     */
    public function downmypaper(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->download($res,3);
        }else{
            echo "<script>alert('未知错误');</script>";
        }
    }

    /**
     * @Description: 下载毕设论文
     * @DateTime:    2018/12/17 15:16
     * @Author:      fyd
     */
    public function downmycode(){
        $pro = new Process();
        $stuid = session("uid");
        $xq = getSenior();
        $res = $pro->getProcessId($stuid,$xq);
        if($res!=-1){
            $this->download($res,4);
        }else{
            echo "<script>alert('未知错误');</script>";
        }
    }

    /**
     * @Description: 上传方法
     * @DateTime:    2018/12/17 13:52
     * @Author:      fyd
     */
    private function upload($type,$dir,$chname,$myext,$id){
        $file = request()->file('file');
        $typeid = $type; //类型id
        $typename = $dir; //文件夹
        $typecname = $chname; //文件夹中文名字
        $year = getSenior(); //获取学年
        $filename = $_FILES["file"]["name"]; //获取文件名
        $ext = getExt($filename); //获取文件后缀
        $processid = $id;// 获取对应的过程id
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
            $cupname = $stuidcard."+".$stuname."+".$title."-".$typecname;
            $upname = iconv("UTF-8","gbk",$cupname);
            $validate["ext"] = $myext;
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
     * @DateTime:    2018/12/17 15:14
     * @Author:      fyd
     */
    private function download($id, $type){
        $processid = $id; //获取过程id
        $type = $type;
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
}