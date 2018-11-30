<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Info;

class Index extends Base
{
    /**
     * @Description: 首页
     * @DateTime:    2018/11/27 10:30
     * @Author:      fyd
     */
    public function index(){
        return $this->fetch("Main/index");
    }

    public function showSet(){
        $imodel = new Info();
        $teaid = session('uid');
        $list = $imodel->getTeaInfo($teaid);
        $this->assign("teainfo",$list);
        return $this->fetch("Main/userSet");
    }

    public function changeInfo(){
        $imodel = new Info();
        $teaid = session('uid');
        $data = [
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