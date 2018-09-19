<?php

class IndexController extends Admin {

    public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 首页
	 */
	public function indexAction() {
    $username = $this->session->get('user_id');
		$MEMBER_REGISTER = $this->site_config['MEMBER_REGISTER'];
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
	 * 后台首页
	 */
	public function mainAction() {
		$username = $this->session->get('user_id');
		$sysinfo = get_sysinfo();
		$pars = array(
			'sitename' => urlencode($this->site_config['SITE_NAME']),
			'domain' => HTTP_HOST,
			'version' => APP_VERSION,
			'release' => APP_RELEASE,
			'os' => PHP_OS,
			'php' => phpversion(),
			'mysql' => $this->category->get_server_info(),
			'browser' => urlencode($_SERVER['HTTP_USER_AGENT']),
		);
		$data = http_build_query($pars);
		$verify = md5($data.$_SERVER['SERVER_NAME']);
		// $client_url = 'https://doufox.com/client.php?'.$data.'&verify='.$verify; // 反馈到官方网站

		$sysinfo['mysqlv'] = $pars['mysql'];
		$sysinfo['domain'] = $pars['domain'];
	    include $this->admin_tpl('main');
	}

	/**
	 * 网站配置
	 */
	public function configAction() {
    	// 变量注释
		$string = array(
			'SITE_THEME'              => '桌面端主题样式, 默认default',
			'SITE_THEME_MOBILE'       => '移动端主题样式, 默认default',
			'SITE_MOBILE'             => '移动端主题样式, 默认关闭',
			'SITE_NAME'               => '网站名称',
			'SITE_SLOGAN'             => '网站头部标语',
			'SITE_TITLE'              => '网站首页SEO标题',
			'SITE_KEYWORDS'           => '网站SEO关键字',
			'SITE_DESCRIPTION'        => '网站SEO描述信息',
			'SITE_WATERMARK'          => '水印功能',
			'SITE_WATERMARK_ALPHA'    => '图片水印透明度',
			'SITE_WATERMARK_TEXT'     => '文字水印',
			'SITE_WATERMARK_SIZE'     => '文字大小',
			'SITE_WATERMARK_POS'      => '水印位置',
			'SITE_THUMB_WIDTH'        => '内容缩略图默认宽度',
			'SITE_THUMB_HEIGHT'       => '内容缩略图默认高度',
			'MEMBER_MODELID'          => '默认会员模型',
			'MEMBER_REGISTER'         => '新会员注册',
			'MEMBER_STATUS'           => '新会员审核', 
			'MEMBER_REGCODE'          => '注册验证码',
			'MEMBER_LOGINCODE'        => '登录验证码',
			'DIY_URL'                 => '开启伪静态', 
			'LIST_URL'                => '栏目url',
			'LIST_PAGE_URL'           => '栏目带分页url',
			'SHOW_URL'                => '内容页url',
			'SHOW_PAGE_URL'           => '内容分页url',
			'RAND_CODE'               => '随机代码',
			'WEIXIN_MP_OPENED'        => '微信公众号开关',
			'WEIXIN_MP_URL'           => '接收来自微信服务器的请求,必须以http://或https://开头',
			'WEIXIN_MP_TOKEN'         => '微信服务器的验证token,必须为英文或数字，长度为3-32字符',
			'WEIXIN_MP_AESKEY'        => 'EncodingAESKey,消息加密密钥由43位字符组成'
		);
    	// 加载应用程序配置文件
		$admin = cms::load_config('admin');
	    $config = cms::load_config('config');
        if ($this->post('submit')) {
            $configdata = $this->post('data');
			$configdata['RAND_CODE']= md5(microtime());
            $postadmin = $this->post('admin');
			if(empty($postadmin['ADMIN_PASS']) ) {
				$postadmin['ADMIN_PASS'] =$admin['ADMIN_PASS'];
			} else {
				$postadmin['ADMIN_PASS'] = md5(md5($postadmin['ADMIN_PASS']));
			}
			$admin_content = "<?php" . PHP_EOL . "if (!defined('IN_CMS')) exit();" . PHP_EOL . "return array(" . PHP_EOL;
			$adminsystem     = array();
            foreach ($postadmin as $var=>$val) {
			    if (!in_array($var, $adminsystem)) {
                    $value    = $val == 'false' || $val == 'true' ? $val : "'" . $val . "'";
                    $admin_content .= "	'" . strtoupper($var) . "'" . $this->setspace($var) . " => " . $value . ", " . PHP_EOL;
				}
            }
            $admin_content .= PHP_EOL . ");";

            $content  = "<?php" . PHP_EOL . "if (!defined('IN_CMS')) exit();" . PHP_EOL . "return array(" . PHP_EOL ;
			$system   = array();

            $content .= PHP_EOL . "	/* 网站相关配置 */" . PHP_EOL;
            foreach ($configdata as $var=>$val) {
			    if (!in_array($var, $system)) {
                    $value    = $val == 'false' || $val == 'true' ? $val : "'" . $val . "'";
                    $content .= "	'" . strtoupper($var) . "'" . $this->setspace($var) . " => " . $value . ",  // " . $string[$var] . PHP_EOL;
				}
            }
            $content .= PHP_EOL . ");";
            file_put_contents(DATA_PATH . 'config' . DS . 'admin.ini.php', $admin_content);
            file_put_contents(DATA_PATH . 'config' . DS . 'config.ini.php', $content);
            $this->show_message('修改成功', 1, url('admin/index/config', array('type'=>$this->get('type'))));
		}

        $file_list		= cms::load_class('file_list');
        $arr			= $file_list->get_file_list(THEME_PATH);
        $arr_mobile		= $file_list->get_file_list(THEME_PATH_MOBILE);
		$theme			= array_diff($arr, array('index.html'));
		$theme_mobile	= array_diff($arr_mobile, array('index.html'));

		$config['ADMIN_PASS'] = '';
        $data  = $config;
	    $type  = $this->get('type') ? $this->get('type') : 1;

		// 会员模型
		$membermodel = $this->membermodel;
        include $this->admin_tpl('config');
	}

	/**
	 * 全站缓存
	 */
	public function cacheAction() {
	    $caches = array(
	        0 => array('模型缓存更新成功..........', 'model', 'cache'),
	        1 => array('栏目缓存更新成功..........', 'category', 'cache'),
	        2 => array('自定义块缓存更新成功..........', 'block', 'cache'),
	        3 => array('模板缓存更新成功..........', 'template', 'cache'),
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
	    $appa = $this->get('ca') ? $this->get('ca') : 'cache';
	    $appc = $this->get('cc');
		$appc = ucfirst($appc) . 'Controller';
		$appa = $appa . 'Action';
		$file = CONTROLLER_PATH . 'admin' . DS . $appc . '.php';
		if (!file_exists($file)) return false;
		cms::load_file($file);
		$app  = new $appc();
		if (method_exists($appc, $appa)) $app->$appa(1);
	}
	
	/**
	 * 空格填补
	 */
	private function setspace($var) {
	    $len = strlen($var) + 2;
	    $cha = 25 - $len;
	    $str = '';
	    for ($i = 0; $i < $cha; $i ++) $str .= ' ';
	    return $str;
	}

}