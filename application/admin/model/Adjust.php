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
        if($res){
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
        $where["stauts"] = "正常";
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
    public function getStuList(){
        $table = "student";
        $field = "id,stuname";
        $stuseid = $this->getStuSeId();
        $where["id"] = ["NOT IN",$stuseid];
        $stulist = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        return $stulist;
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
    public function getTitleList(){
        $table = "tapply";
        $field = "";
        $where["belongsenior"] = getSenior();
        $where["stuid"] = null;
        $where["status"] = "已通过";
        $titleList = Db::name($table)
            ->where($where)
            ->select();
        return $titleList;
    }

    /**
     * @Description: 数据更新,自动调剂
     * @DateTime:    2018/12/19 10:59
     * @Author:      fyd
     */
    public function upMyData($stuid,$titleid){
        $teaid = $this->getTeaidByTitleId($titleid);
        $checktea = $this->checkTeaId($teaid);
        $checkstu = $this->checkStuId($stuid);
        $checktitle = $this->checkTitleId($titleid);

        if($checkstu && $checktea && $checktitle){

        }else{
            return 3; //数据审核失败
        }

        $saveProData = [
            "titleid"       =>      $titleid,
            "stuid"         =>      $stuid,
            "teaid"         =>      $teaid,
            "belongsenior"  =>      getSenior(),
            "weigh"         =>      0,
            "status"       =>      "正常"
        ];

        /**
         * 存储到process中，存储到tapply，这个函数中对于sselect的数据无需处理
         */
        Db::startTrans();
        try{

            // 提交事务
            Db::commit();
        }catch(\think\Exception\DbException $e){
            Db::rollback();
        }
    }
    /**************************************************************************/
    /**
     * @Description: 把对应学生的其他选择隐藏
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    private function cutdownStu($stuid, $id){
        $table = 'sselect';
        $field = 'id';
        $where['status'] = '正常';
        $where['stuid'] = $stuid;
        $stuidArr = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        $count = count($stuidArr);
        for ($i=0;$i<$count;$i++){
            $checkid = $stuidArr[$i]['id'];
            if($checkid==$id){
                continue;
            }
            $update = ['status'=>'隐藏'];
            $wherecheck['id'] = $checkid;
            Db::name($table)
                ->where($wherecheck)
                ->update($update);
        }
    }

    /**
     * @Description: 修改tapply表中的数据
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    private function dbTaUpdate($id){
        $stuid = $this->ccselect($id,'stuid');
        $title = $this->ccselect($id,'titleid');
        $table = 'tapply';
        $where['id'] = $title;
        $where['status'] = '已通过';
        $where['stuid'] = null;
        $update = ['stuid'=>$stuid];
        $res = Db::name($table)
            ->where($where)
            ->update($update);
        return $res;
    }

    /**
     * @Description: 添加到process表中
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    private function dbProUpdate($id){
        $titleid = $this->ccselect($id,'titleid');
        $stuid = $this->ccselect($id,'stuid');
        $teaid = $this->ccselect($id,'teaid');

        $data = [
            'titleid'       =>  $titleid,
            'stuid'         =>  $stuid,
            'teaid'         =>  $teaid,
            'belongsenior'  =>  getSenior()
        ];
        $pro = new Process();
        $pro -> save($data);
    }

    /**
     * @Description: 确认选择这个学生
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    public function chooseTitle($id){
        $table = 'sselect';
        $stuid = $this->ccselect($id,'stuid');
        $isallow = $this->ccselect($id,'isallow');

        if($isallow==1){
            return 2; //这一项已经通过了申请，不能再更新
        }
        $where['id'] = $id;
        $where['issubmit'] = 1;
        $updatedata = ['isallow'=>1];
        Db::startTrans();
        try{
            $res = Db::name($table)
                ->where($where)
                ->update($updatedata);
            $this->cutdownStu($stuid,$id);
            $this->dbTaUpdate($id);
            $this->dbProUpdate($id);
            // 提交事务
            Db::commit();
        }catch(\think\Exception\DbException $e){
            Db::rollback();
            return 3;
        }

        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    /**************************************************************************/
}
