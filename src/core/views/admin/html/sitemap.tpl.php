<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">静态化管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/sitemap/index'); ?>">网站地图</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/index'); ?>">页面静态化</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/home'); ?>">生成首页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/category'); ?>">生成栏目页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/show'); ?>">生成内容页</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">生成网站地图文件</div>
                <div class="panel-body">
                    <p>网站地图（sitemap.xml）：<a href="<?php echo HTTP_URL; ?>/sitemap.xml" target="_blank"><?php echo HTTP_URL; ?>/sitemap.xml</a></p>
                    <p>网站地图（sitemap.html）<a href="<?php echo HTTP_URL; ?>/sitemap.html" target="_blank"><?php echo HTTP_URL; ?>/sitemap.html</a></p>
                    <p>网站地图（sitemap.txt）<a href="<?php echo HTTP_URL; ?>/sitemap.txt" target="_blank"><?php echo HTTP_URL; ?>/sitemap.txt</a></p>
                    <hr />
                    <div class="alert alert-info">
                        <p>网站地图 SiteMap 对于 SEO 非常重要，在网站中加入 SiteMap 有利于搜索引擎蜘蛛的抓取和收录。</p>
                        <p>使用方法：</p>
                        <p>1. 点击下方“生成”按钮，制作网站地图文件;</p>
                        <p>2. 在百度站长平台提交网站地图（百度站长平台工具：https://ziyuan.baidu.com/）</p>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo url('admin/sitemap/xml'); ?>" class="btn btn-default">生成 XML</a>
                    <a href="<?php echo url('admin/sitemap/html'); ?>" class="btn btn-default">生成 HTML</a>
                    <a href="<?php echo url('admin/sitemap/txt'); ?>" class="btn btn-default">生成 TXT</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>