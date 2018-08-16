<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>安装向导</title>
	<?php include $this->install_tpl("style")?>
</head>
<body>
<div class="m-install">
	<div class="install-head">安装向导</div>
	<div class="m-form">
		<div class="install-status1">
			<p>欢迎使用</p>
			<p>您可以免费使用本系统 无任何限制</p>
			<p>小巧灵活简单易用是我们追求目标</p>
			<p>官方网站：<a target="_blank" href="http://www.uinote.com">http://www.uinote.com</a></p>
		</div>
		<div class="install-button">
			<button class="u-install-btn" type="submit"  onclick="window.location.href='?c=install&step=2';return false"name="submit">开始安装</button></a>
		</div>
	</div>
</div>

</body>
</html>