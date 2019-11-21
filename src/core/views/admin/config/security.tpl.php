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
                <a class="list-group-item active" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">安全设置</span>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table_form table table-bordered">
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
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>