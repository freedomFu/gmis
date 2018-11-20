<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/18 21:12
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\model\Prochart;
use think\Controller;
use think\Db;

class Protable extends Base{

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:03
     * @Description: 判断是不是教师权限
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/18 21:14
     * @Description: 显示出流程图
     */
    public function index(){
        $this->isTeacher();
        $pc = new Prochart();
        $prochart = $pc->prochart();

        $this->assign('prochart',$prochart);
        return $this->fetch('tapply/index');
    }

}