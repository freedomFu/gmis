<?php
namespace app\admin\controller;
use app\common\controller\Backend;

class Adjust extends Backend
{
    /**
     * Adjust模型对象
     * @var \app\admin\model\Adjust
     */
    protected $model = null;

    /**
     * @Description: 初始化方法
     * @DateTime:    2018/12/19 8:45
     * @Author:      fyd
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Adjust;
    }

    /**
     * @Description: 显示调剂页面
     * @DateTime:    2018/12/19 8:46
     * @Author:      fyd
     */
    public function index(){
        echo "调剂系统！<br>";
        echo "<a href=''>手动调剂！</a><br>";
        echo "<a href=''>自动调剂！</a><br>";
    }

    public function test(){
        $res = $this->model->getStuList();
        dump($res);
    }
}