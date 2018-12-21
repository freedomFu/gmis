<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"C:\wamp64\www\gmis\public/../application/home\view\sselect\showMySelected.html";i:1545227195;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1544787648;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1545397361;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="http://127.0.0.1/gmis/public/fhome/img/fav-logo.png" type="image/x-icon" />
    <title>毕业设计选题系统</title>
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/fhome/layui/css/layui.css">
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/fhome/css/main/index.css">
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/fhome/css/prochart/index.css">


</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><a href="http://127.0.0.1/gmis/public/index"><img src="http://127.0.0.1/gmis/public/fhome/img/footLogo.png" width="180" /></a></div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/flow">流程图</a></li>


            <?php if(\think\Request::instance()->session('auth') == 1): ?>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/sTitle">学生选题</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/msTitle">已选题目</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/mTitle">我的题目</a></li>
            <?php endif; if(\think\Request::instance()->session('auth') == 2): ?>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/tApply">毕设题目管理</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/tSstu">查看学生申请</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/mastu">管理学生</a></li>
            <?php endif; ?>

            <!--<li class="layui-nav-item">
                <a href="javascript:;">
                    个人信息
                </a>
                <dl class="layui-nav-child">
                    <?php if(\think\Request::instance()->session('auth') == 2): ?>
                    <dd><a href="http://127.0.0.1/gmis/public/Index/showSet">个人信息</a></dd>
                    <?php endif; ?>
                    <dd><a href="javascript:" id="password-btn">修改密码</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/User/logout">退出</a></dd>
                </dl>
            </li>-->

        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    个人信息
                </a>
                <dl class="layui-nav-child">
                    <?php if(\think\Request::instance()->session('auth') == 2): ?>
                    <dd><a href="http://127.0.0.1/gmis/public/myset">个人信息</a></dd>
                    <?php endif; ?>
                    <dd><a href="javascript:" id="password-btn">修改密码</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/logout">退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
<div class="layui-body">
    <div class="layui-container">
        <!-- 内容主体区域 -->
        <h2 id="userCon" style="text-align: center;padding: 15px 0">我申请的题目</h2>
        <!--<div class="btn-wrap layui-clear">
            <div class="layui-show-md-inline-block" style="float:right;">
                <a href="javascript:" id="submit_title" class="layui-btn" data-type="submitData">提交数据</a>
            </div>
        </div>-->
        <table id="mySelected" lay-filter="mySelected"></table>
        <script type="text/html" id="isNewTpl">
            {{(d.isnew==='1'?'是':'否')}}
        </script>
        <script type="text/html" id="isPracTpl">
            {{(d.isprac==='1'?'是':'否')}}
        </script>
        <script type="text/html" id="operation-bar">
            <?php if($isallsave == 0): ?>
            {{# var ifdisabled1=((d.state!='未提交' || d.weigh==0)?'layui-btn-disabled':'')}}
            {{# var ifdisabled2=(d.state=='已通过'?'layui-btn-disabled':'')}}
            <a class="layui-btn layui-btn-normal layui-btn-xs {{ifdisabled1}}" lay-event="{{ifdisabled1=='layui-btn-disabled'?'':'sure'}}">提交</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs {{ifdisabled2}}" lay-event="{{ifdisabled2=='layui-btn-disabled'?'':'del'}}">删除</a>
            <?php else: ?>
            <a class="layui-btn layui-btn-normal layui-btn-xs layui-btn-disabled" lay-event="">提交</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs layui-btn-disabled" lay-event="">删除</a>
            <?php endif; ?>
        </script>
        <div id="showNote" style="font-size: 24px;">
            <p>注：1.一旦提交被教师确认后就不能再修改，<span style="color: #a00000;">请谨慎操作！</span></p>
            <p><span style="opacity: 0;">注：</span>2.请填写优先级(点击单元格即可，<span style="color: lightskyblue;">通过后不可修改</span>)！<span style="color: #a00000;font-weight: bolder;">(高3、中2、低1)</span></p>
        </div>
    </div>
</div>
<div class="layui-footer" style="text-align: center;">
    Copyright © 2018.Dreamtech Studio
</div>
</div>
</body>
</html>
<script src="http://127.0.0.1/gmis/public/fhome/layui/layui.js"></script>
<script src="http://127.0.0.1/gmis/public/fhome/js/base/base.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element
            ,form = layui.form;
        form.render();
    });
</script>
<script type="text/html" id="passwordTp">
    <div id="password">
        <form class="layui-form " method="post" action="#" style="padding: 15px 20px 0 0;">
            <div class="layui-form-item">
                <label class="layui-form-label">旧密码</label>
                <div class="layui-input-block">
                    <input type="password" lay-verify="required" required name="old_pass" placeholder="请输入旧密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-block">
                    <input type="password" lay-verify="required" required name="new_pass" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-block">
                    <input type="password" lay-verify="required" required name="confirm_pass" placeholder="请确认新密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 15px;">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="password">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</script>

<script src="http://127.0.0.1/gmis/public/fhome/js/sselect.js"></script>
<script>
    layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
        var layer = layui.layer;

        layer.msg("<span style='color:lightcoral;font-weight: bolder;font-size: 20px;'>请填写优先级！高3、中2、低1</span>", {
            icon: 0,
            time: 3000
        });
    });
</script>
