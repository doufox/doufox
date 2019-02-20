<?php include $this->install_tpl("header");?>

	<div class="header">系统安装向导 - 使用说明</div>
	<div class="main">
		<div class="step-1">
			<p>欢迎使用网站管理系统</p>
			<p>你可以在基于MIT许可证的授权下, 使用本系统</p>
			<p>我们追求目标: 实现一套通用、简单、自由、开源的网站管理系统</p>
			<p>官方网站: <a target="_blank" href="<?php echo APP_SITE; ?>"><?php echo APP_SITE; ?></a></p>
		</div>
		<div class="install-button">
			<a class="btn" href="<?php echo url('install', array('step' => 2)); ?>">开始安装</a>
		</div>
	</div>

<?php include $this->install_tpl("footer");?>