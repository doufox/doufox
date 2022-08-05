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
        // $data = $this->content->page_limit(1, $num)->where('status!=0')->fields('time,id,catid')->order(array('listorder DESC', 'time DESC'))->select();
        $data = $this->content->getAll('status!=0', null, null, 'time,id,catid', array('listorder DESC', 'time DESC'), null, $num);
        var_dump($data);
        // $data = $this->db->setTableName('content')->order('id DESC')->fields('time,id,catid')->limit(0, $num)->getAll('status!=0', null, null);
        foreach ($data as $key => $t) {
            $data[$key]['url'] = $t['url'];
            // $data[$key]['url'] = $this->view->get_show_url($t);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= "<urlset>";
        foreach ($data as $v) {
            $xml .= "<url><loc>http://";
            $xml .= $_SERVER['HTTP_HOST'] . $v['url'];
            $xml .= "</loc><lastmod>";
            $xml .= date('Y-m-d', $v['time']);
            $xml .= "</lastmod><changefreq>always</changefreq><priority>1.0</priority></url>";
        }
        $xml .= '</urlset>';
        // echo $xml;
        // file_put_contents(PATH_ROOT . DS . 'sitemap.xml', $xml, LOCK_EX);

        // $this->show_message("生成<a target='_blank' href='http://{$_SERVER['HTTP_HOST']}/sitemap.xml' >sitemap.xml</a> 成功", 1, '#');
    }
}
