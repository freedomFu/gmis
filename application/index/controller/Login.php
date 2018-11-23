<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 16:07
 * @Description: 描述信息
 */
namespace app\index\controller;
use app\index\model\Userlogin;
use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{

    public function index(){
        return $this->fetch('user/login');
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 20:55
     * @Description: 判断用户登录情况
     */
    public function login(){
        $data = [
            'auth'      => 2,
            'username'  => '334455',
            'password'  => '123456'
        ];
//        $data = input('data');
        $auth = $data['auth'];
        if($auth!=1 && $auth!=2){
            falsePro(2,'登录方式非法');
            exit;
        }
        $login = new Userlogin();
        $res = $login->login($data);

        if(($res-3)%10 == 0){
            session('auth',$auth);
            dump(Session::get());
            falsePro(0,$auth.'登录成功');
            exit;
        }elseif(($res-2)%10 == 0){
            falsePro(1,'密码错误');
            exit;
        }elseif (($res-1)%10 == 0){
            falsePro(1,'用户不存在');
            exit;
        }



        /*if($data['auth']==1){
            echo "这是学生用户！";
        }else{
            echo "这是教师用户！";
        }*/
        /*$json = ['success'=>0,'succmsg'=>'cc'];
        echo json_encode($json,JSON_UNESCAPED_UNICODE);*/
        /*$url = 'Login/index';
        if(($res-3)%10 == 0){
            session('auth',$data['auth']);
            $this->success('登陆成功','Index/index');
        }elseif(($res-2)%10 == 0){
            $this->error('密码错误',$url);
        }elseif (($res-1)%10 == 0){
            $this->error('用户不存在',$url);
        }*/
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:27
     * @Description: 找回密码，通过使用phpemail发送六位数字密码
     */
    public function findpass(){
        //$data['useremail']
        $idcard = '201509010106';
        $auth = 1;
        $useremail = 'fuyanduo_1026@sina.com';

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

        /*$url = "Index/index";
        switch ($res){
            case 1:
                $this->success("发送成功",$url);
            case 2:
                $this->error("不可为空",$url);
            case 3:
                $this->error("邮箱不符合规范",$url);
            case 0:
            case 4:
                $this->error("找回失败",$url);
            default:
                $this->error("未知错误",$url);
        }*/
    }
}
