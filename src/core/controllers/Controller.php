<?php

/**
 * 控制器基类
 */

if (!defined('IN_CRONLITE')) {
    exit();
}

abstract class Controller
{

    protected $cache;
    protected $session;
    protected $cookie;
    protected $site_config;

    protected $account;
    protected $member;
    protected $memberinfo;
    protected $membermodel;

    protected $category;
    protected $content;
    protected $category_cache;
    protected $category_dir_cache;

    protected $view;
    protected $_options = array();

    protected $plugin;
    protected $plugin_cache;

    /**
     * 用于初始化本类的运行环境,或对基本变量进行赋值
     */
    public function __construct()
    {
        if (!file_exists(DATA_PATH . DS .'installed')) {
            $this->redirect(url('install/index'));
        }
        if (get_magic_quotes_runtime()) {
            set_magic_quotes_runtime(0);
        }
        if (get_magic_quotes_gpc()) {
            !isset($_COOKIE) or $_COOKIE = $this->strip_slashes($_COOKIE);
        } else {
            !isset($_POST) or $_POST = $this->add_slashes($_POST);
            !isset($_GET) or $_GET = $this->add_slashes($_GET);
            !isset($_SESSION) or $_SESSION = $this->add_slashes($_SESSION);
        }

        $this->site_config = core::get_site_config();
        $this->view = core::load_class('view');
        $this->cookie = core::load_class('cookie');
        $this->session = core::load_class('session');
        $this->category = core::load_model('category');
        $this->content = core::load_model('content');
        $this->account = core::load_model('account');
        $this->plugin = core::load_model('plugin');
        $this->category_cache = get_cache('category');
        $this->category_dir_cache = get_cache('category_dir');
        $this->account_cache = get_cache('account');
        $this->plugin_cache = get_cache('plugin');

        if ($this->plugin_cache && is_array($this->plugin_cache)) {
            foreach ($this->plugin_cache as $i) {
                $p = $i['plugin'] . DS . $i['plugin'] . '.php';
                if (true === checkPlugin($p) && (bool) ($i['status']) === true) {
                    core::load_file(PLUGIN_PATH . $p);
                }
            }
        }

        // $userid = session::get('user_id');
        // if ($account_cache) {
        //     $this->account = $account_cache[$userid];
        // } else {
        //     $this->account = $db->account->findAll();
        // }

        // 载入用户系统缓存
        $this->member = core::load_model('member');
        $this->membermodel = get_cache('membermodel');
        $this->memberinfo = $this->getMember();

        $this->view->assign(array(
            'site_generator' => APP_NAME,
            'site_url' => HTTP_URL,
            'site_name' => $this->site_config['SITE_NAME'],
            'site_slogan' => $this->site_config['SITE_SLOGAN'],
            'icp_filing_number' => $this->site_config['ICP_FILING_NUMBER'],
            'site_template' => HTTP_URL . '/' . THEME_DIR . '/' . SITE_THEME . '/',
            'cats' => $this->category_cache,
            'member_model' => $this->membermodel,
            'member' => $this->memberinfo,
            'member_type' => $this->memberinfo['member_type'],
            'app_execution_time' => appExecutionTime(),
        ));
    }

    /**
     * 获取并分析$_GET数组某参数值
     * @param string $key 参数
     * @param string $value 默认值
     * @return NULL|string|int
     */
    public static function get($key, $value = NULL)
    {
        $name = isset($_GET[$key]) ? $_GET[$key] : $value;
        if (!is_array($name)) {
            return htmlspecialchars(trim($name));
        }
        return NULL;
    }

    /**
     * 获取并分析$_POST数组某参数值
     */
    public static function post($string = NULL, $a = 0)
    {
        $name = $a ? $string : (isset($_POST[$string]) ? $_POST[$string] : NULL);
        if (is_null($name)) {
            $name = $_POST;
        }

        if (!is_array($name)) {
            return htmlspecialchars(trim($name));
        }
        foreach ($name as $key => $value) {
            $post_array[$key] = self::post($value, 1);
        }
        return $post_array;
    }

    /**
     * 是否表单POST提交
     */
    public static function isPostForm($var = 'submit', $emp = 0)
    {
        if ($emp) {
            if (!isset($_POST[$var]) && empty($_POST[$var])) {
                return false;
            }
        } else {
            if (!isset($_POST[$var])) {
                return false;
            }
        }
        return true;
    }

