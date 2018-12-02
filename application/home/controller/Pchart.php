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
        return $this->fetch('Prochart/index');
    }

}