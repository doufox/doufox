<?php include $this->admin_tpl('header');?>

<div class="subnav">
    <div class="table_form">
        <form method="post" action="" id="myform" name="myform">
        <div class="pad-10">
            <div class="col-tab">
                <ul class="tabBut cu-li">
                    <li onClick="SwapTab('setting','on','',7,1);" id="tab_setting_1" class="<?php if ($type==1) { ?>on<?php } ?>">系统设置</li>
                    <li onClick="SwapTab('setting','on','',7,2);" id="tab_setting_2" class="<?php if ($type==2) { ?>on<?php } ?>">水印设置</li>
                    <li onClick="SwapTab('setting','on','',7,3);" id="tab_setting_3" class="<?php if ($type==3) { ?>on<?php } ?>">暂无设置</li>
                    <li onClick="SwapTab('setting','on','',7,4);" id="tab_setting_4" class="<?php if ($type==4) { ?>on<?php } ?>">会员设置</li>
                    <li onClick="SwapTab('setting','on','',7,5);" id="tab_setting_5" class="<?php if ($type==5) { ?>on<?php } ?>">URL设置</li>
                    <li onClick="SwapTab('setting','on','',7,6);" id="tab_setting_6" class="<?php if ($type==6) { ?>on<?php } ?>">微信设置</li>
                </ul>
                <div class="contentList pad-10" id="div_setting_1" style="display: none;">
                    <table width="100%" class="table_form">
                        <tr>
                            <th width="100">网站名称：</th>
                            <td>
                                <input class="input-text" type="text" name="data[SITE_NAME]" value="<?php echo $data['SITE_NAME']; ?>" size="30"/>
                                <div class="show-tips"><?php echo $configTips['SITE_NAME']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>桌面端主题样式：</th>
                            <td>
                                <select name="data[SITE_THEME]">
                                <?php if (is_array($theme)) { foreach ($theme as $t) { if (is_dir(THEME_PATH_D . $t)) { ?>
                                <option value="<?php echo $t; ?>" <?php if ($data['SITE_THEME']==$t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                <?php } } } ?>
                                </select>
                                <div class="show-tips"><?php echo $configTips['SITE_THEME']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>移动端主题样式：</th>
                            <td>
                                <select class="config-theme-m" name="data[SITE_THEME_MOBILE]" <?php if ($data['SITE_MOBILE'] !== true) { echo 'disabled'; }?>>
                                    <?php if (is_array($theme_mobile)) { foreach ($theme_mobile as $t) { if (is_dir(THEME_PATH_M . $t)) { ?>
                                    <option value="<?php echo $t; ?>" <?php if ($data['SITE_THEME_MOBILE']==$t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                                    <?php } } } ?>
                                </select>
                                <label><input name="data[SITE_MOBILE]" type="radio" value="true" <?php if ($data['SITE_MOBILE']==true) { ?>checked<?php } ?> onClick="$('.config-theme-m').prop('disabled', false);" />打开</label>
                                &nbsp;&nbsp;&nbsp;
                                <label><input name="data[SITE_MOBILE]" type="radio" value="false" <?php if (empty($data['SITE_MOBILE'])) { ?>checked<?php } ?>  onClick="$('.config-theme-m').prop('disabled', true);"/>关闭</label>
                                <div class="show-tips"><?php echo $configTips['SITE_MOBILE']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>首页标题：</th>
                            <td>
                                <input class="input-text" type="text" name="data[SITE_TITLE]" value="<?php echo $data['SITE_TITLE']; ?>" size="50"/>
                                <div class="show-tips"><?php echo $configTips['SITE_TITLE']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>头部标语：</th>
                            <td><input class="input-text" type="text" name="data[SITE_SLOGAN]" value="<?php echo $data['SITE_SLOGAN']; ?>" size="50"/>
                            <div class="show-tips"><?php echo $configTips['SITE_SLOGAN']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>关键字：</th>
                            <td class="y-bg">
                                <input class="input-text" type="text" name="data[SITE_KEYWORDS]" value="<?php echo $data['SITE_KEYWORDS']; ?>" size="50"/>
                                <div class="show-tips"><?php echo $configTips['SITE_KEYWORDS']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>网站描述：</th>
                            <td>
                                <textarea name="data[SITE_DESCRIPTION]" rows="3" cols="55" class="text"><?php echo $data['SITE_DESCRIPTION']; ?></textarea>
                                <div class="show-tips"><?php echo $configTips['SITE_DESCRIPTION']; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
                    <table width="100%" class="table_form ">
                        <tr>
                            <th width="100">水印类型：</th>
                            <td>
                                <label><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK']==1) { ?>checked<?php } ?> onClick="setSateType(1)">图片水印</label>
                                &nbsp;&nbsp;&nbsp;
                                <label><input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK']==2) { ?>checked<?php } ?> onClick="setSateType(2)">文字水印</label>
                                &nbsp;&nbsp;&nbsp;
                                <label><input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK']==0) { ?>checked<?php } ?> onClick="setSateType(0)">关闭</label>
                        </td>
                        </tr>
                        <tbody id="w_0">
                            <tr id="w_1">
                                <th>水印图片透明度：</th>
                                <td><input class="input-text" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25"/>
                                <div class="show-tips">填写范围（0-99），图片目录：/static/watermark/watermark.png</div></td>
                            </tr>
                            <tr class="w_2">
                                <th>水印文字：</th>
                                <td><input class="input-text" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25"/>
                                <div class="show-tips">默认字体文件：/static/fonts/elephant.ttf（若有中文请下载字体文件覆盖）</div></td>
                            </tr>
                            <tr class="w_2">
                                <th>文字大小：</th>
                                <td><input class="input-text" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25"/>
                                <div class="show-tips">单位像素，默认14</div></td>
                            </tr>
                            <tr>
                                <th>水印位置：</th>
                                <td>
                                    <table>
                                        <tr>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==1) { ?>checked=""<?php } ?> value="1" name="data[SITE_WATERMARK_POS]">顶部居左</label></td>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==2) { ?>checked=""<?php } ?> value="2" name="data[SITE_WATERMARK_POS]">顶部居中</label></td>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==3) { ?>checked=""<?php } ?> value="3" name="data[SITE_WATERMARK_POS]">顶部居右</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==4) { ?>checked=""<?php } ?> value="4" name="data[SITE_WATERMARK_POS]">中部居左</label></td>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==5) { ?>checked=""<?php } ?> value="5" name="data[SITE_WATERMARK_POS]">中部居中</label></td>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==6) { ?>checked=""<?php } ?> value="6" name="data[SITE_WATERMARK_POS]">中部居右</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==7) { ?>checked=""<?php } ?> value="7" name="data[SITE_WATERMARK_POS]">底部居左</label></td>
                                            <td><label><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==8) { ?>checked=""<?php } ?> value="8" name="data[SITE_WATERMARK_POS]">底部居中</label></td>
                                            <td><label><input type="radio" <?php if (empty($data['SITE_WATERMARK_POS'])) { ?>checked=""<?php } ?> value="" name="data[SITE_WATERMARK_POS]">底部居右</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <th>缩略图宽高：</th>
                            <td>
                            <input class="input-text" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6"/>
                            x&nbsp;
                            <input class="input-text" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6"/>
                            &nbsp;px
                            </td>
                        </tr>
                    </table>
                    <script type="text/javascript">
                        function setSateType(id) {
                            if (id == 0) {
                                $('#w_1').hide();
                                $('.w_2').hide();
                                $('#w_0').hide();
                            } else if(id == 1) {
                                $('.w_2').hide();
                                $('#w_1').show();
                                $('#w_0').show();
                            } else if(id == 2) {
                                $('#w_1').hide();
                                $('.w_2').show();
                                $('#w_0').show();
                            }
                        }
                        setSateType(<?php echo $data['SITE_WATERMARK']; ?>);
                    </script>
                </div>

                <div class="contentList pad-10 hidden" id="div_setting_3" style="display: none;">
                    <div>暂无</div>
                    <!-- <table width="100%" class="table_form">
                        <tr>
                            <th width="100">管理员帐号：</th>
                            <td><input class="input-text" type="text" name="admin[ADMIN_NAME]" value="<?php echo $admin['ADMIN_NAME']; ?>" size="30"/><div class="show-tips">后台帐号管理员</div></td>
                        </tr>
                        <tr>
                            <th>管理员密码：</th>
                            <td><input class="input-text" type="text" name="admin[ADMIN_PASS]" value="" size="30"/><div class="show-tips">如果不修改请留空</div></td>
                        </tr>
                    </table> -->
                </div>

                <div class="contentList pad-10 hidden" id="div_setting_4" style="display: none;" >
                    <table width="100%" class="table_form">
                    <tr>
                        <th width="150">默认会员模型：</th>
                        <td>
                            <select name="data[MEMBER_MODELID]">
                                <option value="0"> -- </option>
                        <?php if (is_array($membermodel)) {foreach ($membermodel as $t) { ?>
                                <option value="<?php echo $t['modelid']; ?>" <?php if ($data['MEMBER_MODELID']==$t['modelid']) { ?>selected<?php } ?>><?php echo $t['modelname']; ?></option>
                        <?php } } ?></select></td>
                    </tr>

                    <tr>
                        <th>新会员注册：</th>
                        <td>
                            <label><input name="data[MEMBER_REGISTER]" type="radio" value="1" <?php if ($data['MEMBER_REGISTER']==1) { ?>checked<?php } ?>>打开</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input name="data[MEMBER_REGISTER]" type="radio" value="0" <?php if ($data['MEMBER_REGISTER']==0) { ?>checked<?php } ?>>关闭</label>
                            <div class="show-tips">关闭后 后台顶部导航不显示会员连接，不需要会员功能建议关闭</div>
                        </td>
                    </tr>
                    <tr>
                        <th>新会员审核：</th>
                        <td>
                            <label><input name="data[MEMBER_STATUS]" type="radio" value="1" <?php if ($data['MEMBER_STATUS']==1) { ?>checked<?php } ?>>打开</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input name="data[MEMBER_STATUS]" type="radio" value="0" <?php if ($data['MEMBER_STATUS']==0) { ?>checked<?php } ?>>关闭</label>
                        </td>
                    </tr>
                    <tr>
                        <th>注册验证码：</th>
                        <td>
                            <label><input name="data[MEMBER_REGCODE]" type="radio" value="1" <?php if ($data['MEMBER_REGCODE']==1) { ?>checked<?php } ?>>打开</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input name="data[MEMBER_REGCODE]" type="radio" value="0" <?php if ($data['MEMBER_REGCODE']==0) { ?>checked<?php } ?>>关闭</label>
                        </td>
                    </tr>
                    <tr>
                        <th>登录验证码：</th>
                        <td>
                            <label><input name="data[MEMBER_LOGINCODE]" type="radio" value="1" <?php if ($data['MEMBER_LOGINCODE']==1) { ?>checked<?php } ?>>打开</label>
                            &nbsp;&nbsp;&nbsp;
                            <label><input name="data[MEMBER_LOGINCODE]" type="radio" value="0" <?php if ($data['MEMBER_LOGINCODE']==0) { ?>checked<?php } ?>>关闭</label>
                        </td>
                    </tr>
                    </table>
                </div>

                <div class="contentList pad-10 hidden" id="div_setting_5" style="display: none;">
                    <table width="100%" class="table_form">
                        <tbody>
                            <tr>
                                <th>URL入口文件：</th>
                                <td>
                                    <label><input name="data[HIDE_ENTRY_FILE]" type="radio" value="false" <?php if (!$data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>显示</label>&nbsp;&nbsp;
                                    <label><input name="data[HIDE_ENTRY_FILE]" type="radio" value="true" <?php if ($data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>隐藏</label>&nbsp;&nbsp;
                                    <div class="show-tips"><?php echo $configTips['HIDE_ENTRY_FILE']; ?></div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th width="150">URL显示模式：</th>
                                <td>
                                    <label><input name="data[DIY_URL]" type="radio" value="0" <?php if (!$data['DIY_URL']) { ?>checked<?php } ?> onClick="set_url_type();">动态</label>&nbsp;&nbsp;
                                    <label><input name="data[DIY_URL]" type="radio" value="1" <?php if ($data['DIY_URL']==1) { ?>checked<?php } ?> onClick="set_url_type('diy');">伪静态</label>&nbsp;&nbsp;
                                    <label><input name="data[DIY_URL]" type="radio" value="2" <?php if ($data['DIY_URL']==2) { ?>checked<?php } ?> onClick="set_url_type('diy');">静态</label>&nbsp;&nbsp;
                                    <div class="show-tips">伪静态需要服务器支持并配置相关规则文件。更改模式后需 <a href="<?php echo url('admin/content/updateurl'); ?>">更新内容URL</a> 才生效</div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="url-type-diy" style="display:<?php if (!$data['DIY_URL']) { ?>none<?php } ?>">
                            <tr>
                                <th width="150">栏目URL格式：</th>
                                <td>
                                    <input class="input-text" type="text" name="data[LIST_URL]" value="<?php echo $data['LIST_URL']; ?>" size="40"/>
                                    <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示栏目ID ，{page}表示分页参数</div>
                                </td>
                            </tr>
                            <tr>
                                <th>栏目URL格式(带分页)：</th>
                                <td>
                                    <input class="input-text" type="text" name="data[LIST_PAGE_URL]" value="<?php echo $data['LIST_PAGE_URL']; ?>" size="40"/>
                                    <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示栏目ID ，{page}表示分页参数</div>
                                </td>
                            </tr>
                            <tr>
                                <th>内容展示页：</th>
                                <td>
                                    <input class="input-text" type="text" name="data[SHOW_URL]" value="<?php echo $data['SHOW_URL']; ?>" size="40"/>
                                    <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示内容ID ，{page}表示分页参数 备注：&nbsp;{id}必须存在</div>
                                </td>
                            </tr>
                            <tr>
                                <th>内容展示页(带分页)：</th>
                                <td>
                                    <input class="input-text" type="text" name="data[SHOW_PAGE_URL]" value="<?php echo $data['SHOW_PAGE_URL']; ?>" size="40"/>
                                    <div class="show-tips">参数说明：&nbsp;{dir} 表示栏目目录 ，{id} 表示内容ID ，{page}表示分页参数 备注：&nbsp;{id}必须存在</div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="url-type-default" style="display:<?php if ($data['DIY_URL']) { ?>none<?php } ?>">
                            <tr>
                                <th>栏目参数格式：</th>
                                <td>
                                    <label><input name="data[URL_LIST_TYPE]" type="radio" value="false" <?php if (!$data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目ID</label>&nbsp;&nbsp;
                                    <label><input name="data[URL_LIST_TYPE]" type="radio" value="true" <?php if ($data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目目录</label>&nbsp;&nbsp;
                                    <div class="show-tips"><?php echo $configTips['URL_LIST_TYPE']; ?></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="contentList pad-10 hidden" id="div_setting_6" style="display: none;">
                    <table width="100%" class="table_form">
                        <tr>
                            <th>微信公众号：</th>
                            <td>
                                <label><input name="data[WEIXIN_MP_OPENED]" type="radio" value="true" <?php if ($data['WEIXIN_MP_OPENED']==1) { ?>checked<?php } ?>>打开</label>
                                &nbsp;&nbsp;&nbsp;
                                <label><input name="data[WEIXIN_MP_OPENED]" type="radio" value="false" <?php if ($data['WEIXIN_MP_OPENED']==0) { ?>checked<?php } ?>>关闭</label>
                                <div class="show-tips"><?php echo $configTips['WEIXIN_MP_OPENED']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">URL：</th>
                            <td>
                                <input class="input-text" readonly="readonly" type="text" name="data[WEIXIN_MP_URL]" value="<?php echo $data['WEIXIN_MP_URL']?>" size="60" />
                                <div class="show-tips"><?php echo $configTips['WEIXIN_MP_URL']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Token：</th>
                            <td>
                                <input class="input-text" type="text" name="data[WEIXIN_MP_TOKEN]" value="<?php echo $data['WEIXIN_MP_TOKEN']; ?>" size="32" />
                                <div class="show-tips"><?php echo $configTips['WEIXIN_MP_TOKEN']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th>加密密钥：</th>
                            <td>
                                <input class="input-text" type="text" name="data[WEIXIN_MP_AESKEY]" value="<?php echo $data['WEIXIN_MP_AESKEY']; ?>" size="43" />
                                <div class="show-tips"><?php echo $configTips['WEIXIN_MP_AESKEY']; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="bk15"></div>
                <input type="submit" class="button" value="提交" name="submit">
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	$('#div_setting_<?php echo $type; ?>').show();
	function SwapTab(name, cls_show, cls_hide, cnt, cur) {
		for (i = 1; i <= cnt; i++) {
			if (i == cur) {
				$('#div_'+name+'_'+i).show();
				$('#tab_'+name+'_'+i).attr('class', cls_show);
			} else {
				$('#div_'+name+'_'+i).hide();
				$('#tab_'+name+'_'+i).attr('class', cls_hide);
			}
		}
	}
    function set_url_type(type) {
        if (type && type =='diy') {
            $('.url-type-diy').show();
            $('.url-type-default').hide();
        } else {
            $('.url-type-diy').hide();
            $('.url-type-default').show();
        }
    }
</script>
</body>
</html>