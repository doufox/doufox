<?php
if (!defined('IN_CMS')) {
    exit();
}

class CategoryController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $data = array(
            'site_title' => $this->site_config['SITE_TITLE'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
        );
        $this->response(200, $data, 'success');
    }

    /**
     * 全部栏目
     */
    public function listAction()
    {
        $list = $this->category_cache; // 读取文件缓存
        // 读取数据库后台不会根据排序显示
        // $list = $this->category->findAll('catid,typeid,parentid,child,http,catname');
        $this->response(200, $list, 'success');
    }
}
