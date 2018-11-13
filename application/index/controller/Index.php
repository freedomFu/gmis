<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 20:59
 * @Description: 描述信息
 */
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index(){
        echo "这是首页呀！";
    }
}