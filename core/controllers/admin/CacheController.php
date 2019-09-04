<?php

class CacheController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $caches_desc = array(
            'account.cache.php' => '系统账号',
            'block.cache.php' => '区块',
            'category.cache.php' => '栏目',
            'category_dir.cache.php' => '栏目',
            'formmodel.cache.php' => '表单模型',
            'joinmodel.cache.php' => '模型配置',
            'membermodel.cache.php' => '会员',
            'model.cache.php' => '模型',
            'theme_desktop' => '桌面主题',
            'theme_mobile' => '移动主题',
        );
        $file_list = core::load_class('file_list');
        $dir = DATA_PATH . 'cache' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $data = $file_list->get_file_list($dir); // 扫描缓存数组目录
        $list = array();
        $index = 0;
        if ($data) {
            foreach ($data as $fname) {
                $index++;
                if (!in_array($fname, array('.', '..'))) {
                    if (is_file($dir . $fname)) {
                        // $size = formatFileSize(filesize($dir . $fname), 2);
                        // $ctime = date('Y-m-d H:i:s', filectime($dir . $fname));
                        // $mtime = date('Y-m-d H:i:s', filemtime($dir . $fname));
                        $list[] = array(
                            'index' => $index,
                            'name' => $fname,
                            'size' => formatFileSize(filesize($dir . $fname), 2),
                            'ctime' => date('Y-m-d H:i:s', filectime($dir . $fname)),
                            'mtime' => date('Y-m-d H:i:s', filemtime($dir . $fname)),
                            'type' => 'file',
                            'desc' => $caches_desc[$fname],
                        );
                    } else if (is_dir($dir . $fname)) {
                        $size = 0;
                        $_dir = scandir($dir . $fname);
                        foreach ($_dir as $c) {
                            $size += filesize($dir . $fname . DS . $c);
                        }
                        $list[] = array(
                            'index' => $index,
                            'name' => $fname,
                            'size' => formatFileSize($size, 2),
                            'ctime' => date('Y-m-d H:i:s', filectime($dir . $fname)),
                            'mtime' => date('Y-m-d H:i:s', filemtime($dir . $fname)),
                            'type' => 'directory',
                            'desc' => $caches_desc[$fname],
                        );
                        unset($_dir);
                    }
                    clearstatcache();
                }
            }
        }
        unset($caches_desc, $data, $file_list);
        include $this->admin_tpl('cache/list');
    }

    /** 更新全部缓存
     * 数据缓存
     */
    public function updateAction()
    {
        $caches = array(
            0 => array('账号', 'account', 'cache'),
            1 => array('模型', 'model', 'cache'),
            2 => array('栏目', 'category', 'cache'),
            3 => array('区块', 'block', 'cache'),
            4 => array('模板', 'template', 'cache'),
        );
        if ($this->get('show')) {
            $id = $_GET['id'] ? intval($_GET['id']) : 0;
            $cache = $caches[$id];
            $c = $cache[1];
            $a = $cache[2] . 'Action';
            $id++;

            if (!empty($cache)) {
                echo '<script type="text/javascript">window.parent.frames["hidden"].location="index.php?s=admin&c=' . $c . '&a=cache";</script>';
                echo '<script type="text/javascript">window.parent.updateTips("<p>' . $cache[0] . '缓存更新成功</p>");</script>';
                $this->show_message($msg, 1, url('admin/cache/update', array('show' => 1, 'id' => $id)), 100);
            } else {
                echo '<script type="text/javascript">window.parent.updateSuccess();</script>';
            }
        } else {
            include $this->admin_tpl('cache/update');
        }
    }

    /** 删除缓存文件 */
    public function deleteAction()
    {
        $dir = DATA_PATH . 'cache' . DS;
        $path = urldecode($this->get('path'));
        if (@unlink($dir . $path)) {
            $this->show_message('删除成功', 1, url('admin/cache/index'));
        } else {
            $this->show_message('删除失败', 2, url('admin/cache/index'));
        }
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
