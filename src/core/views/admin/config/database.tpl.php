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
                    <a class="list-group-item" href="<?php echo url('admin/config/robots'); ?>">Robots</a>
                    <a class="list-group-item active" href="<?php echo url('admin/config/database'); ?>">数据库</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <iframe id="db_tester" name="db_tester" style="display:none;"></iframe>
            <form action="<?php echo url('api/database/test'); ?>" method="post" id="db_form" target="db_tester">
                <input type="hidden" name="tdb_host" id="tdb_host" />
                <input type="hidden" name="tdb_username" id="tdb_username" />
                <input type="hidden" name="tdb_password" id="tdb_password" />
                <input type="hidden" name="tdb_name" id="tdb_name" />
                <input type="hidden" name="tdb_prefix" id="tdb_prefix" />
            </form>
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">数据库配置</span>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-danger">请注意：修改此配置可能会导致数据库连接失败 ！</div>
                        <table class="table_form">
                            <tr>
                                <th>数据库类型</th>
                                <td>
                                    <select id="db_type" class="form-control" readonly disabled name="data[db_type]" placeholder="选择数据库类型">
                                        <option value="mysql">MySQL</option>
                                        <option value="sqlite">SQLite</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>服务器地址</th>
                                <td>
                                    <input id="db_host" class="form-control" type="text" size="30" placeholder="服务器地址" name="data[db_host]" value="<?php echo $data['db_host']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>数据库名</th>
                                <td>
                                    <input id="db_name" class="form-control" type="text" size="30" placeholder="数据库名" name="data[db_name]" value="<?php echo $data['db_name']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>表前缀</th>
                                <td>
                                    <input id="db_prefix" class="form-control" type="text" size="30" placeholder="表前缀" name="data[db_prefix]" value="<?php echo $data['db_prefix']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>字符集</th>
                                <td>
                                    <input id="db_charset" class="form-control" type="text" size="30" placeholder="字符集" name="data[db_charset]" value="<?php echo $data['db_charset']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>用户名</th>
                                <td>
                                    <input id="db_username" class="form-control" type="text" size="30" placeholder="数据库用户名" name="data[db_username]" value="<?php echo $data['db_username']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>密码</th>
                                <td>
                                    <input id="db_password" class="form-control" type="text" size="30" placeholder="数据库密码" name="data[db_password]" value="<?php echo $data['db_password']; ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-default" type="test" onClick="test();return 0;">测试连接</a>
                        <button type="submit" name="submit" class="btn btn-default">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function $(ID) {
        return document.getElementById(ID);
    }

    function test() {
        if ($('db_host').value == '') {
            alert('请填写数据库服务器');
            $('db_host').focus();
            return;
        }
        $('tdb_host').value = $('db_host').value;

        if ($('db_username').value == '') {
            alert('请填写数据库用户名');
            $('db_username').focus();
            return;
        }
        $('tdb_username').value = $('db_username').value;
        $('tdb_password').value = $('db_password').value;

        if ($('db_name').value == '') {
            alert('请填写数据库名');
            $('db_name').focus();
            return;
        }
        $('tdb_name').value = $('db_name').value;

        if ($('db_prefix').value == '') {
            alert('请填写数据表前缀');
            $('db_prefix').focus();
            return;
        }
        $('tdb_prefix').value = $('db_prefix').value;
        $('db_form').submit();
    }
</script>

<?php include $this->views('admin/footer'); ?>