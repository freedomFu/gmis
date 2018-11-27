<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Prochart;
use think\Controller;
use think\Db;
use think\Session;

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
//        dump($prochart);
        $this->assign('prochart',$prochart);
        return $this->fetch('index');
    }

    /**
     * @Description: 导航栏
     * @DateTime:    2018/11/27 10:30
     * @Author:      fyd
     */
    public function nav(){
        return $this->fetch('common/base');
    }

}