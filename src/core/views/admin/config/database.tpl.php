<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">系统设置</span></div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/config'); ?>">基本设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">用户设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/attachment'); ?>">附件设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信公众号</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                    <a class="list-group-item active" href="<?php echo url('admin/config/database'); ?>">数据库</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">数据库设置(开发中)</span>
                    </div>
                    <div class="panel-body">
                        <table class="table_form">
                            <tr>
                                <th>数据库类型</th>
                                <td>
                                    <select id="db_type" class="form-control" name="data[db_type]" placeholder="选择数据库类型">
                                        <option value="mysql">MySQL</option>
                                        <option value="sqlite">SQLite</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>服务器地址</th>
                                <td>
                                    <input id="db_host" class="form-control" type="text" size="30" placeholder="服务器地址" name="data[db_host]" value="https://doufox.com" />
                                </td>
                            </tr>
                            <tr>
                                <th>数据库名</th>
                                <td>
                                    <input id="db_name" class="form-control" type="text" size="30" placeholder="数据库名" name="data[db_name]" value="doufox" />
                                </td>
                            </tr>
                            <tr>
                                <th>库名前缀</th>
                                <td>
                                    <input id="db_prefix" class="form-control" type="text" size="30" placeholder="库名前缀" name="data[db_prefix]" value="df_" />
                                </td>
                            </tr>
                            <tr>
                                <th>字符集</th>
                                <td>
                                    <input id="db_charset" class="form-control" type="text" size="30" placeholder="字符集" name="data[db_charset]" value="utf8" />
                                </td>
                            </tr>
                            <tr>
                                <th>用户名</th>
                                <td>
                                    <input id="db_username" class="form-control" type="text" size="30" placeholder="数据库用户名" name="data[db_username]" value="dbuser" />
                                </td>
                            </tr>
                            <tr>
                                <th>密码</th>
                                <td>
                                    <input id="db_password" class="form-control" type="text" size="30" placeholder="数据库密码" name="data[db_password]" value="***********" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" name="submit" class="btn btn-default">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>