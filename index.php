<?php
define('DS', DIRECTORY_SEPARATOR);
define('ENTRY_FILE', 'index.php'); // 系统入口文件
define('ROOT_PATH', dirname(__FILE__) . DS); // 系统根路径
include ROOT_PATH . 'core' . DS . 'core.php'; // 加载系统
core::run(); // 运行系统
// echo '<br/>'.microtime(true);
// echo '<br/>'.$_SERVER['REQUEST_TIME'];
// echo json_encode($_SERVER);
// echo '<br/>$_GET=' . json_encode($_GET) . PHP_EOL;

// $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
// echo '<br/>$path_url_string=' . $path_url_string . PHP_EOL;

// parse_str($path_url_string, $url_info_array);
// echo '<br/>$url_info_array=' . $url_info_array . PHP_EOL;

// $_GET = array_merge($_GET, $url_info_array);
// echo '<br/>$_GET=' . json_encode($_GET) . PHP_EOL;
