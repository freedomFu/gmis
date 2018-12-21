<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"C:\wamp64\www\gmis\public/../application/admin\view\adjust\manual.html";i:1545358994;s:61:"C:\wamp64\www\gmis\application\admin\view\layout\default.html";i:1540985180;s:58:"C:\wamp64\www\gmis\application\admin\view\common\meta.html";i:1540985180;s:60:"C:\wamp64\www\gmis\application\admin\view\common\script.html";i:1540985180;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/gmis/public/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/gmis/public/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/gmis/public/assets/js/html5shiv.js"></script>
  <script src="/gmis/public/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <link rel="stylesheet" href="http://127.0.0.1/gmis/public/assets/adjust/layui/css/layui.css">
<style type="text/css">
    #adjust_panel{
        height: 800px;
        margin: 0 auto;
    }

    #box{
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .box_title{
        width: 100%;
        margin-bottom: 10px;
        font-size: 30px;
        font-weight: bolder;
        text-align: center;
        letter-spacing: 10px;
    }
    table{
        border-collapse:collapse;
        text-align: center;

    }
    td,th{
        border: 1px solid burlywood;
    }
</style>
<div class="panel panel-default panel-intro" id="adjust_panel">
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div id="box">
                <div class="box_title">
                    <p>手动调剂</p>
                    <hr style="width: 80%;margin: 15px auto;" />
                </div>
                <div class="tab">
                    <table class="layui-hide" id="title" lay-filter="title"></table>
                </div>
                <script type="text/html" id="toolbarDemo">
                    <div class="layui-btn-container">
                        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
                    </div>
                </script>
                <div class="tab">
                    <table class="layui-hide" id="stu" lay-filter="stu"></table>
                </div>

                <div class="box_title">
                    <button class="layui-btn layui-btn-normal" id="manual_adjust">手动调剂</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://127.0.0.1/gmis/public/assets/adjust/layui/layui.js"></script>
<script src="http://127.0.0.1/gmis/public/assets/adjust/js/base/base.js"></script>
<script src="http://127.0.0.1/gmis/public/assets/adjust/js/adjust.js"></script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/gmis/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/gmis/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>