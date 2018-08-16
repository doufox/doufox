<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '模型管理';
</script>
<script type="text/javascript">
function cdisabled(id, c) {
    if (c == 1) {
		var url = "<?php echo url('admin/model/cdisabled/',array('typeid'=>$typeid,'modelid'=>'')); ?>"+id;
		window.location.href=url;
		return true;
	}
	if (confirm('禁用模型之后，该模型是数据将会无法访问，确定禁用吗？')) {
		var url = "<?php echo url('admin/model/cdisabled/',array('typeid'=>$typeid,'modelid'=>'')); ?>"+id;
		window.location.href=url;
	}
}
</script>
<div class="subnav">
<form action="" method="post">
	<div class="content-menu">
		<a href="<?php echo url('admin/model/index',  array('typeid'=>$typeid)); ?>" class="on"><em>模型管理</em></a>
		<a href="<?php echo url('admin/model/add',    array('typeid'=>$typeid)); ?>" class="add"><em>添加模型</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list">
		<table width="100%">
			<thead>
			<tr>
				<th width="40" align="left">ID</th>
				<th  align="left">模型名称</th>
				<th  align="left">模型类型</th>
				<th  align="left">数据表名</th>
				<th align="left" width="300" >操作</th>
			</tr>
			</thead>
			<tbody class="line-box">
			<?php if (is_array($list)) {foreach ($list as $t) {  $setting=string2array($t['setting']);$disable = isset($setting['disable']) && $setting['disable'] == 1 ? 1 : 0; ?>
			<tr height="25">
				<td align="left"><?php echo $t['modelid']; ?></td>
				<td align="left"><?php echo $t['modelname']; ?></td>
				<td align="left"><?php echo $typename[$t['typeid']]; ?></td>
				<td align="left"><?php echo $t['tablename']; ?></td>
				<td align="left">
				<a href="<?php echo url('admin/model/fields/',array('typeid'=>$typeid, 'modelid'=>$t['modelid'])); ?>">字段管理</a> | 
				<a href="<?php echo url('admin/model/edit',array('typeid'=>$typeid, 'modelid'=>$t['modelid'])); ?>">编辑</a> | 
				<a href="javascript:cdisabled(<?php echo $t['modelid']; ?>, <?php echo $disable; ?>);"><?php if ($disable) { ?><font color=red><?php echo '启用'; ?></font><?php } else {  echo '禁用 ';  } ?></a> | 
				<a  href="javascript:confirmurl('<?php echo url('admin/model/del/',array('typeid'=>$typeid,'modelid'=>$t['modelid'])); ?>','确定删除 『 <?php echo $t['modelname']; ?> 』吗？ ')" >删除</a> </td>
			</tr>
			<?php } } ?>
			<tbody>
		</table>
	</div>
</div>
</body>
</html>