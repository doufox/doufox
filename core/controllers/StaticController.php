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
        if (isset($ext)) {
            if ($ext == 'js') {
                header("Content-type: application/x-javascript; charset=utf-8");
            } else if ($ext == 'css') {
                header("Content-type: text/css; charset=utf-8");
            } else if ($ext == 'html') {
                header("Content-type: text/html; charset=utf-8");
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
            exit('File does not Exist.');
        }
        return ROOT_PATH . DATA_NAME . $file_name;
    }
}
