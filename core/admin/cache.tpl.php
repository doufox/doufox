<?php include $this->admin_tpl('header');?>

<div class="subnav">
    <div class="content-menu">
    </div>
</div>
<style type="text/css">
.sbs{ }
.sbul{ margin:10px;}
.sbul li{ line-height:30px;}
.button{ margin-top:20px;}
.subnav,.ifm{ display:none;}
html{ _overflow-y:scroll}
</style>
<div class="pad-10">
<form action="<?php echo url('admin/index/cache',array('show'=>1),1); ?>" target="cache_if" method="post" id="myform" name="myform">
<div class="col-2">
<div class="sbs" id="update_tips" style="height:400px; overflow:auto;">
	<ul id="file" class="sbul">
	</ul>
</div>
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