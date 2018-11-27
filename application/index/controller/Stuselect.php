<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Sselect;
use think\Controller;
use think\Db;

class Stuselect extends Base
{
    /**
     * @Description: 判断是不是学生权限
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    private function isStudent(){
        if(session('auth')!=1){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Description: 显示学生选择页面
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    public function show(){
        $this->isStudent();
        $sselect = new Sselect();
        $xq = getSenior();
        $stuid = session('uid');
        $submitData = $sselect->showSubmit($stuid,$xq);
        $subCount = count($submitData);
        for ($i=0;$i<$subCount;$i++){
            $titleid = $submitData[$i]['titleid'];
            $submitData[$i]['total'] = $sselect->getCount($titleid);
            $submitData[$i]['isnew'] = $sselect->getStr($submitData[$i]['isnew']);
            $submitData[$i]['isprac'] = $sselect->getStr($submitData[$i]['isprac']);
            $submitData[$i]['isallow'] = $sselect->getStr($submitData[$i]['isallow']);
        }
        $allowData = $sselect->getAllow($stuid,$xq);
        $profess = $sselect->showProfess();
        $this->assign('profess',$profess);
        $this->assign('submit',$submitData);
        $this->assign('allow',$allowData);

        return $this->fetch('sselect/index');
    }

    /**
     * @Description: 已选题目
     * @DateTime:    2018/11/27 10:35
     * @Author:      fyd
     */
    public function index(){
        $this->isStudent();
        $sselect = new Sselect();
        $stuid = session('uid');
        $list = $sselect->sselect($stuid);
        falsePro('0','',$list);
    }

    /**
     * @Description: 查询题目
     * @DateTime:    2018/11/27 10:27
     * @Author:      fyd
     */
    public function showApplyTitle(){
        $this->isStudent();
        $stuid = session('uid');
        $sselect = new Sselect();
        $senior=getSenior();
        $list = $sselect->showApplyTitle(0,"",$senior);
        $listcount = count($list);
        for($i=0;$i<$listcount;$i++){
            $titleid = $list[$i]['id'];
            $proid = $list[$i]['proid'];
            $list[$i]['proname'] = $sselect->getProfessName($proid);
            $list[$i]['total'] = $sselect->getCount($titleid);
            $list[$i]['pick'] = $sselect->getPick($titleid,$stuid);
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
        $dataid = $_POST['id'];
//        $dataid = 12;
        $xq = getSenior();

        $res = $sselect->delOne($stuid,$dataid,$xq);
        if($res==1){
            falsePro(0,"取消成功");
        }else{
            falsePro(1,"取消失败");
        }
    }

    /**
     * @Description: 获取三个titleid并保存起来
     * @DateTime:    2018/11/27 10:27
     * @Author:      fyd
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
     * @Description: 提交数据,这里提交的时候需要修改weigh
     * @DateTime:    2018/11/27 10:28
     * @Author:      fyd
     */
    public function submitData(){
        $sselect = new Sselect();
        $stuid = session('uid');
        $xq = getSenior();
        $res = $sselect->submitData($stuid,$xq);
        switch ($res){
            case 3:
                falsePro(2,"数量超出，不能申请");
                break;
            case 1:
                falsePro(0,"提交成功");
                break;
            case 0:
                falsePro(1,"提交失败");
                break;
            case 2:
            default:
                falsePro(3,"操作错误");
                break;
        }
    }
}