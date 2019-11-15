<?php

/**
 * 网站配置
 */
class ConfigController extends Admin
{
    // 配置变量说明
    private $configTips;

    public function __construct()
    {
        parent::__construct();
        $this->configTips = array(
            'SITE_THEME' => '桌面端主题样式, 默认default',
            'SITE_THEME_MOBILE' => '移动端主题样式, 默认default',
            'SITE_MOBILE' => '移动端主题样式, 默认关闭',
            'SITE_NAME' => '网站名称',
            'SITE_SLOGAN' => '网站头部标语',
            'SITE_TITLE' => '网站首页SEO标题',
            'SITE_KEYWORDS' => '网站SEO关键字',
            'SITE_DESCRIPTION' => '网站SEO描述信息',
            'SITE_WATERMARK' => '水印功能',
            'SITE_WATERMARK_ALPHA' => '图片水印透明度',
            'SITE_WATERMARK_TEXT' => '文字水印',
            'SITE_WATERMARK_SIZE' => '文字大小',
            'SITE_WATERMARK_POS' => '水印位置',
            'SITE_THUMB_WIDTH' => '内容缩略图默认宽度',
            'SITE_THUMB_HEIGHT' => '内容缩略图默认高度',
            'MEMBER_MODELID' => '默认会员模型',
            'MEMBER_REGISTER' => '新会员注册',
            'MEMBER_STATUS' => '新会员审核',
            'MEMBER_REGCODE' => '注册验证码',
            'MEMBER_LOGINCODE' => '登录验证码',
            'DIY_URL' => '开启伪静态',
            'LIST_URL' => '栏目url',
            'LIST_PAGE_URL' => '栏目带分页url',
            'SHOW_URL' => '内容页url',
            'SHOW_PAGE_URL' => '内容分页url',
            'HIDE_ENTRY_FILE' => '隐藏入口文件需要服务器配置默认文件，如index.php。当服务器配置的默认文件与程序入口文件一致时，设置才生效',
            'URL_LIST_TYPE' => '栏目参数形式，ID形式：catid=123，目录形式：catdir=catdir',
            'RAND_CODE' => '随机代码',
            'WEIXIN_MP_OPENED' => '微信公众号开关',
            'WEIXIN_MP_URL' => '接收来自微信服务器的请求,必须以http://或https://开头',
            'WEIXIN_MP_TOKEN' => '微信服务器的验证token,必须为英文或数字，长度为3-32字符',
            'WEIXIN_MP_AESKEY' => 'EncodingAESKey,消息加密密钥由43位字符组成',
            'ADMIN_LOGINCODE' => '后台登录需要输入验证码',
            'ADMIN_LOGINPATH' => '后台登录路径默认admin',
        );
    }

    /**
     * 系统基本配置
     */
    public function indexAction()
    {
        $data = $this->site_config;
        $configTips = $this->configTips;
        if ($this->isPostForm()) {
            $configdata = $this->post('data');
            $configdata['RAND_CODE'] = md5(microtime());
            $configdata['WEIXIN_MP_URL'] = HTTP_PRE . HTTP_HOST . url('api/weixin/index');
            $configdata = array_merge($data, $configdata);
            $content = "<?php" . PHP_EOL . "if (!defined('IN_CMS')) {" . PHP_EOL . "    exit();" . PHP_EOL . "}" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL;
            foreach ($configdata as $k => $v) {
                $value = $v == 'false' || $v == 'true' ? $v : "'" . $v . "'";
                $content .= "    '" . strtoupper($k) . "'" . $this->setspace($k) . " => " . $value . ", // " . $configTips[$k] . PHP_EOL;
            }
            $content .= PHP_EOL . ");";

            file_put_contents(DATA_PATH . 'config' . DS . 'config.ini.php', $content);
            $this->show_message('修改成功', 1, url('admin/config/index'));
        }
        $file_list = core::load_class('file_list');
        $arr_d = $file_list->get_file_list(THEME_PATH_D);
        $arr_m = $file_list->get_file_list(THEME_PATH_M);
        $theme = array_diff($arr_d, array('index.html'));
        $theme_mobile = array_diff($arr_m, array('index.html'));
        $membermodel = $this->membermodel; // 会员模型

        include $this->admin_view('config/index');
    }

    /**
     * 本地管理员帐号
     * 已废弃，暂不用
     */
    public function localadminAction()
    {
        // 获取管理员配置
        $admin = core::load_config('admin');
        if ($this->isPostForm()) {
            $configdata = $this->post('data');
            $configdata['RAND_CODE'] = md5(microtime());

            // 本地管理员账号
            $postadmin = $this->post('admin');
            if (empty($postadmin['ADMIN_PASS'])) {
                $postadmin['ADMIN_PASS'] = $admin['ADMIN_PASS'];
            } else {
                $postadmin['ADMIN_PASS'] = md5(md5($postadmin['ADMIN_PASS']));
            }
            $admin_content = "<?php" . PHP_EOL . "if (!defined('IN_CMS')) exit();" . PHP_EOL . "return array(" . PHP_EOL;
            $adminsystem = array();
            foreach ($postadmin as $k => $val) {
                if (!in_array($k, $adminsystem)) {
                    $value = $val == 'false' || $val == 'true' ? $val : "'" . $val . "'";
                    $admin_content .= "    '" . strtoupper($k) . "'" . $this->setspace($k) . " => " . $value . ", " . PHP_EOL;
                }
            }
            $admin_content .= PHP_EOL . ");";
            file_put_contents(DATA_PATH . 'config' . DS . 'admin.ini.php', $admin_content);
            $this->show_message('修改成功', 1, url('admin/config/admin'));
        }
        include $this->admin_view('config');
    }

    /**
     * 安全设置
     */
    public function securityAction()
    {
        // 获取当前配置信息
        $data = $this->site_config;
        $configTips = $this->configTips;
        if ($this->isPostForm()) {
            $postdata = $this->post('data');
            $postdata['RAND_CODE'] = md5(microtime());
            $postdata['ADMIN_LOGINPATH'] = $postdata['ADMIN_LOGINPATH'] ? $postdata['ADMIN_LOGINPATH'] : 'admin';
            $postdata = array_merge($data, $postdata);
            $content = "<?php" . PHP_EOL . "if (!defined('IN_CMS')) {" . PHP_EOL . "    exit();" . PHP_EOL . "}" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL;
            foreach ($postdata as $k => $v) {
                $value = $v == 'false' || $v == 'true' ? $v : "'" . $v . "'";
                $content .= "    '" . strtoupper($k) . "'" . $this->setspace($k) . " => " . $value . ", // " . $configTips[$k] . PHP_EOL;
            }
            $content .= PHP_EOL . ");";
            file_put_contents(DATA_PATH . 'config' . DS . 'config.ini.php', $content);
            $this->show_message('修改成功', 1, url('admin/config/security'));
        }

        include $this->admin_view('config/security');
    }

    /**
     * 空格填补
     */
    private function setspace($var)
    {
        $len = strlen($var) + 2;
        $cha = 25 - $len;
        $str = '';
        for ($i = 0; $i < $cha; $i++) {
            $str .= ' ';
        }

        return $str;
    }
}
