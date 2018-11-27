<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Userlogin;
use think\Controller;
use think\Db;
use think\Session;

class User extends Base
{

    /**
     * @Description: 清空session
     * @DateTime:    2018/11/27 10:40
     * @Author:      fyd
     */
    private function delSession(){
        session('auth',0);
        session('username','0');
        session('uid',0);
        Session::delete('isLogin');
    }

    /**
     * @Description: 用户退出
     * @DateTime:    2018/11/27 10:41
     * @Author:      fyd
     */
    public function logout(){
        $this->delSession();
        $this->success('退出成功','Login/index');
    }

    /**
     * @Description: 显示修改密码页面
     * @DateTime:    2018/11/27 10:41
     * @Author:      fyd
     */
    public function showExpass(){
        return $this->fetch('user/expass');
    }

    /**
     * @Description: 修改密码
     * @DateTime:    2018/11/27 10:41
     * @Author:      fyd
     */
    public function expass(){
        // 获取当前用户的身份和ID
        $id = session('uid'); //ID
        $auth = session('auth'); //Auth
        $data = [
            'oldPwd'    => $_POST['oldPwd'],
            'newPwd'    => $_POST['newPwd'],
            'conPwd'    => $_POST['conPwd']
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
                $this->delSession();
                falsePro(0,'修改成功,请重新登录');
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