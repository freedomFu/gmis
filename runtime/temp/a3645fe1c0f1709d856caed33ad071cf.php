<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"C:\wamp64\www\gmis\public/../application/index\view\user\expass.html";i:1543199207;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/expass.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/animate.min.css" />
</head>


<body>
<section class="site-container">
    <section class="card">
        <h3>华北电力大学计算机系毕业设计选题系统</h3>
        <h4>修改密码</h4>
        <div id="find">
            <div class="form__wrapper" data-wow-delay="0.6s">
                <input type="password" class="form__input" id="old_password" name="old_password">
                <label class="form__label" for="old_password">
                    <span class="form__label__content">旧密码</span>
                </label>
            </div>
            <div class="form__wrapper" data-wow-delay="0.6s">
                <input type="text" class="form__input" id="new_password" name="new_password">
                <label class="form__label" for="new_password">
                    <span class="form__label__content">新密码</span>
                </label>
            </div>

            <div class="form__wrapper" data-wow-delay="0.6s">
                <input type="text" class="form__input" id="new_password2" name="new_password2">
                <label class="form__label" for="new_password2">
                    <span class="form__label__content">再次确认新密码</span>
                </label>
            </div>

            <div class="form__wrapper__submit pulse infinite" data-wow-delay="0.7s">
                <div class="form__input__submit">
                    <button type="submit" name="submit" class="btn" id="expass" >确认修改</button>
                </div>
            </div>

        </div>
        <div id="success">
            <div class="form__wrapper" >
                <p>修改成功，<span id="timer"></span> 请重新登录</p>
            </div>
        </div>
    </section>
</section>
<script src="http://127.0.0.1/gmis/public/home/js/base.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/jquery-1.8.0.min.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/user/expass.js"></script>
</body>
</html>