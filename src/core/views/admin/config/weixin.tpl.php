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
                <a class="list-group-item active" href="<?php echo url('admin/config/weixin'); ?>">微信设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">微信设置</span>
                </div>
                <table width="100%" class="table_form table table-bordered">
                    <tr>
                        <th>微信公众号：</th>
                        <td>
                            <label class="label-group"><input name="data[WEIXIN_MP_OPENED]" type="radio" value="true" <?php if ($data['WEIXIN_MP_OPENED'] == 1) { ?>checked<?php } ?>>打开</label>
                            <label class="label-group"><input name="data[WEIXIN_MP_OPENED]" type="radio" value="false" <?php if ($data['WEIXIN_MP_OPENED'] == 0) { ?>checked<?php } ?>>关闭</label>
                            <div class="show-tips"><?php echo $configTips['WEIXIN_MP_OPENED']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="100">URL：</th>
                        <td>
                            <input class="form-control" readonly="readonly" type="text" name="data[WEIXIN_MP_URL]" value="<?php echo $data['WEIXIN_MP_URL'] ?>" size="60" />
                            <div class="show-tips"><?php echo $configTips['WEIXIN_MP_URL']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>Token：</th>
                        <td>
                            <input class="form-control" type="text" name="data[WEIXIN_MP_TOKEN]" value="<?php echo $data['WEIXIN_MP_TOKEN']; ?>" size="32" />
                            <div class="show-tips"><?php echo $configTips['WEIXIN_MP_TOKEN']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>加密密钥：</th>
                        <td>
                            <input class="form-control" type="text" name="data[WEIXIN_MP_AESKEY]" value="<?php echo $data['WEIXIN_MP_AESKEY']; ?>" size="43" />
                            <div class="show-tips"><?php echo $configTips['WEIXIN_MP_AESKEY']; ?></div>
                        </td>
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