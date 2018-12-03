<?php
namespace app\home\controller;
use app\home\model\Userlogin;
use think\Controller;

class Login extends Controller
{
    /**
     * @Description: 显示登录界面
     * @DateTime:    2018/11/28 7:18
     * @Author:      fyd
     */
    public function index(){
        return $this->fetch('Login/index');
    }

    /**
     * @Description: 登录功能
     * @DateTime:    2018/11/28 7:59
     * @Author:      fyd
     */
    public function login(){
        $data = [
            'auth'      => $_POST['auth'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password']
        ];

        $auth = $data['auth'];
        $name = $_POST['username'];
        $pass = $_POST['password'];
        if($auth!=1 && $auth!=2){
            falsePro(2,'登录方式非法');
            exit;
        }

        if($name=="" | $pass==""){
            falsePro(3,'用户名和密码不得为空');
            exit;
        }

        $login = new Userlogin();
        $res = $login->login($data);

        if(($res-3)%10 == 0){
            session('auth',$auth);
            session('isLogin',1);
            session('session_start_time',time());
            falsePro(0,'登录成功');
            exit;
        }elseif(($res-2)%10 == 0){
            falsePro(1,'密码错误');
            exit;
        }elseif (($res-1)%10 == 0){
            falsePro(1,'用户不存在');
            exit;
        }
    }

    /**
     * @Description: 找回密码，通过使用phpemail发送六位数字密码
     * @DateTime:    2018/11/27 10:33
     * @Author:      fyd
     */
    public function findpass(){
        $idcard = $_POST['username'];
        $auth = $_POST['auth'];
        $useremail = $_POST['useremail'];

        $self = new Userlogin();
        $res = $self->findpass($auth,$idcard,$useremail);

        switch ($res){
            case 1:
                falsePro(0,'发送成功');
                break;
            case 2:
                falsePro(1,'各项不可为空');
                break;
            case 3:
                falsePro(2,'邮箱不符合规范');
                break;
            case 0:
                falsePro(3,'找回失败');
                break;
            case 4:
                falsePro(3,'找回失败');
                break;
            case 4:
                falsePro(5,'用户不存在');
                break;
            default:
                falsePro(4,'未知错误');
                break;
        }
    }
}