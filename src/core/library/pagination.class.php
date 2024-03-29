<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * pagination class file
 * 分页类
 */
class pagination
{

    /**
     * 样式配置文件.
     *
     * @var Array
     */
    public $config;

    /**
     * pagelist的css文件.
     *
     * @var string
     */
    private $style;

    /**
     * 连接网址
     *
     * @var string
     */
    public $url;

    /**
     * 当前页
     *
     * @var integer
     */
    public $page;

    /**
     * list总数
     *
     * @var integer
     */
    public $total;

    /**
     * 分页总数
     *
     * @var integer
     */
    public $total_pages;

    /**
     * 每个页面显示的post数目
     *
     * @var integer
     */
    public $num;

    /**
     * list允许放页码数量,如:1.2.3.4就这4个数字,则$per_circle为4
     *
     * @var integer
     */
    public $per_circle;

    /**
     * 分页程序的扩展功能开关,默认关闭
     *
     * @var boolean
     */
    public $ext;

    /**
     * list中的坐标. 如:7,8,九,10,11这里的九为当前页,在list中排第三位,则$center为3
     *
     * @var integer
     */
    public $center;

    /**
     * 第一页
     *
     * @var string
     */
    public $first_page;

    /**
     * 上一页
     *
     * @var string
     */
    public $pre_page;

    /**
     * 下一页
     *
     * @var string
     */
    public $next_page;

    /**
     * 最后一页
     *
     * @var string
     */
    public $last_page;

    /**
     * 分页附属说明
     *
     * @var string
     */
    public $note;

    /**
     * 是否为ajax分页模式
     *
     * @var boolean
     */
    public $isAjax;

    /**
     * ajax分页的动作名称
     *
     * @var string
     */
    public $ajax_action_name;

    /**
     * 分页css名
     *
     * @var string
     */
    public $style_file;

    /**
     * 分页隐藏开关
     *
     * @var boolean
     */
    public $hidden_status;

    /**
     * 构造函数
     *
     * @access public
     * @return boolean
     */
    public function __construct()
    {
        $this->ext = true;
        $this->center = 4;
        $this->num = 7;
        $this->per_circle = 7;
        $this->isAjax = false;
        $this->hidden_status = false;
        return true;
    }

    /**
     * 显示样式结构
     * @param array $config
     * $div 结构 (<ul class="pagination">{content}</ul>)
     * $total 数量 (<a>{content}</a>)
     * $nowpage 当前页 (<span>{content}</span>)
     * $page 普通页 (<a href="{url}">{content}</a>)
     * $pre 上一页 (<a href="{url}">{content}</a>)
     * $next 下一页 (<a href="{url}">{content}</a>)
     */
    public function loadconfig($config = array())
    {
        if (empty($config)) {
            $config = array(
                'div'      => '<ul class="pagination">{content}</ul>',
                'total'    => '<a>{content}</a>',
                'nowpage'  => '<li class="active"><span>{content}</span></li>',
                'page'     => '<li><a href="{url}">{content}</a></li>',
                'pre'      => '<li><a href="{url}">{content}</a></li>',
                'next'     => '<li><a href="{url}">{content}</a></li>',
                'disabled' => '<li class="disabled"><span>{content}</span></li>',
                'note'     => '<li><span>{content}</span><li>',
            );
        }
        $this->first_page = $this->first_page ? $this->first_page : '首页';
        $this->pre_page = $this->pre_page ? $this->pre_page : '上一页';
        $this->next_page = $this->next_page ? $this->next_page : '下一页';
        $this->last_page = $this->last_page ? $this->last_page : '末页';
        $this->note = $this->note ? $this->note : '共 {$total_num} 条 {$total_page} 页 {$num} 条/页'; // 共{$total_num}条{$total_page}页 {$num}条/页
        $this->config = $config;
    }

    private function preg_c($content, $url = '', $config)
    {
        return str_replace('{content}', $content, str_replace('{url}', $url, $config));
    }

    /**
     * 获取总页数
     *
     * @return integer
     */
    private function get_total_page()
    {
        if (!$this->total || !$this->num) {
            return false;
        }

        return ceil($this->total / $this->num);
    }

    /**
     * 获取当前页数
     *
     * @return integer
     */
    private function get_page_num()
    {
        $page = (!$this->page) ? 1 : (int) $this->page;
        // 当URL中?page=5的page参数大于总页数时
        return ($page > $this->total_pages) ? (int) $this->total_pages : $page;
    }

    /**
     * 返回$this->num=$num.
     *
     * @param integer $num
     * @return $this
     */
    public function num($num = null)
    {
        // 参数分析
        if (is_null($num)) {
            $num = 10;
        }

        $this->num = (int) $num;
        return $this;
    }

    /**
     * 返回$this->total=$total_post.
     *
     * @param integer $total_post
     * @return $this
     */
    public function total($total_post = null)
    {
        $this->total = (!is_null($total_post)) ? (int) $total_post : 0;
        return $this;
    }

    /**
     * 开启分页的隐藏功能
     *
     * @access public
     * @param boolean $item 隐藏开关 , 默认为true.
     * @return $this
     */
    public function hide($item = true)
    {
        if ($item === true) {
            $this->hidden_status = true;
        }

        return $this;
    }

    protected function seturl($url, $page)
    {
        return str_replace('{page}', $page, $url);
    }

