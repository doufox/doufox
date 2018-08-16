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
        // print(trim($pathinfo[2] . DIRECTORY_SEPARATOR . $pathinfo[3]))
        $pathinfo = explode('/', $_SERVER['PATH_INFO']); // 格式形式/theme/js/com.js
        if ($pathinfo[2] && $pathinfo[3]) {
            if ($pathinfo[2] == 'js') {
                header('Content-type: application/x-javascript; charset=utf-8');
            } else if ($pathinfo[2] == 'css') {
                header('Content-type: text/css; charset=utf-8');
            }
            header('Cache-Control: max-age=1000000');
            include $this->theme_file(trim($pathinfo[2] . DIRECTORY_SEPARATOR . $pathinfo[3]));
        } else {
            exit('Access Deined!');
        }
    }

    /**
     * 加载静态资源
     * @param string $file_name 文件名
     */
    protected function theme_file($file_name)
    {
        // print(THEME_PATH . THEME_NAME . DIRECTORY_SEPARATOR . $file_name);
        if (!is_file(THEME_PATH . THEME_NAME . DIRECTORY_SEPARATOR . $file_name)) {
            exit('File does not Exist.');
        }
        return THEME_PATH . THEME_NAME . DIRECTORY_SEPARATOR . $file_name;
    }
}
