<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/20 15:15
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Process;
use think\Controller;
use think\Db;

class Reprocess extends Base
{
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
     * @DateTime:    2018/11/20 15:24
     * @Description: 获取教师对应学生毕设流程
     */
    public function show(){
        $this->isTeacher();
        $pro = new Process();
        $id = session('uid');
        $xq = getSenior();
        $list = $pro->showProcess($id,$xq);
        dump($list);
    }
}