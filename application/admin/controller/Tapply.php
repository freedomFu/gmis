<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 毕设题目申请管理
 *
 * @icon fa fa-circle-o
 */
class Tapply extends Backend
{
    
    /**
     * Tapply模型对象
     * @var \app\admin\model\Tapply
     */
    protected $model = null;
    protected $multiFields = "status";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Tapply;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            //$where这里说是 Cannot use object of type Closure as array   闭包不能作为数组  所以可以重新声明一个where条件  也要注意ambigious问题  或者强制转型成array
            /*$where = (array)$where;
            $where["tapply.id"]=1;*/
            $mywhere = [];

            $getAuthId = $this->getWhereProId();
            if($getAuthId==0){
                $mywhere = [];
            }elseif($getAuthId==-1){
                $mywhere["tapply.id"] = -1;
            }else{
                $mywhere["tapply.proid"] = $getAuthId;
            }

            $total = $this->model
                    ->with(['profess','student','teacher'])
                    ->where($where)
                    ->where($mywhere)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['profess','student','teacher'])
                    ->where($where)
                    ->where($mywhere)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            foreach ($list as $row) {
                
                $row->getRelation('profess')->visible(['proname']);
				$row->getRelation('student')->visible(['stuidcard','stuname','stuclass','stuphone']);
				$row->getRelation('teacher')->visible(['teaname']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * @Description: 获取当前
     * @DateTime:    2018/12/15 20:33
     * @Author:      fyd
     */
    private function getWhereProId(){
        $id = $this->auth->id;
        $authid = Db::name("auth_group_access")
            ->where("uid",$id)
            ->value("group_id");
        $groupname = Db::name("auth_group")
            ->where("id",$authid)
            ->value("name");
        $res = Db::name("profess")
            ->where("proname",$groupname)
            ->find();

        if($groupname=="Admin group"){
            return 0;
        }elseif($res){
            return $this->getProId($groupname);
        }else{
            return -1;
        }
    }

    private function getProId($proname){
        $id = Db::name("profess")
            ->where("proname",$proname)
            ->value("id");
        return $id;
    }
}
