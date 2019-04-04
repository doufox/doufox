<?php

include $this->admin_tpl('header');

if (!file_exists(DATA_PATH . 'cache' . DS . "category.cache.php")) {
    echo '<script type="text/javascript">location.href="?s=admin&a=cache";</script>';
}
?>
<div class="subnav">
    <div class="col-2 lf mr10" style="width:48%">
        <div class="table-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th align="left">系统信息</th>
                    </tr>
                </thead>
                <tbody class="line-box">
                    <tr>
                        <td align="left">
                            网站管理系统<br />
                            当前域名：<?php echo $sysinfo['domain']; ?><br />
                            程序版本：<?php echo APP_VERSION; ?><br />
                            发布日期：<?php echo APP_RELEASE; ?><br />
                            操作系统：<?php echo $sysinfo['os']; ?><br />
                            运行环境：<?php echo $sysinfo['web_server']; ?><br />
                            上传文件：<?php echo $sysinfo['fileupload']; ?><br />
                            MySQL版本：<?php echo $sysinfo['mysqlv']; ?><br />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-2 lf mr10" style="width:48%">
        <div class="table-list">
            <table width="100%">
                <thead>
                    <tr>
                        <th align="left">技术支持</th>
                    </tr>
                </thead>
                <tbody class="line-box">
                    <tr>
                        <td align="left">
                            <p>社区支持：<a href="https://doufox.com/forum" target="_blank">社区支持</a></p>
                            <p>联系QQ：1146171115</p>
                            <p>E-mail：crogram@qq.com</p>
                            <p>官方网站：<a href="https://doufox.com/" target="_blank">https://doufox.com</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
