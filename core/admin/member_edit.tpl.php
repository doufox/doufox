<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '会员信息';
</script>

<script type="text/javascript">
function ajaxemail() {
	$('#email_text').html('');
	$.post('<?php echo url('admin/member/ajaxemail'); ?>&rid='+Math.random(), { email:$('#email').val(), id:<?php echo $id; ?> }, function(data){ 
        $('#email_text').html(data); 
	});
}
</script>
<div class="subnav">
	<div class="table_form">
		<form method="post" action="" id="myform" name="myform">
		<table width="100%" class="table_form ">
		<tbody>
		<tr>
			<th width="120">修改会员：</th>
			<td><?php echo $data['username']; ?>&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<th>所属模型：</th>
			<td><?php echo $model['modelname']; ?></td>
		</tr>
		<tr>
			<th>新密码：</th>
			<td><input type="text" class="input-text" size="25" value="" name="password">
			<div class="onShow">不修改密码请留空。</div></td>
		</tr>
		<tr>
			<th>邮箱：</th>
			<td><input type="text" class="input-text" size="25" id="email" value="<?php echo $data['email']; ?>" name="data[email]"onBlur="ajaxemail()">
			<div class="onShow" id="email_text"></div>
			</td>
		</tr>
		<tr>
			<th>注册时间：</th>
			<td><?php echo date('Y-m-d H:i:s', $data['regdate']); ?></td>
		  </tr>
		<tr>
			<th>注册IP：</th>
			<td><?php echo $data['regip']; ?></td>
		</tr>

		<tr>
			<th>状态：</th>
			<td>
			<input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]"> 已审核
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]"> 未审核
			</td>
		</tr>
		<?php if ($model) {  echo $data_fields;  } ?>
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
