<?php

class IndexController extends Admin
{
    public function __construct() {
        parent::__construct();
	}

	public function indexAction() {
        $account = $this->account->find($this->userid);
        $name = empty($account['realname']) ? $account['username'] : $account['realname'];
		$menu = '';
		$form  = get_cache('formmodel');
		if ($form) {
		    foreach ($form as $t) {
				$id   = $t['modelid'];
				$url  = url('admin/form/list', array('modelid'=>$id));
				$menu[$id] = array('id'=>$id, 'name'=>$t['modelname'], 'url'=>$url);
			}
		}
		include $this->admin_tpl('index');
	}

	/**
	 * 后台主视图
	 */
	public function mainAction() {
		$sysinfo = get_sysinfo();
		// $pars = array(
		// 	'sitename' => urlencode($this->site_config['SITE_NAME']),
		// 	'domain' => HTTP_HOST,
		// 	'version' => APP_VERSION,
		// 	'release' => APP_RELEASE,
		// 	'os' => PHP_OS,
		// 	'php' => phpversion(),
		// 	'mysql' => $this->category->get_server_info(),
		// 	'browser' => urlencode($_SERVER['HTTP_USER_AGENT']),
		// );
		// $data = http_build_query($pars);
		// $verify = md5($data.$_SERVER['SERVER_NAME']);
		// $client_url = 'https://doufox.com/client.php?'.$data.'&verify='.$verify; // 反馈到官方网站

		$sysinfo['mysqlv'] = $pars['mysql'];
		$sysinfo['domain'] = $pars['domain'];
	    include $this->admin_tpl('main');
	}

	/**
	 * 数据缓存
	 */
	public function cacheAction() {
	    $caches = array(
	        0 => array('账号缓存更新成功', 'account', 'cache'),
	        1 => array('模型缓存更新成功', 'model', 'cache'),
	        2 => array('栏目缓存更新成功', 'category', 'cache'),
	        3 => array('区块缓存更新成功', 'block', 'cache'),
	        4 => array('模板缓存更新成功', 'template', 'cache'),
	    );
	    if ($this->get('show')) {
	        $id    = $_GET['id'] ? intval($_GET['id']) : 0;
	        $cache = $caches[$id];
	        $c     = $cache[1];
	        $a     = $cache[2] . 'Action';
	        $id ++;

			if (!empty($cache)) {
				echo '<script type="text/javascript">window.parent.frames["hidden"].location="index.php?s=admin&c='. $c .'&a=cache";</script>';
				echo '<script type="text/javascript">window.parent.addtext("<li>' .  $cache[0] . '</li>");</script>';
				$this->show_message($msg, 1, url('admin/index/cache/', array('show'=>1,'id'=>$id)), 100);		
			} else {
	            echo '<script type="text/javascript">window.parent.addtext("<li style=\"color: red;\">全站缓存更新成功</li><li><a style=\"color: #090;font-weight: 700;\" href=\"?s=admin&c=index&a=main\" >点击返回后台主页</li>");</script>';
			}
	    } else {
	        include $this->admin_tpl('cache');
	    }
	}

	/**
	 * 更新指定缓存
	 */
	public function updatecacheAction() {
		$controller = $this->get('cc');
	    $action     = $this->get('ca') ? $this->get('ca') : 'cache';
		$this->updateCache($controller, $action);
	}

}