<?php
/*
Name: 聚合登录
Version: 1.0
URL: http://doufox.com
Description: 连接到聚合登录，实现快速通过第三方登录系统
Author: Doufox
Author URL: http://doufox.com
*/


if (!defined('IN_CRONLITE')) {
    exit('Access Deined!');
}

$plugin_plugin = core::load_model('plugin');
$plugin_oauth_data = $plugin_plugin->getOne('plugin=?', 'oauth');

if ($plugin_oauth_data && $plugin_oauth_data['status'] == 1) {
    if (isset($plugin_oauth_data['setting'])) {
        global $plugin_oauth_setting;
        $plugin_oauth_setting = string2array($plugin_oauth_data['setting']);
    }
    core::load_file(PATH_PLUGIN . 'oauth' . DS . 'oauth_library.php');
    // 后台登录页添加
    addHookAction('admin_login_form_foot', 'plugin_oauth_render');
    // 用户登录页
    addHookAction('memger_login_form_foot', 'plugin_oauth_render');
}
