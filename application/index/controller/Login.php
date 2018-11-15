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

class Login extends Controller
{

    public function index(){
        return '登录界面';
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 20:55
     * @Description: 判断用户登录情况
     */
    public function login(){
        $data = [
            'auth'      => 1,
            'username'  => '201509010110',
            'password'  => '848855'
        ];

        $login = new Userlogin();
        $res = $login->login($data);

        if($data['auth']==1){
            echo "这是学生用户！";
        }else{
            echo "这是教师用户！";
        }
        $url = 'Index/index';
        if(($res-3)%10 == 0){
            session('auth',$data['auth']);
            $this->success('登陆成功',$url);
        }elseif(($res-2)%10 == 0){
            $this->error('密码错误',$url);
        }elseif (($res-1)%10 == 0){
            $this->error('用户不存在',$url);
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:27
     * @Description: 找回密码，通过使用phpemail发送六位数字密码
     */
    public function findpass(){
        $id = session('uid'); //ID
        $auth = session('auth'); //Auth
        $emailPwd = '223344';
        $useremail = '1219532602@qq.com';

        $self = new Userlogin();
        $res = $self->findpass($auth,$id,$useremail);
        $url = "Index/index";
        switch ($res){
            case 1:
                $this->success("发送成功",$url);
            case 2:
                $this->error("不可为空",$url);
            case 3:
                $this->error("邮箱不符合规范",$url);
            case 0:
            case 4:
                $this->error("发送失败",$url);
            default:
                $this->error("未知错误",$url);
        }
    }
}
