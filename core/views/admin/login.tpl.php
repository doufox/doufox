<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="force-rendering" content="webkit"/>
    <meta name="renderer" content="webkit"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>网站管理系统 - 管理员登陆</title>
    <link rel="stylesheet" type="text/css" href="/static/css/login.css"/>
	<link rel="icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
</head>

<body>
	<div class="table">
		<div class="cell">
			<div class="login table">
				<form class="cell" action="" method="post">
					<div class="row">
						<div class="cell l">帐号</div>
						<div class="cell r"><input type="text" name="username" class="text" maxlength="20" /></div>
					</div>
					<div class="row">
						<div class="cell l">密码</div>
						<div class="cell r"><input name="password" type="password" class="text" maxlength="20" autocomplete="off" /></div>
					</div>
					<div class="row">
						<div class="cell l">验证码</div>
						<div class="cell r">
							<input type="text" name="code" class="text captcha" maxlength="4" autocomplete="off" />
							<img id="checkcode" src="<?php echo url("api/access/checkcode", array("width" => 85, "height" => 26)); ?>" title="看不清楚？换一张">
						</div>
					</div>
					<div class="row">
						<div class="cell l"></div>
						<div class="cell r">
							<button name="submit" class="login-submit">登录</button>
							<!-- <input type="submit" class="login-submit" value="登录" name="submit" /> -->
						</div>
					</div>
				</form>
			</div>
			<div class="powered">
				Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo APP_SITE;?>" target="_blank" title="<?php echo APP_NAME;?>"><?php echo APP_NAME;?></a> All Rights Reserved.
			</div>
		</div>
	</div>
	<script type="text/javascript">
		document.getElementById("checkcode").onclick = function () {
			document.getElementById("checkcode").src = '<?php echo url("api/access/checkcode", array("width" => 85, "height" => 26)); ?>&' + Math.random();
		}
	</script>
</body>

</html>