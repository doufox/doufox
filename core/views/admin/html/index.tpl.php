<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '页面静态化';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/createhtml/index'); ?>">页面静态化</a>
		<a href="<?php echo url('admin/createhtml/home'); ?>">生成首页</a>
		<a href="<?php echo url('admin/createhtml/category'); ?>">生成栏目页</a>
		<a href="<?php echo url('admin/createhtml/show'); ?>">生成内容页</a>
	</div>
    <div class="bk10"></div>
    <div>
        内容区域
    </div>
</div>