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
                <a class="list-group-item active" href="<?php echo url('admin/config'); ?>">基础设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">系统设置</span>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">站点信息</a></li>
                    <li role="presentation"><a href="#watermark" aria-controls="watermark" role="tab" data-toggle="tab">图片水印</a></li>
                    <li role="presentation"><a href="#member" aria-controls="member" role="tab" data-toggle="tab">会员设置</a></li>
                    <li role="presentation"><a href="#url" aria-controls="url" role="tab" data-toggle="tab">URL设置</a></li>
                    <li role="presentation"><a href="#weixin" aria-controls="weixin" role="tab" data-toggle="tab">微信设置</a></li>
                </ul>
                <form method="post" action="" class="form-inline">
                    <div class="tab-content">
                        <div role="tabpanel" id="basic" class="tab-pane active">
                            <table width="100%" class="table_form">
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
                            </table>
                        </div>
                        <div role="tabpanel" id="watermark" class="tab-pane">
                            <table width="100%" class="table_form ">
                                <tr>
                                    <th width="100">水印类型：</th>
                                    <td>
                                        <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK'] == 1) { ?>checked<?php } ?> onClick="setSateType(1)">图片水印</label>
                                        <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK'] == 2) { ?>checked<?php } ?> onClick="setSateType(2)">文字水印</label>
                                        <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK'] == 0) { ?>checked<?php } ?> onClick="setSateType(0)">关闭</label>
                                    </td>
                                </tr>
                                <tbody id="w_0">
                                    <tr id="w_1">
                                        <th>图片透明度：</th>
                                        <td><input class="form-control" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25" />
                                            <div class="show-tips">填写范围（0-99），图片目录：/static/watermark/watermark.png</div>
                                        </td>
                                    </tr>
                                    <tr class="w_2">
                                        <th>水印文字：</th>
                                        <td><input class="form-control" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25" />
                                            <div class="show-tips">默认字体文件：/static/fonts/elephant.ttf（若有中文请下载字体文件覆盖）</div>
                                        </td>
                                    </tr>
                                    <tr class="w_2">
                                        <th>文字大小：</th>
                                        <td><input class="form-control" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25" />
                                            <div class="show-tips">单位像素，默认14</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>水印位置：</th>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 1) { ?>checked="" <?php } ?> value="1" name="data[SITE_WATERMARK_POS]">顶部居左</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 2) { ?>checked="" <?php } ?> value="2" name="data[SITE_WATERMARK_POS]">顶部居中</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 3) { ?>checked="" <?php } ?> value="3" name="data[SITE_WATERMARK_POS]">顶部居右</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 4) { ?>checked="" <?php } ?> value="4" name="data[SITE_WATERMARK_POS]">中部居左</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 5) { ?>checked="" <?php } ?> value="5" name="data[SITE_WATERMARK_POS]">中部居中</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 6) { ?>checked="" <?php } ?> value="6" name="data[SITE_WATERMARK_POS]">中部居右</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 7) { ?>checked="" <?php } ?> value="7" name="data[SITE_WATERMARK_POS]">底部居左</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 8) { ?>checked="" <?php } ?> value="8" name="data[SITE_WATERMARK_POS]">底部居中</label></td>
                                                    <td><label class="label-group"><input type="radio" <?php if (empty($data['SITE_WATERMARK_POS'])) { ?>checked="" <?php } ?> value="" name="data[SITE_WATERMARK_POS]">底部居右</label></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr>
                                    <th>缩略图宽高：</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6" />
                                        x&nbsp;
                                        <input class="form-control" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6" />
                                        &nbsp;px
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="member">
                            <table width="100%" class="table_form">
                                <tr>
                                    <th width="150">默认会员模型：</th>
                                    <td>
                                        <select name="data[MEMBER_MODELID]" class="form-control">
                                            <option value="0">==会员模型==</option>
                                            <?php if (is_array($membermodel)) {
                                                foreach ($membermodel as $t) { ?>
                                                    <option value="<?php echo $t['modelid']; ?>" <?php if ($data['MEMBER_MODELID'] == $t['modelid']) { ?>selected<?php } ?>><?php echo $t['modelname']; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>新会员注册：</th>
                                    <td>
                                        <label class="label-group"><input name="data[MEMBER_REGISTER]" type="radio" value="1" <?php if ($data['MEMBER_REGISTER'] == 1) { ?>checked<?php } ?>>打开</label>
                                        <label class="label-group"><input name="data[MEMBER_REGISTER]" type="radio" value="0" <?php if ($data['MEMBER_REGISTER'] == 0) { ?>checked<?php } ?>>关闭</label>
                                        <div class="show-tips">关闭后 后台顶部导航不显示会员连接，不需要会员功能建议关闭</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>新会员审核：</th>
                                    <td>
                                        <label class="label-group"><input name="data[MEMBER_STATUS]" type="radio" value="1" <?php if ($data['MEMBER_STATUS'] == 1) { ?>checked<?php } ?>>打开</label>
                                        <label class="label-group"><input name="data[MEMBER_STATUS]" type="radio" value="0" <?php if ($data['MEMBER_STATUS'] == 0) { ?>checked<?php } ?>>关闭</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>注册验证码：</th>
                                    <td>
                                        <label class="label-group"><input name="data[MEMBER_REGCODE]" type="radio" value="1" <?php if ($data['MEMBER_REGCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                        <label class="label-group"><input name="data[MEMBER_REGCODE]" type="radio" value="0" <?php if ($data['MEMBER_REGCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>登录验证码：</th>
                                    <td>
                                        <label class="label-group"><input name="data[MEMBER_LOGINCODE]" type="radio" value="1" <?php if ($data['MEMBER_LOGINCODE'] == 1) { ?>checked<?php } ?>>打开</label>
                                        <label class="label-group"><input name="data[MEMBER_LOGINCODE]" type="radio" value="0" <?php if ($data['MEMBER_LOGINCODE'] == 0) { ?>checked<?php } ?>>关闭</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="url">
                            <table width="100%" class="table_form">
                                <tbody>
                                    <tr>
                                        <th>URL入口文件：</th>
                                        <td>
                                            <label class="label-group"><input name="data[HIDE_ENTRY_FILE]" type="radio" value="false" <?php if (!$data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>显示</label>
                                            <label class="label-group"><input name="data[HIDE_ENTRY_FILE]" type="radio" value="true" <?php if ($data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>隐藏</label>
                                            <div class="show-tips"><?php echo $configTips['HIDE_ENTRY_FILE']; ?></div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <th width="150">URL显示模式：</th>
                                        <td>
                                            <label class="label-group"><input name="data[DIY_URL]" type="radio" value="0" <?php if (!$data['DIY_URL']) { ?>checked<?php } ?> onClick="set_url_type();">普通模式</label>
                                            <label class="label-group"><input name="data[DIY_URL]" type="radio" value="1" <?php if ($data['DIY_URL'] == 1) { ?>checked<?php } ?> onClick="set_url_type('diy');">伪静态</label>
                                            <label class="label-group"><input name="data[DIY_URL]" type="radio" value="2" <?php if ($data['DIY_URL'] == 2) { ?>checked<?php } ?> onClick="set_url_type('diy');">静态</label>
                                            <div class="show-tips">伪静态需要服务器支持并配置相关规则文件。更改模式后需 <a href="<?php echo url('admin/content/updateurl'); ?>">更新内容URL</a> 才生效</div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="url-type-diy" style="display:<?php if (!$data['DIY_URL']) { ?>none<?php } ?>">
                                    <tr>
                                        <th width="150">栏目URL格式：</th>
                                        <td>
                                            <input class="form-control" type="text" name="data[LIST_URL]" value="<?php echo $data['LIST_URL']; ?>" size="40" />
                                            <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示栏目ID ，{page}表示分页参数</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>栏目URL格式(带分页)：</th>
                                        <td>
                                            <input class="form-control" type="text" name="data[LIST_PAGE_URL]" value="<?php echo $data['LIST_PAGE_URL']; ?>" size="40" />
                                            <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示栏目ID ，{page}表示分页参数</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>内容展示页：</th>
                                        <td>
                                            <input class="form-control" type="text" name="data[SHOW_URL]" value="<?php echo $data['SHOW_URL']; ?>" size="40" />
                                            <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示内容ID ，{page}表示分页参数 备注：&nbsp;{id}必须存在</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>内容展示页(带分页)：</th>
                                        <td>
                                            <input class="form-control" type="text" name="data[SHOW_PAGE_URL]" value="<?php echo $data['SHOW_PAGE_URL']; ?>" size="40" />
                                            <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示内容ID ，{page}表示分页参数 备注：&nbsp;{id}必须存在</div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="url-type-default" style="display:<?php if ($data['DIY_URL']) { ?>none<?php } ?>">
                                    <tr>
                                        <th>栏目参数格式：</th>
                                        <td>
                                            <label class="label-group"><input name="data[URL_LIST_TYPE]" type="radio" value="false" <?php if (!$data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目ID</label>
                                            <label class="label-group"><input name="data[URL_LIST_TYPE]" type="radio" value="true" <?php if ($data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目目录</label>
                                            <div class="show-tips"><?php echo $configTips['URL_LIST_TYPE']; ?></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="weixin">
                            <table width="100%" class="table_form">
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
                        </div>
                    </div>
                    <hr />
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>