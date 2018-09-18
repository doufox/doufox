<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>系统安装向导 - doufox</title>
    <meta name="keywords" content="doufox 网站管理系统 - 安装向导" />
    <meta name="description" content="doufox 网站管理系统 - 安装向导" />
	<link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon" />
	<?php include $this->install_tpl("style");?>
</head>
<body>
<div class="install">
	<div class="header">doufox 系统安装向导 - 使用许可</div>
	<div class="main">
		<div class="step-1">
			<p>欢迎使用 doufox 网站管理系统</p>
			<p>你可以在基于MIT许可证的授权下, 使用本系统</p>
			<p>我们追求目标: 实现一套通用、简单、自由、开源的网站管理系统</p>
			<p>官方网站: <a target="_blank" href="<?php echo APP_SITE; ?>"><?php echo APP_SITE; ?></a></p>
		</div>
		<div class="install-button">
			<button class="btn" type="submit" onclick="window.location.href='?c=install&step=2';return false"name="submit">开始安装</button></a>
		</div>
	</div>
	<div class="footer">
		<div class="copy">Copyright &copy; 2018 Crogram, Inc.</div>
		<a class="site" href="<?php echo APP_SITE; ?>" target="_blank" title="A member of Crogram, Inc.">doufox.com</a>
	</div>
</div>

</body>
</html>