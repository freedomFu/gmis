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
}