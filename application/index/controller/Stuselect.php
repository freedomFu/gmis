<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 21:55
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Sselect;
use think\Controller;
use think\Db;

class Stuselect extends Base
{
    public function index(){
        $sselect = new Sselect();
        $list = $sselect->sselect();
//        dump($list);
        $this->assign('list',$list);
        return $this->fetch('sselect/index');
    }
}