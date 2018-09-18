<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>系统安装向导 - doufox</title>
	<?php include $this->install_tpl("style"); ?>
</head>
<body>
<div class="m-install">
	<div class="install-head">doufox 系统安装向导 一</div>
	<div class="m-form">
		<div class="install-status1">
			<p>欢迎使用 doufox 网站整体管理系统</p>
			<p>你可以在基于MIT许可证的授权下, 使用本系统</p>
			<p>简单、自由、开放, 我们追求目标是: 一套通用的网站整体管理系统</p>
			<p>官方网站: <a target="_blank" href="https://doufox.com/">https://doufox.com</a></p>
		</div>
		<div class="install-button">
			<button class="u-install-btn" type="submit"  onclick="window.location.href='?c=install&step=2';return false"name="submit">开始安装</button></a>
		</div>
	</div>
</div>

</body>
</html>