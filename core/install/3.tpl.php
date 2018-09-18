<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>系统安装向导 - doufox</title>
    <meta name="keywords" content="doufox 网站管理系统 - 安装向导" />
    <meta name="description" content="doufox 网站管理系统 - 安装向导" />
	<link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon" />
	<?php include $this->install_tpl("style");?>
	<script type="text/javascript">
		function $(ID) {return document.getElementById(ID);}
	</script>
</head>
<body>
<div class="install">
	<div class="header">doufox 系统安装向导 - 安装成功</div>
	<div class="main">
		<div class="install-success">
			<div class="formitm">
				<label class="lab">后台地址：</label>
				<div class="ipt"><a href="<?php echo HTTP_URL; ?>admin/"><?php echo HTTP_URL; ?>admin/</a></div>
			</div>
			<div class="formitm">
				<label class="lab">后台账号：</label>
				<div class="ipt"><?php echo $username; ?></div>
			</div>
			<div class="formitm">
				<label class="lab">后台密码：</label>
				<div class="ipt"><?php echo $password; ?></div>
			</div>
			<div class="install-status"></div>
			<div class="install-button">
				<button class="btn" type="submit" name="submit"  onclick="window.location.href='?s=admin';return false">登录后台</button>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="copy">Copyright &copy; 2018 Crogram, Inc.</div>
		<a class="site" href="<?php echo APP_SITE; ?>" target="_blank" title="A member of Crogram, Inc.">doufox.com</a>
	</div>
</body>
</html>