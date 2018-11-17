<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 21:48
 * @Description: 描述信息
 */

namespace app\index\model;
use app\index\model\Tapply;
use think\Model;
use think\Db;

class Sselect extends Model
{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * 学生选择论文题目
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

    public function sselect($teaid){
        $list = Sselect::order('id desc')
            ->where('teaid',$teaid)
            ->paginate(10);
        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:15
     * @Description: 获取筛选信息
     */
    public function showApplyTitle($professid, $titlekey,$senior){
        $where['belongsenior']=$senior;
        $where['status'] = "已通过";
        //都没有传入
        if(!($professid==0)){
            $where['proid'] = $professid;
        }

        if(!empty($titlekey)){
            $where['title'] = ['like','%'.$titlekey.'%'];
        }

        $list = Tapply::where($where)
            ->order('id desc')
            ->select();

        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:45
     * @Description: 根据专业id获取专业名称
     */
    public function getProfessName($professid){
        $where['id']=$professid;
        $res = Db::name('profess')
            ->where($where)
            ->find();
        return $res['proname'];
    }

}