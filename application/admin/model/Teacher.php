<?php

namespace app\admin\model;

use think\Model;

class Teacher extends Model
{
    // 表名
    protected $name = 'teacher';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'teahonor_text',
        'status_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getTeahonorList()
    {
        return ['助教' => __('助教'),'讲师' => __('讲师'),'副教授' => __('副教授'),'教授' => __('教授')];
    }     

    public function getStatusList()
    {
        return ['任教中' => __('任教中'),'未任教' => __('未任教')];
    }     


    public function getTeahonorTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['teahonor']) ? $data['teahonor'] : '');
        $list = $this->getTeahonorList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
