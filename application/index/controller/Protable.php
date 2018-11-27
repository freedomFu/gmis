<?php
namespace app\index\controller;
use app\index\model\Prochart;
use think\Controller;
use think\Db;

class Protable extends Base{

    /**
     * @Description: 判断是不是教师权限
     * @DateTime:    2018/11/27 10:33
     * @Author:      fyd
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Description: 显示出流程图
     * @DateTime:    2018/11/27 10:33
     * @Author:      fyd
     */
    public function index(){
        $this->isTeacher();
        $pc = new Prochart();
        $prochart = $pc->prochart();
//        dump($prochart);
        $this->assign('prochart',$prochart);
        return $this->fetch('tapply/index');
    }

}