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
        $auth = $this->auth->id;
        $this->assign("auth",$auth);
        return $this->fetch("adjust/index");
    }

    /**
     * @Description: 显示手动调剂页面
     * @DateTime:    2018/12/20 21:20
     * @Author:      fyd
     */
    public function manual(){
        $auth = $this->auth->id;
        $this->assign("auth",$auth);
        return $this->fetch("adjust/manual");
    }

    /**
     * @Description: 显示自动调剂页面
     * @DateTime:    2018/12/20 21:20
     * @Author:      fyd
     */
    public function auto(){
        $auth = $this->auth->id;
        $this->assign("auth",$auth);
        return $this->fetch("adjust/auto");
    }

    /**
     * @Description: 描述信息
     * @DateTime:    2018/12/20 22:03
     * @Author:      fyd
     */
    public function getTitleList(){
        $page=input('page');
        $limit=input('limit');
        $titlelist = $this->model->getTitleList($page,$limit);
        $count = $this->model->getTitleCount();
        for($i=0;$i<count($titlelist);$i++){
            $titlelist[$i]['kid']=$i+1;
        }
        if($count>=0){
            echo echoJson(0,"获取成功",$count,$titlelist);
        }else{
            echo echoJson(1,"获取失败",$count,$titlelist);
        }
    }

    /**
     * @Description: 获取学生列表
     * @DateTime:    2018/12/20 22:03
     * @Author:      fyd
     */
    public function getStuList(){
        $page=input('page');
        $limit=input('limit');
        $stulist = $this->model->getStuList($page,$limit);
        $count = $this->model->getStuCount();
        for($i=0;$i<count($stulist);$i++){
            $stulist[$i]['kid']=$i+1;
        }
        if($count>=0){
            echo echoJson(0,"获取成功",$count,$stulist);
        }else{
            echo echoJson(1,"获取失败",$count,$stulist);
        }
    }

    /**
     * @Description: 手动调剂功能
     * @DateTime:    2018/12/21 9:38
     * @Author:      fyd
     */
    public function upData(){
        $titleid = $_POST["titleid"];
        $stuid = $_POST["stuid"];
        $res = $this->model->upMyData($stuid,$titleid);
        switch ($res) {
            case 1:
                falsePro(0,"调剂成功");
                break;
            case 2:
                falsePro(1,"操作失败");
                break;
            case 3:
                falsePro(2,"数据验证失败！");
                break;
            case 4:
                falsePro(3,"未知错误");
                break;
            default:
                falsePro(4,"未知错误");
        }
    }

    /**
     * @Description: 优先调剂
     * @DateTime:    2018/12/21 10:53
     * @Author:      fyd
     */
    public function pa(){
        $titleList = $this->model->getTList();
        $stulist = $this->model->getSList();
        if(count($titleList) != count($stulist)){
            falsePro(1,"数目不符合调剂条件");
            exit;
        }
        $count = count($titleList);
        for($i=0;$i<$count;$i++){
            $titleid = $titleList[$i]["id"];
            $titlename = $titleList[$i]["title"];
            $flag = $this->model->isExTitle($titleid);
            if($flag){
                $res = $this->model->priorAdjust($titleid);
                if($res){
                    continue;
                }else{
                    falsePro(1,"优先调剂题目".$titlename."出现错误");
                    exit;
                }
            }else{
                continue; //不存在就进行下一层循环
            }
        }

        $newTitle = $this->model->getTList();
        $newStu = $this->model->getSList();
        if(count($newTitle) == count($newStu)){ //数目相同
            $total = count($newTitle);
            for($j=0;$j<$total;$j++){
                $titleid = $newTitle[$j]["id"];
                $titlename = $newTitle[$j]["title"];
                $stuid = $newTitle[$j]["id"];
                $res0 = $this->model->upMyData($stuid,$titleid);
                if($res0){
                    continue;
                }else{
                    falsePro(1,"默认调剂题目".$titlename."出现错误");
                    exit;
                }
            }
        }else{
            falsePro(1,"默认调剂数目不符规范");
            exit;
        }
        falsePro(0,"默认调剂成功");
        exit;
    }

    /**
     * @Description: 默认调剂
     * @DateTime:    2018/12/21 11:07
     * @Author:      fyd
     */
    public function da(){
        $titleList = $this->model->getTList();
        $stuList = $this->model->getSList();
        if(count($titleList) == count($stuList)){ //数目相同
            $total = count($titleList);
            for($j=0;$j<$total;$j++){
                $titleid = $titleList[$j]["id"];
                $titlename = $stuList[$j]["title"];
                $stuid = $titleList[$j]["id"];
                $res0 = $this->model->upMyData($stuid,$titleid);
                if($res0){
                    continue;
                }else{
                    falsePro(1,"默认调剂题目".$titlename."出现错误");
                    exit;
                }
            }
        }else{
            falsePro(1,"默认调剂数目不符规范");
            exit;
        }
        falsePro(0,"默认调剂成功");
        exit;
    }


    public function test(){
        $res = $this->model->endAdjust();
        dump($res);
    }
}