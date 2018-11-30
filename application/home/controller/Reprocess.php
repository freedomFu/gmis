<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Process;
use think\Controller;
use think\Db;

class Reprocess extends Base
{
    /**
     * @Description: 判断是不是教师权限
     * @DateTime:    2018/11/27 10:34
     * @Author:      fyd
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    public function showPage(){
        return $this->fetch("Tapply/showStudent");
    }

    /**
     * @Description: 获取教师对应学生毕设流程
     * @DateTime:    2018/11/27 10:34
     * @Author:      fyd
     */
    public function show(){
        $this->isTeacher();
        $pro = new Process();
        $id = session('uid');
        $xq = getSenior();
        $page=input('page');
        $limit=input('limit');
        $list = $pro->showProcess($id,$xq,$page,$limit);
        for($i=0;$i<count($list);$i++){
            $list[$i]['kid']=$i+1;
        }

        $count = $pro->getProcessCount($id,$xq);
        if($count){
            echo echoJson(0,"获取成功",$count,$list);
        }else{
            echo echoJson(1,"获取失败");
        }
    }

    /**
     * @Description: 保存数据  编辑成绩
     * @DateTime:    2018/11/27 10:34
     * @Author:      fyd
     */
    public function editScore(){
        $this->isTeacher();
        $process = new Process();
        $id = $_POST['id'];
        $score = $_POST['replyscore'];
        $res = $process->editScore($id,$score);

        switch ($res){
            case 0:
                falsePro(1,"修改成绩失败");
                break;
            case 1:
                falsePro(0,"修改成绩成功");
                break;
            /*case 2:
                falsePro(2,"不可更新成绩");
                break;*/
             default:
                falsePro(3,"未知错误");
                break;
        }
    }
}