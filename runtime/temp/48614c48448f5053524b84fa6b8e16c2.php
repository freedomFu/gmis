<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"C:\wamp64\www\gmis\public/../application/admin\view\teacher\add.html";i:1541941233;s:61:"C:\wamp64\www\gmis\application\admin\view\layout\default.html";i:1540985180;s:58:"C:\wamp64\www\gmis\application\admin\view\common\meta.html";i:1540985180;s:60:"C:\wamp64\www\gmis\application\admin\view\common\script.html";i:1540985180;}*/ ?>
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
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teaidcard'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teaidcard" data-rule="required" class="form-control" name="row[teaidcard]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teaname'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teaname" data-rule="required" class="form-control" name="row[teaname]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teapwd'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teapwd" data-rule="required" class="form-control" name="row[teapwd]" type="text" value="123456">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teaduty'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teaduty" data-rule="required" class="form-control" name="row[teaduty]" type="text" value="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teahonor'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-teahonor" data-rule="required" class="form-control selectpicker" name="row[teahonor]">
                <?php if(is_array($teahonorList) || $teahonorList instanceof \think\Collection || $teahonorList instanceof \think\Paginator): if( count($teahonorList)==0 ) : echo "" ;else: foreach($teahonorList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"讲师"))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Teatitlenum'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-teatitlenum" data-rule="required" class="form-control" name="row[teatitlenum]" type="text" value="0">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Starttimer'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-starttimer" data-rule="required" class="form-control" name="row[starttimer]" type="text" value="尚未填写">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Middletimer'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-middletimer" data-rule="required" class="form-control" name="row[middletimer]" type="text" value="尚未填写">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Replytimer'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-replytimer" data-rule="required" class="form-control" name="row[replytimer]" type="text" value="尚未填写">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Note'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-note" data-rule="required" class="form-control" name="row[note]" type="text" value="无">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weigh" data-rule="required" class="form-control" name="row[weigh]" type="number" value="0">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"任教中"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/gmis/public/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/gmis/public/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>