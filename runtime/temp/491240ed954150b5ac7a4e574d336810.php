<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"C:\wamp64\www\gmis\public/../application/index\view\user\login.html";i:1542766312;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/login.css" />
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/gmis/public/home/css/animate.min.css" />
   
    
</head>


<body>
  <section class="site-container">
    <section class="card">
      <h3>华北电力大学计算机系毕业设计选题系统</h3>
      <form>
        <div class="form__wrapper" data-wow-delay="0.5s">
          <input type="text" class="form__input" id="username" name="username">
          <label class="form__label" for="username">
            <span class="form__label__content">用户名</span>
          </label>
        </div>
        <div class="form__wrapper" data-wow-delay="0.6s">
          <input type="password" class="form__input" id="password" name="password">
          <label class="form__label" for="password">
            <span class="form__label__content">密码</span>
          </label>
        </div>
        <div class="form__wrapper__submit pulse infinite" data-wow-delay="0.7s">
          <div class="form__input__submit">
            <button type="button" name="submit" class="btn btn_teacher">教师登录</button>
            <button type="submit" name="submit" class="btn btn_student">学生登录</button>
          </div>
        </div>
      </form>
    </section>
  </section>
  <script src="http://127.0.0.1/gmis/public/home/js/base.js"></script>
  <script src="http://127.0.0.1/gmis/public/home/js/jquery-1.8.0.min.js"></script>
  <script src="http://127.0.0.1/gmis/public/home/js/login/login.js"></script>
</body>
</html>