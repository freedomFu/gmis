<?php
namespace app\home\model;
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
     * @Description: 展示流程   序号  题目  学生学号  学生姓名  学生班级  开题时间  中期检查时间  答辩时间  答辩地点  答辩成绩
     * @DateTime:    2018/11/27 10:42
     * @Author:      fyd
     */
    public function showProcess($teaid, $xq, $page, $limit){
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
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $list;
    }

    /**
     * @Description: 获取总数
     * @DateTime:    2018/11/29 23:39
     * @Author:      fyd
     */
    public function getProcessCount($teaid, $xq){
        $where['p.teaid'] = $teaid;
        $where['p.belongsenior'] = $xq;
        $maintable = 'process';
        $mt = 'p';
        $count = Db::name($maintable)
            ->alias($mt)
            ->where($where)
            ->count();
        return $count;
    }

    /**
     * @Description: 填写成绩
     * @DateTime:    2018/11/27 10:42
     * @Author:      fyd
     */
    public function editScore($processid,$score){
        $process = Process::get($processid);
        $oldScore = $process['replyscore'];

        /*if($oldScore>0){ //成绩可以修改多次嘛？
            return 2; //已经打过成绩不可以再打
        }*/

        $process->replyscore = $score;
        $res = $process->save();
        if($res){
            return 1; //更新成功
        }else{
            return 0; //更新失败
        }
    }




}