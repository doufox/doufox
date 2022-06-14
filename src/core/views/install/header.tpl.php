<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit" />
    <meta name="force-rendering" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="robots" content="none, nofollow, noarchive, nocache">
    <meta name="referrer" content="never" />
    <title>系统安装向导 - <?php echo APP_NAME; ?> 网站内容管理系统</title>
    <meta name="keywords" content="安装向导"/>
    <meta name="description" content="<?php echo APP_NAME; ?> 网站内容管理系统 - 安装向导"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap.min.css" />
    <style type="text/css">
        .container {
            max-width: 460px;
            margin: 100px auto auto;
        }

        /* .tip { padding-top: 10px; }
        .tip input { margin: 0 5px 3px 0; } */
        .status {
            padding-left: 10px;
            color: #093
        }

        .status-err {
            color: #F00
        }

        /* .u-btn-sm { padding: 0 10px; height: 22px; line-height: 22px; } */
        .install-status {
            margin-left: auto;
            margin-right: auto;
            line-height: 35px;
            font-size: 12px;
            text-align: center;
            color: #F00
        }

        .panel-footer {
            padding: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="panel panel-<?php echo $this->status; ?>">
            <div class="panel-heading">
                <span class="panel-title">系统安装向导</span>
            </div>