<?php
namespace app\home\model;
use think\Model;
use think\Db;

class Prochart extends Model
{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * 教师申请题目模型
     * @author fyd
     */

    //获取器修改时间格式
    public function getcreatetimeAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['createtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    public function getRefreshtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['refreshtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    /**
     * @Description: 获取流程表
     * @DateTime:    2018/11/27 10:45
     * @Author:      fyd
     */
    public function prochart(){
        $list = Prochart::order('id asc')->select();
        $total = count($list);
        for($i=0;$i<$total;$i++){
            $id = $list[$i]['id'];
            $nowid = $this->getDateNum();
            if($id<$nowid){
                $list[$i]['isnow'] = -1; //过去
            }elseif ($id==$nowid){
                $list[$i]['isnow'] = 0; //现在
            }elseif ($id>$nowid){
                $list[$i]['isnow'] = 1; //过后
            }else{
                $list[$i]['isnow'] = 2; //未知错误
            }
        }
        return $list;
    }

    /**
     * @Description: 判断当前时间是不是在两个时间段之间,传入的参数是时间戳
     * @DateTime:    2018/12/1 22:27
     * @Author:      fyd
     */
    private function isNow($start,$end){
        //获取当前时间的时间戳
        $now = strtotime('now');
        if($now>=$start && $now<=$end){ //如果是就返回true
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Description: 根据当前时间获取当前的流程
     * @DateTime:    2018/12/1 22:22
     * @Author:      fyd
     */
    public function getDateNum(){
        $list = Prochart::order("id asc")->select();
        $total = count($list);
        $now = strtotime('now');
        $first = strtotime($list[0]['starttime']);
        $last = strtotime($list[$total-1]['endtime']);
        if($now<$first){
            return -1; //还没开始
        }
        if($now>$last){
            return -2; //已经结束
        }
        $id = 0;
        for($i=0;$i<$total;$i++){
            $startTimer = strtotime($list[$i]['starttime']);
            $endTimer = strtotime($list[$i]['endtime']);
            $id = $list[$i]['id'];
            $flag = $this->isNow($startTimer,$endTimer); //获取是不是属于这个id
            if($flag){
                return $id;
            }
        }
        return $id;
    }

    /**
     * @Description: 判断是不是在这个时间
     * @DateTime:    2018/12/2 15:35
     * @Author:      fyd
     */
    public function enterCheck($proname){
        $field = "id,proname,starttime,endtime";
        $where['proname'] = $proname;
        $list = Prochart::field($field)
            ->where($where)
            ->find();
//        dump($list);
        $start = strtotime($list['starttime']);
        $end = strtotime($list['endtime']);
        $flag = $this->isNow($start,$end);
        return $flag;
    }

    /**
     * @Description: 审核时间
     * @DateTime:    2018/12/14 20:49
     * @Author:      fyd
     */
    public function getTimeCheck(){
        $where['setname'] = "时间审核";
        $res = Db::name("userset")
            ->where($where)
            ->value("status");
        if($res=="on"){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Description: 进行审核  已经开启则判断是不是在 未开启则可以进入
     * @DateTime:    2018/12/15 8:55
     * @Author:      fyd
     */
    public function doCheck($proname){
        if($this->getTimeCheck()){
            $res = $this->enterCheck($proname);
            if($res){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /**
     * @Description: 学生用户信息 根据auth判断
     * @DateTime:    2018/12/15 11:09
     * @Author:      fyd
     */
    public function getStuInfo($stuid){
        $table = "process";
        $alias = "gp";
        $join = [
            ['gmis_student gs','gs.id=gp.stuid','LEFT'],
            ['gmis_teacher gte','gte.id=gp.teaid','LEFT']
        ];
        $where['gp.stuid'] = $stuid;
        $where['gp.status'] = "正常";
        $field = "gp.id,gs.stuidcard,gs.stuname,gte.starttimer,gte.middletimer,gte.replytimer,gte.replyplace";
        $list = Db::name($table)
            ->alias($alias)
            ->field($field)
            ->join($join)
            ->where($where)
            ->find();
        $list["auth"] = "学生";

        $rearr = [
            "id"            =>  $list["id"],
            "idcard"        =>  $list["stuidcard"],
            "name"          =>  $list["stuname"],
            "auth"          =>  "学生",
            "starttime"     =>  $list["starttimer"],
            "middletime"    =>  $list["middletimer"],
            "replytime"     =>  $list["replytimer"],
            "replyplace"    =>  $list["replyplace"],
        ];

        return $rearr;
    }

    /**
     * @Description: 教师用户信息
     * @DateTime:    2018/12/15 11:10
     * @Author:      fyd
     */
    public function getTeaInfo($teaid){
        $table = "teacher";
        $where['id'] = $teaid;
//        $where['status'] = "任教中";
        $field = "id,teaidcard,teaname,starttimer,middletimer,replytimer,replyplace";
        $list = Db::name($table)
            ->field($field)
            ->where($where)
            ->find();

        $rearr = [
            "id"            =>  $list["id"],
            "idcard"        =>  $list["teaidcard"],
            "name"          =>  $list["teaname"],
            "auth"          =>  "教师",
            "starttime"     =>  $list["starttimer"],
            "middletime"    =>  $list["middletimer"],
            "replytime"     =>  $list["replytimer"],
            "replyplace"    =>  $list["replyplace"],
        ];

        return $rearr;
    }



}