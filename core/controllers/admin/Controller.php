<?php

class Admin extends Controller
{

    protected $admin;

    public function __construct()
    {
        parent::__construct();
        $this->isAdminLogin();
        xiaocms::load_file(CORE_PATH . 'library' . DIRECTORY_SEPARATOR . 'fields.function.php');
        define('IN_ADMIN', true);
    }

    /**
     * 后台登陆检查
     */
    protected function isAdminLogin($namespace = 'admin', $controller = null)
    {
        if (xiaocms::get_namespace_id() != $namespace) {
            return false;
        }

        if ($controller && xiaocms::get_controller_id() != $controller) {
            return false;
        }

        if (xiaocms::get_namespace_id() == 'admin' && xiaocms::get_controller_id() == 'login') {
            return false;
        }

        if ($username = $this->session->get('user_id')) {
            if ($username) {
                return false;
            }
        }
        $url = xiaocms::get_namespace_id() == 'admin' && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != 's=admin' ? url('admin/login', array('url' => urlencode(SITE_PATH . ENTRY_SCRIPT_NAME . '?' . $_SERVER['QUERY_STRING']))) : url('admin/login');
        $this->redirect($url);
    }

    /**
     * 获取更新缓存JS代码
     */
    protected function getCacheCode($c, $a = 'cache')
    {
        return '<script type="text/javascript" src="' . url('admin/index/updatecache', array('cc' => $c, 'ca' => $a)) . '"></script>';
    }

}
