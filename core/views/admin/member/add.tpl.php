<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '添加会员';
	function ajaxemail() {
		$('#email_text').html('');
		$.post('<?php echo url('api/member/ajaxemail'); ?>&rid='+Math.random(), { email:$('#email').val(), id:<?php echo $id; ?> }, function(data){ 
			$('#email_text').html(data); 
		});
	}
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/member/index'); ?>">会员管理</a>
		<a href="<?php echo url('admin/member/add'); ?>" class="add">添加会员</a>
		<a href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
	</div>
	<div class="bk10"></div>
	<div class="table_form">
		<form method="post" action="" id="myform" name="myform">
		<table width="100%" class="table_form ">
		<tbody>
			<tr>
				<th width="100">会员类型：</th>
				<td><?php echo $model['modelname']; ?>
			
				<select name="data[modelid]">
					<option value="0"> == 会员类型 == </option>
					<?php if (is_array($membermodel)) {foreach ($membermodel as $t) { ?>
					<option value="<?php echo $t['modelid']; ?>"><?php echo $t['modelname']; ?></option>
					<?php } } ?>
				</select>
			</td>
			</tr>
			<tr>
				<th>登陆账号：</th>
				<td>
					<input class="input-text" type="text" size="20" value="" name="data[username]" maxlength="20" />
				</td>
			</tr>
			<tr>
				<th>会员昵称：</th>
				<td><input type="text" class="input-text" size="50" value="" name="data[nickname]" maxlength="50"></td>
			</tr>
			<tr>
				<th>登陆密码：</th>
				<td><input type="text" class="input-text" size="50" value="" name="data[password]"></td>
			</tr>
			<tr>
				<th>电子邮箱：</th>
				<td><input type="text" class="input-text" size="50" id="email" value="" name="data[email]"onBlur="ajaxemail()"></td>
			</tr>
			<tr>
				<th>设置状态：</th>
				<td>
					<label><input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]"> 已审核</label>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<label><input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]"> 未审核</label>
				</td>
			</tr>
			<?php if ($model) {echo $data_fields;} ?>
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" class="button" value="提交" name="submit"></td>
			</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
</body>
</html>
