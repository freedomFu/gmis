<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"C:\wamp64\www\gmis\public/../application/home\view\Login\index.html";i:1545397339;}*/ ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/fhome/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/fhome/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/fhome/css/demo.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/fhome/css/component.css" />
    <script src="http://127.0.0.1/gmis/public/fhome/layui/layui.js"></script>
    <script src="http://127.0.0.1/gmis/public/fhome/js/login.js"></script>
    <script src="http://127.0.0.1/gmis/public/fhome/js/html5.js"></script>

</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3 style="font-size:40px;">毕业设计选题系统</h3>
                <form action="#" name="f" method="post" class="layui-form">
                    <div class="input_radio">
                        <div id="radioAuth">
                            <input type="radio" name="auth" value="1" title="学生" checked>
                            <input type="radio" name="auth" value="2" title="教师" checked>
                        </div>
                    </div>

                    <div class="input_outer">
                        <div class="layui-form-item">
                            <span class="u_user"><label class="layui-form-label"></label></span>
                                <input name="username" lay-verify="required" required class="layui-input text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
                        </div>
                    </div>

                    <div class="input_outer">
                        <div class="layui-form-item">
                        <span class="us_uer"><label class="layui-form-label"></label></span>
                        <input name="password" lay-verify="required" required class="layui-input text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="mb2"><button class="layui-btn act-but" id="userLog" lay-submit lay-filter="userLog">登录</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->

<script src="http://127.0.0.1/gmis/public/fhome/js/TweenLite.min.js"></script>
<script src="http://127.0.0.1/gmis/public/fhome/js/EasePack.min.js"></script>
<script src="http://127.0.0.1/gmis/public/fhome/js/rAF.js"></script>
<script src="http://127.0.0.1/gmis/public/fhome/js/demo-1.js"></script>
<script src="http://127.0.0.1/gmis/public/fhome/js/base/base.js"></script>
</body>
</html>