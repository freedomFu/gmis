<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"C:\wamp64\www\gmis\public/../application/index\view\common\base.html";i:1543193354;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>首页</title>
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/home/css/base.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">选课系统</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li onclick="liclick(this)" class="active"><a href="http://127.0.0.1/gmis/public/index/Index/index" target="fra" >首页</a></li>
                <?php if(\think\Request::instance()->session('auth') == 1): ?>
                <li onclick="liclick(this)" ><a href="http://127.0.0.1/gmis/public/index/Stuselect/show" target="fra">学生选题</a></li>
                <?php endif; if(\think\Request::instance()->session('auth') == 2): ?>
                <li onclick="liclick(this)"><a href="http://127.0.0.1/gmis/public/index/Teapply/show.html" target="fra">申请题目</a></li>
                <li onclick="liclick(this)"><a href="http://127.0.0.1/gmis/public/index/Teapply/show.html" target="fra">老师选学生</a></li>
                <?php endif; ?>
                <!--<li onclick="liclick(this)"><a href="../调剂平台/调剂平台.html" target="fra">调剂平台</a></li>-->
                <li onclick="liclick(this)"><a href="http://127.0.0.1/gmis/public/index/User/showExpass" target="fra">修改密码</a></li>
                <li onclick="liclick(this)"><a href="http://127.0.0.1/gmis/public/index/User/logout" target="fra">退出</a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="content">
    <iframe  name="fra" src="http://127.0.0.1/gmis/public/index/Index/index" frameborder="0"></iframe>
</div>
<script src="https://code.jquery.com/jquery.js"></script>
<script>
    function liclick(x){
        for(var i=0;i<$(".nav li").length;i++){
            $(".nav li").removeClass("active");
        }
        $(x).addClass("active")
    }
</script>
</body>
</html>

