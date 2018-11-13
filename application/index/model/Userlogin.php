<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 14:45
 * @Description: 用户模型
 */
namespace app\index\model;
use think\Model;
use think\Db;

class Userlogin extends Model
{
    public function login($data){
        $auth = $data['auth'];
        if($auth == 1){
            $res = $this->check($data,'student','stuidcard','stupwd');
            $res = '1'.$res;
        }elseif ($auth == 2){
            $res = $this->check($data,'teacher','teaidcard','teapwd');
            $res = '2'.$res;
        }
        return $res;
    }


    /**
     * @Author:      fyd
     * @DateTime:    2018/11/13 15:16
     * @Description: 登录审核
     */
    private function check($data, $name,$idcard,$pwd){
        $user = Db::name($name)
            -> where($idcard,$data['username'])
            -> find();
        dump($user);

        if($user){
            if($user[$pwd] == $data['password']){
                session('username',$data['username']);
                session('uid',$user['id']);
                return 3; //信息正确
            }else{
                return 2; //密码错误
            }
        }else{
            return 1; //用户不存在
        }
    }
}