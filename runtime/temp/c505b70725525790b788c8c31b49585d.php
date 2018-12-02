<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"C:\wamp64\www\gmis\public/../application/home\view\Prochart\index.html";i:1543735453;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1543738560;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1543467483;}*/ ?>
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
        <div class="layui-logo"><a href="http://127.0.0.1/gmis/public/home/Index/index"><img src="http://127.0.0.1/gmis/public/fhome/img/footLogo.png" width="180" /></a></div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Pchart/index">流程图</a></li>


            <?php if(\think\Request::instance()->session('auth') == 1): ?>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Stuselect/showSelect">学生选题</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Stuselect/show">已选题目</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Stuselect/showMyTitle">我的题目</a></li>
            <?php endif; if(\think\Request::instance()->session('auth') == 2): ?>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Teapply/show">查看题目</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Teapply/showSelectStu">查看学生申请</a></li>
            <li class="layui-nav-item"><a href="http://127.0.0.1/gmis/public/home/Reprocess/showPage">管理学生</a></li>
            <?php endif; ?>

            <!--<li class="layui-nav-item">
                <a href="javascript:;">
                    个人信息
                </a>
                <dl class="layui-nav-child">
                    <?php if(\think\Request::instance()->session('auth') == 2): ?>
                    <dd><a href="http://127.0.0.1/gmis/public/home/Index/showSet">个人信息</a></dd>
                    <?php endif; ?>
                    <dd><a href="javascript:" id="password-btn">修改密码</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/User/logout">退出</a></dd>
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
                    <dd><a href="http://127.0.0.1/gmis/public/home/Index/showSet">个人信息</a></dd>
                    <?php endif; ?>
                    <dd><a href="javascript:" id="password-btn">修改密码</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/User/logout">退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
<div class="layui-body">
    <div class="layui-container">
        <div class="layui-row layui-col-space10 prochartDemo">
            <div class="layui-anim layui-anim-fadein">
                <div class="layui-col-md4" style="opacity: 0;">左边</div>
                    <div class="layui-col-md4">
                        <ul class="layui-timeline">
                            <?php if(is_array($prochart) || $prochart instanceof \think\Collection || $prochart instanceof \think\Paginator): $i = 0; $__LIST__ = $prochart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                            <li class="layui-timeline-item">
                                <?php if($pro['isnow'] == -1): ?>
                                <i class="layui-icon layui-timeline-axis">&#xe605;</i>  <!-- 已截止 -->
                                <div class="layui-timeline-content layui-text">
                                    <h2 class="layui-timeline-title" style="color: #7E96B3;"><?php echo $pro['proname']; ?></h2>
                                <?php endif; if($pro['isnow'] == 0): ?>
                                <i class="layui-icon layui-timeline-axis">&#xe6af;</i>  <!-- 正在进行 -->
                                <div class="layui-timeline-content layui-text">
                                    <h2 class="layui-timeline-title" style="color: #a00000;"><?php echo $pro['proname']; ?>(进行中)</h2>
                                <?php endif; if($pro['isnow'] == 1): ?>
                                <i class="layui-icon layui-timeline-axis">&#xe609;</i>  <!-- 未开始 -->
                                <div class="layui-timeline-content layui-text">
                                    <h2 class="layui-timeline-title"><?php echo $pro['proname']; ?></h2>
                                <?php endif; if($pro['isnow'] == 2): ?>
                                <i class="layui-icon layui-timeline-axis">&#xe609;</i>  <!-- 未开始 -->
                                <div class="layui-timeline-content layui-text">
                                    <h2 class="layui-timeline-title" style="color: #0e6f5c;"><?php echo $pro['proname']; ?></h2>
                                <?php endif; ?>
                                    <h4>
                                        <?php echo $pro['starttime']; ?> → <?php echo $pro['endtime']; ?>
                                    </h4>
                                    <br/>
                                </div>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                <div class="layui-col-md4"></div>

            </div>
        </div>
            <!--<div class="layui-col-md3"></div>-->
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
</body>
</html>