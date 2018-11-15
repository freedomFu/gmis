<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 14:41
 * @Description: 基础文件
 */
namespace app\index\controller;
use think\Controller;
use think\Db;

class Basetea extends Controller
{
    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 14:43
     * @Description: 初始化函数，用于判断用户是否登录
     */
    public function _initialize(){
        if(session('uid')==0){
            $this->error("请先登录系统！","Login/index");
        }
    }
}