<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"C:\wamp64\www\gmis\public/../application/home\view\Tapply\showStudent.html";i:1544795854;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1544787648;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1543467483;}*/ ?>
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
        <h2 id="userCon" style="text-align: center;padding: 15px 0">管理学生</h2>

        <table id="showStudent" lay-filter="showStudent"></table>
        <script type="text/html" id="operation-bar">
            <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="edit">修改</a>
        </script>
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
                    <input type="password" name="old_pass" placeholder="请输入旧密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-block">
                    <input type="password" name="new_pass" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">确认密码</label>
                <div class="layui-input-block">
                    <input type="password" name="confirm_pass" placeholder="请确认新密码" autocomplete="off" class="layui-input">
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

<script src="http://127.0.0.1/gmis/public/fhome/js/showEditScore.js"></script>
<div id="changeScore" style="display: none">
    <form class="layui-form " lay-filter="changeScore" id="change_score" action="#" style="padding: 15px 20px 0 0;" method="post">
        <div class="layui-form-item layui-hide">
            <label class="layui-form-label">ID</label>
            <div class="layui-input-block">
                <input type="text" name="id" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">中期成绩</label>
            <div class="layui-input-block">
                <select name="mscore" lay-verify="required" required lay-filter="mscore" id="mscore">
                    <option value="">---请选择---</option>
                    <?php if(is_array($midscore) || $midscore instanceof \think\Collection || $midscore instanceof \think\Paginator): $i = 0; $__LIST__ = $midscore;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$midscore): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $midscore; ?>"><?php echo $midscore; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">答辩成绩</label>
            <div class="layui-input-block">
                <select name="rscore" lay-verify="required" required lay-filter="rscore" id="rscore">
                    <option value="">---请选择---</option>
                    <?php if(is_array($repscore) || $repscore instanceof \think\Collection || $repscore instanceof \think\Paginator): $i = 0; $__LIST__ = $repscore;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$repscore): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $repscore; ?>"><?php echo $repscore; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 15px;">
            <div class="layui-input-block">
                <button class="layui-btn" type="button"  lay-submit="" lay-filter="change_score">立即提交</button>
            </div>
        </div>
    </form>
</div>