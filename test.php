<?php

header('Content-Type: text/html; charset=utf-8');
// $path = pathinfo("http://www.w3school.com.cn/php/sdfsdf?sfsdf=34");
// print_r($path);
// print_r($path['dirname']);
// print_r($path['basename']);
// print_r($path['filename']);

print(PHP_EOL);
print($_SERVER['REQUEST_URI']);

print(" \n");


$pathinfo = explode('/', $_SERVER['PATH_INFO']);
echo '控制器：';
print($pathinfo);
print(PHP_EOL);
// switch ($pathinfo[1]) {
//     case '':
//     case '/':
//     case 'home':
//         print_r('--home');
//         break;
//     case '/about':
//         print_r('--about');
//         break;
//     case '/static':
//         print_r('--static');
//         break;
//     default:
//         header('HTTP/1.0 404 Not Found');
//         print_r('--404');
//         break;
// }
// pathinfo($file, PATHINFO_EXTENSION)
print(PHP_EOL);
$aaa = pathinfo("http://alskjdf.com/php/static/js/dddd.js"); 
print($aaa);
print(PHP_EOL);
print_r($aaa['dirname']);
print(PHP_EOL);
print_r($aaa['basename']);
print(PHP_EOL);
print_r($aaa['filename']);

print(PHP_EOL);

$bbb = '/theme/css/style.css';
echo strtr($bbb, array('/theme'=>''));
print(PHP_EOL);

echo explode('/', '/theme/css/style.css')[1];
