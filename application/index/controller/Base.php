<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Base extends Controller
{
    /**
     * @Description: 初始化函数，用于判断用户是否登录
     * @DateTime:    2018/11/27 10:30
     * @Author:      fyd
     */
    public function _initialize(){
        if(session('uid')==0){
            $this->error("请先登录系统！","Login/index");
        }
    }
}