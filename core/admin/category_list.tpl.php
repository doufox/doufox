<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '栏目管理';
</script>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/category'); ?>"  class="on"><em>全部栏目</em></a>
		<a href="<?php echo url('admin/category/add'); ?>" class="add"><em>添加栏目</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list">
		<form action="" method="post" name="myform">
		<table width="100%">
		<thead>
		<tr>
			<th width="40" align="left">排序</th>
			<th width="20" align="left">ID </th>
			<th  align="left">栏目名称</th>
			<th width="100"  align="left">类型</th>
			<th width="100" align="left">内容</th>
			<th width="100" align="left">显示</th>
			<th width="150" align="left">操作</th>
		</tr>
		</thead>
		<tbody  class="line-box">
		<?php echo $categorys ;?> 
		<tr height="25">
		<td colspan="7" align="left">
			<input type="submit" class="button" value="排序" name="submit" onClick="$('#load').show()">&nbsp;<div class="onShow">排序方式为“由小到大” 更改排序后请更新缓存</div>
			<span id="load" style="display:none"><img src="/static/img/loading.gif"></span>
		</td>
		</tr>
		</tbody>
		</table>
		</form>
    </div>
</div>
</body>
</html>