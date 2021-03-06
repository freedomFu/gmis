<?php

namespace app\admin\model;

use think\Model;

class Sselect extends Model
{
    // 表名
    protected $name = 'sselect';
    
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

    
    public function getStatusList()
    {
        return ['正常' => __('正常'),'隐藏' => __('隐藏')];
    }     


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function student()
    {
        return $this->belongsTo('Student', 'stuid', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function tapply()
    {
        return $this->belongsTo('Tapply', 'titleid', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function teacher()
    {
        return $this->belongsTo('Teacher', 'teaid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
