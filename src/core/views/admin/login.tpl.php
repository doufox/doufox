<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="force-rendering" content="webkit" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>网站内容管理系统 - DouFox</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
    <meta name="robots" content="none, nofollow, noarchive, nocache">
    <meta name="referrer" content="never" />
    <link type="text/css" href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">
        body {
            background-color: #f3f3f3;
        }
        .header {
            margin: 16% 0 30px;
        }
        .text-muted {
            font-size: 16px;
            color: #999;
        }
        .panel {
            max-width: 600px;
            margin: 0 auto;
        }
        .panel-body {
            padding: 40px;
        }
        .row {
            max-width: 300px;
            margin: 0 auto;
        }
        .input-group {
            margin-bottom: 20px;
        }
        #checkcode {
            width: 85px;
            height: 26px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header text-center">
            <h1>DouFox</h1>
            <p class="text-muted">网站内容管理系统</p>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>管理员登陆</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username" class="control-label">账号</label>
                                <input name="username" type="text" class="form-control" placeholder="输入登录账号" required autofocus maxlength="20" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">密码</label>
                                <span class="pull-right"><a href="#" title="正在开发中">忘记密码</a></span>
                                <input name="password" type="password" class="form-control" placeholder="输入登录密码" maxlength="20" autocomplete="off" required />
                            </div>
                            <div class="input-group">
                                <input type="text" name="code" class="form-control captcha" placeholder="右侧验证码" maxlength="4" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" style="padding: 3px;">
                                        <img id="checkcode" src="" title="看不清楚？换一张" alt="验证码" />
                                    </button>
                                </span>
                            </div>
                            <div class="form-group">
                                <a href="#" title="正在开发中">手机验证码登录</a>
                            </div>
                            <button name="submit" type="submit" class="btn btn-primary btn-block">登录</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        (function() {
            function checkcode_init() {
                document.getElementById("checkcode").src = '<?php echo url("api/access/checkcode", array("width" => 85, "height" => 26)); ?>&' + Math.random();
            }
            checkcode_init();
            document.getElementById("checkcode").onclick = checkcode_init;
        })();
    </script>
</body>

</html>