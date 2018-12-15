<?php

namespace app\admin\model;

use think\Model;

class Process extends Model
{
    // 表名
    protected $name = 'process';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'middlescore_text',
        'replyscore_text',
        'status_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getMiddlescoreList()
    {
        return ['优' => __('优'),'良' => __('良'),'中' => __('中'),'通过' => __('通过'),'不通过' => __('不通过'),'未填写' => __('未填写')];
    }     

    public function getReplyscoreList()
    {
        return ['优' => __('优'),'良' => __('良'),'中' => __('中'),'通过' => __('通过'),'不通过' => __('不通过'),'未填写' => __('未填写')];
    }     

    public function getStatusList()
    {
        return ['正常' => __('正常'),'隐藏' => __('隐藏')];
    }     


    public function getMiddlescoreTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['middlescore']) ? $data['middlescore'] : '');
        $list = $this->getMiddlescoreList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getReplyscoreTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['replyscore']) ? $data['replyscore'] : '');
        $list = $this->getReplyscoreList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function tapply()
    {
        return $this->belongsTo('Tapply', 'titleid', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function student()
    {
        return $this->belongsTo('Student', 'stuid', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function teacher()
    {
        return $this->belongsTo('Teacher', 'teaid', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
