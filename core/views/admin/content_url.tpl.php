<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
	top.document.getElementById('position').innerHTML = '更新内容地址';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/content/updateurl'); ?>" class="on">更新内容地址</a>
	</div>
	<div class="bk10"></div>

	<form action="" method="post" target='result'>
		<table width="100%" class="table_form">
			<tr>
				<th width="100">选择栏目</th>
				<td>
					<select name="catids[]" style="width:200px;" size=10 multiple>
						<option value="0">=== 全部栏目 ===</option>
						<?php echo $category; ?>
					</select>
					<div class="show-tips">表单列表模板</div>
				</td>
			</tr>
			<tr>
				<th>每次执行数量</th>
				<td><input type="text" class="input-text" size="10" value="100" name="nums"></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input class="button" type="submit" name="submit" value="开始执行" /></td>
			</tr>
			<tr>
				<th style="text-align:left;"><b>运行状态</b></th>
				<td style="padding-left:2px;">
					<iframe name="result" frameborder="0" id="result" width="100%" height="30"></iframe>
				</td>
			</tr>
		</table>
	</form>

</div>
</body>
</html>
