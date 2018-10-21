<?php
define('DS', DIRECTORY_SEPARATOR);
define('ENTRY_FILE', 'index.php'); // 系统入口文件
define('ROOT_PATH', dirname(__FILE__) . DS); // 系统根路径
// include ROOT_PATH . 'core' . DS . 'core.php'; // 加载系统
// core::run(); // 运行系统
header('Content-Type: text/html; charset=utf-8');
// 获得请求地址
$root = $_SERVER['SCRIPT_NAME'];
echo '<br/>';
echo '$root=' . $root;
echo PHP_EOL;

$path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];

echo '<br/>$path_url_string=' . $path_url_string . PHP_EOL;

echo '<br/>$PATH_INFO=' . $_SERVER['PATH_INFO'] . PHP_EOL;
echo '<br/>$SCRIPT_URL=' . $_SERVER['SCRIPT_URL'] . PHP_EOL;
echo '<br/>$PHP_SELF=' . $_SERVER['PHP_SELF'] . PHP_EOL;
echo '<br/>$REDIRECT_SCRIPT_URI=' . $_SERVER['REDIRECT_SCRIPT_URI'] . PHP_EOL;
// echo '<br/>$server=' . json_encode($_SERVER) . PHP_EOL;

echo '<br/>路径: ' . trim(str_replace($root, '', $_SERVER['PATH_INFO']), '/') . PHP_EOL;

$request = $_SERVER['REQUEST_URI'];
echo '<br/>';
echo '$request=' . $request;
echo PHP_EOL;

// 获得index.php 后面的地址
// $url = trim(str_replace($root, '', $request), '/');
$url = strtolower(trim(str_replace($root, '', $_SERVER['PATH_INFO']), '/'));
echo '<br/>$url=' . $url . PHP_EOL;

// 默认控制器和默认方法
$namespace_name = '';
$controller_name = 'index';
$action_name = 'index';

$URI = array();
// 如果为空，则是访问根地址
if (!empty($url)) {
    $URI = explode('/', $url);
    // 如果function为空 则默认访问index
    if (count($URI) == 1) {
        if (inNameSpace($URI[0])) {
            $namespace_name = $URI[0];
        } else if (isController('', $URI[0])) {
            $controller_name = $URI[0];
        } else {
            $action_name = $URI[0];
        }
    } else if (count($URI) == 2) {
        if (inNameSpace($URI[0])) {
            $namespace_name = $URI[0];
            if (isController($URI[0] . DS, $URI[1])) {
                $controller_name = $URI[1];
            } else {
                $action_name = $URI[1];
            }
        } else if (isController('', $URI[0])) {
            $controller_name = $URI[0];
        }
    } else if (count($URI) > 2) {
        if (inNameSpace($URI[0])) {
            $namespace_name = $URI[0];
            if (isController($URI[0] . DS, $URI[1])) {
                $controller_name = $URI[1];
                $action_name = $URI[2];
            } else {
                $action_name = $URI[1];
            }
        } else if (isController('', $URI[0])) {
            $controller_name = $URI[0];
            $action_name = $URI[1];
        } else {
            $action_name = $URI[0];
        }
    }
}

function inNameSpace($path)
{
    $aaa = ROOT_PATH . 'core/controllers/' . $path;
    echo '<br/>$NameSpace=' . $aaa . PHP_EOL;
    if (is_dir($aaa)) {
        return true;
    }
    return false;
}

function isController($path = '', $file)
{
    $aaa = ROOT_PATH . 'core/controllers/' . $path . ucfirst($file) . 'Controller.php';
    echo '<br/>$ControllerName=' . $aaa . PHP_EOL;
    if (is_file($aaa)) {
        return true;
    }
    return false;
}

echo '<br/>';
echo '$URI=' . json_encode($URI);
echo PHP_EOL;

$router = array(
    'namespace' => $namespace_name,
    'controller' => $controller_name,
    'action' => $action_name,
);

echo '<br/>';
echo '$router=' . json_encode($router);
echo PHP_EOL;
