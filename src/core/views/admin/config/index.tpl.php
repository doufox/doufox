<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">系统设置</span></div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/config'); ?>">基本设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/attachment'); ?>">附件</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信公众号</a>
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
                        <table class="table_form">
                            <tr>
                                <th>网站名称</th>
                                <td>
                                    <input class="form-control" type="text" size="30" placeholder="网站名称" name="data[SITE_NAME]" value="<?php echo $data['SITE_NAME']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>网站品牌标语</th>
                                <td>
                                    <input class="form-control" type="text" size="50" placeholder="网站品牌宣传标语" name="data[SITE_SLOGAN]" value="<?php echo $data['SITE_SLOGAN']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>网站SEO标题</th>
                                <td>
                                    <input class="form-control" type="text" size="50" placeholder="网站SEO标题" name="data[SITE_TITLE]" value="<?php echo $data['SITE_TITLE']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>网站SEO关键字</th>
                                <td>
                                    <input class="form-control" type="text" size="50" placeholder="网站SEO关键字" name="data[SITE_KEYWORDS]" value="<?php echo $data['SITE_KEYWORDS']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <th>网站SEO描述</th>
                                <td>
                                    <textarea class="form-control" rows="3" cols="55" placeholder="网站SEO描述信息" name="data[SITE_DESCRIPTION]"><?php echo $data['SITE_DESCRIPTION']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>桌面端主题</th>
                                <td>
                                    <select class="form-control" name="data[SITE_THEME]">
                                        <?php if (is_array($theme)) {
                                            foreach ($theme as $t) {
                                                if (is_dir(THEME_PATH . $t)) { ?>
                                                    <option value="<?php echo $t; ?>" <?php if ($data['SITE_THEME'] == $t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                                <?php }
                                            }
                                        } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>移动端主题</th>
                                <td>
                                    <select class="form-control" name="data[SITE_MOBILE]">
                                        <?php if (is_array($theme)) {
                                            foreach ($theme as $t) {
                                                if (is_dir(THEME_PATH . $t)) { ?>
                                                    <option value="<?php echo $t; ?>" <?php if ($data['SITE_MOBILE'] == $t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                                <?php }
                                            }
                                        } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>网站ICP备案号</th>
                                <td>
                                    <input class="form-control" type="text" size="30" placeholder="网站ICP备案号（如：沪ICP备12345678号）" name="data[ICP_FILING_NUMBER]" value="<?php echo $data['ICP_FILING_NUMBER']; ?>" />
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

<?php include $this->admin_view('footer'); ?>