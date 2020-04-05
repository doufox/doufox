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
                    <a class="list-group-item active" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">会员设置</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group form-inline">
                            <label for="MEMBER_MODELID" class="col-sm-3 col-md-2 control-label">默认会员模型</label>
                            <div class="col-sm-9 col-md-10">
                                <select id="MEMBER_MODELID" name="data[MEMBER_MODELID]" class="form-control">
                                    <option value="0">==会员模型==</option>
                                    <?php if (is_array($membermodel)) {
                                        foreach ($membermodel as $t) { ?>
                                            <option value="<?php echo $t['modelid']; ?>" <?php if ($data['MEMBER_MODELID'] == $t['modelid']) { ?>selected<?php } ?>><?php echo $t['modelname']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">新会员注册</label>
                            <div class="col-sm-9 col-md-10">
                                <label class="label-group"><input name="data[MEMBER_REGISTER]" type="radio" value="1" <?php if ($data['MEMBER_REGISTER'] == 1) { ?>checked<?php } ?>>打开</label>
                                <label class="label-group"><input name="data[MEMBER_REGISTER]" type="radio" value="0" <?php if ($data['MEMBER_REGISTER'] == 0) { ?>checked<?php } ?>>关闭</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">新会员审核</label>
                            <div class="col-sm-9 col-md-10">
                                <label class="label-group"><input name="data[MEMBER_STATUS]" type="radio" value="1" <?php if ($data['MEMBER_STATUS'] == 1) { ?>checked<?php } ?>>打开</label>
                                <label class="label-group"><input name="data[MEMBER_STATUS]" type="radio" value="0" <?php if ($data['MEMBER_STATUS'] == 0) { ?>checked<?php } ?>>关闭</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">注册验证码</label>
                            <div class="col-sm-9 col-md-10">
                                <label class="label-group"><input name="data[MEMBER_REGCODE]" type="radio" value="1" <?php if ($data['MEMBER_REGCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                <label class="label-group"><input name="data[MEMBER_REGCODE]" type="radio" value="0" <?php if ($data['MEMBER_REGCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-md-2 control-label">登录验证码</label>
                            <div class="col-sm-9 col-md-10">
                                <label class="label-group"><input name="data[MEMBER_LOGINCODE]" type="radio" value="1" <?php if ($data['MEMBER_LOGINCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                <label class="label-group"><input name="data[MEMBER_LOGINCODE]" type="radio" value="0" <?php if ($data['MEMBER_LOGINCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
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