<?php
if (!defined('IN_CMS')) {
    exit();
}

/**
 * 模板解析类
 */
class view
{

    protected static $_instance;
    public $view_dir;
    public $compile_dir;
    public $_options = array();
    public $theme;
    public $viewpath;

    public function __construct()
    {
        $this->view_dir = THEME_CURRENT;
        $this->viewpath = basename(THEME_CURRENT) . DS;
        $this->_options['viewpath'] = $this->viewpath;
        // 编译主题模板生成的文件路径
        $this->compile_dir = DATA_PATH . 'cache' . DS . THEME_TYPE . DS;
    }

    /**
     * 获取视图文件的路径
     */
    protected function get_view_file($file_name)
    {
        return $this->view_dir . $file_name;
    }

    /**
     * 获取视图编译文件的路径
     */
    protected function get_compile_file($file_name)
    {
        return $this->compile_dir . $file_name . '.cache.php';
    }

    /**
     * 生成视图编译文件
     */
    protected function create_compile_file($compile_file, $content)
    {
        $compile_dir = dirname($compile_file);
        if (!is_dir($compile_dir)) {
            @mkdir($compile_dir, 0777) or exit($compile_dir . '目录没有写入权限');
        } else if (!is_writable($compile_dir)) {
            @chmod($compile_dir, 0777) or exit($compile_dir . '目录没有写入权限');
        }
        file_put_contents($compile_file, $content, LOCK_EX) or exit($compile_dir . '目录没有写入权限');
    }

    /**
     * 缓存重写分析
     */
    protected function is_compile($view_file, $compile_file)
    {
        return (is_file($compile_file) && is_file($view_file) && (filemtime($compile_file) >= filemtime($view_file))) ? false : true;
    }

