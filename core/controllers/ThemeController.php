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
        // $theme = explode('/', $file_name);
        // $theme = $pathinfo[1];
        $file = strtr($file_name, array('/theme' => ''));
        // if ($theme == 'theme') {
        //     THEME_PATH . DIRECTORY_SEPARATOR . $file_name
        // }
        // if (is_mobile()) {
        //     $file_real_path = THEME_MOBILE_PATH . SITE_THEME_MOBILE . $file;
        // } else {
        //     $file_real_path = THEME_PATH . SITE_THEME .$file;
        // }
        $file_real_path = THEME_CURRENT . THEME_DIR . $file;
        if (!is_file($file_real_path)) {
            exit('File does not Exist.');
        }
        return $file_real_path;
    }
}
