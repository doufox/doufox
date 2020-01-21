<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="page_menu">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="panel-title">系统设置</span></div>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo url('admin/config'); ?>">基本设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                <a class="list-group-item active" href="<?php echo url('admin/config/database'); ?>">数据库</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">数据库设置</span>
                </div>
                <table width="100%" class="table_form table table-bordered">
                    <tr>
                        <th>类型：</th>
                        <td>MySQL</td>
                    </tr>
                    <tr>
                        <th width="100">服务器：</th>
                        <td>aaaaa</td>
                    </tr>
                    <tr>
                        <th width="100">数据库名：</th>
                        <td>aaaaa</td>
                    </tr>
                    <tr>
                        <th>库名前缀：</th>
                        <td>doufox_</td>
                    </tr>
                    <tr>
                        <th>字符集：</th>
                        <td>utf8</td>
                    </tr>
                    <tr>
                        <th width="100">用户名：</th>
                        <td>aaa</td>
                    </tr>
                    <tr>
                        <th>密码：</th>
                        <td>***********</td>
                    </tr>
                </table>
                <div class="panel-body">
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>