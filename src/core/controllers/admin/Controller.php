<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class Admin extends Controller
{

    protected $userid;
    protected $current_account;
    protected $current_account_name;
    protected $menu_model;
    protected $current_nav;

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_login();
        define('IN_ADMIN', true);
        core::load_file(PATH_CORE . DS . 'library' . DS . 'fields.function.php');
        $this->init_common_data();
    }

    /**
     * 后台页面，提示信息页面跳转
     * msg    消息内容
     * status 返回结果状态  1=成功 2=错误 默认错误
     * url    返回跳转地址 默认为来源
     * time   等待时间 ，默认为2秒
     * return exit
     */
    public function show_message($msg, $status = 2, $url = HTTP_REFERER, $time = 2000)
    {
        include $this->views('admin/msg');
        exit;
    }

    /** 后台登陆检查
     * 
     */
    protected function is_admin_login($namespace = 'admin', $controller = null)
    {
        if (core::get_namespace_id() != $namespace) {
            return false;
        }

        if ($controller && core::get_controller_id() != $controller) {
            return false;
        }

        if (core::get_namespace_id() == 'admin' && core::get_controller_id() == 'login') {
            return false;
        }

        if ($this->session->get('member_id')) {
            $this->userid = $this->session->get('member_id');
            if ($this->userid) {
                return false;
            }
        }

        $url = core::get_namespace_id() == 'admin'
            ? url('admin/login', array('url' => urlencode(HTTP_URL . '/' . ENTRY_FILE . '?' . $_SERVER['QUERY_STRING'])))
            : url('admin/login');
        $this->redirect($url);
    }

    /** 加载公共数据
     * 
     */
    protected function init_common_data()
    {
        // 当前激活导航菜单
        $this->current_nav = core::get_controller_id();
        if ($this->current_nav == 'form') {
            $this->current_nav = 'model';
        } elseif (in_array($this->current_nav, array('account', 'attachment', 'template', 'database', 'backup', 'cache', 'file'))) {
            $this->current_nav = 'manage';
        }
        // 当前账号信息
        // $this->current_account = $this->account->find($this->userid);
        $this->current_account['name'] = empty($this->memberinfo['realname']) ? $this->memberinfo['nickname'] : $this->memberinfo['realname'];
        // 菜单-表单模型
        $this->menu_model = '';
        $form = get_cache('formmodel');
        if ($form) {
            foreach ($form as $t) {
                $id = $t['modelid'];
                $url = url('admin/form/list', array('modelid' => $id));
                $this->menu_model[$id] = array('id' => $id, 'name' => $t['modelname'], 'url' => $url);
            }
        }
        unset($form);
    }
    /**
     * 获取更新缓存JS代码
     */
    protected function getCacheCode($c, $a = 'cache')
    {
        return '<script type="text/javascript" src="' . url('admin/index/updatecache', array('cc' => $c, 'ca' => $a)) . '"></script>';
    }

    /**
     * 更新缓存
     */
    protected function updateCache($c, $a)
    {
        $controller = ucfirst($c) . 'Controller';
        $action = $a . 'Action';
        $file = PATH_CONTROLER . 'admin' . DS . $controller . '.php';
        if (!file_exists($file)) {
            return false;
        }
        core::load_file($file);
        $application = new $controller();
        if (method_exists($controller, $action)) {
            $application->$action(1);
        }
    }
}
