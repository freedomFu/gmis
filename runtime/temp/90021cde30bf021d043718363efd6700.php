<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"C:\wamp64\www\gmis\public/../application/index\view\index\index.html";i:1543107544;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/home/css/prochart.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title>毕设流程图</title>
</head>
<body>
    <div id="map">
        <h3 class="title">毕设流程图</h3>
        <div id="map_box">
            <?php if(is_array($prochart) || $prochart instanceof \think\Collection || $prochart instanceof \think\Paginator): $i = 0; $__LIST__ = $prochart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;if($pro['statusnum'] == 2): ?>
            <div class="now">
                <div class="before"></div>
            <?php endif; if($pro['statusnum'] == 1): ?>
            <div class="now">
                <div id="now_box"></div>
            <?php endif; if($pro['statusnum'] == 0): ?>
            <div class="now">
                <div id="after"></div>
            <?php endif; ?>
                <span><?php echo $pro['proname']; ?></span><br>
                <span>(<?php echo $pro['protimer']; ?>)</span>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</body>
</html>
