<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>安装向导 </title>
	<?php include $this->install_tpl("style") ?>
	<script type="text/javascript">
		function $(ID) {return document.getElementById(ID);}
	</script>
</head>
<body>
<div class="m-install">
	<div class="install-head">安装向导</div>
	<div class="install-model">
		<div class="m-form">
				<fieldset>
					<div class="formitm">
						<label class="lab">后台地址：</label>
						<div class="ipt"><a href="<?php echo HTTP_URL;?>admin/"><?php echo HTTP_URL;?>admin/</a></div>
					</div>
					<div class="formitm">
						<label class="lab">后台账号：</label>
						<div class="ipt"><?php echo $username ;?></div>
					</div>
					<div class="formitm">
						<label class="lab">后台密码：</label>
						<div class="ipt"><?php echo $password ;?></div>
					</div>
					<div class="install-status"></div>
					<div class="install-button">
						<button class="u-install-btn" type="submit" name="submit"  onclick="window.location.href='?s=admin';return false">登录后台</button>
					</div>
				</fieldset>
			</form>
</body>
</html>