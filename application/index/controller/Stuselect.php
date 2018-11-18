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
        $list = $sselect->showApplyTitle(1,"",$senior);
        $listcount = count($list);
        for($i=0;$i<$listcount;$i++){
            $titleid = $list[$i]['id'];
            $proid = $list[$i]['proid'];
            $list[$i]['proname'] = $sselect->getProfessName($proid);
            $list[$i]['total'] = $sselect->getCount($titleid);
        }

        dump(session('uid'));

        $this->assign('list',$list);
        return $this->fetch('sselect/showTitle');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:49
     * @Description: 获取三个titleid并保存起来
     */
    public function saveData(){
        $sselect = new Sselect();
        $dataid = [2,4,8];
        $url = "Stuselect/showApplyTitle";
        $stuid = session('uid');
        $check = $sselect->checkStuTitleNum($stuid,$dataid);
        switch ($check){
            case 4:
                $this->error("你已经提交了，不能再添加了",$url);
            case 2:
                $this->error("数据过多",$url);
            case 3:
                $this->error("你只能申请三个哦！",$url);
            case 1:
            default:
                break;
        }

        $res = $sselect->saveData($stuid,$dataid);

        switch ($res){
            case 1:
                $this->success("保存成功",$url);
            case 0:
                $this->error("保存失败",$url);
            default:
                $this->error("未知错误",$url);
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 18:57
     * @Description: 提交数据
     */
    public function submitData(){
        $sselect = new Sselect();
        $stuid = session('uid');
        $res = $sselect->submitData($stuid);
        $url = "Stuselect/showApplyTitle";
        switch ($res){
            case 4:
                $this->error("你已经提交了，不能再添加了",$url);
            case 3:
                $this->error("存在题目数目已经申请数目已经超过10个");
            case 2:
                $this->success("您的数据有误",$url);
            case 1:
                $this->success("保存成功",$url);
            case 0:
                $this->error("保存失败",$url);
            default:
                $this->error("未知错误",$url);
        }
    }
}