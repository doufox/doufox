<?php

class CacheController extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
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
