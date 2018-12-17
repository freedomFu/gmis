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
        $field = 'p.id,gta.title,gs.id as sid,gs.stuidcard,gs.stuname,gs.stuclass,gt.starttimer,gt.middletimer,gt.replytimer,gt.replyplace,gt.note,p.middlescore,p.replyscore';
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
    public function editScore($processid,$data){
        $process = Process::get($processid);
        $midscore = $data['middlescore'];
        $repscore = $data['replyscore'];

        /*if($oldScore>0){ //成绩可以修改多次嘛？
            return 2; //已经打过成绩不可以再打
        }*/

        $process->middlescore = $midscore;
        $process->replyscore = $repscore;
        $res = $process->save();
        if($res){
            return 1; //更新成功
        }else{
            return 0; //更新失败
        }
    }

    /**
     * @Description: 获取过程信息
     * @DateTime:    2018/12/16 18:06
     * @Author:      fyd
     */
    public function getProcessInfo($id){
        $table = "process";
        $alias = "gp";
        $where["gp.status"] = "正常";
        $where["gp.id"] = $id;
        $field = "gp.id,gta.title,gs.stuidcard,gs.stuname";
        $join = [
            ["gmis_tapply gta", "gta.id=gp.titleid"],
            ["gmis_student gs", "gs.id=gp.stuid"]
        ];

        $processInfo = Db::name($table)
            ->alias($alias)
            ->join($join)
            ->field($field)
            ->where($where)
            ->find();
        return $processInfo;
    }

    /**
     * @Description: 获取processid
     * @DateTime:    2018/12/17 14:19
     * @Author:      fyd
     */
    public function getProcessId($stuid, $xq){
        $where["stuid"] = $stuid;
        $where["belongsenior"] = $xq;
        $processid = Process::where($where)
            ->value("id");
        if($processid){
            return $processid;
        }else{
            return -1;
        }
    }

    /**
     * @Description: 是否可以上传
     * @DateTime:    2018/12/17 14:13
     * @Author:      fyd
     */
    public function checkUp($stuid, $xq){
        $where["stuid"] = $stuid;
        $where["belongsenior"] = $xq;
        $where["status"] = "正常";
        $res = Process::where($where)
            ->find();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }




}