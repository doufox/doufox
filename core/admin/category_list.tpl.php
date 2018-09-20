<?php include $this->admin_tpl('header');?>

<script type="text/javascript">
	window.top.document.getElementById('position').innerHTML = '栏目管理';
</script>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/category'); ?>" class="on"><em>全部栏目</em></a>
		<a href="<?php echo url('admin/category/add'); ?>" class="add"><em>添加栏目</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list">
		<form action="" method="post" name="myform">
			<table width="100%">
				<thead>
				<tr>
					<th align="left" width="40">排序</th>
					<th align="left" width="40">栏目ID</th>
					<th align="left">栏目名称</th>
					<th align="left" width="100">栏目目录</th>
					<th align="left" width="50">类型</th>
					<th align="left" width="50">内容数量</th>
					<th align="left" width="50">显示</th>
					<th align="left" width="150">操作</th>
				</tr>
				</thead>
				<tbody class="line-box">
					<?php echo $categorys;?> 
					<tr height="25">
						<td align="left" colspan="8">
							<input type="submit" class="button" value="排序" name="submit" onClick="$('#load').show()">
							<span class="onShow">排序方式为“由小到大” 更改排序后请更新缓存</span>
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