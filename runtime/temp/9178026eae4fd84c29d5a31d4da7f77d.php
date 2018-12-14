<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"C:\wamp64\www\gmis\public/../application/home\view\Main\userSet.html";i:1544787468;s:59:"C:\wamp64\www\gmis\application\home\view\Public\header.html";i:1544787648;s:59:"C:\wamp64\www\gmis\application\home\view\Public\footer.html";i:1543467483;}*/ ?>
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
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md4" style="margin:50px auto;margin-top: 100px;">
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
        <div class="layui-col-md8">
            <div style="width:700px;margin:50px auto;">
                <h2 id="setTeacherInfo">设置教师信息</h2>
                <form class="layui-form " id="set_info_form" action="#" style="padding: 15px 20px 0 0;" method="post">
                    <!--职称-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">职称</label>
                        <div class="layui-input-block">
                            <select name="teahonor" lay-verify="required">
                                <option value=""></option>
                                <?php if(is_array($teahonor) || $teahonor instanceof \think\Collection || $teahonor instanceof \think\Paginator): $i = 0; $__LIST__ = $teahonor;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$th): $mod = ($i % 2 );++$i;if($th == $teainfo['teahonor']): ?>
                                <option value="<?php echo $th; ?>" selected><?php echo $th; ?></option>
                                <?php else: ?>
                                <option value="<?php echo $th; ?>"><?php echo $th; ?></option>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <!--岗位-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">岗位</label>
                        <div class="layui-input-block">
                            <select name="teaduty" lay-verify="required">
                                <option value=""></option>
                                <?php if(is_array($teaduty) || $teaduty instanceof \think\Collection || $teaduty instanceof \think\Paginator): $i = 0; $__LIST__ = $teaduty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$td): $mod = ($i % 2 );++$i;if($td == $teainfo['teaduty']): ?>
                                <option value="<?php echo $td; ?>" selected><?php echo $td; ?></option>
                                <?php else: ?>
                                <option value="<?php echo $td; ?>"><?php echo $td; ?></option>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>

                    <!--开题日期-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">开题日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="starttimer" value="<?php echo $teainfo['starttimer']; ?>" id="starttimer" lay-verify="date|belongtime" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <!--中期时间-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">中期时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="middletimer" value="<?php echo $teainfo['middletimer']; ?>" id="middletimer" lay-verify="date|belongtime" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <!--答辩时间-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">答辩时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="replytimer" value="<?php echo $teainfo['replytimer']; ?>" id="replytimer" lay-verify="date|belongtime" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <!--答辩地点-->
                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">答辩地点</label>
                        <div class="layui-input-block">
                            <input type="text" name="replyplace" value="<?php echo $teainfo['replyplace']; ?>" lay-verify="title" autocomplete="off" placeholder="请输入答辩地点" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item set_info">
                        <label class="layui-form-label layui-form-label1">手机号</label>
                        <div class="layui-input-block">
                            <input type="tel" name="teaphone" value="<?php echo $teainfo['teaphone']; ?>"  lay-verify="required|phone" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item" style="margin-top: 15px;">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="change_info">立即提交</button>
                        </div>
                    </div>
                </form>
            </div>
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
<script src="http://127.0.0.1/gmis/public/fhome/js/userSet.js"></script>