<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理员登陆</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<meta name="author" content="Crogram, Inc." />
	<meta name="copyright" content="Copyright (c)  Crogram, Inc. All Rights Reserved." />
	<link href="/static/css/login.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="/static/img/favicon.ico" mce_href="/static/img/favicon.ico" type="image/x-icon">
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>
</head>

<body>
	<div class="table">
		<div class="cell">
			<div class="login table">
				<form class="cell" action="" method="post">
					<div class="row">
						<div class="cell l">帐号</div>
						<div class="cell r"><input type="text" id="username" name="username" class="text" value="" maxlength="20" /></div>
					</div>
					<div class="row">
						<div class="cell l">密码</div>
						<div class="cell r"><input name="password" type="password" class="text" value="" maxlength="20" autocomplete="off" /></div>
					</div>
					<div class="row">
						<div class="cell l">验证码</div>
						<div class="cell r">
							<input type="text" name="code" class="text captcha" maxlength="4" autocomplete="off" />
							<img id="checkcode" src="<?php echo url("api/checkcode/ ", array("width " => 85, "height " => 26)); ?>" title="看不清楚？换一张">
						</div>
					</div>
					<div class="row">
						<div class="cell l"></div>
						<div class="cell r">
							<input type="submit" class="login-submit" value="登录" name="submit" />
						</div>
					</div>
				</form>
			</div>
			<div class="powered">
				Copyright &copy; <?php echo date('Y'); ?> <a href="https://crogram.com" target="_blank">Crogram, Inc.</a> All Rights Reserved.
			</div>
		</div>
	</div>
	<script type="text/javascript">
		document.querySelector("#checkcode").onclick = function () {
			document.querySelector("#checkcode").src = '<?php echo url("api/checkcode/", array("width" => 85, "height" => 26)); ?>&' + Math.random();
		}
	</script>
</body>

</html>