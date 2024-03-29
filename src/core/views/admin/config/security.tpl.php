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
                    <a class="list-group-item active" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/robots'); ?>">Robots</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">安全设置</span>
                    </div>
                    <div class="panel-body">
                        <table class="table_form">
                            <tr>
                                <th>登陆需要验证码</th>
                                <td>
                                    <label class="label-group"><input name="data[ADMIN_LOGINCODE]" type="radio" value="1" <?php if ($data['ADMIN_LOGINCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                    <label class="label-group"><input name="data[ADMIN_LOGINCODE]" type="radio" value="0" <?php if ($data['ADMIN_LOGINCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
                                </td>
                            </tr>
                            <tr>
                                <th>自定义后台路径</th>
                                <td>
                                    <input class="form-control" type="text" size="30" placeholder="自定义后台登录路径（默认admin）" name="data[ADMIN_LOGINPATH]" value="<?php echo $data['ADMIN_LOGINPATH']; ?>" />
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