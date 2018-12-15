<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Prochart;

class Pchart extends Base
{
    /**
     * @Description: 显示流程图
     * @DateTime:    2018/11/28 9:17
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

}