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

    public function indexAction()
    {
        include $this->views('admin/sitemap/index');
    }

    /**
     * 生成 sitemap.xml
     */
    public function xmlAction()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
        $xml .= '<!-- Generated By ' . APP_NAME . ' ' . date('Y-m-d H:i:s', time()) . ' -->' . PHP_EOL;
        // 首页
        $xml .= '<url><loc>' . HTTP_URL . '</loc><priority>1.00</priority><lastmod>' . date('Y-m-d', time()) . '</lastmod><changefreq>always</changefreq></url>' . PHP_EOL;
        // 栏目内容
        $data_category = get_cache('category');
        foreach ($data_category as $v) {
            $xml .= '<url><loc>' . $v['url'] . '</loc><priority>0.8</priority><lastmod>' . date('Y-m-d', time()) . '</lastmod><changefreq>daily</changefreq></url>' . PHP_EOL;
        }
        // 文章内容
        $num = 3000; // 生成的数量
        $data_content = $this->content->getAll('status!=0', null, 'time,url', ['listorder DESC', 'time DESC'], null, $num);
        foreach ($data_content as $v) {
            $xml .= '<url><loc>' . $v['url'] . '</loc><priority>0.5</priority><lastmod>' . date('Y-m-d', $v['time']) . '</lastmod><changefreq>daily</changefreq></url>' . PHP_EOL;
        }
        $xml .= '</urlset>';
        file_put_contents(PATH_ROOT . DS . 'sitemap.xml', $xml, LOCK_EX);

        $this->show_message('网站地图 sitemap.xml 已生成', 1, url('admin/sitemap/index'));
    }

    /**
     * 生成 sitemap.html
     */
    public function htmlAction()
    {
        $html = '<!DOCTYPE html>
<!-- Generated By ' . APP_NAME . ' ' . date('Y-m-d H:i:s', time()) . ' -->
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>' . PHP_EOL;
        // 首页
        $html .= '<p>首页：</p>' . PHP_EOL . '<ul><li><a href="' . HTTP_URL . '">' . $this->site_config['SITE_NAME'] . '</a></li></ul>' . PHP_EOL;
        // 栏目内容
        $data_category = get_cache('category');
        $html .= '<hr /><p>栏目页：</p><ul>' . PHP_EOL;
        foreach ($data_category as $v) {
            $html .= '<li><a href="' . $v['url'] . '">' . $v['catname'] . '</a></li>' . PHP_EOL;
        }
        $html .= '</ul>' . PHP_EOL;
        // 文章内容
        $num = 3000; // 生成的数量
        $data_content = $this->content->getAll('status!=0', null, 'title,time,url', ['listorder DESC', 'time DESC'], null, $num);
        $html .= '<hr /><p>文章页：</p><ul>' . PHP_EOL;
        foreach ($data_content as $v) {
            $html .= '<li><a href="' . $v['url'] . '">' . $v['title'] . '</a></li>' . PHP_EOL;
        }
        $html .= '</ul>
</body>
</html>';

        file_put_contents(PATH_ROOT . DS . 'sitemap.html', $html, LOCK_EX);

        $this->show_message('网站地图 sitemap.html 已生成', 1, url('admin/sitemap/index'));
    }

    /**
     * 生成 sitemap.txt
     */
    public function txtAction()
    {
        // 首页
        $txt = HTTP_URL . PHP_EOL;
        // 栏目内容
        $data_category = get_cache('category');
        foreach ($data_category as $v) {
            $txt .= $v['url'] . PHP_EOL;
        }
        // 文章内容
        $num = 3000; // 生成的数量
        $data_content = $this->content->getAll('status!=0', null, 'title,time,url', ['listorder DESC', 'time DESC'], null, $num);
        foreach ($data_content as $v) {
            $txt .= $v['url'] . PHP_EOL;
        }

        file_put_contents(PATH_ROOT . DS . 'sitemap.txt', $txt, LOCK_EX);

        $this->show_message('网站地图 sitemap.txt 已生成', 1, url('admin/sitemap/index'));
    }
}
