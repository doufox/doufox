<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>提示 - 系统安装向导</title>
    <meta name="keywords" content="系统安装向导" />
    <meta name="description" content="系统安装向导" />
	<link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon" />
	<?php include $this->install_tpl("style")?>
</head>
<body>
<div class="install">
	<div class="header">提示</div>
	<div class="main">
		<div class="installed">
			<h2>doufox 系统已经安装完成</h2>
			<p>如需重新安装, 请删除 installed 文件</p>
		</div>
		<div class="install-button">
			<a class="btn" href="<?php echo HTTP_URL;?>">返回网站</a>
		</div>
	</div>
	<div class="footer">
		<div class="copy">Copyright &copy; 2018 Crogram, Inc.</div>
		<a class="site" href="<?php echo APP_SITE;?>" target="_blank" title="A member of Crogram, Inc.">doufox.com</a>
	</div>
</div>

</body>
</html>