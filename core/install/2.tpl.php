<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>安装向导 </title>
	<?php include $this->install_tpl("style")?>
	<script type="text/javascript">
		function $(ID) {return document.getElementById(ID);}
	</script>
</head>
<body>
<div class="m-install">
	<div class="install-head">安装向导 </div>
	<div class="install-model">
		<div class="m-form">
			<iframe id="db_tester" name="db_tester" style="display:none;"></iframe>
			<form action="" method="post" id="db_form" target="db_tester">
				<input type="hidden" name="step" value="db_test"/>
				<input type="hidden" name="tdb_host" id="tdb_host"/>
				<input type="hidden" name="tdb_user" id="tdb_user"/>
				<input type="hidden" name="tdb_pass" id="tdb_pass"/>
				<input type="hidden" name="tdb_name" id="tdb_name"/>
				<input type="hidden" name="ttb_pre"  id="ttb_pre"/>
				<input type="hidden" name="ttb_test" id="ttb_test"/>
			</form>
			<form  action="" method="post" id="dform" onsubmit="return check();">
				<input type="hidden" name="step" value="3">
			<?php if (!$error) {?>
				<fieldset>
					<div class="formitm">
						<label class="lab">数据库主机：</label>
						<div class="ipt"><input name="db_host" type="text" id="db_host" value="localhost" class="u-ipt" /></div>
					</div>
					<div class="formitm">
						<label class="lab">数据库用户名：</label>
						<div class="ipt"><input name="db_user" type="text" id="db_user" value="" class="u-ipt" /></div>
					</div>
					<div class="formitm">
						<label class="lab">数据库密码：</label>
						<div class="ipt"><input name="db_pass" type="text" id="db_pass" value="" class="u-ipt" /></div>
					</div>
					<div class="formitm">
						<label class="lab">数据库名：</label>
						<div class="ipt">
							<input name="db_name" type="text" id="db_name" value="" onblur="$('ttb_test').value=0;test();void(0);" class="u-ipt" />
						</div>
					</div>
					<div class="formitm">
						<label class="lab">表前缀：</label>
						<div class="ipt"><input name="tb_pre" type="text" id="tb_pre" value="ui_" class="u-ipt" />
						<span><input type="button" value="测试数据库连接" onclick="$('ttb_test').value=1;test();void(0);" class="u-btn-sm"/></span>
					</div>
					</div>
					<div class="formitm">
						<label class="lab">后台帐号：</label>
						<div class="ipt"><input name="username" type="text" id="username" value="admin" class="u-ipt" />
						</div>
					</div>
					<div class="formitm">
						<label class="lab">后台密码：</label>
						<div class="ipt"><input name="password" type="text" id="password" value="admin" class="u-ipt" />
						</div>
					</div>
					<div id="tip" style="display:none">
						<div class="formitm">
							<label class="lab"></label>
							<div class="ipt">
							<span  style="color:#060;font-weight: 700;" >安装中...<img src="<?php echo ADMIN_DIR; ?>/img/loading.gif"></span>
						</div>
					</div>
					</div>
					<div class="install-status"></div>
					<div class="install-button">
						<button class="u-install-btn" type="submit" name="submit"  id="submit">安装</button>
					</div>
			<?php } else {?>
		<div class="install-button">
		<div class="install-status"><?php echo $error; ?></div>
		</div>
			<?php }
;?>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
function test() {
	if($('db_host').value == '') {
		alert('请填写数据库服务器');
		$('db_host').focus();
		return;
	}
	$('tdb_host').value = $('db_host').value;

	if($('db_user').value == '') {
		alert('请填写数据库用户名');
		$('db_user').focus();
		return;
	}
	$('tdb_user').value = $('db_user').value;
	$('tdb_pass').value = $('db_pass').value;

	if($('db_name').value == '') {
		alert('请填写数据库名');
		$('db_name').focus();
		return;
	}
	$('tdb_name').value = $('db_name').value;

	if($('tb_pre').value == '') {
		alert('请填写数据表前缀');
		$('tb_pre').focus();
		return;
	}
	$('ttb_pre').value = $('tb_pre').value;
	$('db_form').submit();
}
function check() {
	if($('db_host').value == '') {
		alert('请填写数据库服务器');
		$('db_host').focus();
		return false;
	}

	if($('db_user').value == '') {
		alert('请填写数据库用户名');
		$('db_user').focus();
		return false;
	}

	if($('db_name').value == '') {
		alert('请填写数据库名');
		$('db_name').focus();
		return false;
	}

	if($('tb_pre').value == '') {
		alert('请填写数据表前缀');
		$('tb_pre').focus();
		return false;
	}

	if($('username').value.length < 5) {
		alert('后台帐号最少5位');
		$('username').focus();
		return false;
	}

	if(!$('username').value.match(/^[a-z0-9]+$/)) {
		alert('后台帐号只能使用小写字母(a-z)、数字(0-9)');
		$('username').focus();
		return false;
	}

	if($('password').value.length < 5) {
		alert('后台密码最少5位');
		$('password').focus();
		return false;
	}

	$('tip').style.display = '';
	$('submit').disabled = true;
	return true;
}
</script>
</body>
</html>