<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * 静态文件加载
 */
class StaticController
{
    public static $pathinfo;

    public function __construct()
    { }

    public function indexAction()
    {
        $path = explode('?', $_SERVER['REQUEST_URI']);
        $file = $path[0];
        $file_real_path = DATA_PATH . DS .$file;
        if (!file_exists($file_real_path) || !is_file($file_real_path)) {
            header("HTTP/1.0 404 Not Found");
            header('Refresh: 10; url=' . HTTP_PRE. HTTP_HOST);
            exit('Not Found.');
        }
        $ext = get_file_extension($file);
        if (isset($ext)) {
            if ($ext == 'js') {
                header('Content-type: application/x-javascript');
            } else if ($ext == 'css') {
                header('Content-type: text/css');
            } else if ($ext == 'png') {
                header('Content-type: image/png');
            } else if ($ext == 'jpg' || $ext == 'jpeg') {
                header('Content-type: image/jpeg');
            } else if ($ext == 'gif') {
                header('Content-type: image/gif');
            } else if ($ext == 'ico') {
                header('Content-type: image/x-icon');
            }
            include $file_real_path;
        } else {
            exit('Access Deined!');
        }
    }
}
