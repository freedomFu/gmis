<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Userlogin;
use think\Controller;
use think\Db;

class User extends Base
{

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:26
     * @Description: 用户退出
     */
    public function logout(){
        session('auth',0);
        session('username','0');
        session('uid',0);
        $this->success('退出成功','Index/index');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:27
     * @Description: 修改密码
     */
    public function expass(){
        // 获取当前用户的身份和ID
        $id = session('uid'); //ID
        $auth = session('auth'); //Auth
        $data = [
            'oldPwd'    => '848855',
            'newPwd'    => '123456',
            'conPwd'    => '123456'
        ];
        $user = new Userlogin();
        $res = $user->expass(1,1,$data);
        $url = 'Index/index';
        //判断情况
        switch ($res){
            case 2:
                $this->error('原密码错误',$url);
                break;
            case 3:
                $this->error('两次密码不同',$url);
                break;
            case 4:
                $this->error('密码不符合规范',$url);
                break;
            case 1:
                $this->success('修改成功',$url);
                break;
            case 0:
                $this->error('修改失败',$url);
                break;
            default:
                $this->error('未知错误',$url);
        }
    }

}