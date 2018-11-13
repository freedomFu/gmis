<?php
namespace app\index\controller;
use app\index\model\Userlogin;
use think\Controller;
use think\Db;

class Login extends Controller
{

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 20:55
     * @Description: 判断用户登录情况
     */
    public function index(){
        $data = [
            'auth'      => 1,
            'username'  => '201509010110',
            'password'  => '123456'
        ];

        $login = new Userlogin();
        $res = $login->login($data);

        if($data['auth']==1){
            echo "这是学生用户！";
        }else{
            echo "这是教师用户！";
        }

        if(($res-3)%10 == 0){
            session('auth',$data['auth']);
            $this->success('登陆成功');
        }elseif(($res-2)%10 == 0){
            $this->error('密码错误');
        }elseif (($res-1)%10 == 0){
            $this->error('用户不存在');
        }
    }
}