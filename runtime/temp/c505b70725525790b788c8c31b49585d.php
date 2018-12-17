<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"C:\wamp64\www\gmis\public/../application/home\view\Prochart\index.html";i:1545017842;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1544787648;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1543467483;}*/ ?>
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
<style type="text/css">
    #pchartfooter{
        vertical-align: center;
        margin-top: 180px;
        color: #1e282c;
        font-size: 15px;
        border:1px solid #cee3e9;
        background:#f1f7f9;
        padding: 20px 0;
        border-radius:25px;
    }
    .pchartp{
        margin: 8px 5px;
    }

    .pcharttitle{
        color: #8e8e8e;
        margin: 0 10px 0 30px;
    }

    .pchartcon{
        color: #0f253c;
        -webkit-text-stroke: 0.05px lightskyblue;
    }

</style>
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
                <div class="layui-col-md4">
                    <div id="pchartfooter">
                        <p class="pchartp"><span class="pcharttitle">用户姓名：</span> <span class="pchartcon"><?php echo $userinfo['name']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">用户工号：</span> <span class="pchartcon"><?php echo $userinfo['idcard']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">用户身份：</span> <span class="pchartcon"><?php echo $userinfo['auth']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">开题时间：</span> <span class="pchartcon"><?php echo $userinfo['starttime']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">中期时间：</span> <span class="pchartcon"><?php echo $userinfo['middletime']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">答辩时间：</span> <span class="pchartcon"><?php echo $userinfo['replytime']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">答辩地点：</span> <span class="pchartcon"><?php echo $userinfo['replyplace']; ?></span> </p>
                        <?php if(\think\Request::instance()->session('auth') == 1): ?>
                        <p class="pchartp"><span class="pcharttitle">开题报告：</span> <span class="pchartcon"><?php echo $userinfo['openreport']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">毕设论文：</span> <span class="pchartcon"><?php echo $userinfo['paper']; ?></span> </p>
                        <p class="pchartp"><span class="pcharttitle">毕设材料：</span> <span class="pchartcon"><?php echo $userinfo['code']; ?></span> </p>
                        <?php endif; ?>
                    </div>
                </div>
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