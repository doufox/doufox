<?php

/**
 * 插件
 */

$globalHooks = array();
// $active_plugin = self::get('active_plugin');
$active_plugin = array(
    'tips/tips.php',
    'helloworld/helloworld.php'
);

if ($active_plugin && is_array($active_plugin)) {
    foreach ($active_plugin as $plugin) {
        if (true === checkPlugin($plugin)) {
            include_once PLUGIN_PATH . $plugin;
        }
    }
}
