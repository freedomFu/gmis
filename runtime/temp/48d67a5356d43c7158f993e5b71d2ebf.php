<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"C:\wamp64\www\gmis\public/../application/admin\view\adjust\index.html";i:1545357671;s:61:"C:\wamp64\www\gmis\application\admin\view\layout\default.html";i:1540985180;s:58:"C:\wamp64\www\gmis\application\admin\view\common\meta.html";i:1540985180;s:60:"C:\wamp64\www\gmis\application\admin\view\common\script.html";i:1540985180;}*/ ?>
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
        width: 50%;
        margin: 0 auto;
    }

    #adjust_title{
        font-size: 45px;
        font-weight: bolder;
        text-align: center;
        margin-top: 50px;
    }

    .adjust_btn{
        margin: 100px 0px;
        text-align: center;
    }

    .adjust_btn button{
        width: 160px;
        height: 80px;
        font-size: 22px;
    }

</style>
<div class="panel panel-default panel-intro" id="adjust_panel">
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <p id="adjust_title"><span>调剂平台</span></p>
            <div class="adjust_btn">
                <a href="http://127.0.0.1/gmis/public/admin/Adjust//manual"><button class="layui-btn layui-btn-lg layui-btn-normal layui-btn-radius">手动调剂</button></a>
            </div>

            <div class="adjust_btn">
                <a href="http://127.0.0.1/gmis/public/admin/Adjust//auto"><button class="layui-btn layui-btn-lg layui-btn-danger layui-btn-radius">自动调剂</button></a>
            </div>


        </div>
    </div>
</div>
<script src="http://127.0.0.1/gmis/public/assets/adjust/js/base/base.js"></script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/gmis/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/gmis/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>