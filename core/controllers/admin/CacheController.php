<?php

class CacheController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $file_list = core::load_class('file_list');
        $dir = DATA_PATH . 'cache' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $data = $file_list->get_file_list($dir); // 扫描缓存数组目录
        $list = array();
        if ($data) {
            foreach ($data as $path) {
                if (!in_array($path, array('.', '..')) && is_file($dir . $path)) {
                    $size = formatFileSize(filesize($dir . $path), 2);
                    $ctime = date('Y-m-d H:i:s', filectime($dir . $path));
                    $mtime = date('Y-m-d H:i:s', filemtime($dir . $path));
                    $list[] = array(
                        'path' => $path,
                        'size' => $size,
                        'ctime' => $ctime,
                        'mtime' => $mtime,
                        'name' => '缓存数据'
                    );
                    clearstatcache();
                }
            }
        }
        unset($data);
        unset($file_list);
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
