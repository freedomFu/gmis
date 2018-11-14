<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 22:15
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\model\Tapply;
use think\Controller;
use think\Db;

class Teapply extends Controller
{
    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 22:17
     * @Description: 显示添加申请的表单
     */
    public function index(){
        return 123;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 22:19
     * @Description: 添加数据测试
     */
    public function add(){
        $data = [
            'title'     =>  '基于NBA的金秋杯的管理系统',
            'nature'    =>  '未知',
            'source'    =>  '未知',
            'isnew'     =>  '0',
            'isprac'    =>  '1',
            'note'      =>  '无'
        ];

        $teapply = new Tapply();
        $res = $teapply->add($data);
        if($res == 1){
            $this->success("添加成功",'index');
        }elseif($res ==2){
            $this->error("已经有这个题目了",'index');
        }else{
            $this->error("添加失败",'index');
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:50
     * @Description: 修改申请信息
     */
    public function edit(){
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
        if($res == 1){
            $this->success("修改成功",'index');
        }elseif($res == 2){
            $this->error("重复的题目",'index');
        }else{
            $this->error("修改失败",'index');
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 15:09
     * @Description: 删除数据
     */
    public function del(){
        $teapply = new Tapply();
//        $id = input('id');
        $id = 16;
        $res = $teapply->del($id);
        if($res){
            $this->success("删除成功",'index');
        }else{
            $this->error("删除失败",'index');
        }
    }
}