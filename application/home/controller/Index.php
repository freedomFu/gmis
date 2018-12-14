<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Prochart;
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

        $teahonor = $this->getArray("getTeaHonor");
        $this->assign("teahonor",$teahonor);
        $teaduty = $this->getArray("getTeaDuty");
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

    private function getNeedBetween($str,$s1,$s2){
        $kw=$str;
        $kw='123'.$kw.'123';
        $st =stripos($kw,$s1);
        $ed =stripos($kw,$s2);
        if(($st==false||$ed==false)||$st>=$ed){
            return 0;
        }
        $kw=substr($kw,($st+1),($ed-$st-1));
        return $kw;
    }

    public function getArray($funame){
        $i = new Info();
        $res = $i->$funame();
        $str = $res[0]['Type'];
        $typestr = $this->getNeedBetween($str,'(',')');
        $typestr = str_replace("'","",$typestr);
        $typearr = explode(",",$typestr);
        return $typearr;
    }

    /*public function test(){
        $res = $this->getArray("getTeaDuty");
        dump($res);
    }*/

}