<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '表单配置';
</script>

<div class="subnav">
	<div class="content-menu">
<?php if (!$join) { ?>	<a href="<?php echo url('index/form',array('modelid'=>$modelid)); ?>" class="add"  target="_blank"><em>发布内容</em></a><?php };?>
		<a href="<?php echo url('admin/form/list',array('modelid'=>$modelid,'cid'=>$cid)); ?>" class="on"><em>信息管理</em></a>
		<a href="<?php echo url('admin/form/config',array('modelid'=>$modelid, 'cid'=>$cid)); ?>" class="on"><em>表单设置</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list">
		<form method="post" action="" id="myform" name="myform">
		<input type="hidden" value="<?php echo $catid; ?>" name="catid">
		<input type="hidden" value="<?php echo $data['typeid']; ?>" name="typeid">
		<div class="col-tab">
			<ul class="tabBut cu-li">
				<li onClick="SwapTab('setting','on','',6,1);" class="on" id="tab_setting_1">基本选项</li>
				<li onClick="SwapTab('setting','on','',6,2);" id="tab_setting_2" class="">模板调用</li>
			</ul>
			<div class="contentList pad-10" id="div_setting_1" style="display: block;">
			<table width="100%" class="table_form ">
			<tbody>
				<tr>
					<th width="200">表单名称：</th>
					<td><input type="text" class="input-text" size="10" value="<?php echo $model['modelname']; ?>" name="data[modelname]"></td>
				</tr>
				<tr>
					<th>表单类型：</th>
					<td>
					<?php echo $join_info; ?>
					</td>
				</tr>
				<tr>
					<th>表单提交模板：</th>
					<td>
					<input type="text" class="input-text" size="30" value="<?php echo $model['categorytpl']; ?>" name="data[categorytpl]"><div class="onShow">默认为form.html</div>
					</td>
				</tr>
				<tr>
					<th>提交权限：</th>
					<td>
					<input type="radio" <?php if (empty($model['setting']['form']['post'])) { ?>checked<?php } ?> value="0" name="setting[form][post]"> 游客
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" <?php if ($model['setting']['form']['post']==1) { ?>checked<?php } ?> value="1" name="setting[form][post]"> 会员
					</td>
				</tr>
				<tr>
					<th>是否开启验证码：</th>
					<td>
					<input type="radio" <?php if (empty($model['setting']['form']['code'])) { ?>checked<?php } ?> value="0" name="setting[form][code]"> 关闭
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" <?php if ($model['setting']['form']['code']==1) { ?>checked<?php } ?> value="1" name="setting[form][code]"> 打开
					</td>
				</tr>
				<tr>
					<th>是否审核：</th>
					<td>
					<input type="radio" <?php if (empty($model['setting']['form']['check'])) { ?>checked<?php } ?> value="0" name="setting[form][check]"> 关闭
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" <?php if ($model['setting']['form']['check']==1) { ?>checked<?php } ?> value="1" name="setting[form][check]"> 打开
					</td>
				</tr>
				<tr>
					<th>是否在会员中心显示：</th>
					<td>
					<input type="radio" <?php if (empty($model['setting']['form']['member'])) { ?>checked<?php } ?> value="0" name="setting[form][member]"> 关闭
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" <?php if ($model['setting']['form']['member']==1) { ?>checked<?php } ?> value="1" name="setting[form][member]"> 打开
					<div class="onShow">会员中心能查看到用户提交的内容</div>
					</td>
				</tr>

				<tr>
					<th>同一会员（游客）提交一次：</th>
					<td>
					<input type="radio" <?php if (empty($model['setting']['form']['num'])) { ?>checked<?php } ?> value="0" name="setting[form][num]"> 不限
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" <?php if ($model['setting']['form']['num']==1) { ?>checked<?php } ?> value="1" name="setting[form][num]"> 一次
					</td>
				</tr>
				<tr>
					<th>同一IP提交间隔：</th>
					<td>
					<input type="text" class="input-text" size="10" value="<?php echo $model['setting']['form']['time']; ?>" name="setting[form][ip]"><div class="onShow">单位分钟</div>
					</td>
				</tr>
						<?php if (is_array($model['fields']['data'])) { foreach ($model['fields']['data'] as $t) { ?>
						<tr>
							<th>表单自定义字段：<?php echo $t['name']; ?>: </th>
							<td>
							<input type="checkbox" value="<?php echo $t['field']; ?>" name="setting[form][show][]" <?php if (@in_array($t['field'], $model['setting']['form']['show'])) { ?>checked<?php } ?>> 在后台管理列表显示
							<br/>
							<input type="checkbox" value="<?php echo $t['field']; ?>" name="setting[form][membershow][]" <?php if (@in_array($t['field'], $model['setting']['form']['membershow'])) { ?>checked<?php } ?>> 在会员中心管理列表显示
							&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<?php } } ?>
			</tbody>
			</table>
			</div>
			

			<div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
				
			<table width="100%" class="table_form ">
			<tbody>
				<tr>
					<th width="200"></th>
					<td>具体调用信息可以参考官方模板或帮助手则 <a href="http://www.xiaocms.com">http://www.xiaocms.com</a></td>
				</tr>
				<tr>
					<th>表单提交地址：</th>
					<td><?php echo $form_url; ?> </td>
				</tr>
				<tr>
				  <th>表单列表数据调用（供参考）：</th>
				  <td>
				  <textarea style="width:90%;height:70px;overflow: hidden;color:#777777"><?php echo $list_code; ?></textarea>
				  </td>
				</tr>

			</tbody>
			</table>
			</div>


			
			
			<div class="bk15"></div>
			<input type="submit" class="button" value="提交" name="submit">
		</div>
		</form>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
	for(i=1;i<=cnt;i++){
		if(i==cur){
			$('#div_'+name+'_'+i).show();
			$('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			$('#div_'+name+'_'+i).hide();
			$('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}
</script>