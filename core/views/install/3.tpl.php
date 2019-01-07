<?php include $this->install_tpl("header");?>

	<script type="text/javascript">
		function $(ID) {return document.getElementById(ID);}
	</script>
	<div class="header">doufox 系统安装向导 - 安装成功</div>
	<div class="main">
		<div class="install-success">
			<div class="formitm">
				<label class="lab">后台管理地址：</label>
				<div class="ipt"><a href="<?php echo url('admin'); ?>"><?php echo HTTP_URL; ?>admin/</a></div>
			</div>
			<div class="formitm">
				<label class="lab">超级管理员账号：</label>
				<div class="ipt"><?php echo $username; ?></div>
			</div>
			<div class="formitm">
				<label class="lab">超级管理员密码：</label>
				<div class="ipt"><?php echo $password; ?></div>
			</div>
		</div>
		<div class="install-status"></div>
		<div class="install-button">
			<a class="btn" href="<?php echo url('admin'); ?>">登录后台</a>
		</div>
	</div>

<?php include $this->install_tpl("footer");?>