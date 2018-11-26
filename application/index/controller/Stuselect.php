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

    public function show(){
        $this->isStudent();
        $sselect = new Sselect();
        $profess = $sselect->showProfess();
        $this->assign('profess',$profess);
        return $this->fetch('sselect/index');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:30
     * @Description: 已选题目
     */
    public function index(){
        $this->isStudent();

        $sselect = new Sselect();
        $stuid = session('uid');
        $list = $sselect->sselect($stuid);
        falsePro('0','',$list);
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:31
     * @Description: 查询题目
     */
    public function showApplyTitle(){
        $this->isStudent();
        $sselect = new Sselect();
        $senior=getSenior();
        $list = $sselect->showApplyTitle(0,"",$senior);
        $listcount = count($list);
        for($i=0;$i<$listcount;$i++){
            $titleid = $list[$i]['id'];
            $proid = $list[$i]['proid'];
            $list[$i]['proname'] = $sselect->getProfessName($proid);
            $list[$i]['total'] = $sselect->getCount($titleid);
        }

        $auth = session('auth');
        if($auth==1){
            falsePro(0,$auth,$list);
        }else{
            falsePro(1,$auth,$list);
        }
    }

    /**
     * @Description: 打勾
     * @DateTime:    2018/11/26 15:51
     * @Author:      fyd
     */
    public function saveOne(){
        $sselect = new Sselect();
        $stuid = session('uid');
        $dataid = $_POST['id'];
        $xq = getSenior();
        $res = $sselect->saveOne($stuid,$dataid,$xq);

        switch ($res){
            case 1:
                falsePro(0,"成功");
                break;
            case 0:
                falsePro(1,"失败");
                break;
            case 2:
                falsePro(2,"不能多余三个呀");
                break;
            case 3:
                falsePro(3,"已经通过，不可申请");
                break;
            case 4:
                falsePro(3,"数据重复");
                break;
        }
    }

    /**
     * @Description: 取消勾
     * @DateTime:    2018/11/26 16:39
     * @Author:      fyd
     */
    public function delOne(){
        $sselect = new Sselect();
        $stuid = session('uid');
//        $dataid = $_POST['id'];
        $dataid = 15;
        $xq = getSenior();

        $res = $sselect->delOne($stuid,$dataid,$xq);

        if($res==1){
            falsePro(0,"取消成功");
        }else{
            falsePro(1,"取消失败");
        }
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
     * @Description: 提交数据,这里提交的时候需要修改weigh
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