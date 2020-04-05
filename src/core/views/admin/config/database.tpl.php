<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
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
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">数据库设置</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="db_type" class="col-sm-3 col-md-2 control-label">数据库类型：</label>
                            <div class="col-sm-9 col-md-10">
                                <select id="db_type" class="form-control" name="data[db_type]" placeholder="数据库类型">
                                    <option value="mysql">MySQL</option>
                                    <option value="sqlite">SQLite</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_host" class="col-sm-3 col-md-2 control-label">服务器：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_host" class="form-control" type="text" size="30" placeholder="服务器地址" name="data[db_host]" value="https://doufox.com" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_name" class="col-sm-3 col-md-2 control-label">数据库名：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_name" class="form-control" type="text" size="30" placeholder="数据库名" name="data[db_name]" value="doufox" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_prefix" class="col-sm-3 col-md-2 control-label">库名前缀：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_prefix" class="form-control" type="text" size="30" placeholder="库名前缀" name="data[db_prefix]" value="df_" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_charset" class="col-sm-3 col-md-2 control-label">字符集：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_charset" class="form-control" type="text" size="30" placeholder="字符集" name="data[db_charset]" value="utf8" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_username" class="col-sm-3 col-md-2 control-label">用户名：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_username" class="form-control" type="text" size="30" placeholder="数据库用户名" name="data[db_username]" value="dbuser" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="db_password" class="col-sm-3 col-md-2 control-label">密码：</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="db_password" class="form-control" type="text" size="30" placeholder="数据库密码" name="data[db_password]" value="***********" />
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" name="submit" class="btn btn-default">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>