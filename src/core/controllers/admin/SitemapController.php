<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class SitemapController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 生成首页
     */
    public function indexAction()
    {
        $num = 3000; // 生成的数量
        //      public function getAll($where, $value = null, $fields = null, $order = null, $offset = null, $count = null)
        $data = $this->content->getAll('status!=0', null, 'time,id,catid,url', array('listorder DESC', 'time DESC'), null, $num);
        // var_dump($data);
        // foreach ($data as $key => $t) {
        //     $data[$key]['url'] = $t['url'];
        //     // $data[$key]['url'] = $this->view->get_show_url($t);
        // }

        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= "<urlset>";
        foreach ($data as $v) {
            $xml .= '<url>';
            $xml .= '<loc>' . HTTP_URL . $v['url'] . '</loc>';
            $xml .= "<lastmod>" . date('Y-m-d', $v['time']) . '</lastmod>';
            $xml .= '<changefreq>always</changefreq>';
            $xml .= '<priority>1.0</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';
        echo $xml;
        file_put_contents(ROOT_PATH . DS . 'sitemap.xml', $xml, LOCK_EX);

        $this->show_message("生成<a target='_blank' href='http://{$_SERVER['HTTP_HOST']}/sitemap.xml' >sitemap.xml</a> 成功", 1, '#');

    }
}
