<?php
/*
Name: 小贴士
Version: 1.0
URL: http://doufox.com
Description: 内置插件，它会在您管理主页面显示一句温馨的小提示。
Author: Doufox
Author URL: http://doufox.com
*/


if (!defined('IN_CRONLITE')) {
    exit('Access Deined!');
}


function plugin_tips_css()
{
    echo '<style type="text/css">#plugin_admin_tips {color: #0006ff; text-align: center;}</style>';
}

function plugin_tips()
{
    $array_tips = array(
        '你永远都不知道，明天和未来哪个会先到',
        '做一个开心的人',
        '今天你备份数据了吗？',
    );
    $i = mt_rand(0, count($array_tips) - 1);
    $tip = $array_tips[$i];
    echo '<div class="alert alert-info" role="alert" id="plugin_admin_tips">' . $tip . '</div>';
}

// 管理主页面显示
addHookAction('admin_index_top', 'plugin_tips_css'); // head 头部插入 CSS 样式
addHookAction('admin_index_content_top', 'plugin_tips');
