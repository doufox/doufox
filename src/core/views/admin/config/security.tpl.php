<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<script type="text/javascript">
    function set_url_type(type) {
        if (type && type == 'diy') {
            $('.url-type-diy').show();
            $('.url-type-default').hide();
        } else {
            $('.url-type-diy').hide();
            $('.url-type-default').show();
        }
    }
    function setSateType(id) {
        if (id == 0) {
            $('#w_1').hide();
            $('.w_2').hide();
            $('#w_0').hide();
        } else if (id == 1) {
            $('.w_2').hide();
            $('#w_1').show();
            $('#w_0').show();
        } else if (id == 2) {
            $('#w_1').hide();
            $('.w_2').show();
            $('#w_0').show();
        }
    }
    setSateType(<?php echo $data['SITE_WATERMARK']; ?>);
</script>

<div class="container">
    <div class="page_menu">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="panel-title">系统设置</span></div>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo url('admin/config'); ?>">基础设置</a>
                <a class="list-group-item active" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">安全设置</span>
            </div>
            <div class="panel-body">
                <form method="post" action="" class="form-inline">
                    <div class="tab-content">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="100">后台路径：</th>
                                <td>
                                    <input class="form-control" type="text" name="data[ADMIN_LOGINPATH]" value="<?php echo $data['ADMIN_LOGINPATH']; ?>" size="30" />
                                    <div class="show-tips"><?php echo $configTips['ADMIN_LOGINPATH']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>验证码：</th>
                                <td>
                                    <label class="label-group"><input name="data[ADMIN_LOGINCODE]" type="radio" value="1" <?php if ($data['ADMIN_LOGINCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                    <label class="label-group"><input name="data[ADMIN_LOGINCODE]" type="radio" value="0" <?php if ($data['ADMIN_LOGINCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
                                    <div class="show-tips"><?php echo $configTips['ADMIN_LOGINCODE']; ?></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr />
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>