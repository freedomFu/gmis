<?php
namespace app\home\controller;
use app\home\controller\Base;
use app\home\model\Process;
use app\home\model\Prochart;
use app\home\model\Comclass;
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
            $this->error("您没有权限操作！","../login");
        }
    }


    public function showPage(){
        $this->isTeacher();

        /********************************************************************/
        $proc = new Prochart();
        $proname = "答辩成绩管理";
        $res = $proc->doCheck($proname);
        if(!$res){
            $this->error("当前时间不可以进行".$proname."操作","../flow");
        }

        /********************************************************************/
        $com = new Comclass();
        $midscore = $com->getMidScore();
        $this->assign("midscore",$midscore);
        $repscore = $com->getRepScore();
        $this->assign("repscore",$repscore);
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
            echo echoJson(1,"获取失败",$count,$list);
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
        $data = [
            'middlescore'               =>$_POST['mscore'],
            'replyscore'                =>$_POST['rscore']
        ];
        $res = $process->editScore($id,$data);

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