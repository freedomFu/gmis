<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"C:\wamp64\www\gmis\public/../application/index\view\tapply\index.html";i:1542547444;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php if(is_array($prochart) || $prochart instanceof \think\Collection || $prochart instanceof \think\Paginator): $i = 0; $__LIST__ = $prochart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
        <?php echo $pro['id']; ?> -- <?php echo $pro['proname']; ?> -- <?php echo $pro['protimer']; ?> <br>
    <?php endforeach; endif; else: echo "" ;endif; ?>

</body>
</html>