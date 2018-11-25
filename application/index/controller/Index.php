<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 20:59
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Prochart;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Base
{
    /**
     * @Author:      fyd
     * @DateTime:    2018/11/23 15:18
     * @Description: 首页
     */
    public function index(){
        $pc = new Prochart();
        $prochart = $pc->prochart();
//        dump($prochart);
        $this->assign('prochart',$prochart);
        return $this->fetch('index');
    }

}