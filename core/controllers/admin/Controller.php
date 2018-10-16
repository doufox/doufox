<?php

class Admin extends Controller
{

    protected $userid;

    public function __construct()
    {
        parent::__construct();
        $this->isAdminLogin();
        cms::load_file(CORE_PATH . 'library' . DS . 'fields.function.php');
        define('IN_ADMIN', true);
    }

    /**
     * 后台登陆检查
     */
    protected function isAdminLogin($namespace = 'admin', $controller = null)
    {
        if (cms::get_namespace_id() != $namespace) {
            return false;
        }

        if ($controller && cms::get_controller_id() != $controller) {
            return false;
        }

        if (cms::get_namespace_id() == 'admin' && cms::get_controller_id() == 'login') {
            return false;
        }

        if ($this->session->get('user_id')) {
            $this->userid = $this->session->get('user_id');
            if ($this->userid) {
                return false;
            }
        }

        $url = cms::get_namespace_id() == 'admin' && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != 's=admin'
        ? url('admin/login', array('url' => urlencode(HTTP_URL . ENTRY_FILE . '?' . $_SERVER['QUERY_STRING'])))
        : url('admin/login');
        $this->redirect($url);
    }

    /**
     * 获取更新缓存JS代码
     */
    protected function getCacheCode($c, $a = 'cache') {
        return '<script type="text/javascript" src="' . url('admin/index/updatecache', array('cc' => $c, 'ca' => $a)) . '"></script>';
    }

	/**
	 * 更新缓存
	 */
	protected function updateCache($c, $a) {
		$controller  = ucfirst($c) . 'Controller';
		$action      = $a . 'Action';
		$file        = CONTROLLER_PATH . 'admin' . DS . $controller . '.php';
		if (!file_exists($file)) {
            return false;
        }
		cms::load_file($file);
		$application = new $controller();
		if (method_exists($controller, $action)) {
            $application->$action(1);
        }
	}
}