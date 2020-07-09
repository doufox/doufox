<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">系统设置</span></div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/config'); ?>">基本设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
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
                        <span class="panel-title">基本设置</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="SITE_NAME" class="col-sm-3 col-md-2 control-label">网站名称</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="SITE_NAME" class="form-control" type="text" size="30" placeholder="网站名称" name="data[SITE_NAME]" value="<?php echo $data['SITE_NAME']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_SLOGAN" class="col-sm-3 col-md-2 control-label">网站头部标语</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="SITE_SLOGAN" class="form-control" type="text" size="50" placeholder="网站头部标语" name="data[SITE_SLOGAN]" value="<?php echo $data['SITE_SLOGAN']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_TITLE" class="col-sm-3 col-md-2 control-label">首页标题</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="SITE_TITLE" class="form-control" type="text" size="50" placeholder="网站首页SEO标题" name="data[SITE_TITLE]" value="<?php echo $data['SITE_TITLE']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_KEYWORDS" class="col-sm-3 col-md-2 control-label">关键字</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="SITE_KEYWORDS" class="form-control" type="text" size="50" placeholder="网站SEO关键字" name="data[SITE_KEYWORDS]" value="<?php echo $data['SITE_KEYWORDS']; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_DESCRIPTION" class="col-sm-3 col-md-2 control-label">网站描述</label>
                            <div class="col-sm-9 col-md-10">
                                <textarea id="SITE_DESCRIPTION" class="form-control" rows="3" cols="55" placeholder="网站SEO描述信息" name="data[SITE_DESCRIPTION]"><?php echo $data['SITE_DESCRIPTION']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_THEME" class="col-sm-3 col-md-2 control-label">桌面端主题</label>
                            <div class="col-sm-9 col-md-10">
                                <select id="SITE_THEME" class="form-control" name="data[SITE_THEME]">
                                    <?php if (is_array($theme)) {
                                        foreach ($theme as $t) {
                                            if (is_dir(THEME_PATH . $t)) { ?>
                                                <option value="<?php echo $t; ?>" <?php if ($data['SITE_THEME'] == $t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                            <?php }
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="SITE_MOBILE" class="col-sm-3 col-md-2 control-label">移动端主题</label>
                            <div class="col-sm-9 col-md-10">
                                <select id="SITE_MOBILE" class="form-control" name="data[SITE_MOBILE]">
                                    <?php if (is_array($theme)) {
                                        foreach ($theme as $t) {
                                            if (is_dir(THEME_PATH . $t)) { ?>
                                                <option value="<?php echo $t; ?>" <?php if ($data['SITE_MOBILE'] == $t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                            <?php }
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ICP_FILING_NUMBER" class="col-sm-3 col-md-2 control-label">ICP备案号</label>
                            <div class="col-sm-9 col-md-10">
                                <input id="ICP_FILING_NUMBER" class="form-control" type="text" size="30" placeholder="ICP备案号" name="data[ICP_FILING_NUMBER]" value="<?php echo $data['ICP_FILING_NUMBER']; ?>" />
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