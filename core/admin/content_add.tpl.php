<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '添加内容';
</script>
		
<div class="subnav">


	<div class="table_form">
		<form method="post" action="" id="myform" name="myform">
		<input name="backurl" type="hidden" value="<?php echo $backurl; ?>">
		<table width="100%" class="table_form">
		<tbody>
		<tr>
			<th width="80"><font color="red">*</font>&nbsp;栏目：</th>
			<td>
			<select name="data[catid]">
			<?php echo $category; ?>
			</select>
			</td>
		</tr>
		

		<?php if ($model['content']['title']['show']) { ?>
		<tr>
			<th><font color="red">*</font>&nbsp;<?php echo $model['content']['title']['name']; ?>：</th>
			<td><input type="text" class="input-text" size="80" id="title" value="<?php echo $data['title']; ?>" name="data[title]" onBlur="ajaxtitle()"><span id="title_text"></span></td>
		</tr>
		<?php }  if ($model['content']['thumb']['show']) { ?>

		<tr>
			<th><?php echo $model['content']['thumb']['name']; ?>：</th>
			<td><span style="position: relative;">
<input type="text" class="input-text" size="50" value="<?php echo $data['thumb']; ?>" name="data[thumb]" id="thumb" onmouseover="admin_command.preview2('thumb')" onmouseout="admin_command.preview('thumb')">
			<input type="button"  class="button" onClick="admin_command.uploadImage('thumb', 1)" value="上传图片">
			<div id="urlTip" class="show-tips">可直接输入图片地址</div><div id="imgPreviewthumb"></div></span></td>
		</tr>

		<?php }  if ($model['content']['keywords']['show']) { ?>
		<tr>
			<th><?php echo $model['content']['keywords']['name']; ?>：</th>
			<td><input type="text" class="input-text" size="50" id="keywords" value="<?php echo $data['keywords']; ?>" name="data[keywords]">
			<div class="show-tips">多关键词之间用“,”隔开</div></td>
		</tr>

		<?php }  if ($model['content']['description']['show']) { ?>
		<tr>
			<th><?php echo $model['content']['description']['name']; ?>：</th>
			<td><textarea style="width:490px;height:44px;" maxlength="255" id="description" name="data[description]"><?php echo $data['description']; ?></textarea></td>
		</tr>
		<?php }  echo $data_fields; ?>
		<tr>
			<th>状态：</th>
			<td><input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]" > 正常 &nbsp;
			<input type="radio" <?php if ($data['status']==2) { ?>checked<?php } ?> value="2" name="data[status]" > 头条	&nbsp;
			<input type="radio" <?php if ($data['status']==3) { ?>checked<?php } ?> value="3" name="data[status]" > 推荐	&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]" > 未审核

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<?php echo content_date('time'); ?>&nbsp;阅读数：<input type="text" class="input-text" size="5" value="<?php echo $data['hits']; ?>" name="data[hits]"></td>
		</tr>



		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" class="button" value="提交" name="submit" onClick="$('#load').show()">
			<span id="load" style="display:none"><img src="/static/img/loading.gif"></span>
			</td>
		</tr>
		</tbody>
		</table>
	</form>
	</div>
</div>
<script type="text/javascript">
function ajaxtitle() {
	$('#title_text').html('');
	admin_command.get_kw();//读取关键字
	$.post('<?php echo HTTP_URL . DS . ENTRY_FILE; ?>?s=admin&c=content&a=ajaxtitle&id='+Math.random(), { title:$('#title').val(), id:<?php echo $data[id] ? $data[id] : 0; ?> }, function(data){ 
        $('#title_text').html(data); 
	});
}
</script>

</body>
</html>
