<?php include $this->admin_tpl('header');?>

<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="page_menu">
        侧边栏功能区
    </div>
    <div class="page_content">
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
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
