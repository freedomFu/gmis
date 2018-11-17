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
    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:03
     * @Description: 判断是不是学生权限
     */
    private function isStudent(){
        if(session('auth')!=1){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:30
     * @Description: 已选题目
     */
    public function index(){
        $this->isStudent();

        $sselect = new Sselect();
        $teaid = 5;
        $list = $sselect->sselect($teaid);
//        dump($list);
        $this->assign('list',$list);
        return $this->fetch('sselect/index');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:31
     * @Description: 查询题目
     */
    public function showApplyTitle(){
        $this->isStudent();

        $sselect = new Sselect();
        $senior="2018-2019";
        $list = $sselect->showApplyTitle(1,"系统",$senior);
        $listcount = count($list);
        for($i=0;$i<$listcount;$i++){
            $proid = $list[$i]['proid'];
            $list[$i]['proname'] = $sselect->getProfessName($proid);
        }

        $this->assign('list',$list);
        return $this->fetch('sselect/showTitle');
    }
}