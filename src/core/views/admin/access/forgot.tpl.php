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
        html {
            width: 100%;
            height: 100%;
        }
        body {
            background-color: #f3f3f3;
            display: table;
            height: 100%;
            width: 100%;
        }
        .container {
            width: 100%;
            display: table-cell;
            vertical-align: middle;
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>重置密码，开发中</span>
                <span class="pull-right">DouFox 网站管理系统</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username" class="control-label">账号</label>
                                <input name="username" id="username" type="text" class="form-control" placeholder="输入登录账号" required maxlength="20" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">注册邮箱</label>
                                <input name="email" id="email" type="email" class="form-control" placeholder="输入注册邮箱" autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <label for="phone" class="control-label">手机号</label>
                                <input name="phone" id="phone" type="text" class="form-control" placeholder="11 位手机号" maxlength="11" autocomplete="off" required />
                            </div>
                            <div class="input-group">
                                <input type="text" name="code" class="form-control captcha" placeholder="验证码" maxlength="4" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" style="padding: 3px;">
                                        <img id="checkcode" src="" title="看不清楚？换一张" alt="验证码" />
                                    </button>
                                </span>
                            </div>

                            <div class="form-group">
                                <a href="<?php echo url('admin/login/index');?>">已有账号登录</a>
                            </div>
                            <button name="submit" type="submit" class="btn btn-primary btn-block">提交</button>
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