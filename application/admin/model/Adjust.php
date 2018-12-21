<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Adjust extends Model
{
    // 表名
    protected $name = 'student';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 追加属性
    protected $append = [
        'status_text'
    ];

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }
    /**************************************************************************/
    //获取添加数据
    /**
     * @Description: 根据题目id获取教师id
     * @DateTime:    2018/12/19 8:57
     * @Author:      fyd
     */
    private function getTeaidByTitleId($titleid){
        $table = "tapply";
        $where["belongsenior"] = getSenior();
        $where["stuid"] = null;
        $where["status"] = "已通过";
        $where["id"] = $titleid;
        $value = "teaid";

        $teaid = Db::name($table)
            ->where($where)
            ->value($value);
        return $teaid;
    }

    /**************************************************************************/
    //检验添加的数据是否合法
    /**
     * @Description: 判断题目id是否合法
     * @DateTime:    2018/12/19 9:27
     * @Author:      fyd
     */
    private function checkTitleId($titleid){
        $table = "tapply";
        $where["id"] = $titleid;
        $where["stuid"] = null;
        $where["status"] = "已通过";
        $res = Db::name($table)
            ->where($where)
            ->find();

        $where["status"] = "正常";
        $where["titleid"] = $titleid;
        $where["belongsenior"] = getSenior();
        $notTe = Db::name("process")
            ->where($where)
            ->find();
        if($res && (!$notTe)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Description: 检验学生id是否合法
     * @DateTime:    2018/12/19 10:29
     * @Author:      fyd
     */
    private function checkStuId($stuid){
        $isExist = Db::name("student")
            ->where("id",$stuid)
            ->find();
        $where["status"] = "正常";
        $where["stuid"] = $stuid;
        $where["belongsenior"] = getSenior();
        $notSe = Db::name("process")
            ->where($where)
            ->find();
        if($isExist && (!$notSe)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Description: 检验教师id是否合法
     * @DateTime:    2018/12/19 10:37
     * @Author:      fyd
     */
    private function checkTeaId($teaid){
        $table = "teacher";
        $where["id"] = $teaid;
        $res = Db::name($table)
            ->where($where)
            ->find();
        if($res){
            return true;
        }else{
            return false;
        }
    }
    /**************************************************************************/
    //获取手动调节的两个列表  未选学生和题目

    /**
     * @Description: 获取未选题学生列表
     * @DateTime:    2018/12/19 9:27
     * @Author:      fyd
     */
    public function getStuList($page,$limit){
        $table = "student";
        $field = "id,stuidcard,stuname,stuclass,stuphone";
        $stuseid = $this->getStuSeId();
        $where["id"] = ["NOT IN",$stuseid];
        $stulist = Db::name($table)
            ->field($field)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $stulist;
    }

    public function getSList(){
        $table = "student";
        $field = "id,stuidcard,stuname,stuclass,stuphone";
        $stuseid = $this->getStuSeId();
        $where["id"] = ["NOT IN",$stuseid];
        $stulist = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        return $stulist;
    }

    public function getStuCount(){
        $table = "student";
        $field = "id,stuidcard,stuname,stuclass,stuphone";
        $stuseid = $this->getStuSeId();
        $where["id"] = ["NOT IN",$stuseid];
        $count = Db::name($table)
            ->field($field)
            ->where($where)
            ->count();
        return $count;
    }

    /**
     * @Description: 获取已经确定选题的学生id
     * @DateTime:    2018/12/19 9:45
     * @Author:      fyd
     */
    private function getStuSeId(){
        $table = "process";
        $field = "stuid";
        $where["status"] = "正常";
        $where["belongsenior"] = getSenior();
        $stuseid = [];
        $getStuList = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        $count = count($getStuList);
        for($i=0;$i<$count;$i++){
            $stuseid[$i] = $getStuList[$i]["stuid"];
        }
        return $stuseid;
    }
    /**
     * @Description: 获取未被选择的题目列表
     * @DateTime:    2018/12/19 9:28
     * @Author:      fyd
     */
    public function getTitleList($page,$limit){
        $table = "tapply";
        $alias = "gta";
        $join = [
            ["gmis_teacher gt", "gta.teaid = gt.id" , "INNER"]
        ];
        $field = "gta.id,title,teaid,gt.teaname,gt.teaphone";
        $where["belongsenior"] = getSenior();
        $where["stuid"] = null;
        $where["gta.status"] = "已通过";
        $titleList = Db::name($table)
            ->alias($alias)
            ->field($field)
            ->join($join)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $titleList;
    }

    public function getTList(){
        $table = "tapply";
        $alias = "gta";
        $join = [
            ["gmis_teacher gt", "gta.teaid = gt.id" , "INNER"]
        ];
        $field = "gta.id,title,teaid,gt.teaname,gt.teaphone";
        $where["belongsenior"] = getSenior();
        $where["stuid"] = null;
        $where["gta.status"] = "已通过";
        $titleList = Db::name($table)
            ->alias($alias)
            ->field($field)
            ->join($join)
            ->where($where)
            ->select();
        return $titleList;
    }

    public function getTitleCount(){
        $table = "tapply";
        $field = "id,title,teaid";
        $where["belongsenior"] = getSenior();
        $where["stuid"] = null;
        $where["status"] = "已通过";
        $count = Db::name($table)
            ->field($field)
            ->where($where)
            ->count();
        return $count;
    }
    /**************************************************************************/
    //手动调剂
    /**
     * @Description: 数据更新,手动调剂，两边各选一个
     * @DateTime:    2018/12/19 10:59
     * @Author:      fyd
     */
    public function upMyData($stuid,$titleid){
        $teaid = $this->getTeaidByTitleId($titleid);
        $checktea = $this->checkTeaId($teaid);
        $checkstu = $this->checkStuId($stuid);
        $checktitle = $this->checkTitleId($titleid);
        $saveProData = [
            "titleid"       =>      $titleid,
            "stuid"         =>      $stuid,
            "teaid"         =>      $teaid,
            "belongsenior"  =>      getSenior(),
            "weigh"         =>      0,
            "status"        =>      "正常",
            "createtime"    =>      time(),
            "updatetime"    =>      time()
        ];
        if($checkstu && $checktea && $checktitle){
            /**
             * 存储到process中，存储到tapply，这个函数中对于sselect的数据无需处理
             */
            Db::startTrans();
            try{
                $res1 = Db::name("process")->insert($saveProData);//插入process数据
                $where["status"] = "已通过";
                $where["id"] = $titleid;
                $where["stuid"] = null;
                $update = ["stuid"=>$stuid];
                $res2 = Db::name("tapply")
                    ->where($where)
                    ->update($update);
                $res3 = $this->changeSselect($stuid,$titleid);
                if($res1 && $res2 && $res3){
                    // 提交事务
                    Db::commit();
                    return 1; //成功
                }else{
                    Db::rollback();
                    return 2; //失败
                }
            }catch(\think\Exception\DbException $e){
                Db::rollback();
                return 4;
            }
        }else{
            return 3; //数据审核失败
        }
    }

    /**
     * @Description: 隐藏对应学生和题目的其余数据
     * @DateTime:    2018/12/20 8:30
     * @Author:      fyd
     */
    private function changeSselect($stuid,$titleid){
        $table = "sselect";
        $where["issubmit"] = 1;
        $where["isallow"] = 0;
        $where["titleid"] = $titleid;
        $where["stuid"] = $stuid;
        $where["belongsenior"] = getSenior();
        $where["status"] = "正常";
        $update = ["status"=>"隐藏"];
        $isExist = Db::name($table)
            ->where($where)
            ->find();
        // 如果存在就进行隐藏操作，否则就不操作，直接返回true
        if($isExist){
            $commonwhere["isallow"] = 0;
            $commonwhere["issubmit"] = 1;
            $commonwhere["belongsenior"] = getSenior();
            $commonwhere["status"] = "正常";
            try{
                //先把isallow置为1
                $res1 = Db::name($table)
                    ->where($where)
                    ->update(["isallow"=>1]);
                //把对应学生其余选择的内容置为隐藏
                $where2["stuid"] = $stuid;
                $where2["titleid"] = ["<>",$titleid];
                $flag2 = Db::name($table)
                    ->where($commonwhere)
                    ->where($where2)
                    ->find();
                if($flag2){
                    $res2 = Db::name($table)
                        ->where($commonwhere)
                        ->where($where2)
                        ->update($update);
                }else{
                    return true;
                }

                //把对应题目的其余申请置为隐藏
                $where3["stuid"] = ["<>",$stuid];
                $where3["titleid"] = $titleid;
                $flag3 = Db::name($table)
                    ->where($commonwhere)
                    ->where($where3)
                    ->find();
                if($flag3){
                    $res3 = Db::name($table)
                        ->where($commonwhere)
                        ->where($where3)
                        ->update($update);
                }else{
                    $res3 = true;
                }

                if($res1 && $res2 && $res3){
                    return true;
                }else{
                    Db::rollback();
                    return false;
                }
            }catch(\think\Exception\DbException $e){
                Db::rollback();
                return false;
            }
        }else{
            return true;
        }
    }
    /**************************************************************************/
    //自动调剂
    /**
     * @Description: 优先调剂存在的
     * @DateTime:    2018/12/20 9:48
     * @Author:      fyd
     */
    public function priorAdjust($titleid){
        $table = "sselect";
        $where["titleid"] = $titleid;
        $where["isallow"] = 0;
        $where["issubmit"] = 1;
        $where["status"] = "正常";
        $where["belongsenior"] = getSenior();
        $order = "createtime asc, updatetime asc, weigh desc";
        $limit = 1;
        $valname = "stuid";
        $stuid = Db::name($table)
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->value($valname);
        $res = $this->upMyData($stuid,$titleid);
        if($res==1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Description: 是否存在于sselect中
     * @DateTime:    2018/12/20 13:54
     * @Author:      fyd
     */
    public function isExTitle($titleid){
        $table = "sselect";
        $where["titleid"] = $titleid;
        $where["isallow"] = 0;
        $where["issubmit"] = 1;
        $where["belongsenior"] = getSenior();
        $where["status"] = "正常";
        $res = Db::name($table)
            ->where($where)
            ->find();
        if($res){
            return true;
        }else{
            return false;
        }
    }
    /**************************************************************************/
}
