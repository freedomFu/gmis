<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"C:\wamp64\www\gmis\public/../application/index\view\tapply\index.html";i:1542698436;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    剩余的量为：<?php echo $leftnum; ?> <br>
    <?php if(is_array($tapplylist) || $tapplylist instanceof \think\Collection || $tapplylist instanceof \think\Paginator): $i = 0; $__LIST__ = $tapplylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
        <?php echo $pro['id']; ?>--<?php echo $pro['title']; ?>-<?php echo $pro['nature']; ?>-<?php echo $pro['source']; ?>-<?php echo $pro['isnew']; ?>
    --<?php echo $pro['isprac']; ?>-<?php echo $pro['proname']; ?>-<?php echo $pro['note']; ?>-<?php echo $pro['status']; ?>
    --<?php echo $pro['stuidcard']; ?>--<?php echo $pro['stuname']; ?>--<?php echo $pro['stuclass']; ?>
    --<?php echo $pro['stuphone']; ?>
    <br>
    <?php endforeach; endif; else: echo "" ;endif; ?>

</body>
</html>