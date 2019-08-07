<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="force-rendering" content="webkit" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>网站管理系统 - 管理员登陆</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
    <meta name="robots" content="none, nofollow, noarchive, nocache">
    <meta name="referrer" content="never" />
    <link type="text/css" href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/static/css/login.css" />
</head>

<body>
    <div class="panel panel-default login">
        <div class="panel-heading">
            <span class="panel-title">管理员登陆</span>
        </div>
        <div class="panel-body">
            <form method="POST" action="">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="username" type="text" class="form-control" placeholder="账号" required autofocus maxlength="20">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input name="password" type="password" class="form-control" placeholder="密码" maxlength="20" autocomplete="off" required />
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                    <input type="text" name="code" class="form-control captcha" placeholder="验证码" maxlength="4" autocomplete="off" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" style="padding: 3px;">
                            <img id="checkcode" src="<?php echo url("api/access/checkcode", array("width" => 85, "height" => 26)); ?>"
                                style="width: 85px; height: 26px;" title="看不清楚？换一张" alt="验证码" />
                        </button>
                    </span>
                </div>
                <button name="submit" type="submit" class="btn btn-lg btn-primary btn-block">登录</button>
            </form>
            <hr />
            <p class="text-muted">Copyright &copy; <?php echo date('Y'); ?> Crogram, Inc. All Rights Reserved.</p>
        </div>
        <script type="text/javascript">
            document.getElementById("checkcode").onclick = function() {
                document.getElementById("checkcode").src = '<?php echo url("api/access/checkcode", array("width" => 85, "height" => 26)); ?>&' + Math.random();
            }
        </script>
</body>

</html>