<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"C:\wamp64\www\gmis\public/../application/index\view\sselect\showTitle.html";i:1542422991;}*/ ?>
<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$showapply): $mod = ($i % 2 );++$i;?>
<?php echo $showapply['title']; ?> -- <?php echo $showapply['proid']; ?> -- <?php echo $showapply['proname']; ?> -- <?php echo $showapply['belongsenior']; ?> - <?php echo $showapply['status']; ?>
<br>
<?php endforeach; endif; else: echo "" ;endif; ?>
