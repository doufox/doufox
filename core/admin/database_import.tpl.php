<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '数据库恢复';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/database'); ?>"  class="on"><em>数据库备份</em></a>
	</div>
	<div class="bk10"></div>

<div class="table-list">
<form method="post" name="myform" id="myform" action="">
<table width="100%" cellspacing="0">
    <thead>
       <tr>
           <th width="33" align="right"><input name="selectform" class="cselectform" type="checkbox" onClick="setC()"></th>
           <th width="150" align="left">备份时间</th>
           <th >备份文件目录</th>
           <th width="111">文件大小</th>
           <th width="80" align="left" >操作</th>
       </tr>
    </thead>
    <tbody class="line-box">
	<?php 
	if ($list) {
	foreach($list as $v){?>
	<tr>
	<td align="right"><input class="selectform" type="checkbox" name="paths[]" value="<?php echo $v['path']?>"/></td>
	<td align="left"><?php echo date('Y-m-d H:i:s', $v['path'])?></td>
	<td align="left"><?php echo $v['sqldir']?></td>
	<td align="center"><?php echo $v['size']?></td>
	<td  align="left">
	<a href="javascript:admin_command.confirmurl('<?php echo url("admin/database/import", array("path"=>$v['path']))?>', '确定恢复数据库吗')">恢复数据库</a>
    </td>
	</tr>
	<?php } }?>
    <tr height="28">
	<td colspan="5" align="left"><input type="submit" class="button" value="批量删除" name="submit" >&nbsp;备份目录：/data/bakup/
</td>
	</tr>
	</tbody>
</table>
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
</script>
</body>
</html>
