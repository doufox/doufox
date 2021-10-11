<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit" />
    <meta name="force-rendering" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="referrer" content="always" />
    <title><?php echo $msg; ?> - <?php echo $this->site_config['SITE_NAME']; ?></title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico" />
    <link rel="shortcut" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico" />
    <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css" />
    <style type="text/css">
        body {
            font-size: 12px;
            line-height: 1.5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            margin-bottom: 60px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: #f5f5f5;
        }

        .container {
            width: auto;
            max-width: 680px;
            padding: 0 15px;
        }

        .container .text-muted {
            margin: 20px 0;
        }
    </style>
    <?php doHookAction('admin_head'); ?>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1><?php echo $msg; ?></h1>
        </div>
        <div class="alert alert-<?php if ($status == 1) { ?>success<?php } else { ?>info<?php } ?>">
            <p>
                <?php if ($url == null) { ?>
                    <button class="btn btn-link" href="javascript:history.back();">[返回上一页]</button>
                <?php } elseif ($url == 'close') { ?>
                    <button class="btn btn-link" type="button" name="close" onClick="window.close();">[关闭]</button>
                <?php } elseif ($url == 'back') { ?>
                    <script type="text/javascript">
                        setTimeout(function() {
                            history.back();
                        }, <?php echo $time; ?>);
                    </script>
                <?php } else { ?>
                    <a class="btn btn-link" href="<?php echo $url; ?>">[如果您的浏览器没有自动跳转，请点击这里]</a>
                    <script type="text/javascript">
                        setTimeout("location.href='<?php echo $url; ?>';", <?php echo $time; ?>);
                    </script>
                <?php } ?>
                <a class="btn btn-link" href="/">[返回首页]</a>
            </p>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted text-right">
                <a class="pull-left" href="<?php echo url(''); ?>"><?php echo $this->site_config['SITE_NAME']; ?></a>
                <span>Powered by <a href="<?php echo APP_SITE; ?>" target="_blank"><?php echo ucfirst(APP_NAME); ?></a></span>
            </p>
        </div>
    </footer>
</body>

</html>