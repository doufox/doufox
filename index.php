<?php

header('Content-Type: text/html; charset=utf-8');
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('CORE_NAME', 'core'); // 系统核心目录
include ROOT_PATH . CORE_NAME . DIRECTORY_SEPARATOR . 'app.php';
xiaocms::run();
