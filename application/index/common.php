<?php

/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 16:03
 * @Description: 加密密码
 */
function enctypePw($password){
    $sha1 = sha1($password); // sha1加密
    $base64 = base64_encode($sha1); //base64编码加密
    return md5($base64); //md5加密
}

/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 14:41
 * @Description: 判断邮箱
 */
function isEmail($email){
    $flag = false;
    $match = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
    if(preg_match($match,$email)){
        $flag = true;
    }
    return $flag;
}

/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 14:42
 * @Description: 判断密码是否合法
 */
function isPw($password){
    $flag = false;
    $match = "/^[a-zA-Z0-9]{4,16}$/";
    if(preg_match($match,$password)){
        $flag = true;
    }
    return $flag;
}

/**
 * @Author:      fyd
 * @DateTime:    2018/11/22 14:42
 * @Description: 获取当前学期
 */
function getSenior(){
    $thisyear = date("Y");
    $lastyear = date("Y")-1;
    $nextyear = date("Y")+1;

    $thismonth = date("m");

    if($thismonth<9){
        $senior = $lastyear.'-'.$thisyear;
    }else{
        $senior = $thisyear.'-'.$nextyear;
    }

    return $senior;
}

/**
 * @Author:      fyd
 * @DateTime:    2018/11/22 14:42
 * @Description: 返回json数据
 */
function falsePro($errno, $errmsg){
    $json = ['errno'=>$errno,'errmsg'=>$errmsg];
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
}
