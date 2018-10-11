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
           <th width="80" align="left">&nbsp;</th>
           <th align="left">表名</th>
           <th align="left">类型</th>
           <th align="left">编码</th>
           <th align="left">记录数</th>
           <th align="left">使用空间</th>
           <th align="left">碎片</th>
           <th width="150" align="left">操作</th>
       </tr>
    </thead>
    <tbody class="line-box">
	<?php foreach($data as $v){?>
	<tr>
		<td align="left">
			<input <?php if ($v['tables_sys']) { echo 'class="selectform"';}?> type="checkbox" name="table[]" value="<?php echo $v['Name'];?>"/>
			<?php if ($v['tables_sys']) { echo '<font color="#f00">系统表</font>';} else {echo '<font color="#369">其他表</font>';}?>
		</td>
		<td align="left"><?php echo $v['Name']?></td>
		<td align="left"><?php echo $v['Engine']?></td>
		<td align="left"><?php echo $v['Collation']?></td>
		<td align="left"><?php echo $v['Rows']?></td>
		<td align="left"><?php echo formatFileSize($v['Data_length']+$v['Index_length'])?></td>
		<td align="left"><?php echo formatFileSize($v['Data_free'])?></td>
		<td align="left">
			<a href="<?php echo url("admin/database/repair", array("name"=>$v['Name']))?>">修复</a> | 
			<a href="<?php echo url("admin/database/optimize", array("name"=>$v['Name']))?>">优化</a> | 
			<a href="javascript:void(0);" onclick="showcreat('<?php echo $v['Name']?>')">结构</a>
		</td>
	</tr>
	<?php }
	if (is_array($data)) {
	?>
    <tr height="28">
		<td colspan="8" align="left">
			<span>选择系统表&nbsp;&nbsp;</span>
			<input name="selectform" class="cselectform" type="checkbox" onClick="setC()">&nbsp;&nbsp;
			<input type="submit" class="button" value="开始备份数据库" name="submit">
		</td>
	</tr>
    <?php }?>
	</tbody>
</table>
<div class="btn">&nbsp;</div>
</form>
</div>
</div>
<script language="javascript">
function setC() {
	if($(".cselectform").attr('checked')) {
		$(".selectform").attr("checked",true);
	} else {
		$(".selectform").attr("checked",false);
	}
}
function showcreat(tblname) {
	window.top.art.dialog({
		title:tblname+'表结构', 
		id:'show', 
		iframe:'<?php echo url("admin/database/table", null, 1)?>&name='+tblname,
		width:'700px',
		height:'400px'
	});
}
</script>
</body>
</html>