    /**
     * 设置视图变量
     */
    public function assign($key, $value = null)
    {
        if (!$key) {
            return false;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->_options[$k] = $v;
            }
        } else {
            $this->_options[$key] = $value;
        }
        return true;
    }

    /**
     * 分析视图文件名
     */
    protected function parse_file_name($file_name = null)
    {
        return THEME_DIR . DS . $file_name;
    }

    /**
     * 加载视图文件
     */
    protected function load_view_file($view_file)
    {
        if (!is_file($view_file)) {
            exit('模板文件不存在' . ': ' . $view_file);
        }

        $view_content = file_get_contents($view_file);
        return $this->handle_view_file($view_content);
    }

    /**
     * 编译视图标签
     */
    protected function handle_view_file($view_content)
    {
        if (!$view_content) {
            return false;
        }

        // 正则表达式匹配的模板标签
        $regex_array = array(
            '#{template\s+(.+?)\s*}#is',
            '#{block\s+([0-9]+)}#i',

            '#{nav\s+(.+?)\s?}#i',
            '#{\/nav}#i',

            '#{list\s+(.+?)return=(.+?)\s?}#i',
            '#{list\s+(.+?)\s?}#i',
            '#{\/list}#i',

            '#{loop\s+\$(.+?)\s+\$(\w+?)\s?}#i',
            '#{loop\s+\$(.+?)\s+\$(\w+?)\s?=>\s?\$(\w+?)\s?}#i',
            '#{\/loop}#i',

            '#{if\s+(.+?)\s?}#i',
            '#{else\sif\s+(.+?)\s?}#i',
            '#{else}#i',
            '#{\/if}#i',

            '#{function.([a-z_0-9]+)\((.*)\)}#Ui',
            '#{\$(.+?)}#i',
            '#{php\s+(.+?)}#is',

            '#\?\>\s*\<\?php\s#s',
        );

        // 替换直接变量输出
        $replace_array = array(
            "<?php include \$this->_include('\\1'); echo PHP_EOL; ?>",
            "<?php \$this->block(\\1);?>",

            "<?php \$return = \$this->_category(\"\\1\");  if (is_array(\$return)) { foreach (\$return as \$key=>\$vdata) { \$arrchilds = @explode(',', \$vdata['arrchilds']);    \$current = in_array(\$catid, \$arrchilds);?>",
            "<?php } } ?>",

            "<?php \$return_\\2 = \$this->_listdata(\"\\1 return=\\2\"); extract(\$return_\\2); if (is_array(\$return_\\2)) { foreach (\$return_\\2 as \$key_\\2=>\$\\2) { ?>",
            "<?php \$return = \$this->_listdata(\"\\1\"); extract(\$return); if (is_array(\$return)) { foreach (\$return as \$key=>\$vdata) { ?>",
            "<?php } } ?>",

            "<?php if (is_array(\$\\1)) { foreach (\$\\1 as \$\\2) { ?>",
            "<?php if (is_array(\$\\1)) { foreach (\$\\1 as \$\\2=>\$\\3) { ?>",
            "<?php } } ?>",

            "<?php if (\\1) { ?>",
            "<?php } else if (\\1) { ?>",
            "<?php } else { ?>",
            "<?php } ?>",

            "<?php echo \\1(\\2); ?>",
            "<?php echo \$\\1; ?>",
            "<?php \\1 ?>",

            " ",
        );
        return preg_replace($regex_array, $replace_array, $view_content);
    }

    /**
     * 解析分类标签
     */
    protected function _category($param)
    {
        $_param = explode(' ', $param);
        $param = array();
        foreach ($_param as $p) {
            $mark = strpos($p, '=');
            if ($p && $mark !== false) {
                $var = substr($p, 0, $mark);
                $val = substr($p, $mark + 1);
                if (isset($var) && $var) {
                    $param[$var] = $val;
                }
            }
        }
        $system = array();
        if (is_array($param)) {
            foreach ($param as $key => $val) {
                if (in_array($key, array('catid', 'typeid', 'modelid', 'parentid', 'num', 'ismenu'))) {
                    $system[$key] = $val;
                }
            }
        }
        $parentid = $system['parentid'] ? $system['parentid'] : 0;
        $cats = get_cache('category');
        $i = 1;
        foreach ($cats as $catid => $cat) {
            if ($system['num']) {
                if ($i > $system['num']) {
                    break;
                }
            }

            if (!$system['ismenu']) {
                if (!$cat['ismenu']) {
                    continue;
                }
            }

            if ($system['typeid']) {
                if ($cat['typeid'] != $system['typeid']) {
                    continue;
                }
            }

            if ($system['modelid']) {
                if ($cat['modelid'] != $system['modelid']) {
                    continue;
                }
            }

            if ($system['catid']) {
                $catids = explode(',', $system['catid']);
                if (!in_array($cat['catid'], $catids)) {
                    continue;
                }
            } else
            if ($cat['parentid'] != $parentid) {
                continue;
            }

            $data[$catid] = $cat;
            $i++;
        }
        unset($_param, $param, $system, $p, $cats, $catids);
        return $data;
    }

    /**
     * 解析list标签
     */
    protected function _listdata($param)
    {
        $_param = explode(' ', $param);
        $param = array();
        foreach ($_param as $p) {
            $mark = strpos($p, '=');
            if ($p && $mark !== false) {
                $var = substr($p, 0, $mark);
                $val = substr($p, $mark + 1);
                if (isset($var) && $var) {
                    $param[$var] = $val;
                }
            }
        }
        $system = $fields = $_fields = array();
        if (is_array($param)) {
            foreach ($param as $key => $val) {
                if (in_array($key, array('table', 'optional', 'cache', 'page', 'urlrule', 'num', 'order', 'pagesize', 'return'))) {
                    $system[$key] = $val;
                } else {
                    $fields[$key] = $val;
                    $_fields[] = $key;
                }
            }
        }
        $dbcache = isset($system['cache']) ? (int) $system['cache'] : 0;
        $where = '';
        $table = isset($system['table']) && $system['table'] ? $system['table'] : 'content';
        $db = core::load_model($table);
        $table = $db->prefix . $table;
        $table_data = $table_fields = $table_data_fields = $arrchilds = null;
        $_table_fields = $db->get_table_fields();
        $table_fields = array_intersect($_fields, $_table_fields);
        if (isset($fields['catid']) && $fields['catid']) {
            $cats = get_cache('category');
            $cat = $cats[$fields['catid']];
        }
        if (isset($system['optional']) && $system['optional']) {
            // show optional fields
            $model = null;
            if ($table == $db->prefix . 'content') {
                $models = get_cache('model');
                if (isset($fields['catid']) && $fields['catid'] && isset($cat) && $cat) {
                    $model = $models[$cat['modelid']];
                } elseif (isset($fields['modelid']) && $fields['modelid']) {
                    $model = $models[$fields['modelid']];
                }
            } elseif ($table == $db->prefix . 'member' && isset($fields['modelid']) && $fields['modelid']) {
                $models = get_cache('membermodel');
                $model = $models[$fields['modelid']];
            }
            if ($model) {
                $table_data = $model['tablename'];
                $db_data = core::load_model($table_data);
                $_table_data_fields = $db_data->get_table_fields();
                $table_data_fields = array_intersect($_fields, $_table_data_fields);
                foreach ($table_data_fields as $k => $c) {
                    if (in_array($c, $table_fields)) {
                        unset($table_data_fields[$k]);
                    }
                }
                $table_data = $db->prefix . $table_data;
            }
        }
        // WHERE整合
        $fieldsAll = array($table => $table_fields, $table_data => $table_data_fields);
        foreach ($fieldsAll as $_table => $t) {
            if (is_array($t)) {
                foreach ($t as $f) {
                    if ($fields[$f] == '') {
                        continue;
                    }
                    if ($f == 'catid' && isset($fields['catid']) && $fields['catid']) {
                        if (isset($cat) && $cat && $cat['child']) {
                            $arrchilds = $cat['arrchilds'];
                            $where .= ' AND `' . $_table . '`.`catid` IN (' . $arrchilds . ')';
                        } elseif (strpos($fields['catid'], ',') !== false) {
                            $where .= ' AND `' . $_table . '`.`catid` IN (' . $fields['catid'] . ')';
                        } else {
                            $where .= ' AND `' . $_table . '`.`catid`=' . $fields['catid'];
                        }
                    } elseif ($f == 'thumb' && isset($fields['thumb']) && is_numeric($fields['thumb'])) {
                        $where .= $fields['thumb'] ? ' AND `' . $_table . '`.`thumb`<>""' : '';
                    } else {
                        $value = is_numeric($fields[$f]) ? $fields[$f] : '"' . addslashes($fields[$f]) . '"';
                        $where .= ' AND `' . $_table . '`.`' . $f . '`=' . $value . '';
                    }
                }
            }
        }
        if ($table == $db->prefix . 'content' && !isset($fields['status'])) {
            $where .= ' AND `' . $db->prefix . 'content`.`status`!=0';
        }
        if ($where) {
            if (substr($where, 0, 4) == ' AND') {
                $where = ' WHERE' . substr($where, 4);
            } else {
                $where = ' WHERE' . $where;
            }
        }

        // FROM整合
        $from = 'FROM ' . $table;
        if ($table_data) {
            $from .= ' LEFT JOIN ' . $table_data . ' ON `' . $table . '`.`' . $db->get_primary_key() . '`=`' . $table_data . '`.`' . $db_data->get_primary_key() . '`';
        }
        // ORDER排序
        $order = '';
        if ($system['order']) {
            if (strtoupper($system['order']) == 'RAND()') {
                $order .= ' ORDER BY RAND()';
            } else {
                $orders = explode(',', $system['order']);
                foreach ($orders as $t) {
                    list($_field, $_order) = explode('_', $t);
                    $_name = null;
                    if (in_array($_field, $_table_fields)) {
                        $_name = $table;
                    } elseif (isset($_table_data_fields) && in_array($_field, $_table_data_fields)) {
                        $_name = $table_data;
                    }
                    $_orderby = isset($_order) && strtoupper($_order) == 'ASC' ? 'ASC' : 'DESC';
                    if ($_name) {
                        $order .= ' `' . $_name . '`.`' . $_field . '` ' . $_orderby . ',';
                    }
                }
                if (substr($order, -1) == ',') {
                    $order = ' ORDER BY' . substr($order, 0, -1);
                }
            }
        } elseif ($table == $db->prefix . 'content') {
            $order = ' ORDER BY time DESC';
        }
        // limit与分页
        $limit = '';
        if ($system['num']) {
            $limit = ' LIMIT ' . $system['num'];
        } elseif (isset($system['page'])) {
            $pageurl = '';
            $system['page'] = (int) $system['page'] ? (int) $system['page'] : 1;
            if ($system['urlrule']) {
                $pageurl = str_replace(array('_page_', '[page]'), '{page}', $system['urlrule']);
                $pagesize = $system['pagesize'] ? $system['pagesize'] : (isset($cat['pagesize']) ? $cat['pagesize'] : 10);
            } elseif ($cat) {
                $pageurl = getCaturl($cat, '{page}');
                $pagesize = $system['pagesize'] ? $system['pagesize'] : $cat['pagesize'];
            } else {
                $pagesize = $system['pagesize'] ? $system['pagesize'] : 10;
                $pageurl = '{page}';
            }
            $sql = 'SELECT count(*) AS total ' . $from . ' ' . $where;
            $count = $db->execute($sql, false, $dbcache);
            $total = $count['total'];
            $pagination = core::load_class('pagination');
            $pagination->loadconfig();
            $start_id = $pagesize * ($system['page'] - 1);
            $limit = ' LIMIT ' . $start_id . ',' . $pagesize;
            $pagination = $pagination->total($total)->url($pageurl)->num($pagesize)->page($system['page'])->output();
        }
        // 查询结果
        $sql = 'SELECT * ' . $from . $where . $order . $limit;
        $data = $db->execute($sql, true, $dbcache);
        // 释放变量
        unset($_param, $param, $par, $p, $fields, $_fields, $dbcache, $sql);
        unset($table, $db, $table_data, $table_fields, $table_data_fields, $arrchilds, $_table_fields);
        unset($fieldsAll, $_table_data_fields, $cache, $db_join, $cats, $cat, $models, $model, $db_data, $where, $order, $from);
        if (isset($system['return']) && $system['return'] && $system['return'] != 'xiao') {
            return array(
                'pagelist_' . $system['return'] => $pagination,
                'return_' . $system['return'] => $data,
            );
        }
        unset($system);
        return array('pagination' => $pagination, 'return' => $data);
    }

    /**
     * 区块
     */
    protected function block($id)
    {
        $data = get_cache('block');
        $row = $data[$id];
        if (empty($row)) {
            return null;
        }

        echo htmlspecialchars_decode($row['content']);
    }

    /**
     * 加载include视图
     */
    protected function _include($file_name)
    {
        if (!$file_name) {
            return false;
        }

        $file_name = $this->parse_file_name($file_name);
        $view_file = $this->get_view_file($file_name);
        $compile_file = $this->get_compile_file($file_name);
        if ($this->is_compile($view_file, $compile_file)) {
            $view_content = $this->load_view_file($view_file);
            $this->create_compile_file($compile_file, $view_content);
        }
        return $compile_file;
    }

    /**
     * 显示视图文件
     */
    public function display($file_name = null)
    {
        if (!empty($this->_options)) {
            extract($this->_options, EXTR_PREFIX_SAME, 'data');
            $this->_options = array();
        }
        $file_name = $this->parse_file_name($file_name);
        $view_file = $this->get_view_file($file_name);
        $compile_file = $this->get_compile_file($file_name);
        if ($this->is_compile($view_file, $compile_file)) {
            $view_content = $this->load_view_file($view_file);
            $this->create_compile_file($compile_file, $view_content);
        }
        include $compile_file;
    }

    /**
     * destructor
     *
     * @access public
     * @return void
     */
    public function __destruct()
    {
        $this->_options = array();
    }

    /**
     * 单件模式调用方法
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
