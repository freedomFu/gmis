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
        $this->success('退出成功','Login/index');
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
            'oldPwd'    => '621191',
            'newPwd'    => '123456',
            'conPwd'    => '123456'
        ];
        $user = new Userlogin();
        $res = $user->expass($auth,$id,$data);

        //判断情况
        switch ($res){
            case 2:
                falsePro(2,'原密码错误');
                break;
            case 3:
                falsePro(3,'两次密码输入不匹配');
                break;
            case 4:
                falsePro(4,'密码输入不规范');
                break;
            case 1:
                falsePro(0,'修改成功');
                break;
            case 0:
                falsePro(1,'修改失败');
                break;
            default:
                falsePro(5,'未知错误');
                break;
        }
    }

}