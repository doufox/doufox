<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '数据库备份';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/database/import'); ?>" class="on"><em>数据库恢复</em></a>
	</div>
	<div class="bk10"></div>

<div class="table-list">
<form method="post" name="myform" id="myform" action="">
<input name="list_form" id="list_form" type="hidden" value="">
<table width="100%" cellspacing="0">
    <thead>
       <tr>
           <th align="left" width="80">选择</th>
           <th align="left">表名</th>
           <th align="left">类型</th>
           <th align="left">编码</th>
           <th align="left">行数</th>
           <th align="left">使用空间</th>
           <th align="left">碎片</th>
           <th align="left" width="150">操作</th>
       </tr>
    </thead>
    <tbody class="line-box">
		<?php foreach($data as $v){ ?>
		<tr>
			<td>
				<label>
					<input <?php if ($v['tables_sys']) { echo 'class="selectform"';}?> type="checkbox" name="table[]" value="<?php echo $v['Name'];?>"/>
					<?php if ($v['tables_sys']) { echo '<font color="#f00">系统表</font>';} else {echo '<font color="#369">其他表</font>';}?>
				</label>
			</td>
			<td><?php echo $v['Name']?></td>
			<td><?php echo $v['Engine']?></td>
			<td><?php echo $v['Collation']?></td>
			<td><?php echo $v['Rows']?></td>
			<td><?php echo formatFileSize($v['Data_length'] + $v['Index_length'])?></td>
			<td><?php echo formatFileSize($v['Data_free'])?></td>
			<td>
				<a href="<?php echo url("admin/database/repair", array("name"=>$v['Name']))?>">修复</a> | 
				<a href="<?php echo url("admin/database/optimize", array("name"=>$v['Name']))?>">优化</a> | 
				<a href="javascript:void(0);" onclick="showTableStructure('<?php echo $v['Name']?>')">结构</a>
			</td>
		</tr>
		<?php } if (is_array($data)) { ?>
		<tr height="28">
			<td colspan="8">
				<label><input name="selectform" class="select_tables" type="checkbox" onClick="selectTables()">&nbsp;选择系统表</label>&nbsp;&nbsp;
				<input type="submit" class="button" value="开始备份数据库" name="submit">
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="btn">&nbsp;</div>
</form>
</div>
</div>
<script type="text/javascript">
	function selectTables () {
		if ($('.select_tables').prop('checked')) {
			$('.selectform').prop("checked", true);
		} else {
			$('.selectform').prop("checked", false);
		}
	}

	function showTableStructure (table) {
		window.top.art.dialog({
			title: table + '表结构', 
			id: 'show', 
			iframe: '<?php echo url("admin/database/table")?>&name=' + table,
			width: '700px',
			height: '400px'
		});
	}
</script>
</body>
</html>
