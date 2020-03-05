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
        <form method="post" action="" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">微信设置</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label">微信公众号：</label>
                        <div class="col-sm-9 col-md-10">
                            <label class="label-group"><input name="data[WEIXIN_MP_OPENED]" type="radio" value="true" <?php if ($data['WEIXIN_MP_OPENED'] == 1) { ?>checked<?php } ?>>打开</label>
                            <label class="label-group"><input name="data[WEIXIN_MP_OPENED]" type="radio" value="false" <?php if ($data['WEIXIN_MP_OPENED'] == 0) { ?>checked<?php } ?>>关闭</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="WEIXIN_MP_URL" class="col-sm-3 col-md-2 control-label">URL：</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="WEIXIN_MP_URL" class="form-control" type="text" size="60" readonly placeholder="接收来自微信服务器的请求,必须以http://或https://开头" name="data[WEIXIN_MP_URL]" value="<?php echo $data['WEIXIN_MP_URL']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="WEIXIN_MP_TOKEN" class="col-sm-3 col-md-2 control-label">Token：</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="WEIXIN_MP_TOKEN" class="form-control" type="text" size="32" placeholder="微信服务器的验证token,必须为英文或数字，长度为3-32字符" name="data[WEIXIN_MP_TOKEN]" value="<?php echo $data['WEIXIN_MP_TOKEN']; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="WEIXIN_MP_AESKEY" class="col-sm-3 col-md-2 control-label">加密密钥：</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="WEIXIN_MP_AESKEY" class="form-control" type="text" size="43" placeholder="EncodingAESKey,消息加密密钥由43位字符组成" name="data[WEIXIN_MP_AESKEY]" value="<?php echo $data['WEIXIN_MP_AESKEY']; ?>" />
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

<?php include $this->admin_view('footer'); ?>