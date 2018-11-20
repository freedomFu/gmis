<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/20 15:05
 * @Description: 描述信息
 */
namespace app\index\model;

use think\Model;
use think\Db;

class Process extends Model
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
     * @Author:      fyd
     * @DateTime:    2018/11/20 15:26
     * @Description: 展示流程
     */
    ////序号  题目  学生学号  学生姓名  学生班级  开题时间  中期检查时间  答辩时间  答辩地点  答辩成绩
    public function showProcess($teaid, $xq){
        $where['p.teaid'] = $teaid;
        $where['p.belongsenior'] = $xq;
        $maintable = 'process';
        $mt = 'p';
        $field = 'p.id,gta.title,gs.stuidcard,gs.stuname,gs.stuclass,gt.starttimer,gt.middletimer,gt.replytimer,gt.replyplace,gt.note,p.replyscore';
        $join = [
            ['gmis_student gs','gs.id=p.stuid'],
            ['gmis_teacher gt','gt.id=p.teaid'],
            ['gmis_tapply gta','gta.id=p.titleid'],
        ];
        $list = Db::name($maintable)
            ->alias($mt)
            ->join($join)
            ->field($field)
            ->where($where)
            ->select();
        return $list;
    }




}