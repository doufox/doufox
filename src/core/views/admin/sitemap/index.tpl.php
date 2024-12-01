<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">网站地图</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/sitemap/index'); ?>">网站地图</a>
                    <a class="list-group-item" href="<?php echo HTTP_URL; ?>/sitemap.xml" target="_blank"><i class="glyphicon glyphicon-new-window"></i> 查看 XML</a>
                    <a class="list-group-item" href="<?php echo HTTP_URL; ?>/sitemap.html" target="_blank"><i class="glyphicon glyphicon-new-window"></i> 查看 HTML</a>
                    <a class="list-group-item" href="<?php echo HTTP_URL; ?>/sitemap.txt" target="_blank"><i class="glyphicon glyphicon-new-window"></i> 查看 TXT</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">生成网站地图文件</div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <p>网站地图 SiteMap 对于 SEO 非常重要，在网站中加入 SiteMap 有利于搜索引擎蜘蛛的抓取和收录。</p>
                        <p>使用方法：</p>
                        <p>1. 点击下方“生成”按钮，制作网站地图文件；</p>
                        <p>2. 在搜索引擎的站长平台提交网站地图链接；</p>
                    </div>
                    <p>网站地图 XML 格式：<a href="<?php echo HTTP_URL; ?>/sitemap.xml" target="_blank"><?php echo HTTP_URL; ?>/sitemap.xml</a></p>
                    <p>网站地图 HTML 格式：<a href="<?php echo HTTP_URL; ?>/sitemap.html" target="_blank"><?php echo HTTP_URL; ?>/sitemap.html</a></p>
                    <p>网站地图 TXT 格式：<a href="<?php echo HTTP_URL; ?>/sitemap.txt" target="_blank"><?php echo HTTP_URL; ?>/sitemap.txt</a></p>
                    <hr />
                    <p>
                        常用站长平台工具：<a href="https://ziyuan.baidu.com/" target="_blank">百度</a>、<a href="https://zhanzhang.sogou.com/" target="_blank">搜狗</a>、<a href="https://zhanzhang.so.com/" target="_blank">360</a>
                    </p>
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