<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="renderer" content="webkit"/>
    <meta name="force-rendering" content="webkit"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="robots" content="none, nofollow, noarchive, nocache">
    <meta name="referrer" content="never"/>
    <meta name="generator" content="<?php echo APP_NAME; ?>"/>
    <title><?php echo $this->site_config['SITE_NAME']; ?> - 网站管理系统后台</title>
    <link rel="stylesheet" type="text/css" href="/static/css/backend.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" mce_href="/favicon.ico">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/dialog.js?skin=green"></script>
</head>

<body>
<?php include $this->admin_tpl('head');?>

<div id="main">
    <div id="left">
        <div class="left-head">
            <span style="float:right;">
                <a href="javascript:void(0);" onClick="refresh();" class="refresh">
                    <img src="/static/img/space.gif" alt="刷新菜单" title="刷新菜单" height="18" width="16" />
                </a>
            </span>
            <label id='root_menu_name'>内容管理</label>
        </div>
        <div id="browser">
            <iframe name="leftMain" id="leftMain" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" src="<?php echo url('admin/content/category'); ?>"
                style="border:none" width="100%">
            </iframe>
        </div>
    </div>
    <div id="right">
        <div id="home">
            <div id="shortcut">
                <a href="javascript:_open_url(107,'<?php echo url('admin/index/cache'); ?>');" title="更新缓存">更新缓存</a>
                <a href="<?php echo HTTP_URL; ?>" title="网站首页" target="_blank">网站首页</a>
            </div>
            <label id="position">后台首页</label>
        </div>
        <div id="frame_container" style="width:100%;">
            <iframe name="right" id="rightMain" frameborder="false" scrolling="auto" style="border:none;" width="100%" allowtransparency="true"
                src="<?php echo url('admin/index/main'); ?>">
            </iframe>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>

<script type="text/javascript">
    window.onresize = function () {
        var heights = document.documentElement.clientHeight;
        document.getElementById('rightMain').height = heights - 90;
        document.getElementById('leftMain').height = heights - 90;
    }
    window.onresize();

    function _open_url(id, targetUrl) {
        var title = $("#M_" + id).find('a').html();
        document.getElementById('position').innerHTML = title
        document.getElementById('rightMain').src = targetUrl
        $('.focused').removeClass("focused");
        $('#M_' + id).addClass("focused");
    }

    function logout() {
        if (confirm('确定退出吗'))
            top.location = '<?php echo url("admin/login/logout"); ?>';
        return false;
    }

    function refresh() {
        document.getElementById('leftMain').src = "<?php echo url('admin/content/category'); ?>";
    }
</script>
</body>

</html>