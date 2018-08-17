<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $this->site_config['SITE_NAME']; ?> - 后台管理中心</title>
  <link rel="stylesheet" type="text/css" href="/static/css/backend.css" />
  <link rel="icon" href="/static/img/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="/static/img/favicon.ico" type="image/x-icon" />
  <script type="text/javascript" src="/static/js/jquery.min.js"></script>
  <script type="text/javascript" src="/static/js/dialog.js?skin=green"></script>
</head>
<body>
<!--头部开始-->
<div id="head">
  <div id="logo">
    <a href="<?php echo HTTP_URL; ?>?s=admin"><h1>后台管理中心</h1></a>
  </div>
  <div id="menu_position">
    <ul id="menu">
        <li id="_MP101" ><a href="javascript:_MP(101,'?s=admin&c=category');" >栏目</a></li>
        <li id="_MP102" ><a href="javascript:_MP(102,'?s=admin&c=block');" >区块</a></li>
        <?php if ($MEMBER_REGISTER) {?><li id="_MP103" ><a href="javascript:_MP(103,'?s=admin&c=member');" >会员</a></li><?php }?>
        <li id="_MP104" ><a href="javascript:_MP(104,'?s=admin&a=config&type=1');" >设置</a>
          <ul>
            <li id="_MP1041" ><a href="javascript:_MP(1041,'?s=admin&a=config&type=1');" >系统设置</a></li>
            <li id="_MP1042" ><a href="javascript:_MP(1042,'?s=admin&a=config&type=2');" >水印设置</a></li>
            <li id="_MP1043" ><a href="javascript:_MP(1043,'?s=admin&a=config&type=3');" >后台密码</a></li>
            <li id="_MP1044" ><a href="javascript:_MP(1044,'?s=admin&a=config&type=4');" >会员配置</a></li>
            <li id="_MP1045" ><a href="javascript:_MP(1045,'?s=admin&a=config&type=5');" >URL设置</a></li>
            <li id="_MP107" ><a href="javascript:_MP(107,'?s=admin&a=cache');" >更新缓存</a></li>
            <li id="_MP403" ><a href="javascript:_MP(403,'?s=admin&c=Content&a=updateurl');" >更新内容URL</a></li>
            <li id="_MP403" ><a href="javascript:_MP(403,'?s=admin&c=Database');" >数据库备份</a></li>
            <li id="_MP1046" ><a href="javascript:_MP(1046,'?s=admin&c=model');" >内容模型</a></li>
            <li id="_MP1047" ><a href="javascript:_MP(1047,'?s=admin&c=model&typeid=3');" >表单模型</a></li>
<?php if (is_array($menu)) {foreach ($menu as $t) {?>
            <li id="_MP9<?php echo $t['id'] ?>" ><a href="javascript:_MP(9<?php echo $t['id'] ?>,'<?php echo $t['url'] ?>');" ><?php echo $t['name'] ?></a></li>
<?php }}?>
		  <li class="menubtm"></li>
          </ul>
        </li>
         <li id="_MP105" ><a href="javascript:_MP(105,'?s=admin&c=template');" >模板</a></li>
<?php if (file_exists(CONTROLLER_DIR . 'admin' . DIRECTORY_SEPARATOR . "CreatehtmlController.php")) {;?>
        <li id="_MP106" ><a href="javascript:_MP(106,'?s=admin&c=createhtml');" >生成</a>
          <ul>
            <li id="_MP1061" ><a href="javascript:_MP(1061,'?s=admin&c=createhtml&a=index');" >生成首页</a></li>
            <li id="_MP1062" ><a href="javascript:_MP(1062,'?s=admin&c=createhtml&a=category');" >生成栏目页</a></li>
            <li id="_MP1063" ><a href="javascript:_MP(1063,'?s=admin&c=createhtml&a=show');" >生成内容页</a></li>
            <li class="menubtm"></li>
          </ul>
        </li><?php }?>
        <li id="_MP107" ><a href="javascript:_MP(107,'?s=admin&c=attachment');" >附件</a></li>
   </ul>
  </div>
  <div class="user">
    <?php echo $username; ?>&nbsp;<a href="javascript:void(0);" onClick="logout();">退出</a></div>
</div>
<!--头部结束-->
<div id="main">
  <!--左侧开始-->
  <div id="left">
    <div class="left-head">
      <span style="float:right;"><a href="javascript:void(0);" onClick="refresh();" class="refresh"><img src="/static/img/space.gif" alt="刷新菜单" title="刷新菜单" height="18" width="16" /></a></span>
      <label id='root_menu_name'>内容管理</label>
    </div>
    <div id="browser"><iframe name="leftMain" id="leftMain" src="?s=admin&c=content&a=category" frameborder="false" scrolling="auto" style="border:none" width="100%" height="auto" allowtransparency="true"></iframe></div>
  </div>
  <!--左侧结束-->
  <!--右侧开始-->
  <div id="right">
    <div id="home">
    	<div id="shortcut">
        <a href="javascript:_MP(107,'?s=admin&a=cache');" title="更新缓存">更新缓存</a>
        <a href="https://www.crogram.com" title="Crogram" target="_blank" title="帮助">帮助</a>
        <a href="./" title="网站首页" target="_blank">网站首页</a>
    	</div>
    	<label id="position">后台首页</label>
    </div>
    <div id="frame_container" style="width:100%;"><iframe name="right" id="rightMain" src="<?php echo url('admin/index/main'); ?>" frameborder="false" scrolling="auto" style="border:none;" width="100%" allowtransparency="true"></iframe></div>
  </div>
</div>
<script type="text/javascript">
window.onresize = function(){
	var heights = document.documentElement.clientHeight;
	document.getElementById('rightMain').height = heights-61;
	document.getElementById('leftMain').height = heights-61;
}
window.onresize();
function _MP(id, targetUrl) {
	var title = $("#_MP"+id).find('a').html();
	$("#position").html(title);
	$("#rightMain").attr('src', targetUrl);
	$('.focused').removeClass("focused");
	$('#_MP'+id).addClass("focused");
}
function logout(){
	if (confirm("确定退出吗"))
	top.location = '<?php echo url("admin/login/logout/"); ?>';
	return false;
}
function refresh() {
	document.getElementById('leftMain').src = '<?php echo url('admin/content/category'); ?>';
}
</script>
</body>
</html>
