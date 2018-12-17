<?php
namespace app\home\model;
use app\home\model\Comclass;
use think\Model;

class Upfile extends Model
{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';


    /**
     * @Description: 添加任务书到数据库
     * @DateTime:    2018/12/16 21:58
     * @Author:      fyd
     */
    public function addassign($data){
        $where["belongsenior"] = $data["belongsenior"];
        $where["processid"] = $data["processid"];
        $where["type"] = $data["type"];
        $isExist = Upfile::where($where)
            ->find();
        if($isExist){
            $id = $isExist["id"];
            $u = Upfile::get($id);
            $u->save($data);
            return 2;//已经存在更新数据
        }else{
            $res = Upfile::save($data);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function downassign($proid,$type,$senior){
        $where["belongsenior"] = $senior;
        $where["processid"] = $proid;
        $where["type"] = $type;
        $file = Upfile::where($where)
            ->find();
        if($file){
            $returndata = [
                "filename"      =>      $file["filename"],
                "filepath"      =>      $file["filepath"],
                "fileext"       =>      $file["fileext"]
            ];
            return $returndata;
        }else{
            return false;
        }



    }

}