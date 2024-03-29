<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class SessionController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $file_list = core::load_class('file_list');
        $dir = PATH_CACHE . DS .'session' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $data = $file_list->get_file_list($dir, array('.', '..', 'index.html')); // 扫描缓存数组目录
        $list = array();
        $idx = 0;
        if ($data) {
            foreach ($data as $fname) {
                // if (!in_array($fname, array('.', '..')) && is_file($dir . $fname)) {
                if (is_file($dir . $fname)) {
                    $idx++;
                    $list[] = array(
                        'name' => $fname,
                        'index' => $idx,
                        'size' => formatFileSize(filesize($dir . $fname), 2),
                        'ctime' => date('Y-m-d H:i:s', filectime($dir . $fname)),
                        'mtime' => date('Y-m-d H:i:s', filemtime($dir . $fname))
                    );
                    clearstatcache();
                }
            }
        }
        unset($data, $file_list);
        include $this->views('admin/session/list');
    }
}
