<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 上传文件管理
 *
 * @icon fa fa-circle-o
 */
class Upfile extends Backend
{
    
    /**
     * Upfile模型对象
     * @var \app\admin\model\Upfile
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Upfile;
        $this->view->assign("typeList", $this->model->getTypeList());
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

            $mywhere = [];

            $getAuthId = $this->getWhereGroupId();
            $getTeaId = $this->getTeaList();
            $getProId = $this->getProList();
            if($getAuthId==1){
                $mywhere = [];
            }elseif($getAuthId==-1){
                $mywhere["upfile.id"] = -1;
            }else{
                $mywhere["upfile.processid"] = ["in",$getProId];
            }

            $total = $this->model
                    ->with(['process'])
                    ->where($where)
                    ->where($mywhere)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['process'])
                    ->where($where)
                    ->where($mywhere)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            for($i=0;$i<$total;$i++){
                $filepath = $list[$i]["filepath"];
                $filename = $list[$i]["filename"].".".$list[$i]["fileext"];
                $list[$i]["filepath"] = SITE_URL."/".$filepath."/".$filename;
                $list[$i]["filepath"] = str_replace('\\','/',$list[$i]["filepath"]);

                $stuid = $list[$i]["process"]["stuid"];
                $teaid = $list[$i]["process"]["teaid"];
                $list[$i]["process"]["stuname"] = $this->getName($stuid,"student","stuname");
                $list[$i]["process"]["teaname"] = $this->getName($teaid,"teacher","teaname");
            }

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

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

    private function getTeaList(){
        $groupId = $this->getWhereGroupId();
        $table = "teacher";
        $where["teabelongid"] = $groupId;
        $field = "id";
        $tealist = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        $teaid = [];
        for($i=0;$i<count($tealist);$i++){
            $teaid[$i] = $tealist[$i]["id"];
        }
        return $teaid;
    }

    private function getProList(){
        $teaid = $this->getTeaList();
        $table = "process";
        $where["teaid"] = ["in",$teaid];
        $where["status"] = "正常";
        $field = "id";
        $prolist = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        $proid = [];
        for($i=0;$i<count($prolist);$i++){
            $proid[$i] = $prolist[$i]["id"];
        }
        return $proid;
    }

    /**
     * @Description: 获取姓名
     * @DateTime:    2018/12/18 14:29
     * @Author:      fyd
     */
    private function getName($id, $table,$colname){
        $where["id"] = $id;
        $name = Db::name($table)
            ->where($where)
            ->value($colname);
        return $name;

    }
}