    /**
     * 是否已登陆
     */
    protected function is_logged()
    {
        if ($this->memberinfo && isset($this->memberinfo['id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否系统管理身份
     */
    public function is_admin()
    {
        return self::is_logged() && isset($this->memberinfo['member_type']) && $this->memberinfo['member_type'] == 'member_admin';
    }

    /**
     * 获取当前运行程序的网址域名
     */
    public static function get_server_name()
    {
        $server_name = strtolower($_SERVER['SERVER_NAME']);
        $server_port = ($_SERVER['SERVER_PORT'] == '80') ? '' : ':' . (int) $_SERVER['SERVER_PORT'];
        $secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
        return ($secure ? 'https://' : 'http://') . $server_name . $server_port;
    }

    /**
     * 获取当前项目的根目录的URL
     */
    public static function get_base_url()
    {
        $url = str_replace(array('\\', '//'), '/', dirname($_SERVER['SCRIPT_NAME']));
        return (substr($url, -1) == '/') ? $url : $url . '/'; //URL以反斜杠("/")结尾
    }

    /**
     * 网址(URL)跳转操作
     *
     * 页面跳转方法，例:运行页面跳转到自定义的网址(即:URL重定向)
     * @access public
     * @param string $url 所要跳转的URL
     * @return void
     */
    public static function redirect($url)
    {
        // 参数分析
        if (!$url) {
            return false;
        }

        if (!headers_sent()) {
            header("Location:" . $url);
        } else {
            echo '<script type="text/javascript">location.href="' . $url . '";</script>';
        }
        exit();
    }

    /**
     * 公共页面，提示信息页面跳转
     * msg    消息内容
     * status 返回结果状态  1=成功 2=错误 默认错误
     * url    返回跳转地址 默认为来源
     * time   等待时间 ，默认为2秒
     */
    public function show_message($msg, $status = 2, $url = HTTP_REFERER, $time = 2000)
    {

        include $this->views('public/msg');
        exit;
    }

    /**
     * stripslashes
     */
    protected static function strip_slashes($string)
    {
        if (!$string) {
            return false;
        }

        if (!is_array($string)) {
            return stripslashes($string);
        }

        foreach ($string as $key => $value) {
            $string[$key] = self::strip_slashes($value);
        }
        return $string;
    }

    /**
     * addslashes
     */
    protected static function add_slashes($string)
    {
        if (!$string && is_null($string)) {
            return false;
        }

        if (!is_array($string)) {
            return addslashes($string);
        }

        foreach ($string as $key => $value) {
            $string[$key] = self::add_slashes($value);
        }
        return $string;
    }

    /**
     * 获取用户信息
     */
    protected function getMember()
    {
        if ($this->cookie->get('member_id') && $this->cookie->get('member_code')) {
            $uid = (int) $this->cookie->get('member_id');
            $code = $this->cookie->get('member_code');
            if (!empty($uid) && $code == substr(md5($this->site_config['RAND_CODE'] . $uid), 5, 20)) {
                $_memberinfo = $this->member->find($uid);
                $member_table = $this->membermodel[$_memberinfo['modelid']]['tablename'];
                if ($_memberinfo && $member_table) {
                    $_memberinfo['member_type'] = $member_table;
                    $_member = core::load_model($member_table);
                    $memberdata = $_member->find($uid);
                    if ($memberdata) {
                        $_memberinfo = array_merge($_memberinfo, $memberdata);
                    }
                    return $_memberinfo;
                }
            }
        }
        return false;
    }

    /**
     * 加载自定义字段
     * fields 字段数组
     * data   字段默认值
     * auth   字段权限（是否必填）
     */
    protected function getFields($fields, $data = array())
    {
        core::load_file(CORE_PATH . DS . 'library' . DS . 'fields.function.php');
        $data_fields = '';
        if (empty($fields['data'])) {
            return false;
        }

        foreach ($fields['data'] as $t) {
            if (core::get_namespace_id() != 'admin' && !$t['isshow']) {
                continue;
            }

            if (!@in_array($t['field'], $fields['merge']) && !in_array($t['formtype'], array('merge', 'fields')) && empty($t['merge'])) {
                // 单独显示的字段。
                $data_fields .= '<tr>';
                $data_fields .= isset($t['not_null']) && $t['not_null'] ? '<th><font color="red">*</font> ' . $t['name'] . '：</th>' : '<th>' . $t['name'] . '：</th>';
                $data_fields .= '<td>';
                $func = 'content_' . $t['formtype'];
                $t['setting'] = $t['setting'] ? $t['setting'] : 0;
                $content = array($data[$t['field']]);
                $content = var_export($content, true);
                if (function_exists($func)) {
                    eval("\$data_fields .= " . $func . "(" . $t['field'] . ", " . $content . ", " . $t['setting'] . ");");
                }

                $data_fields .= $t['tips'] ? '<div class="show-tips">' . $t['tips'] . '</div>' : '';
                $data_fields .= '<span id="ck_' . $t['field'] . '"></span>';
                $data_fields .= '</td>';
                $data_fields .= '</tr>';
            } elseif ($t['formtype'] == 'merge') {
                $data_fields .= '<tr>';
                $data_fields .= '<th>' . $t['name'] . '：</th>';
                $data_fields .= '<td>';
                $setting = string2array($t['setting']);
                $string = $setting['content'];
                $regex_array = $replace_array = array();
                foreach ($t['data'] as $field) {
                    $current = $fields['data'][$field];
                    $str = '';
                    $func = 'content_' . $current['formtype'];
                    $current['setting'] = $current['setting'] ? $current['setting'] : 0;
                    $content = array($data[$field]);
                    $content = var_export($content, true);
                    if (function_exists($func)) {
                        eval("\$str = " . $func . "(" . $field . ", " . $content . ", " . $current['setting'] . ");");
                    }

                    $regex_array[] = '{' . $field . '}';
                    $replace_array[] = $str;
                }
                $data_fields .= str_replace($regex_array, $replace_array, $string);
                $data_fields .= '</td>';
                $data_fields .= '</tr>';
            } elseif ($t['formtype'] == 'fields') {
                $data_fields .= '<tr>';
                $data_fields .= '<th>' . $t['name'] . '：</th><td>';
                $data_fields .= '<div class="fields-list" id="list_' . $t['field'] . '_fields"><ul id="' . $t['field'] . '-sort-items">';
                $merge_string = NULL;
                $contentdata = empty($data[$t['field']]) ? array(0 => array()) : string2array($data[$t['field']]);
                $setting = string2array($t['setting']);
                $string = $setting['content'];
                foreach ($contentdata as $i => $cdata) {
                    $data_fields .= '<li id="li_' . $t['field'] . '_' . $i . '_fields">';
                    $regex_array = $replace_array = $o_replace_array = array();
                    foreach ($fields['data'] as $field => $value) {
                        if ($value['merge'] == $t['fieldid']) {
                            $str = $o_str = '';
                            $func = 'content_' . $value['formtype'];
                            $value['setting'] = $value['setting'] ? $value['setting'] : 0;
                            $content = array($cdata[$field]);
                            $content = var_export($content, true);
                            if (function_exists($func)) {
                                eval("\$str = " . $func . "(" . $field . ", " . $content . ", " . $value['setting'] . ");");
                            }

                            if (empty($merge_string) && function_exists($func)) {
                                eval("\$o_str = " . $func . "(" . $field . ", NULL, " . $value['setting'] . ");");
                            }

                            $regex_array[] = '{' . $field . '}';
                            $replace_array[] = str_replace('data[' . $field . ']', 'data[' . $t['field'] . '][' . $i . '][' . $field . ']', $str);
                            $o_replace_array[] = str_replace('data[' . $field . ']', 'data[' . $t['field'] . '][{block_id}][' . $field . ']', $o_str);
                        }
                    }
                    if (empty($merge_string)) {
                        $merge_string = '<li id="li_' . $t['field'] . '_{block_id}_fields">' . str_replace($regex_array, $o_replace_array, $string) . '<div class="option"><a href="javascript:;" onClick="$(\'#li_' . $t['field'] . '_{block_id}_fields\').remove()">删除</a></div></li>';
                        $merge_string = str_replace(array("\r", "\n", "\t", chr(13)), array('', '', '', ''), $merge_string);
                    }
                    $data_fields .= str_replace($regex_array, $replace_array, $string);
                    $data_fields .= '<div class="option"><a href="javascript:;" onClick="$(\'#li_' . $t['field'] . '_' . $i . '_fields\').remove()">删除</a></div></li>';
                }
                $data_fields .= '</ul>
                <div class="bk10"></div>
                <div class="picBut cu"><a href="javascript:;" onClick="add_block_' . $t['field'] . '()">添加</a></div>
                <script type="text/javascript">
                function add_block_' . $t['field'] . '() {
                    var c  = \'' . addslashes($merge_string) . '\';
                    var id = parseInt(Math.random()*1000);
                    c = c.replace(/{block_id}/ig, id);
                    $("#' . $t['field'] . '-sort-items").append(c);
                }
                $("#' . $t['field'] . '-sort-items").sortable();
                </script>
                </td>';
                $data_fields .= '</tr>';
            }
        }
        return $data_fields;
    }

    /**
     * 验证自定义字段
     */
    protected function checkFields($fields, $data, $msg = 1)
    {
        if (empty($fields)) {
            return false;
        }
        foreach ($fields['data'] as $t) {
            if (core::get_namespace_id() != 'admin' && !$t['isshow']) {
                continue;
            }

            if ($t['formtype'] != 'merge' && isset($t['not_null']) && $t['not_null']) {
                if (is_null($data[$t['field']]) || $data[$t['field']] == '') {
                    $this->show_message($t['name'] . '不能为空');
                }
                if (isset($t['pattern']) && $t['pattern']) {
                    if (!preg_match($t['pattern'], $data[$t['field']])) {
                        $showmsg = isset($t['errortips']) && $t['errortips'] ? $t['errortips'] : $t['name'] . '格式不正确';
                        $this->show_message($showmsg);
                    }
                }
            }
        }
    }

    /**
     * 生成水印图片
     */
    protected function watermark($file)
    {
        if (!$this->site_config['SITE_WATERMARK']) {
            return false;
        }

        $image = core::load_class('image_lib');
        if ($this->site_config['SITE_WATERMARK'] == 1) {
            $image->set_watermark_alpha($this->site_config['SITE_WATERMARK_ALPHA']);
            $image->make_image_watermark($file, $this->site_config['SITE_WATERMARK_POS']);
        } else {
            $image->set_text_content($this->site_config['SITE_WATERMARK_TEXT']);
            $image->make_text_watermark($file, $this->site_config['SITE_WATERMARK_POS'], $this->site_config['SITE_WATERMARK_SIZE']);
        }
    }

    /**
     * 验证验证码
     */
    protected function checkCode($value)
    {
        $code = $this->session->get('checkcode');
        $value = strtolower($value);
        $this->session->delete('checkcode');
        return $code === $value;
    }

    /**
     * 模型栏目
     */
    protected function getModelCategory($modelid)
    {
        $data = array();
        foreach ($this->category_cache as $cat) {
            if ($modelid == $cat['modelid'] && $cat['typeid'] == 1 && $cat['child'] == 0) {
                $data[$cat['catid']] = $cat;
            }
        }
        return $data;
    }

    /**
     * 模型的关联表单
     */
    protected function getModelJoin($modelid)
    {
        if (empty($modelid)) {
            return NULL;
        }

        $data = get_cache('formmodel');
        $return = NULL;
        if ($data) {
            foreach ($data as $t) {
                if ($t['joinid'] == $modelid) {
                    $return[] = $t;
                }
            }
        }
        return $return;
    }

    /**
     * 可在用户中心显示的表单
     */
    protected function getFormMember()
    {
        $data = get_cache('formmodel');
        $join = get_cache('joinmodel');
        $return = NULL;
        if ($data) {
            foreach ($data as $id => $t) {
                if (isset($t['setting']['form']['member']) && $t['setting']['form']['member']) {
                    $t['joinname'] = isset($join[$t['joinid']]['modelname']) && $join[$t['joinid']]['modelname'] ? $join[$t['joinid']]['modelname'] : '';
                    $return[$id] = $t;
                }
            }
        }
        return $return;
    }

    /**
     * 格式化字段数据
     */
    protected function getFieldData($model, $data)
    {
        if (!isset($model['fields']['data']) || empty($model['fields']['data']) || empty($data)) {
            return $data;
        }

        foreach ($model['fields']['data'] as $t) {
            if (!isset($data[$t['field']])) {
                continue;
            }

            if ($t['formtype'] == 'editor') {
                // 把编辑器中的HTML实体转换为字符
                $data[$t['field']] = htmlspecialchars_decode($data[$t['field']]);
            } elseif (in_array($t['formtype'], array('checkbox', 'files', 'fields'))) {
                // 转换数组格式
                $data[$t['field']] = string2array($data[$t['field']]);
            }
        }
        return $data;
    }

    /** 加载视图模板文件，系统内置默认模板
     * @param string $file 文件名 如 admin/login、install/footer
     */
    protected function views($file)
    {
        return VIEW_PATH . $file . '.tpl.php';
    }
}
