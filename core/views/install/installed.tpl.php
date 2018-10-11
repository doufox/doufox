<?php include $this->install_tpl("header");?>

	<div class="header">提示</div>
	<div class="main">
		<div class="installed">
			<h2>doufox 系统已经安装</h2>
			<p>如需重新安装, 请删除 installed 文件</p>
		</div>
		<div class="install-button">
			<a class="btn" href="<?php echo HTTP_URL;?>">返回网站</a>
		</div>
	</div>

<?php include $this->install_tpl("footer");?>