<!doctype html>
<html lang="zh-CN">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>提示信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon" />
    <style type="text/css">
        html,
        body {
            width: 100%;
            height: 100%;
        }

        body,
        h1,
        p,
        a,
        img {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
            font-size: 12px;
            line-height: 1.5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        h1 {
            font-size: 14px;
            margin-top: 12px;
        }

        p {
            font-size: 12px;
            line-height: 150%;
            padding: 10px;
            line-height: 18px;
        }

        .table {
            width: 90%;
            height: 100%;
            display: table;
            margin-left: auto;
            margin-right: auto;
        }

        .table-cell {
            display: table-cell;
            vertical-align: middle;
        }

        .msg-container {
            max-width: 420px;
            padding: 20px 0;
            margin: -120px auto 0;
            border-radius: 4px;
        }

        #success {
            border: 1px solid #A6DFA6;
            background: #EEF9EE;
        }

        #success h1 {
            color: #237E29;
        }

        #success a:link,
        a:visited {
            color: #237E29;
            text-decoration: none;
        }

        #success a:hover,
        a:active {
            color: #237E29;
            text-decoration: underline;
        }

        #error {
            border: 1px solid #FDBD77;
            background: #FFFDD7;
        }

        #error h1 {
            color: #f30;
        }

        #error a:link,
        a:visited {
            color: #f30;
            text-decoration: none;
        }

        #error a:hover,
        a:active {
            color: #0066FF;
            text-decoration: underline;
        }

        .c_red {
            color: #FF0000;
        }

        #success a {
            color: #237E29;
        }

        #error a {
            color: #f30;
        }
    </style>
</head>

<body class="table">
    <div class="table-cell">
        <div class="msg-container" <?php if ($status == 1) { ?>id="success" <?php } else { ?>id="error" <?php } ?>>
            <div class="content">
                <h1><?php echo $msg; ?></h1>
                <p><?php if ($url == null) { ?>
                        <a href="javascript:history.back();">[点这里返回上一页]</a>
                    <?php } elseif ($url == 'close') { ?>
                        <button type="button" name="close" onClick="window.close();"></button>
                    <?php } elseif ($url == 'back') { ?>
                        <script type="text/javascript">
                            setTimeout(function() {
                                history.back();
                            }, <?php echo $time; ?>);
                        </script>
                    <?php } else { ?>
                        <a href="<?php echo $url; ?>">如果您的浏览器没有自动跳转，请点击这里</a>
                        <script type="text/javascript">
                            setTimeout("location.href='<?php echo $url; ?>';", <?php echo $time; ?>);
                        </script>
                    <?php } ?>
                </p>
            </div>
        </div>
    </div>
</body>

</html>