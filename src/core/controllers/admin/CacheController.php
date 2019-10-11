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
            'account.cache.php' => array(
                'controller' => 'account',
                'title' => '系统账号'
            ),
            'block.cache.php' => array(
                'controller' => 'block',
                'title' => '区块'
            ),
            'category.cache.php' => array(
                'controller' => 'category',
                'title' => '栏目'
            ),
            'category_dir.cache.php' => array(
                'controller' => 'category',
                'title' => '栏目'
            ),
            'formmodel.cache.php' => array(
                'controller' => 'form',
                'title' => '表单模型'
            ),
            'joinmodel.cache.php' => array(
                'controller' => 'model',
                'title' => '模型配置'
            ),
            'membermodel.cache.php' => array(
                'controller' => 'member',
                'title' => '会员'
            ),
            'model.cache.php' => array(
                'controller' => 'model',
                'title' => '模型'
            ),
            'theme_desktop' => array(
                'controller' => 'template',
                'title' => '桌面主题'
            ),
            'theme_mobile' => array(
                'controller' => 'template',
                'title' => '移动主题'
            ),
        );
        $file_list = core::load_class('file_list');
        $dir = DATA_PATH . 'cache' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $data = $file_list->get_file_list($dir); // 扫描缓存数组目录
        $list = array();
        if ($data) {
            $index = 0;
            foreach ($data as $fname) {
                $index++;
                if (!in_array($fname, array('.', '..'))) {
                    $line = array(
                        'name' => $fname,
                        'index' => $index,
                        'size' => '',
                        'type' => 'file',
                        'desc' => $caches_desc[$fname]['title'],
                        'controller' => $caches_desc[$fname]['controller'],
                        'ctime' => date('Y-m-d H:i:s', filectime($dir . $fname)),
                        'mtime' => date('Y-m-d H:i:s', filemtime($dir . $fname)),
                        'update' => url('admin/' . $caches_desc[$fname]['controller'] . '/cache')
                    );
                    if (is_file($dir . $fname)) {
                        $line['type'] = 'file';
                        $line['size'] = formatFileSize(filesize($dir . $fname), 2);
                    } else if (is_dir($dir . $fname)) {
                        $size = 0;
                        $_dir = scandir($dir . $fname);
                        foreach ($_dir as $c) {
                            $size += filesize($dir . $fname . DS . $c);
                        }
                        $line['size'] = formatFileSize($size, 2);
                        $line['type'] = 'directory';
                        unset($_dir);
                    }
                    $list[] = $line;
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
