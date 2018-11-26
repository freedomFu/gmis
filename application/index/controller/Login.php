<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 16:07
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\model\Userlogin;
use think\Controller;
use think\Session;

class Login extends Controller
{

    public function index(){
        return $this->fetch('user/login');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/23 14:33
     * @Description: 判断用户是否登录
     */
    private function isLogin(){
        $isLogin = \session('isLogin');
        if(!empty($isLogin)){
//            dump(Session::get());
            $this->error("您已经登录！","index/index");
            exit;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 20:55
     * @Description: 判断用户登录情况
     */
    public function login(){
        $data = [
            'auth'      => $_POST['auth'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password']
        ];

        $auth = $data['auth'];
        if($auth!=1 && $auth!=2){
            falsePro(2,'登录方式非法');
            exit;
        }
        $login = new Userlogin();
        $res = $login->login($data);

        if(($res-3)%10 == 0){
            session('auth',$auth);
            session('isLogin',1);
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

    public function showFind(){
        return $this->fetch("user/forgetpass");
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:27
     * @Description: 找回密码，通过使用phpemail发送六位数字密码
     */
    public function findpass(){
        $idcard = $_POST['id'];
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
                falsePro(3,'找回失败哦');
                break;
            case 4:
                falsePro(3,'找回失败');
                break;
            default:
                falsePro(4,'未知错误');
                break;
        }
    }
}
