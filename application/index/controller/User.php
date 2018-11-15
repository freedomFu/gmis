<?php
namespace app\index\controller;
use app\index\model\Userlogin;
use think\Controller;
use think\Db;

class User extends Controller
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
            $this->success('登陆成功','Index/index');
        }elseif(($res-2)%10 == 0){
            $this->error('密码错误','Index/index');
        }elseif (($res-1)%10 == 0){
            $this->error('用户不存在','Index/index');
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:26
     * @Description: 用户退出
     */
    public function logout(){
        session(null);
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
            'oldPwd'    => '234567',
            'newPwd'    => '123456',
            'conPwd'    => '123456'
        ];
        $user = new Userlogin();
        $res = $user->expass(1,1,$data);
        $url = 'Index/index';
        switch ($res){
            case 2:
                $this->error('原密码错误',$url);
                break;
            case 3:
                $this->error('两次密码不同',$url);
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


    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 22:27
     * @Description: 找回密码，通过使用phpemail发送六位数字密码
     */
    public function findpass(){
        $id = session('uid'); //ID
        $auth = session('auth'); //Auth
    }
}