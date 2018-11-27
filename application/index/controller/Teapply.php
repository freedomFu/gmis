<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Tapply;
use think\Controller;
use think\Db;

class Teapply extends Base
{
    /**
     * @Description: 判断是不是教师权限
     * @DateTime:    2018/11/27 10:36
     * @Author:      fyd
     */
    private function isTeacher(){
        if(session('auth')!=2){
            $this->error("您没有权限操作！","Login/index");
        }
    }

    /**
     * @Description: 显示界面
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
     */
    public function show(){
        $this->isTeacher();
        $teapply = new Tapply();
        $profess = $teapply->showProfess();
        $this->assign('profess',$profess);
        return $this->fetch('tapply/teacher');
    }

    /**
     * @Description: 显示该教师已经申请过的内容
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
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
        falsePro(0,'',$list,$titlenum,$leftNum);
    }

    /**
     * @Description: 添加数据
     * @DateTime:    2018/11/27 10:37
     * @Author:      fyd
     */
    public function add(){
        $this->isTeacher();
        $teapply = new Tapply();
        $teaid = session('uid');
        $titlenum = $teapply->getTitleNum($teaid);  //允许的个数
        $appliedNum = $teapply->getAppliedNum($teaid);  //已经提交申请的数目
        if($titlenum<=$appliedNum){
            falsePro(3,"您已经没有剩余名额了！");
            exit;
        }
        $isnew = $this->isTrue($_POST['isnew']);
        $isprac = $this->isTrue($_POST['isprac']);
        $data = [
            'title'         =>  $_POST['title'],
            'nature'        =>  $_POST['nature'],
            'source'        =>  $_POST['source'],
            'isnew'         =>  $isnew,
            'isprac'        =>  $isprac,
            'teaid'         =>  $teaid,
            'proid'         =>  $_POST['proid'],
            'belongsenior'  =>  getSenior()
        ];

        $res = $teapply->add($data);
        if($res == 1){
            falsePro(0,"添加成功");
        }elseif($res ==2){
            falsePro(2,"题目重复");
        }else{
            falsePro(1,"添加失败");
        }
    }

    /**
     * @Description: 根据boolean返回值
     * @DateTime:    2018/11/27 10:38
     * @Author:      fyd
     */
    private function isTrue($bool){
        if($bool=="true"){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @Description: 修改申请信息
     * @DateTime:    2018/11/27 10:38
     * @Author:      fyd
     */
    public function edit(){
        $this->isTeacher();
        $id = $_POST['id'];
        $isnew = $this->isTrue($_POST['isnew']);
        $isprac = $this->isTrue($_POST['isprac']);
        $data = [
            'title'     =>  $_POST['title'],
            'nature'    =>  $_POST['nature'],
            'source'    =>  $_POST['source'],
            'isnew'     =>  $isnew,
            'isprac'    =>  $isprac,
            'proid'     =>  $_POST['proid']
        ];

        $teapply = new Tapply();
        $res = $teapply->edit($id,$data);
        if($res == 1){
            falsePro(0,"修改成功");
        }elseif($res == 2){
            falsePro(2,"题目出现重复");
        }elseif($res==3){
            falsePro(3,"已经通过申请，不可以再修改");
        }else{
            falsePro(1,"修改失败");
        }
    }

    /**
     * @Description: 删除数据
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function del(){
        $this->isTeacher();
        $teapply = new Tapply();
        $id = $_POST['id'];
        $res = $teapply->del($id);
        if($res==1){
            falsePro(0,"删除成功");
        }elseif($res==2){
            falsePro(2,"已经通过申请，不可删除");
        }elseif($res==3){
            falsePro(3,"id不存在");
        }else{
            falsePro(1,"删除失败");
        }
    }

    /**
     * @Description: 教师选择学生
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function showSelectStu(){
        $this->isTeacher();
        $ta = new Tapply();
        $teaid = session('uid');
        $xq = getSenior();
        $list = $ta->showSelectStu($teaid,$xq);
        falsePro('0','',$list);
    }

    /**
     * @Description: 选择学生,需要对应的id
     * @DateTime:    2018/11/27 10:39
     * @Author:      fyd
     */
    public function chooseTitle(){
        $this->isTeacher();

        $ta = new Tapply();
        $id = $_POST['id'];
        $res = $ta->chooseTitle($id);

        switch ($res){
            case 2:
                falsePro(2,"这一项已经通过申请！");
                break;
            case 1:
                falsePro(0,"确认成功");
                break;
            case 0:
                falsePro(1,"确认失败");
                break;
            default:
                falsePro(3,"未知错误");
                break;
        }
    }
}