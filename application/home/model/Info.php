<?php
namespace app\home\model;
use think\Model;
use think\Db;

class Info extends Model
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

    public function getTeaInfo($teaid){
        $where['id'] = $teaid;
        $field = "teaduty,teahonor,teaphone,starttimer,middletimer,replytimer,replyplace";
        $table = "teacher";
        $list = Db::name($table)
            ->field($field)
            ->where($where)
            ->find();
        return $list;
    }

    public function changeTeaInfo($teaid,$data){
        $where['id'] = $teaid;
        $table = "teacher";
        $res = Db::name($table)
            ->where($where)
            ->update($data);

        if($res){
            return 1;
        }else{
            return 0;
        }
    }
}
