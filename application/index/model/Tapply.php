<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 22:01
 * @Description: 描述信息
 */
namespace app\index\model;

use think\Model;
use think\Db;

class Tapply extends Model{
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
    public function getcreatetimeAttr($value,$data){
        $value = $value ? $value: (isset($data['refreshtime']) ? $data['createtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s",$value) : $value;
    }


    public function getRefreshtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['refreshtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/20 11:10
     * @Description: 展示当前教师的申请内容
     */
    public function show($teaid,$xq){
        $where['teaid'] = $teaid;
        $where['belongsenior'] = $xq;
        $maintable = 'tapply';
        $field = 'ta.id,title,nature,source,isnew,isprac,proname,note,ta.status,stuidcard,stuname,stuclass,stuphone';
        $mt = 'ta';
        $join = [
            ['gmis_student gs','gs.id=ta.stuid','LEFT'],
            ['gmis_profess gp','gp.id=ta.proid','LEFT'],
        ];
        $list = Db::name($maintable)
            ->alias($mt)
            ->join($join)
            ->field($field)
            ->where($where)
            ->select();
        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:53
     * @Description: 新增数据
     */
    public function add($data){
        $tapply = new Tapply($data);
        $title = $data['title'];
        $uniCheck = Tapply::checkTitle($title);
        if($uniCheck){
            return 2; //已经有存在的标题
        }

        $res = $tapply->save();
        if($res){
            return 1; //代表添加成功
        }else{
            return 0; //代表系统原因添加失败
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 11:01
     * @Description: 审核标题
     */
    protected static function checkTitle($title){
        $where['title'] = $title;
        $uniCheck = Tapply::where($where)
            ->find();
        if($uniCheck){
            return true; //已经有存在的标题
        }else{
            return false;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:53
     * @Description: $data是指新提交的数据
     */
    public function edit($id, $data){
        $tapply = new Tapply();
        $where['id'] = $id;

        $isAllow = $this->checkIsAllow($id);
        if($isAllow){
            return 3; // 已经通过申请，不能再添加了
        }

        $oldData = $tapply
            ->where($where)
            ->find();
        $oldTitle = $oldData['title']; //原来数据库中的标题
//        dump($oldTitle);
        $newTitle = $data['title']; //新输入的标题
//        dump($newTitle);
//        dump($oldTitle!=$newTitle);

        if($oldTitle!=$newTitle){ //标题发生变化
            $checkNewTitle = Tapply::checkTitle($newTitle);
            if($checkNewTitle){
                return 2; //新标题与数据库中数据重复
            }
        }
        $ta = Tapply::get($id);
        $res = $ta->save($data);
        if($res){
            return 1; //修改成功
        }else{
            return 0; //修改失败
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/18 20:26
     * @Description: 判断这个id对应的数据是不是已经通过，如果已经通过了，就不可以再编辑了
     */
    public function checkIsAllow($titleid){
        $where['id'] = $titleid;
        $isAllow = Tapply::where($where)
            ->value('status');
        if($isAllow == "已通过"){
            return 1;
        }elseif($isAllow == "未通过"){
            return 0;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/15 10:18
     * @Description: 删除数据
     */
    public function del($id){
        $isAllow = $this->checkIsAllow($id);
        if($isAllow){
            return 2; // 已经通过申请，不能再删除了
        }

        $ta = Tapply::get($id);
        if($ta){
            $res = $ta->delete();
            if($res){
                return 1; //删除成功
            }else{
                return 0; //删除失败
            }
        }else{
            return 3;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/18 15:33
     * @Description: 获取题目数量
     */
    public function getTitleNum($teaid){
        $where['id'] = $teaid;
        $tableName = 'teacher';
        $titleNum = Db::name($tableName)
            ->where($where)
            ->value('teatitlenum');
        return $titleNum;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/18 15:42
     * @Description: 获取已经申请的
     */
    public function getAppliedNum($teaid){
        $where['teaid'] = $teaid;
        $total = Tapply::where($where)
            ->count();
        return $total;
    }

}