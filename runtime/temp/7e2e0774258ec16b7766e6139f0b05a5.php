<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"C:\wamp64\www\gmis\public/../application/index\view\sselect\index.html";i:1542291448;}*/ ?>
<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sselect): $mod = ($i % 2 );++$i;?>
    <?php echo $sselect['stuid']; ?> -- <?php echo $sselect['titleid']; ?> -- <?php echo $sselect['teaid']; endforeach; endif; else: echo "" ;endif; ?>

<?php echo $list->render(); ?>
