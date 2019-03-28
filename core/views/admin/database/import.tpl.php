<?php include $this->admin_tpl('header'); ?>

<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '备份列表';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/database/index'); ?>" class="on">数据表</a>
		<a href="<?php echo url('admin/database/import'); ?>" class="on">备份列表</a>
	</div>
	<div class="bk10"></div>

<div class="table-list">
<form method="post" name="myform" id="myform" action="">
<table width="100%" cellspacing="0">
    <thead>
       <tr>
			<th align="left" width="50">
				<label><input name="selectform" class="select_backups" type="checkbox" onClick="selectBackup()">&nbsp;全选</label>
			</th>
           <th align="left" width="150">备份时间</th>
           <th align="left">备份文件目录</th>
           <th align="left" width="150">文件大小</th>
           <th align="left" width="150">操作</th>
       </tr>
    </thead>
    <tbody class="line-box">
		<?php if ($list) { foreach($list as $v){ ?>
		<tr>
			<td>
				<label><input class="selectform" type="checkbox" name="paths[]" value="<?php echo $v['path']?>"/>&nbsp;选择<label>
			</td>
			<td><?php echo date('Y-m-d H:i:s', $v['path'])?></td>
			<td><?php echo $v['sqldir']?></td>
			<td><?php echo $v['size']?></td>
			<td>
				<a href="javascript:admin_command.confirmurl('<?php echo url("admin/database/import", array("path"=>$v['path']))?>', '确定恢复数据库吗')">恢复</a>
				<a href="javascript:showTableBackups(<?php echo $v['path']?>);">预览</a>
				<a href="javascript:void(0);">下载</a>
				<a href="javascript:admin_command.confirmurl('<?php echo url("admin/database", array("path"=>$v['path']))?>', '确定删除吗？');">删除</a>
			</td>
		</tr>
		<?php } }?>
		<tr height="28">
			<td colspan="5" align="left">
				<input type="submit" class="button" value="批量删除" name="submit" >&nbsp;备份目录：/data/bakup/
			</td>
		</tr>
	</tbody>
</table>
</form>
</div>

</div>
<script type="text/javascript">
	function selectBackup() {
		if ($('.select_backups').prop('checked')) {
			$('.selectform').prop('checked', true);
		} else {
			$('.selectform').prop('checked', false);
		}
	}

	function showTableBackups (path) {
		window.top.art.dialog({
			title: '查看备份数据' + path, 
			id: 'show', 
			iframe: '<?php echo url("admin/database/view")?>&file=' + path,
			width: '80%',
			height: '400px'
		});
	}
</script>
</body>
</html>
