<?php
/**
 * 主题文件加载
 */
class ThemeController
{
    public static $pathinfo;

    public function __construct()
    {

    }

    public function indexAction()
    {
        $path = explode('?', $_SERVER['REQUEST_URI']);
        $file = $path[0];
        $ext = get_file_extension($file);
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
        $file = strtr($file_name, array('/theme' => ''));
        $file_real_path = THEME_CURRENT . THEME_DIR . $file;
        if (!is_file($file_real_path)) {
            header("HTTP/1.0 404 Not Found");
            // header('Refresh: 3; url=' . HTTP_PRE. HTTP_HOST);
            exit('Not Found.');
        }
        return $file_real_path;
    }
}
