<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '区块编辑';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/block'); ?>"  class="on"><em>全部区块</em></a>
		<a href="<?php echo url('admin/block/add'); ?>" class="add"><em>添加区块</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table_form">
		<form action="" method="post">
		<input name="id" type="hidden" value="<?php echo $data['id']; ?>">
		<table width="100%" class="table_form">
		<tr>
			<th width="60">区块名称： </th>
			<td><input class="input-text" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="40"/>    编辑方式：<select id="type" name="data[type]" onChange="select_type(this.value)">
			<option value="0"> ... 请选择方式</option>
			<?php if (is_array($type)) { foreach ($type as $i=>$v) { ?>
			<option value="<?php echo $i; ?>" <?php if ($data['type']==$i) { ?>selected<?php } ?>><?php echo $v; ?></option>
			<?php } } ?>
			</select></td>
        </tr>
        <tr>
            <th width="80">备注： </th>
            <td><input class="input-text" type="text" name="data[remark]" value="<?php echo $data['remark']; ?>" size="100" /></td>
        </tr>
		<tr id="text_1" style="display:none">
			<th>区块内容： </th>
			<td><textarea name="data[content_1]" id="data[content]" cols="91" rows="8"><?php echo $data['content']; ?></textarea>
			<br><div class="show-tips">区块内容支持HTML标签</div></td>
		</tr>
		<tr id="text_2" style="display:none">
			<th>区块内容： </th>
			<td><span style="position: relative;"><input type="text" class="input-text"  size="50" value="<?php echo $data[content]; ?>" name="data[content_2]"  id="thumb"   onmouseover="preview2('thumb')" onmouseout="preview('thumb')">
				<input type="button"  class="button" onClick="uploadImage('thumb')" value="上传图片">
				<div id="urlTip" class="show-tips">可直接输入图片地址</div><div id="imgPreviewthumb"></div></span></td>
		</tr>
		<tr id="text_3" style="display:none;">
			<th>区块内容：</th>
			<td>
			<?php echo content_editor('content_3', array(0=>$data['content']), array('system'=>1)); ?>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input class="button" type="submit" name="submit" value="提交" /></td>
		</tr>
		</table>
		</form>
	</div>
</div>
<script type="text/javascript">
function select_type(id) {
	$("#text_1").hide();
	$("#text_2").hide();
	$("#text_3").hide();
	$("#text_"+id).show();
}
<?php if ($data['type']) { ?>
$("#text_<?php echo $data['type']; ?>").show();
<?php } ?>
</script>
</body>
</html>