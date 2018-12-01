<?php
namespace app\home\controller;
use app\home\controller\Base;
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
            $this->error("您没有权限操作！","Login/index");
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
            echo echoJson(1,"无数据");
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 打勾
     * @DateTime:    2018/11/26 15:51
     * @Author:      fyd
     */
    public function saveOne(){
        $sselect = new Sselect();
        $stuid = session('uid');
        $dataid = $_POST['id'];
        $xq = getSenior();
        $res = $sselect->saveOne($stuid,$dataid,$xq);

        switch ($res){
            case 1:
                falsePro(0,"成功");
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
        }
    }

    /**
     * @Description: 取消勾
     * @DateTime:    2018/11/26 16:39
     * @Author:      fyd
     */
    public function delOne(){
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
     * @Description: 提交数据,这里提交的时候需要修改weigh
     * @DateTime:    2018/11/27 10:28
     * @Author:      fyd
     */
    public function submitData(){
        $sselect = new Sselect();
        $id = $_POST['id'];
        $stuid = session('uid');
        $xq = getSenior();
        $res = $sselect->submitData($stuid,$xq,$id);
        switch ($res){
            case 3:
                falsePro(2,"数量超出，不能申请");
                break;
            case 1:
                falsePro(0,"提交成功");
                break;
            case 0:
                falsePro(1,"提交失败");
                break;
            case 2:
                falsePro(2,"未找到数据");
                break;
            default:
                falsePro(3,"操作错误");
                break;
        }
    }
}