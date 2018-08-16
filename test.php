<?php

header('Content-Type: text/html; charset=utf-8');
$path = pathinfo("http://www.w3school.com.cn/php/sdfsdf?sfsdf=34");
print_r($path);
print_r($path['dirname']);
print_r($path['basename']);
print_r($path['filename']);

$pathinfo = explode('/', $_SERVER['PATH_INFO']);
echo '控制器：', $pathinfo[1];

switch ($pathinfo[1]) {
    case '':
    case '/':
    case 'home':
        print_r('--home');
        break;
    case '/about':
        print_r('--about');
        break;
    case '/static':
        print_r('--static');
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        print_r('--404');
        break;
}
