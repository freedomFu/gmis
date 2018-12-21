<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 普通教师
 *
 * @icon fa fa-circle-o
 */
class Teacher extends Backend
{
    
    /**
     * Teacher模型对象
     * @var \app\admin\model\Teacher
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Teacher;
        $this->view->assign("teadutyList", $this->model->getTeadutyList());
        $this->view->assign("teahonorList", $this->model->getTeahonorList());
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
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            $mywhere = [];

            $getAuthId = $this->getWhereGroupId();
            if($getAuthId==1){
                $mywhere = [];
            }elseif($getAuthId==-1){
                $mywhere["id"] = -1;
            }else{
                $mywhere["teabelongid"] = $getAuthId;
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->where($mywhere)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->where($mywhere)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $totalnum = $this->model
                ->where($where)
                ->where($mywhere)
                ->sum("teatitlenum");

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list,"extend"=>['totalnum'=>$totalnum]);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * @Description: 获取当前groupid
     * @DateTime:    2018/12/15 20:33
     * @Author:      fyd
     */
    private function getWhereGroupId(){
        $id = $this->auth->id;
        $authid = Db::name("auth_group_access")
            ->where("uid",$id)
            ->value("group_id");

        if($authid){
            return $authid;
        }else{
            return -1;
        }
    }

}
