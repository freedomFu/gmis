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