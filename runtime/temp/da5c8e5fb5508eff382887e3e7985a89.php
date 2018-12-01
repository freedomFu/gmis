<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"C:\wamp64\www\gmis\public/../application/home\view\Tapply\showApply.html";i:1543586154;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1543553675;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1543467483;}*/ ?>
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
            <li class="layui-nav-item">
                <a href="javascript:;">学生管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="http://127.0.0.1/gmis/public/home/Stuselect/showSelect">学生选题</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/Stuselect/show">已选题目</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/Stuselect/showMyTitle">我的题目</a></dd>
                </dl>
            </li>
            <?php endif; if(\think\Request::instance()->session('auth') == 2): ?>
            <li class="layui-nav-item">
                <a href="javascript:;">教师管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="http://127.0.0.1/gmis/public/home/Teapply/show">查看题目</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/Teapply/showSelectStu">查看学生申请</a></dd>
                    <dd><a href="http://127.0.0.1/gmis/public/home/Reprocess/showPage">管理学生</a></dd>
                </dl>
            </li>
            <?php endif; ?>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    个人信息<?php echo \think\Request::instance()->session('auth'); ?>
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
        <!-- 内容主体区域 -->
        <h2 id="userCon" style="text-align: center;">申请题目管理</h2>
        <div class="btn-wrap layui-clear">
            <div class="layui-show-md-inline-block" style="float:right;">
                <a href="javascript:" id="add_tapply_check" class="layui-btn" data-type="new">申请题目</a>
            </div>
        </div>
        <table id="tapply" lay-filter="tapply"></table>
        <script type="text/html" id="operation-bar">
            {{# var ifdisabled=(d.status=='已通过'?'layui-hide':'')}}
            <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
            <a class="layui-btn layui-btn-warm layui-btn-xs {{ifdisabled}}" lay-event="edit">修改</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs {{ifdisabled}}" lay-event="del">删除</a>
        </script>
        <script type="text/html" id="isNewTpl">
            {{(d.isnew==='1'?'是':'否')}}
        </script>
        <script type="text/html" id="isPracTpl">
            {{(d.isprac==='1'?'是':'否')}}
        </script>
        <div id="showNote">
        <p style="color: #999">您可以申请的数量为：<span id="totalNum" style="font-size:28px;color:#a00000;"></span>  剩余数量为：<span id="leftNum" style="font-size:28px;color:lightseagreen;"></span></p>
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

<script type="text/html" id="apply_title">
    <div id="tapply-template">
        <form class="layui-form " action="#" style="padding: 15px 20px 0 0;" method="post">
            <div class="layui-form-item layui-hide">
                <label class="layui-form-label">ID</label>
                <div class="layui-input-block">
                    <input type="text" name="id" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">题目</label>
                <div class="layui-input-block">
                    <input type="text" name="title" required autocomplete="off" class="layui-input" placeholder="请输入标题">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">题目性质</label>
                <div class="layui-input-block">
                    <input type="text" name="nature" required autocomplete="off" class="layui-input" placeholder="请输入课题性质">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">题目来源</label>
                <div class="layui-input-block">
                    <input type="text" name="source" required autocomplete="off" class="layui-input" placeholder="请输入课题来源">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">专业</label>
                <div class="layui-input-block">
                    <select name="proid" lay-filter="zhuanye">
                        <option value="0"></option>
                        <?php if(is_array($profess) || $profess instanceof \think\Collection || $profess instanceof \think\Paginator): $i = 0; $__LIST__ = $profess;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $pro['id']; ?>"><?php echo $pro['proname']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新题目</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="isnew" lay-skin="switch" lay-text="是|否">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">结合实际</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="isprac" lay-skin="switch" lay-text="是|否">
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 15px;">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="apply_title">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</script>

<script src="http://127.0.0.1/gmis/public/fhome/js/tapply.js"></script>

<div id="editShow" style="display: none">
    <form class="layui-form " lay-filter="editShow" id="change_apply" action="#" style="padding: 15px 20px 0 0;" method="post">
        <div class="layui-form-item layui-hide">
            <label class="layui-form-label">ID</label>
            <div class="layui-input-block">
                <input type="text" name="id" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">题目</label>
            <div class="layui-input-block">
                <input type="text" name="title" required autocomplete="off" class="layui-input" placeholder="请输入标题">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">题目性质</label>
            <div class="layui-input-block">
                <input type="text" name="nature" required autocomplete="off" class="layui-input" placeholder="请输入课题性质">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">题目来源</label>
            <div class="layui-input-block">
                <input type="text" name="source" required autocomplete="off" class="layui-input" placeholder="请输入课题来源">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">专业</label>
            <div class="layui-input-block">
                <select name="proid" lay-filter="zhuanye" id="proname">
                    <option value="0"></option>
                    <?php if(is_array($profess) || $profess instanceof \think\Collection || $profess instanceof \think\Paginator): $i = 0; $__LIST__ = $profess;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $pro['id']; ?>"><?php echo $pro['proname']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新题目</label>
            <div class="layui-input-block">
                <input type="checkbox" name="isnew" lay-skin="switch" lay-text="是|否">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">结合实际</label>
            <div class="layui-input-block">
                <input type="checkbox" name="isprac" lay-skin="switch" lay-text="是|否">
            </div>
        </div>
        <div class="layui-form-item" style="margin-top: 15px;">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="change_apply">立即提交</button>
            </div>
        </div>
    </form>
</div>