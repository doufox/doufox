<?php include $this->admin_tpl('header');?>

<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '更新缓存';
</script>
<div class="subnav">
    <div class="content-menu">
    </div>
</div>
<style type="text/css">
	.sbul{ margin:10px;}
	.sbul li{ line-height:30px;}
	.subnav,.ifm{ display:none;}
	html{ _overflow-y:scroll}
</style>
<div class="pad-10">
	<form action="<?php echo url('admin/index/cache',array('show'=>1),1); ?>" target="cache_if" method="post" id="myform" name="myform">
		<div id="update_tips" style="height:400px; overflow:auto;">
			<ul id="file" class="sbul"></ul>
		</div>
	</form>
	<iframe id="cache_if" name="cache_if" class="ifm"></iframe>
	<iframe id="hidden" name="hidden"  width="0" height="0" frameborder=0></iframe>
</div>
<script type="text/javascript">
	document.myform.submit();
	function addtext(data) {
		$('#file').append(data);
		document.getElementById('update_tips').scrollTop = document.getElementById('update_tips').scrollHeight;
	}
</script>
</body>
</html>