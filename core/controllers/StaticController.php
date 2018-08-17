<?php
/**
 * 静态文件加载
 */
class StaticController
{
    public static $pathinfo;

    public function __construct()
    {

    }

    public function indexAction()
    {
        $file = $_SERVER['REQUEST_URI'];
        $ext = get_extension($file);
        header('X-Powered-By: ' . CMS_NAME);
        if (isset($ext)) {
            if ($ext == 'js') {
                header('Content-type: application/x-javascript');
            } else if ($ext == 'css') {
                header('Content-type: text/css');
            } else if ($ext == 'png') {
                header('Content-type: image/png');
            } else if ($ext == 'jpg') {
                header('Content-type: image/jpeg');
            } else if ($ext == 'gif') {
                header('Content-type: image/gif');
            } else if ($ext == 'ico') {
                header('Content-type: image/x-icon');
            } else {
                header('Content-Type: text/html; charset=UTF-8');
            }
            include $this->load_file($file);
        } else {
            exit('Access Deined!');
        }
    }

    /**
     * 加载静态资源
     * @param string $file_name 文件名
     */
    protected function load_file($file_name)
    {
        if (!is_file(ROOT_PATH . DATA_NAME . $file_name)) {
            header("HTTP/1.0 404 Not Found");
            // header('Refresh: 3; url=' . HTTP_PRE. HTTP_HOST);
            exit('Not Found.');
        }
        return ROOT_PATH . DATA_NAME . $file_name;
    }
}
