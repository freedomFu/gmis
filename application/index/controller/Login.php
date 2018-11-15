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
            'password'  => '431677'
        ];

        $data['password'] = enctypePw($data['password']);

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
     * @DateTime:    2018/11/14 22:26
     * @Description: 用户退出
     */
    public function logout(){
        session('auth',0);
        session('username','0');
        session('uid',0);
        $this->success('退出成功','Index/index');
    }
}
