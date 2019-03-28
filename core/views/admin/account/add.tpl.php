<?php include $this->admin_tpl('header'); ?>

<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '添加/修改后台用户';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/account'); ?>">全部账号</a>
		<a href="<?php echo url('admin/account/add'); ?>" class="add">添加账号</a>
		<a href="<?php echo url('admin/account/me'); ?>">我的账号</a>
	</div>
	<div class="bk10"></div>
	<div class="table_form">
		<form action="" method="post">
		<div class="col-tab">
			<ul class="tabBut cu-li">
				<li onClick="SwapTab('setting','on','',3, 1);" id="tab_setting_1" class="on">基本信息</li>
				<li onClick="SwapTab('setting','on','',3, 2);" id="tab_setting_2">系统权限</li>
				<li onClick="SwapTab('setting','on','',3, 3);" id="tab_setting_3">栏目设置</li>
			</ul>
			<div class="contentList pad-10" id="div_setting_1" style="display: block;">
				<table width="100%" class="table_form">
					<tr>
						<th width="100">账号：</th>
						<td><?php if ($data['username']) { echo $data['username'];} else { ?>
							<input class="input-text" type="text" name="data[username]" value="" size="30"/>
							<div class="show-tips">后台登陆账号</div><?php } ?>
						</td>
					</tr>
					<tr>
						<th>密码：</th>
						<td>
							<input class="input-text" type="text" name="data[password]" value="" size="30"/>
							<?php if ($data['username']) { ?><div class="show-tips">不修改密码，请留空。</div>
							<?php } else { ?><div class="show-tips">后台登陆密码</div><?php } ?>
						</td>
					</tr>
					<tr>
						<th>姓名：</th>
						<td>
							<input class="input-text" type="text" name="data[realname]" value="<?php echo $data['realname']; ?>" size="30"/>
							<div class="show-tips">账号显示姓名</div>
						</td>
					</tr>
					<tr>
						<th>超级管理员：</th>
						<td>
							<label><input name="data[roleid]" type="radio" value="1" <?php if ($data['roleid']) echo 'checked' ?>>是</label>&nbsp;&nbsp;&nbsp;
							<label><input name="data[roleid]" type="radio" value="0" <?php if (!$data['roleid']) echo 'checked' ?>>否</label>
							<div class="show-tips">超级管理员不受权限所控制(注:系统必须含有一个超级管理员，否则会出问题)</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="contentList pad-10" id="div_setting_2" style="display: none;">
				<div class="show-tips">模型管理包含了内容、会员、表单、自定义、等模型设置</div>
				<table width="100%" class="table_form">
					<tbody>
						<tr height="25" >
							<td align="left" width="100">
								<input name="auth[index-config]" value="1" id="c_index" type="checkbox" onClick="selectInput('index')" <?php if ($auth['index-config']) echo 'checked' ?>>
								<label for="c_index">系统设置</label>
							</td>
							<td align="left"></td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[account-index]" value="1" id="c_admin" type="checkbox" onClick="selectInput('admin')" <?php if ($auth['account-index']) echo 'checked' ?>>
								<label for="c_admin">账号管理</label>
							</td>
							<td align="left">
								<input class="c_admin" name="auth[account-add]" type="checkbox" value="1" <?php if ($auth['account-add']) echo 'checked' ?>><span>添加</span>
								<input class="c_admin" name="auth[account-edit]" type="checkbox" value="1" <?php if ($auth['account-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_admin" name="auth[account-del]" type="checkbox" value="1" <?php if ($auth['account-del']) echo 'checked' ?>><span>删除</span><div class="show-tips">开启此项也意味着赋予最大权限</div>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[category-index]" value="1" id="c_category" type="checkbox" onClick="selectInput('category')" <?php if ($auth['category-index']) echo 'checked' ?>>
								<label for="c_category">栏目管理</label>
							</td>
							<td align="left">
								<input class="c_category" name="auth[category-add]" type="checkbox" value="1" <?php if ($auth['category-add']) echo 'checked' ?> ><span>添加</span>
								<input class="c_category" name="auth[category-edit]" type="checkbox" value="1" <?php if ($auth['category-edit']) echo 'checked' ?> ><span>编辑</span>
								<input class="c_category" name="auth[category-del]" type="checkbox" value="1" <?php if ($auth['category-del']) echo 'checked' ?> ><span>删除</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[block-index]" value="1" id="c_block" type="checkbox" onClick="selectInput('block')" <?php if ($auth['block-index']) echo 'checked' ?>>
								<label for="c_block">区块管理</label>
							</td>
							<td align="left">
								<input class="c_block" name="auth[block-add]" type="checkbox" value="1" <?php if ($auth['block-add']) echo 'checked' ?> ><span>添加</span>
								<input class="c_block" name="auth[block-edit]" type="checkbox" value="1" <?php if ($auth['block-edit']) echo 'checked' ?> ><span>编辑</span>
								<input class="c_block" name="auth[block-del]" type="checkbox" value="1" <?php if ($auth['block-del']) echo 'checked' ?> ><span>删除</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[content-index]" value="1" id="c_content" type="checkbox" onClick="selectInput('content')"  <?php if ($auth['content-index']) echo 'checked' ?>>
								<label for="c_content">内容管理</label>
							</td>
							<td align="left">
								<input class="c_content" name="auth[content-add]" type="checkbox" value="1"  <?php if ($auth['content-add']) echo 'checked' ?> ><span>添加</span>
								<input class="c_content" name="auth[content-edit]" type="checkbox" value="1"  <?php if ($auth['content-edit']) echo 'checked' ?> ><span>编辑</span>
								<input class="c_content" name="auth[content-del]" type="checkbox" value="1"  <?php if ($auth['content-del']) echo 'checked' ?> ><span>删除</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[diytable-index]" value="1" id="c_diytable" type="checkbox" onClick="selectInput('diytable')" <?php if ($auth['diytable-index']) echo 'checked' ?>>
								<label for="c_diytable">自定义表</label>
							</td>
							<td align="left">
								<input class="c_diytable" name="auth[diytable-add]" type="checkbox" value="1"  <?php if ($auth['diytable-add']) echo 'checked' ?>><span>添加</span>
								<input class="c_diytable" name="auth[diytable-edit]" type="checkbox" value="1"  <?php if ($auth['diytable-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_diytable" name="auth[diytable-del]" type="checkbox" value="1"  <?php if ($auth['diytable-del']) echo 'checked' ?>><span>删除</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[form-index]" value="1" id="c_form" type="checkbox" onClick="selectInput('form')"  <?php if ($auth['form-index']) echo 'checked' ?>>
								<label for="c_form">表单管理</label>
							</td>
							<td align="left">
								<input class="c_form" name="auth[form-edit]" type="checkbox" value="1" <?php if ($auth['form-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_form" name="auth[form-del]" type="checkbox" value="1" <?php if ($auth['form-del']) echo 'checked' ?>><span>删除</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[member-index]" value="1" id="c_member" type="checkbox" onClick="selectInput('member')" <?php if ($auth['member-index']) echo 'checked' ?>>
								<label for="c_member">会员管理</label>
							</td>
							<td align="left">
								<input class="c_member" name="auth[member-edit]" type="checkbox" value="1" <?php if ($auth['member-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_member" name="auth[member-del]" type="checkbox" value="1" <?php if ($auth['member-del']) echo 'checked' ?>><span>删除</span>
							</td>
						</tr>

						<tr height="25">
							<td align="left">
								<input name="auth[template-index]" value="1" id="c_template" type="checkbox" onClick="selectInput('template')"  <?php if ($auth['template-index']) echo 'checked' ?>>
								<label for="c_template">模板管理</label>
							</td>
							<td align="left">
								<input class="c_template" name="auth[template-add]" type="checkbox" value="1" <?php if ($auth['template-add']) echo 'checked' ?>><span>添加</span>
								<input class="c_template" name="auth[template-edit]" type="checkbox" value="1" <?php if ($auth['template-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_template" name="auth[template-updatefilename]" type="checkbox" value="1" <?php if ($auth['template-updatefilename']) echo 'checked' ?>><span>备注</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[database-index]" value="1" id="c_database" type="checkbox" onClick="selectInput('database')" <?php if ($auth['database-index']) echo 'checked' ?>>
								<label for="c_database">数据备份</label>
							</td>
							<td align="left">
								<input class="c_database" name="auth[database-import]" type="checkbox" value="1" <?php if ($auth['database-import']) echo 'checked' ?>><span>数据恢复</span>
								<input class="c_database" name="auth[database-repair]" type="checkbox" value="1" <?php if ($auth['database-repair']) echo 'checked' ?>><span>修复表</span>
								<input class="c_database" name="auth[database-optimize]" type="checkbox" value="1" <?php if ($auth['database-optimize']) echo 'checked' ?>><span>优化表</span>
								<input class="c_database" name="auth[database-table]" type="checkbox" value="1" <?php if ($auth['database-table']) echo 'checked' ?>><span>查看表结构</span>
							</td>
						</tr>
						<tr height="25">
							<td align="left">
								<input name="auth[createhtml-index]" value="1" id="c_createhtml" type="checkbox" onClick="selectInput('createhtml')" <?php if ($auth['createhtml-index']) echo 'checked' ?>>
								<label for="c_createhtml">生成静态</label>
							</td>
							<td align="left">
								<input class="c_createhtml" name="auth[createhtml-category]" type="checkbox" value="1" <?php if ($auth['createhtml-category']) echo 'checked' ?>><span>生成栏目</span>
								<input class="c_createhtml" name="auth[createhtml-one_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-one_cat']) echo 'checked' ?>><span>生成栏目附加</span>
								<input class="c_createhtml" name="auth[createhtml-all_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-all_cat']) echo 'checked' ?>><span>生成栏目附加</span>
								<input class="c_createhtml" name="auth[createhtml-show]" type="checkbox" value="1" <?php if ($auth['createhtml-show']) echo 'checked' ?>><span>生成内容页</span>
								<input class="c_createhtml" name="auth[createhtml-all_show]" type="checkbox" value="1" <?php if ($auth['createhtml-all_show']) echo 'checked' ?>><span>生成内容页附加</span>
							</td>
						</tr>

						<tr height="25">
							<td align="left">
								<input name="auth[models-index]" value="1" id="c_models" type="checkbox" onClick="selectInput('models')" <?php if ($auth['models-index']) echo 'checked' ?>>
								<label for="c_models">模型管理</label>
							</td>
							<td align="left">
								<input class="c_models" name="auth[models-add]" type="checkbox" value="1" <?php if ($auth['models-add']) echo 'checked' ?>><span>添加</span>
								<input class="c_models" name="auth[models-edit]" type="checkbox" value="1" <?php if ($auth['models-edit']) echo 'checked' ?>><span>编辑</span>
								<input class="c_models" name="auth[models-del]" type="checkbox" value="1" <?php if ($auth['models-del']) echo 'checked' ?>><span>删除</span>
								<input class="c_models" name="auth[models-field]" type="checkbox" value="1" <?php if ($auth['models-field']) echo 'checked' ?>><span>字段管理</span>
								<input class="c_models" name="auth[models-addfield]" type="checkbox" value="1" <?php if ($auth['models-addfield']) echo 'checked' ?>><span>添加字段</span>
								<input class="c_models" name="auth[models-editfield]" type="checkbox" value="1" <?php if ($auth['models-editfield']) echo 'checked' ?>><span>修改字段</span>
								<input class="c_models" name="auth[models-delfield]" type="checkbox" value="1" <?php if ($auth['models-delfield']) echo 'checked' ?>><span>删除字段</span>
								<input class="c_models" name="auth[models-disable]" type="checkbox" value="1" <?php if ($auth['models-disable']) echo 'checked' ?>><span>禁用/启用</span>
							</td>
						</tr>

					</tbody>
				</table>
			</div>
			<div class="contentList pad-10" id="div_setting_3" style="display: none;">
				<div class="show-tips">禁止管理的栏目</div>
				<ul width="100%" class="table_form">
					<?php if (is_array($cats)) foreach ($cats as $k=>$v) { ?>
					<?php if ($v['typeid']!=1) continue; ?>
					<li>
						<input id="catid-checkbox-<?php echo $v['catid']; ?>" class="c_add" type="checkbox" value="1" name="auth[catid-<?php echo $v['catid']; ?>]" <?php if ($auth['catid-'.$v['catid']]) echo 'checked' ?>>
						<label for="catid-checkbox-<?php echo $v['catid']; ?>"><?php echo $v['catname']; ?></label>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="bk15"></div>
			<input class="button" type="submit" name="submit" value="提交"/>
		</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	function SwapTab(name,cls_show,cls_hide,cnt,cur) {
		for(i=1;i<=cnt;i++) {
			if (i==cur) {
				$('#div_'+name+'_'+i).show();
				$('#tab_'+name+'_'+i).attr('class',cls_show);
			} else {
				$('#div_'+name+'_'+i).hide();
				$('#tab_'+name+'_'+i).attr('class',cls_hide);
			}
		}
	}
	function selectInput(c) {
		if ($("#c_"+c).prop('checked')==true) {
			$(".c_"+c).prop("checked", true);
		} else {
			$(".c_"+c).prop("checked", false);
		}
	}
</script>
</body>
</html>