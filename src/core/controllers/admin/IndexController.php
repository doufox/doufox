<?php

class IndexController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $sysinfo = get_sysinfo();
        $pars = array(
            // 'sitename' => urlencode($this->site_config['SITE_NAME']),
            'domain' => HTTP_HOST,
            // 'version' => APP_VERSION,
            // 'release' => APP_RELEASE,
            // 'os' => PHP_OS,
            // 'php' => phpversion(),
            'mysql' => $this->category->get_server_info(),
            // 'browser' => urlencode($_SERVER['HTTP_USER_AGENT']),
        );
        // $data = http_build_query($pars);
        // $verify = md5($data.$_SERVER['SERVER_NAME']);
        // $client_url = 'https://doufox.com/client.php?'.$data.'&verify='.$verify; // 反馈到官方网站
        $sysinfo['mysqlv'] = $pars['mysql'];
        $sysinfo['domain'] = $pars['domain'];
        include $this->admin_view('index');

        // 缓存
        if (!file_exists(DATA_PATH . 'cache' . DS . "category.cache.php")) {
            echo '<script type="text/javascript">location.href="' . url('admin/cache/update') . '";</script>';
        }
    }

    /**
     * 后台主视图
     */
    public function mainAction()
    {
        $sysinfo = get_sysinfo();
        // $pars = array(
        //     'sitename' => urlencode($this->site_config['SITE_NAME']),
        //     'domain' => HTTP_HOST,
        //     'version' => APP_VERSION,
        //     'release' => APP_RELEASE,
        //     'os' => PHP_OS,
        //     'php' => phpversion(),
        //     'mysql' => $this->category->get_server_info(),
        //     'browser' => urlencode($_SERVER['HTTP_USER_AGENT']),
        // );
        // $data = http_build_query($pars);
        // $verify = md5($data.$_SERVER['SERVER_NAME']);
        // $client_url = 'https://doufox.com/client.php?'.$data.'&verify='.$verify; // 反馈到官方网站

        $sysinfo['mysqlv'] = $pars['mysql'];
        $sysinfo['domain'] = $pars['domain'];
        include $this->admin_view('main');
    }

    /**
     * 更新指定缓存
     */
    public function updatecacheAction()
    {
        $controller = $this->get('cc');
        $action = $this->get('ca') ? $this->get('ca') : 'cache';
        $this->updateCache($controller, $action);
    }

}
