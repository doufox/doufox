<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="page_menu">
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
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">基本设置</span>
                </div>
                <table width="100%" class="table_form table table-bordered">
                    <tr>
                        <th width="100">网站名称：</th>
                        <td>
                            <input class="form-control" type="text" name="data[SITE_NAME]" value="<?php echo $data['SITE_NAME']; ?>" size="30" />
                            <div class="show-tips"><?php echo $configTips['SITE_NAME']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>网站头部标语：</th>
                        <td><input class="form-control" type="text" name="data[SITE_SLOGAN]" value="<?php echo $data['SITE_SLOGAN']; ?>" size="50" />
                            <div class="show-tips"><?php echo $configTips['SITE_SLOGAN']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>首页标题：</th>
                        <td>
                            <input class="form-control" type="text" name="data[SITE_TITLE]" value="<?php echo $data['SITE_TITLE']; ?>" size="50" />
                            <div class="show-tips"><?php echo $configTips['SITE_TITLE']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>关键字：</th>
                        <td class="y-bg">
                            <input class="form-control" type="text" name="data[SITE_KEYWORDS]" value="<?php echo $data['SITE_KEYWORDS']; ?>" size="50" />
                            <div class="show-tips"><?php echo $configTips['SITE_KEYWORDS']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>网站描述：</th>
                        <td>
                            <textarea class="form-control" name="data[SITE_DESCRIPTION]" rows="3" cols="55"><?php echo $data['SITE_DESCRIPTION']; ?></textarea>
                            <div class="show-tips"><?php echo $configTips['SITE_DESCRIPTION']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>桌面端主题：</th>
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
                            <div class="show-tips"><?php echo $configTips['SITE_THEME']; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <th>移动端主题：</th>
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
                            <div class="show-tips"><?php echo $configTips['SITE_MOBILE']; ?></div>
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