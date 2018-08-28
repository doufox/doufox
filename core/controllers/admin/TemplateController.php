<?php

class TemplateController extends Admin
{

    private $dir;
    private $file_info;

    public function __construct()
    {
        parent::__construct();
        $this->dir = THEME_PATH . SITE_THEME . DIRECTORY_SEPARATOR;
        if (file_exists($this->dir . 'config.php')) {
            $this->file_info = include $this->dir . 'config.php';
        }
    }

    public function indexAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
        $filepath = $this->dir . $dir;
        $list = glob($filepath . '*');
        $local = str_replace(ROOT_PATH, '', $filepath);
        $encode_local = str_replace(array('/', '\\'), '|', $local);
        $file_explan = $this->file_info['file_explan'];
        include $this->admin_tpl('template_list');

    }

    public function updatefilenameAction()
    {
        $file_explan = $this->post('file_explan') ? $this->post('file_explan') : '';
        if (!isset($this->file_info['file_explan'])) {
            $this->file_info['file_explan'] = array();
        }

        $this->file_info['file_explan'] = array_merge($this->file_info['file_explan'], $file_explan);
        @file_put_contents($this->dir . 'config.php', '<?php return ' . var_export($this->file_info, true) . ';?>');
        $this->show_message('提交成功', 1);
    }

    public function editAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
        $filename = urldecode($this->get('file'));
        $filepath = $this->dir . $dir . $filename;
        $local = str_replace(ROOT_PATH, '', $filepath);
        if (!is_file($filepath)) {
            $this->show_message($dir . $filename . '该文件不存在', 2, '?s=admin&c=template&dir=' . $dir);
        }

        if ($this->isPostForm()) {
            file_put_contents($filepath, stripslashes($_POST['file_content']), LOCK_EX);
            $this->show_message('提交成功', 1);
        }
        $filecontent = htmlspecialchars(file_get_contents($filepath));
        include $this->admin_tpl('template_add');
    }

    public function addAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
        $filepath = $this->dir . $dir;
        $local = str_replace(ROOT_PATH, '', $filepath);
        $filecontent = '';
        if ($this->isPostForm()) {
            $filename = $this->post('file_name');
            if (file_exists($filepath . $filename)) {
                $this->show_message('该文件已经存在', '?s=admin&c=template&dir=' . $dir, 2);
            }
            $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
            if (!in_array($ext, array('html', 'css', 'js'))) {
                $this->show_message('文件名后缀不对', 2, '?s=admin&c=template&dir=' . $dir);
            }

            file_put_contents($filepath . $filename, stripslashes($_POST['file_content']), LOCK_EX);
            $this->show_message('提交成功', 1, '?s=admin&c=template&dir=' . $dir);
        }
        include $this->admin_tpl('template_add');
    }

    public function delAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
        $filename = urldecode($this->get('file'));
        $filepath = $this->dir . $dir . $filename;
        // 为了错误删除模板先注销掉
        //        if (@unlink($filepath))
        //        $this->show_message('删除成功',1);
        //        else
        //        $this->show_message('删除失败',2, '?s=admin&c=template&dir='.$dir );
    }

    // 还未实现
    public function visualizationAction()
    {
        $dir = $this->get('dir') ? urldecode($this->get('dir')) : '';
        $dir = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
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
        // $file_list = cms::load_class('file_list');
        // $list_desktop = $file_list->get_file_list(THEME_PATH);
        // $list_mobile = $file_list->get_file_list(THEME_PATH_MOBILE);
        // foreach ($list_desktop as $file_path) {
        //     $dir = DATA_PATH . 'cache' . DIRECTORY_SEPARATOR . 'theme_desktop'. DIRECTORY_SEPARATOR . $file_path . DIRECTORY_SEPARATOR;
        //     $file_list->delete_dir($dir);
        //     if (!file_exists($dir)) {
        //         mkdir($dir, 0777, true);
        //     }
        // }
        // foreach ($list_mobile as $file_path) {
        //     $dir = DATA_PATH . 'cache' . DIRECTORY_SEPARATOR . 'theme_mobile'. DIRECTORY_SEPARATOR . $file_path . DIRECTORY_SEPARATOR;
        //     $file_list->delete_dir($dir);
        //     if (!file_exists($dir)) {
        //         mkdir($dir, 0777, true);
        //     }
        // }
        $this->cacheDesktopAction();
        $this->cacheMobileAction();
        $show or $this->show_message('缓存更新成功', 1, url('admin/template/index'));
    }

    public function cacheDesktopAction()
    {
        $file_list = cms::load_class('file_list');
        $list_desktop = $file_list->get_file_list(THEME_PATH);
        foreach ($list_desktop as $file_path) {
            $dir = DATA_PATH . 'cache' . DIRECTORY_SEPARATOR . 'theme_desktop'. DIRECTORY_SEPARATOR . $file_path . DIRECTORY_SEPARATOR;
            $file_list->delete_dir($dir);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }

    public function cacheMobileAction()
    {
        $file_list = cms::load_class('file_list');
        $list_mobile = $file_list->get_file_list(THEME_PATH_MOBILE);
        foreach ($list_mobile as $file_path) {
            $dir = DATA_PATH . 'cache' . DIRECTORY_SEPARATOR . 'theme_mobile'. DIRECTORY_SEPARATOR . $file_path . DIRECTORY_SEPARATOR;
            $file_list->delete_dir($dir);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }
}
