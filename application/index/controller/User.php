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
     * @DateTime:    2018/11/14 22:27
     * @Description: 修改密码
     */
    public function expass(){
        // 获取当前用户的身份和ID
        $id = session('uid'); //ID
        $auth = session('auth'); //Auth
        $data = [
            'oldPwd'    => '123456',
            'newPwd'    => '223344',
            'conPwd'    => '223344'
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