<?php
/*
Name: Hello World
Version: 1.0
URL: https://doufox.com
Description: 内置插件，它会在您每个管理页面显示一句"Hello World !"。
Author: doufox
Author URL: https://doufox.com
*/


if (!defined('IN_CRONLITE')) {
    exit();
}

function plugin_helloworld_css()
{
    echo '<style type="text/css">#plugin_admin_helloworld {color: red; text-align: center;}</style>';
}

function plugin_helloworld()
{
    echo '<div class="container"><div class="alert alert-info" role="alert" id="plugin_admin_helloworld">Hello World !</div></div>';
}

// 每个管理界面顶部插入样式和内容
addHookAction('admin_head', 'plugin_helloworld_css');
addHookAction('admin_top', 'plugin_helloworld');
