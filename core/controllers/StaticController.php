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
        $pathinfo = explode('/', $_SERVER['PATH_INFO']); // 格式形式/static/js/com.js
        // $file_name = trim($_REQUEST['file']) ? trim($_REQUEST['file']) : 'index.html';
        if ($pathinfo[2] && $pathinfo[3]) {
            if ($pathinfo[2] == 'js') {
                header("Content-type: application/x-javascript; charset=utf-8");
            } else if ($pathinfo[2] == 'css') {
                header("Content-type: text/css; charset=utf-8");
            }
            include $this->static_file(trim($pathinfo[2]) . DIRECTORY_SEPARATOR . trim($pathinfo[3]));
        } else {
            exit('Access Deined!');
        }
    }

    /**
     * 加载静态资源
     * @param string $file_name 文件名
     */
    protected function static_file($file_name)
    {
        if (!is_file(STATIC_DIR . $file_name)) {
            exit('File does not Exist.');
        }
        return STATIC_DIR . $file_name;
    }
}
