<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '表单信息';
</script>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/form/list',array('modelid'=>$modelid,'cid'=>$cid)); ?>" class="on">返回列表</a>
	</div>
	<div class="bk10"></div> 
	<div class="table_form">
		<form method="post" action="" id="myform" name="myform">
		<table width="100%" class="table_form">
		<tbody>
		<tr>
			<th width="150">表单名称：</th>
			<td><?php echo $model['modelname']; ?></td>
		</tr>
		<?php if ($join) { ?>
		<tr>
			<th>当前表单<?php echo $join_info; ?>:</th>
			<td><a href="<?php echo url('index/show',array('id'=>$cid)); ?>" target="_blank"><?php echo $ciddata['title']; ?></a>
			<input type="hidden" value="<?php echo $cid; ?>" name="cid" ></td>
		</tr>
		<?php }  echo $fields; ?>
		<tr>
		<th>状态：</th>
			<td>
			<input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]" onClick="$('#verify').hide()"> 已审核
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]" onClick="$('#verify').hide()"> 未审核
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" class="button" value="提交" name="submit" onClick="$('#load').show()">
			<span id="load" style="display:none"><img src="/static/img/loading.gif"></span></td>
		</tr>
		</tbody>
		</table>
		<br>
		</form>
	</div>
</div>
</body>
</html>
