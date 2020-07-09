<?php
include $this->admin_view('header');
include $this->admin_view('navbar');
doHookAction('admin_index_top');
?>

<div class="container-fluid">
    <div class="row">
    <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">快速导航</span>
            </div>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo url('admin/category/add'); ?>">添加栏目</a>
                <a class="list-group-item" href="<?php echo url('admin/member/index'); ?>">会员列表</a>
                <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
                <a class="list-group-item" href="<?php echo url('admin/attachment'); ?>">查看附件</a>
                <a class="list-group-item" href="<?php echo url('admin/backup'); ?>">备份管理</a>
                <a class="list-group-item" href="<?php echo url('admin/cache'); ?>">更新缓存</a>
            </div>
        </div>
    </div>
    <div class="col-sm-9 col-md-9 col-lg-10 page_content">
        <?php doHookAction('admin_index_content_top'); echo PHP_EOL; ?>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">系统信息</div>
                    <div class="panel-body">
                    <p>网站管理系统<br />
                        当前域名：<?php echo $sysinfo['domain']; ?><br />
                        程序版本：<?php echo APP_VERSION; ?><br />
                        发布日期：<?php echo APP_RELEASE; ?><br />
                        操作系统：<?php echo $sysinfo['os']; ?><br />
                        运行环境：<?php echo $sysinfo['web_server']; ?><br />
                        上传文件：<?php echo $sysinfo['fileupload']; ?><br />
                        MySQL版本：<?php echo $sysinfo['mysqlv']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">技术支持</div>
                    <div class="panel-body">
                        <p>社区支持：<a href="https://doufox.com/forum" target="_blank">社区支持</a><br />
                        联系QQ：1146171115<br />
                        E-mail：crogram@qq.com<br />
                        官方网站：<a href="https://doufox.com/" target="_blank">https://doufox.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <?php doHookAction('admin_index_content_bottom'); echo PHP_EOL; ?>
    </div>
    </div>
</div>

<?php
doHookAction('admin_index_bottom');
include $this->admin_view('footer');
?>