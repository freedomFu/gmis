<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Prochart;
use app\home\model\Comclass;
use app\home\model\Info;

class Index extends Base
{
    /**
     * @Description: 首页
     * @DateTime:    2018/11/27 10:30
     * @Author:      fyd
     */
    public function index(){
        $pc = new Prochart();
        $prochart = $pc->prochart();
        $this->assign('prochart',$prochart);

        $auth = session("auth");
        $uid = session("uid");
        if($auth==1){ // 学生
            $info = $pc->getStuInfo($uid);
        }elseif($auth==2){
            $info = $pc->getTeaInfo($uid);
        }
        $this->assign("userinfo",$info);
        return $this->fetch('Prochart/index');
    }

    public function showSet(){
        $imodel = new Info();
        $pc = new Prochart();
        $prochart = $pc->prochart();
        $this->assign('prochart',$prochart);
        $teaid = session('uid');
        $list = $imodel->getTeaInfo($teaid);
        $this->assign("teainfo",$list);

        $com = new Comclass();
        $teahonor = $com->getTeaHonor();
        $this->assign("teahonor",$teahonor);
        $teaduty = $com->getTeaDuty();
        $this->assign("teaduty",$teaduty);
        return $this->fetch("Main/userSet");
    }

    public function changeInfo(){
        $imodel = new Info();
        $teaid = session('uid');
        $data = [
            'teaduty'           =>      $_POST['teaduty'],
            'teahonor'          =>      $_POST['teahonor'],
            'starttimer'        =>      $_POST['starttimer'],
            'middletimer'       =>      $_POST['middletimer'],
            'replytimer'        =>      $_POST['replytimer'],
            'replyplace'        =>      $_POST['replyplace'],
            'teaphone'          =>      $_POST['teaphone']
        ];

        $res = $imodel->changeTeaInfo($teaid,$data);

        if($res){
            falsePro(0,"提交成功");
        }else{
            falsePro(1,"提交失败");
        }
    }

}