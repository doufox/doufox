<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class CacheController extends Admin
{
    private $cache_dir;

    public function __construct()
    {
        parent::__construct();
        $this->cache_dir = CACHE_PATH . DS;
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0777);
        }
    }

    public function indexAction()
    {
        $caches_desc = array(
            'account.cache.php' => array(
                'controller' => 'account',
                'title' => '系统账号'
            ),
            'models' => array(
                'controller' => 'models',
                'title' => '模型数据'
            ),
            'block.cache.php' => array(
                'controller' => 'block',
                'title' => '区块数据'
            ),
            'category.cache.php' => array(
                'controller' => 'category',
                'title' => '栏目数据'
            ),
            'category_dir.cache.php' => array(
                'controller' => 'category',
                'title' => '分类数据'
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
                'title' => '用户模型'
            ),
            'contentmodel.cache.php' => array(
                'controller' => 'model',
                'title' => '内容模型'
            ),
            'pagemodel.cache.php' => array(
                'controller' => 'model',
                'title' => '单页模型'
            ),
            'theme' => array(
                'controller' => 'template',
                'title' => '主题'
            ),
            'plugin.cache.php' => array(
                'controller' => 'plugin',
                'title' => '插件'
            ),
        );
        $file_list = core::load_class('file_list');
        $data = $file_list->get_file_list($this->cache_dir, array('.DS_Store', 'index.html', '.htaccess.cache.php', '.htaccess')); // 扫描缓存数组目录
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
                        'ctime' => date('Y-m-d H:i:s', filectime($this->cache_dir . $fname)),
                        'mtime' => date('Y-m-d H:i:s', filemtime($this->cache_dir . $fname)),
                        'update' => url('admin/' . $caches_desc[$fname]['controller'] . '/cache')
                    );
                    if (is_file($this->cache_dir . $fname)) {
                        $line['type'] = 'file';
                        $line['size'] = formatFileSize(filesize($this->cache_dir . $fname), 2);
                    } else if (is_dir($this->cache_dir . $fname)) {
                        $size = 0;
                        $_dir = scandir($this->cache_dir . $fname);
                        foreach ($_dir as $c) {
                            $size += filesize($this->cache_dir . $fname . DS . $c);
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
        include $this->views('admin/cache/list');
    }

    /** 更新全部缓存
     * 数据缓存
     */
    public function updateAction()
    {
        $caches = array(
            array('账号', 'account', 'cache'),
            array('模型', 'model', 'cache'),
            array('栏目', 'category', 'cache'),
            array('区块', 'block', 'cache'),
            array('模板', 'template', 'cache'),
            array('插件', 'plugin', 'cache')
        );
        if ($this->get('show')) {
            $id = $_GET['id'] ? intval($_GET['id']) : 0;
            $cache = $caches[$id];
            $c = $cache[1];
            $a = $cache[2] . 'Action';
            $id++;

            if (!empty($cache)) {
                echo '<script type="text/javascript">window.parent.frames["hidden"].location="' . url('admin', array('c' => $c, 'a' => 'cache')) . '";</script>';
                echo '<script type="text/javascript">window.parent.updateTips("<p>' . $cache[0] . '缓存更新成功</p>");</script>';
                $this->show_message('', 1, url('admin/cache/update', array('show' => 1, 'id' => $id)), 100);
            } else {
                echo '<script type="text/javascript">window.parent.updateSuccess();</script>';
            }
        } else {
            include $this->views('admin/cache/update');
        }
    }

    /** 删除缓存文件 */
    public function deleteAction()
    {
        $path = urldecode($this->get('path'));
        $file = $this->cache_dir . $path;
        if (is_file($file) && @unlink($file)) {
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
