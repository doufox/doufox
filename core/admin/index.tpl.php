<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->site_config['SITE_NAME']; ?> - 网站管理系统后台</title>
    <link rel="stylesheet" type="text/css" href="/static/css/backend.css" />
    <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/dialog.js?skin=green"></script>
</head>

<body>
    <div id="head">
        <div class="logo">
            <h1>网站管理系统后台</h1>
        </div>
        <div id="menu_position">
            <ul id="menu">
                <li id="_MP100" class="focused">
                    <a href="<?php echo url('admin'); ?>">主页</a>
                </li>
                <li id="_MP101">
                    <a href="javascript:_MP(101,'<?php echo url('admin/category'); ?>');">栏目</a>
                </li>
                <li id="_MP102">
                    <a href="javascript:_MP(102,'<?php echo url('admin/block'); ?>');">区块</a>
                </li>
                <?php if ($MEMBER_REGISTER) {?>
                <li id="_MP103">
                    <a href="javascript:_MP(103,'<?php echo url('admin/member'); ?>');">会员</a>
                </li>
                <?php }?>
                <li id="_MP104">
                    <a href="javascript:_MP(104, '<?php echo url('admin/index/config'); ?>');">设置</a>
                    <ul>
                        <li id="_MP1041">
                            <a href="javascript:_MP(1041,'<?php echo url('admin/index/config', array('type'=> 1)); ?>');">系统设置</a>
                        </li>
                        <li id="_MP1042">
                            <a href="javascript:_MP(1042,'<?php echo url('admin/index/config', array('type'=> 2)); ?>');">水印设置</a>
                        </li>
                        <li id="_MP1043">
                            <a href="javascript:_MP(1043,'<?php echo url('admin/index/config', array('type'=> 3)); ?>');">后台密码</a>
                        </li>
                        <li id="_MP1044">
                            <a href="javascript:_MP(1044,'<?php echo url('admin/index/config', array('type'=> 4)); ?>');">会员配置</a>
                        </li>
                        <li id="_MP1045">
                            <a href="javascript:_MP(1045,'<?php echo url('admin/index/config', array('type'=> 5)); ?>');">URL设置</a>
                        </li>
                        <li id="_MP107">
                            <a href="javascript:_MP(107,'<?php echo url('admin/index/cache'); ?>');">更新缓存</a>
                        </li>
                        <li id="_MP403">
                            <a href="javascript:_MP(403,'<?php echo url('admin/content/updateurl'); ?>');">更新内容URL</a>
                        </li>
                        <li id="_MP403">
                            <a href="javascript:_MP(403,'<?php echo url('admin/database'); ?>');">数据库备份</a>
                        </li>
                        <li id="_MP1046">
                            <a href="javascript:_MP(1046,'<?php echo url('admin/model'); ?>');">内容模型</a>
                        </li>
                        <li id="_MP1047">
                            <a href="javascript:_MP(1047,'<?php echo url('admin/model', array('typeid'=> 3)); ?>');">表单模型</a>
                        </li>
                        <?php if (is_array($menu)) {foreach ($menu as $t) {?>
                        <li id="_MP9<?php echo $t['id'] ?>">
                            <a href="javascript:_MP(9<?php echo $t['id'] ?>,'<?php echo $t['url'] ?>');">
                                <?php echo $t['name'] ?>
                            </a>
                        </li>
                        <?php }}?>
                        <li class="menubtm"></li>
                    </ul>
                </li>
                <li id="_MP105">
                    <a href="javascript:_MP(105,'<?php echo url('admin/template'); ?>');">模板</a>
                </li>
                <li id="_MP106">
                    <a href="javascript:_MP(106,'<?php echo url('admin/createhtml'); ?>');">生成</a>
                    <ul>
                        <li id="_MP1061">
                            <a href="javascript:_MP(1061,'<?php echo url('admin/createhtml/index'); ?>&a=index');">生成首页</a>
                        </li>
                        <li id="_MP1062">
                            <a href="javascript:_MP(1062,'<?php echo url('admin/createhtml'); ?>&a=category');">生成栏目页</a>
                        </li>
                        <li id="_MP1063">
                            <a href="javascript:_MP(1063,'<?php echo url('admin/createhtml'); ?>&a=show');">生成内容页</a>
                        </li>
                        <li class="menubtm"></li>
                    </ul>
                </li>
                <li id="_MP107">
                    <a href="javascript:_MP(107,'<?php echo url('admin/attachment'); ?>');">附件</a>
                </li>
            </ul>
        </div>
        <div class="user">
            <?php echo $username; ?>&nbsp;
            <a href="javascript:void(0);" onClick="logout();">退出</a>
        </div>
    </div>
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
                    <a href="javascript:_MP(107,'<?php echo url('admin/index/cache'); ?>');" title="更新缓存">更新缓存</a>
                    <a href="<?php echo APP_SITE; ?>" title="帮助" target="_blank" title="帮助">帮助</a>
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
    <script type="text/javascript">
        window.onresize = function () {
            var heights = document.documentElement.clientHeight;
            document.getElementById('rightMain').height = heights - 61;
            document.getElementById('leftMain').height = heights - 61;
        }
        window.onresize();

        function _MP(id, targetUrl) {
            var title = $("#_MP" + id).find('a').html();
            document.getElementById('position').innerHTML = title
            document.getElementById('rightMain').src = targetUrl
            $('.focused').removeClass("focused");
            $('#_MP' + id).addClass("focused");
        }

        function logout() {
            if (confirm("确定退出吗"))
                top.location = '<?php echo url("admin/login/logout/"); ?>';
            return false;
        }

        function refresh() {
            document.getElementById('leftMain').src = '<?php echo url('admin/content/category'); ?>';
        }
    </script>
</body>

</html>