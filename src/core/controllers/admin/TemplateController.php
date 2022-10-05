<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class TemplateController extends Admin
{

    private $dir;
    private $allowed_file_suffix;

    public function __construct()
    {
        parent::__construct();
        $this->allowed_file_suffix = array('html', 'css', 'js', 'txt');
    }

    public function indexAction()
    {
        // list all template dir
        $class_file_list = core::load_class('file_list');
        $template_list = $class_file_list->get_file_list(PATH_TEMPLATE, array('.DS_Store', 'index.html'));
        $list = array();
        foreach ($template_list as $x) {
            $list[] = array(
                'template' => $x,
                'image' => HTTP_URL . "/template/$x/preview.png",
            );
        }
        unset($class_file_list, $template_list);
        include $this->views('admin/template/list');
    }

    public function itemAction()
    {
        $class_file_list = core::load_class('file_list');
        $template_list = $class_file_list->get_file_list(PATH_TEMPLATE, array('.DS_Store', 'index.html'));
        unset($class_file_list);
        $template = $this->get('template') ? urldecode($this->get('template')) : 'default';
        if (!empty($template)) {
            if (!in_array($template, $template_list)) {
                $template = SITE_THEME;
            }
        }

        $template_path = PATH_TEMPLATE . DS . $template . DS;

        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '/';
        $dir = str_replace(DS . DS, DS, $dir);
        $filepath = $template_path . $dir;
        if (!file_exists($filepath)) {
            $this->show_message('模板文件夹不存在！', 2, url('admin/template/item', array('template' => $template)));
        }
        $list = glob($filepath . '*');

        $cur_path = DIR_TEMPLATE . DS . $template . $dir;

        // 模板配置信息
        if (file_exists($template_path . 'config.php')) {
            $info = include $template_path . 'config.php';
        }
        $encode_local = str_replace(array('/', '\\'), '|', $cur_path);
        $file_explan = $info['file_explan'];
        // 显示当前路径
        $cur_path = DS . $cur_path;
        // $cur_url = url('admin/template', array('dir' => urldecode(dirname($dir) . DS)));
        // 返回上一级路径
        if (urldecode(dirname($dir)) == '.') {
            $top_url = url('admin/template/item', array('template' => $template));
        } else {
            $top_url = url('admin/template/item', array('template' => $template, 'dir' => urldecode(dirname($dir) . DS)));
        }
        include $this->views('admin/template/item');
    }

    public function updatefilenameAction()
    {
        $this->dir = PATH_TEMPLATE . DS . SITE_THEME . DS;
        if (file_exists($this->dir . 'config.php')) {
            $info = include $this->dir . 'config.php';
        }
        $file_explan = $this->post('file_explan') ? $this->post('file_explan') : '';
        if (!isset($info['file_explan'])) {
            $info['file_explan'] = array();
        }

        $info['file_explan'] = array_merge($info['file_explan'], $file_explan);
        @file_put_contents($this->dir . 'config.php', '<?php return ' . var_export($info, true) . ';?>');
        $this->show_message('提交成功', 1);
    }

    public function editAction()
    {
        $template = $this->get('template') ? urldecode($this->get('template')) : '';
        if (!file_exists(PATH_TEMPLATE . DS . $template)) {
            $this->show_message('该模板不存在！', 2, url('admin/template'));
        }
        $filename = urldecode($this->get('file'));
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '/';
        $dir = str_replace(DS . DS, DS, $dir);

        $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
        if (!in_array($ext, $this->allowed_file_suffix)) {
            $this->show_message($ext . '文件不允许操作！', 2, url('admin/template/item', array('dir' => $dir)));
        }

        $filepath = PATH_TEMPLATE . DS . $template . $dir . $filename;
        $cur_path = DS . DIR_TEMPLATE. DS . $template . $dir . $filename;
        if (!is_file($filepath)) {
            $this->show_message($cur_path . '该文件不存在！', 2, url('admin/template/item', array('dir' => $dir)));
        }

        if ($this->isPostForm()) {
            file_put_contents($filepath, stripslashes($_POST['file_content']), LOCK_EX);
            $this->show_message('提交成功', 1);
        }
        if (urldecode(dirname($dir)) == '.') {
            $top_url = url('admin/template/item', array('template' => $template));
        } else {
            $top_url = url('admin/template/item', array('template' => $template, 'dir' => urldecode($dir . DS)));
        }
        $filecontent = htmlspecialchars(file_get_contents($filepath));
        include $this->views('admin/template/add');
    }

    public function addAction()
    {
        $template = $this->get('template') ? urldecode($this->get('template')) : 'default';
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '/';
        $dir = str_replace(DS . DS, DS, $dir);
        $filepath = PATH_TEMPLATE . DS . $template . $dir;
        if (!file_exists($filepath)) {
            $this->show_message('文件夹不存在！', 2, url('admin/template/item', array('template' => $template)));
        } else if (!is_writable($filepath)) {
            $this->show_message('文件夹没有权限操作！', 2, url('admin/template/item', array('template' => $template)));
        }
        $cur_path = DS . DIR_TEMPLATE . DS . $template . $dir;
        $filecontent = '';
        if ($this->isPostForm()) {
            $filename = $this->post('file_name');
            if (file_exists($filepath . $filename)) {
                $this->show_message('该文件已经存在', 2, url('admin/template/add', array('template' => $template, 'dir' => $dir)));
            }
            $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
            if (!in_array($ext, $this->allowed_file_suffix)) {
                $this->show_message('文件名后缀不对', 2, url('admin/template/add', array('template' => $template, 'dir' => $dir)));
            }

            file_put_contents($filepath . $filename, stripslashes($_POST['file_content']), LOCK_EX);
            $this->show_message('提交成功', 1, url('admin/template/item', array('template' => $template, 'dir' => $dir)));
        }
        include $this->views('admin/template/add');
    }

    public function delAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DS . DS, DS, $dir);
        $filename = urldecode($this->get('file'));
        $filepath = $this->dir . $dir . $filename;
        // 为了错误删除模板先注销掉
        //        if (@unlink($filepath))
        //        $this->show_message('删除成功',1);
        //        else
        //        $this->show_message('删除失败',2, url('admin/template', array('dir' => $dir)));
    }

    // 还未实现
    public function visualizationAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DS . DS, DS, $dir);
        $filename = urldecode($this->get('file'));
        $filepath = $this->dir . $dir . $filename;

        ob_start();

        $this->view->display('index.html');

        $html = ob_get_contents();
        ob_clean();
        echo $html;
    }

    public function cacheAction($show = 0)
    {
        $file_list = core::load_class('file_list');
        $list = $file_list->get_file_list(PATH_TEMPLATE);
        // $list = array_diff($list, array('index.html'));
        foreach ($list as $file_path) {
            $dir = PATH_CACHE . DS . DIR_TEMPLATE . DS . $file_path . DS;
            $file_list->delete_dir($dir);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
        unset($file_list);
        $show or $this->show_message('缓存更新成功', 1, url('admin/template/index'));
    }
}
