<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/18 21:03
 * @Description: 描述信息
 */
namespace app\index\model;

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

    private function getStatus($status){
        if($status=="未开始"){
            $res = 0;
        }elseif ($status=="正在进行"){
            $res = 1;
        }elseif ($status=="已截止"){
            $res = 2;
        }

        return $res;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/18 21:07
     * @Description: 获取流程表
     */
    public function prochart(){
        $list = Prochart::order('id asc')->select();
        $total = count($list);
        for($i=0;$i<$total;$i++){
            $status = $this->getStatus($list[$i]['status']);
            $list[$i]['statusnum'] = $status;
        }

        return $list;
    }
}