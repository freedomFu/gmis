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
        $uniCheck = Tapply::where('title',$title)
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
        $oldData = $tapply
            ->where('id',$id)
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

    public function del($id){
        $ta = Tapply::get($id);
        $res = $ta->delete();
        if($res){
            return 1; //删除成功
        }else{
            return 0; //删除失败
        }
    }


}