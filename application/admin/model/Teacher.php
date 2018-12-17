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
        'teaduty_text',
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

    
    public function getTeadutyList()
    {
        return ['一岗' => __('一岗'),'二岗' => __('二岗'),'三岗' => __('三岗'),'四岗' => __('四岗'),'五岗' => __('五岗'),'六岗' => __('六岗'),'七岗' => __('七岗'),'八岗' => __('八岗'),'九岗' => __('九岗'),'十岗' => __('十岗'),'其它' => __('其它')];
    }     

    public function getTeahonorList()
    {
        return ['教授' => __('教授'),'副教授' => __('副教授'),'讲师' => __('讲师'),'助教' => __('助教'),'正高级实验师' => __('正高级实验师'),'高级实验师' => __('高级实验师'),'实验师' => __('实验师'),'助理实验师' => __('助理实验师'),'实验员' => __('实验员')];
    }     

    public function getStatusList()
    {
        return ['任教中' => __('任教中'),'未任教' => __('未任教')];
    }     


    public function getTeadutyTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['teaduty']) ? $data['teaduty'] : '');
        $list = $this->getTeadutyList();
        return isset($list[$value]) ? $list[$value] : '';
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
