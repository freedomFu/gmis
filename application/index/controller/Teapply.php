<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 22:15
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Tapply;
use think\Controller;
use think\Db;

class Teapply extends Base
{
    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:03
     * @Description: 判断是不是教师权限
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 22:17
     * @Description: 显示该教师已经申请过的内容
     */
    public function index(){
        $this->isTeacher();
        $teapply = new Tapply();
        $id = session('uid');
        $titlenum = $teapply->getTitleNum($id);  //允许的个数
        $appliedNum = $teapply->getAppliedNum($id);  //已经提交申请的数目
        $leftNum = $titlenum-$appliedNum;
        $xq = getSenior();
        $list = $teapply->show($id,$xq);
        $this->assign('leftnum',$leftNum);
        $this->assign('tapplylist',$list);
        return $this->fetch('tapply/index');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 22:19
     * @Description: 添加数据测试
     */
    public function add(){
        $this->isTeacher();
        $teapply = new Tapply();
        $stuid = session('uid');
        $titlenum = $teapply->getTitleNum($stuid);  //允许的个数
        $appliedNum = $teapply->getAppliedNum($stuid);  //已经提交申请的数目
        $url = 'index';
        if($titlenum<=$appliedNum){
            $this->error("您已经没有剩余名额了",$url);
        }

        $teaid = session('uid');
        $data = [
            'title'         =>  '测试管理系统',
            'nature'        =>  '未知',
            'source'        =>  '未知',
            'isnew'         =>  '0',
            'isprac'        =>  '1',
            'teaid'         =>  $teaid,
            'proid'         =>  5,
            'note'          =>  '无',
            'belongsenior'  =>  getSenior()
        ];

        $res = $teapply->add($data);
        if($res == 1){
            $this->success("添加成功",$url);
        }elseif($res ==2){
            $this->error("已经有这个题目了",$url);
        }else{
            $this->error("添加失败",$url);
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:50
     * @Description: 修改申请信息
     */
    public function edit(){
        $this->isTeacher();
//        $id = input('id');
        $id = 4;

        $data = [
            'title'     =>  '基于物联网系统的防护系统',
            'nature'    =>  '未知',
            'source'    =>  '不知道',
            'isnew'     =>  '0',
            'isprac'    =>  '1',
            'note'      =>  '无'
        ];

        $teapply = new Tapply();
        $res = $teapply->edit($id,$data);
        $url = 'index';
        if($res == 1){
            $this->success('修改成功',$url);
        }elseif($res == 2){
            $this->error('重复的题目',$url);
        }elseif($res==3){
            $this->error('已经通过申请，不能修改了',$url);
        }else{
            $this->error('修改失败',$url);
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 15:09
     * @Description: 删除数据
     */
    public function del(){
        $this->isTeacher();
        $teapply = new Tapply();
//        $id = input('id');
        $id = 16;
        $res = $teapply->del($id);
        $url = 'index';
        if($res){
            $this->success('删除成功',$url);
        }else{
            $this->error('删除失败',$url);
        }
    }

    public function test(){
        $teapply = new Tapply();
        echo $teapply->checkIsAllow(14);
    }
}