<?php

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('CORE_DIR', 'core'); // 系统核心目录
include ROOT_PATH . CORE_DIR . DIRECTORY_SEPARATOR . 'app.php';
cms::run();
