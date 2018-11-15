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
        $where[$idcard] = $data['username'];
        $user = Db::name($name)
            -> where($where)
            -> find();
//        dump($user);

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

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/15 10:33
     * @Description: 修改密码
     */
    public function expass($auth, $id,$data){
        $table = $this->findTable($auth);
        $tablename = $table[0];
        $pwdname = $table[1];
        $where['id'] = $id;
        $oldPwd = $data['oldPwd'];
        $newPwd = $data['newPwd'];
        $conPwd = $data['conPwd'];
        $tableData = Db::name($tablename)
            ->where($where)
            ->find();

        switch (true){
            case enctypePw($oldPwd)!=$tableData[$pwdname]:
                return 2; //原密码错误！
            case $newPwd!=$conPwd:
                return 3; //两次密码不同
            default:
                break;
        }

        dump($tableData);
        $pass = enctypePw($newPwd);
        $update = [$pwdname=>$pass];
        $res = Db::name($tablename)
            ->where($where)
            ->update($update);

        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/15 10:36
     * @Description: 根据用户auth获取表
     */
    private function findTable($auth){
        if($auth==1){
            $table = ['student','stupwd'];
        }elseif($auth==2){
            $table = ['teacher','teapwd'];
        }
        return $table;
    }
}