<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"C:\wamp64\www\gmis\public/../application/index\view\user\forgetpass.html";i:1543201246;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>找回密码</title>
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/forpass.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/animate.min.css" />
</head>


<body>
<section class="site-container">
    <section class="card">
        <h3>华北电力大学计算机系毕业设计选题系统</h3>
        <h4>找回密码</h4>
        <div id="find">
            <div class="form__wrapper" data-wow-delay="0.5s">
                <input type="email" class="form__input" id="email" name="email">
                <label class="form__label" for="username">
                    <span class="form__label__content">邮箱</span>
                </label>
            </div>
            <div class="form__wrapper" data-wow-delay="0.5s">
                <input type="text" class="form__input" id="username" name="username">
                <label class="form__label" for="username">
                    <span class="form__label__content">用户名</span>
                </label>
            </div>

            <div class="form__wrapper__submit pulse infinite" data-wow-delay="0.7s">
                <div class="form__input__submit">
                    <button type="submit" name="submit" class="btn" id="teacher">教师找回</button>
                    <button type="submit" name="submit" class="btn" id="student">学生找回</button>
                </div>
            </div>

        </div>

        <div id="success">

            <div class="form__wrapper" >
                <p>找回成功，<span id="timer"></span> 将返回登录页面</p>
            </div>

        </div>
    </section>
</section>

<script src="http://127.0.0.1/gmis/public/home/js/base.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/jquery-1.8.0.min.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/user/forpass.js"></script>

</body>
</html>