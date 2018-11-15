<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 20:59
 * @Description: 描述信息
 */
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Controller
{
    public function index(){
        dump(Session::get());
        return $this->fetch('user/login');
    }

}