    /**
     * 返回$this->url=$url.
     *
     * @param string $url
     * @return $this
     */
    public function url($url = null)
    {
        // 当url为空时,自动获取url参数. 注:默认当前页的参数为page
        if (is_null($url)) {
            // 当网址没有参数时
            $url = (!$_SERVER['QUERY_STRING']) ? $_SERVER['REQUEST_URI'] . ((substr($_SERVER['REQUEST_URI'], -1) == '?') ? 'page=' : '?page=') : '';
            // 当网址有参数时,且有分页参数(page)时
            if (!$url && (stristr($_SERVER['QUERY_STRING'], 'page='))) {
                $url = str_ireplace('page=' . $this->page, '', $_SERVER['REQUEST_URI']);
                $end_str = substr($url, -1);
                if ($end_str == '?' || $end_str == '&') {
                    $url .= 'page=';
                } else {
                    $url .= '&page=';
                }
            }
            // 当网址中未发现含有分页参数(page)时
            if (!$url) {
                $url = $_SERVER['REQUEST_URI'] . '&page=';
            }
        }
        // 自动获取都没获取到url...额..没有办法啦, 趁早返回false
        if (!$url) {
            return false;
        }

        $this->url = trim($url);
        return $this;
    }

    /**
     * 返回$this->page=$page.
     *
     * @param integer $page
     * @return $this
     */
    public function page($page = null)
    {
        // 当参数为空时.自动获取GET['page']
        if (is_null($page)) {
            $page = (int) Controller::get('page');
            $page = (!$page) ? 1 : $page;
        }
        if (!$page) {
            return false;
        }

        $this->page = $page;
        return $this;
    }

    /**
     * 返回$this->ext=$ext.
     *
     * @param boolean $ext
     * @return $this
     */
    public function ext($ext = true)
    {
        // 将$ext转化为小写字母.
        $this->ext = ($ext) ? true : false;
        return $this;
    }

    /**
     * 返回$this->center=$num.
     *
     * @param integer $num
     * @return $this
     */
    public function center($num)
    {
        if (!$num) {
            return false;
        }

        $this->center = (int) $num;
        return $this;
    }

    /**
     * 返回$this->per_circle=$num.
     *
     * @param integer $num
     * @return $this
     */
    public function circle($num)
    {
        if (!$num) {
            return false;
        }

        $this->per_circle = (int) $num;
        return $this;
    }

    /**
     * 处理第一页, 上一页
     *
     * @return string
     */
    private function get_first_page()
    {
        if ($this->page == 1 || $this->total_pages <= 1) {
            return $this->preg_c($this->first_page, null, $this->config['disabled']) . $this->preg_c($this->pre_page, null, $this->config['disabled']);
        }

        return $this->preg_c($this->first_page, $this->seturl($this->url, 1), $this->config['pre']) . $this->preg_c($this->pre_page, $this->seturl($this->url, $this->page - 1), $this->config['pre']);
    }

    /**
     * 处理下一页, 最后一页
     *
     * @return string
     */
    private function get_last_page()
    {
        if ($this->page == $this->total_pages || $this->total_pages <= 1) {
            return $this->preg_c($this->next_page, null, $this->config['disabled']) . $this->preg_c($this->last_page, null, $this->config['disabled']);
        }

        return $this->preg_c($this->next_page, $this->seturl($this->url, $this->page + 1), $this->config['next']) . $this->preg_c($this->last_page, $this->seturl($this->url, $this->total_pages), $this->config['next']);
    }

    /**
     * 处理注释内容
     *
     * @return string
     */
    private function get_note()
    {
        if (!$this->ext || !$this->note) {
            return false;
        }

        $note = str_replace(array('{$total_num}', '{$total_page}', '{$num}'), array($this->total, $this->total_pages, $this->num), $this->note);
        return $this->preg_c($note, null, $this->config['note']);
    }

    /**
     * 处理list内容
     *
     * @return string
     */
    private function get_list()
    {
        if (empty($this->total_pages) || empty($this->page)) {
            return false;
        }

        if ($this->total_pages > $this->per_circle) {
            if ($this->page + $this->per_circle >= $this->total_pages + $this->center) {
                $list_start = $this->total_pages - $this->per_circle + 1;
                $list_end = $this->total_pages;
            } else {
                $list_start = ($this->page > $this->center) ? $this->page - $this->center + 1 : 1;
                $list_end = ($this->page > $this->center) ? $this->page + $this->per_circle - $this->center : $this->per_circle;
            }
        } else {
            $list_start = 1;
            $list_end = $this->total_pages;
        }
        $pagelist_queue = '';
        for ($i = $list_start; $i <= $list_end; $i++) {
            $pagelist_queue .= ($this->page == $i) ? $this->preg_c($i, null, $this->config['nowpage']) : $this->preg_c($i, $this->seturl($this->url, $i), $this->config['page']);
        }
        return $pagelist_queue;
    }

    /**
     * 输出处理完毕的HTML
     *
     * @return string
     */
    public function output()
    {
        // 支持长的url.
        $this->url = trim(str_replace(array("\n", "\r"), '', $this->url));
        // 获取总页数.
        $this->total_pages = $this->get_total_page();
        // 获取当前页.
        $this->page = $this->get_page_num();
        return ($this->total <= $this->num) ? '' : $this->preg_c($this->get_note() . $this->get_first_page() . $this->get_list() . $this->get_last_page(), '', $this->config['div']);
    }

    /**
     * 析构函数
     *
     * @access public
     * @return void
     */
    public function __destruct()
    { }
}
