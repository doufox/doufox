<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '添加模型';
</script>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/model/index',  array('typeid'=>$typeid)); ?>" class="on"><em>模型管理</em></a>
		<a href="<?php echo url('admin/model/add',    array('typeid'=>$typeid)); ?>" class="add"><em>添加模型</em></a>
	</div>
		<div class="bk10"></div>

	<div class="table_form">
		<form action="" method="post">
		<input name="modelid" type="hidden" value="<?php echo $data['modelid']; ?>">

				<table width="100%" class="table_form">
				<tr>
					<th width="150">模型类型： </th>
					<td><?php echo $typename[$typeid]; ?></td>
				</tr>
				<tr>
					<th><font color="red">*</font> 名称： </th>
					<td><input class="input-text" type="text" name="modelname" value="<?php echo $data['modelname']; ?>" size="30"/></td>
				</tr>
				<tr>
					<th><font color="red">*</font> 数据表名： </th>
					<td><input class="input-text" type="text" name="tablename" value="<?php echo $data['tablename']; ?>" size="30" <?php if ($data['modelid']) { ?>disabled<?php } ?> /><div class="show-tips">只能由小写英文和数字组成(无需加表前缀)，此项不能修改。</div></td>
				</tr>
				<tbody>
				<?php if ($typeid == 1) { ?>
				<tr>
					<th>关联表单：</th>
					<td>
					<?php if (is_array($formmodel)) { foreach ($formmodel as $t) { ?>
					<input type="checkbox" value="<?php echo $t['modelid']; ?>" name="join[]" <?php if (in_array($t['modelid'], $join)) { ?>checked=""<?php } else {  if (in_array($t['modelid'], $joindata)) { ?>disabled=""<?php }  } ?> /> <?php echo $t['modelname']; ?>&nbsp;&nbsp;
					<?php } } ?>
					<div class="show-tips">用于拓展内容（如评论，留言等）。</div>
					</td>
				</tr>
				<tr>
					<th>栏目模板： </th>
					<td><input class="input-text" type="text" name="categorytpl" value="<?php echo $data['categorytpl']; ?>" size="30"/><div class="show-tips">例如：category_news.html。不填写则会是category_+模型名称拼音</div></td>
				</tr>
				<tr>
					<th>列表模板： </th>
					<td><input class="input-text" type="text" name="listtpl" value="<?php echo $data['listtpl']; ?>" size="30"/><div class="show-tips">例如：list_news.html。</div></td>
				</tr>
				<tr>
					<th>内容模板： </th>
					<td><input class="input-text" type="text" name="showtpl" value="<?php echo $data['showtpl']; ?>" size="30"/><div class="show-tips">例如：show_news.html。</div>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th> </th>
					<td><input type="submit" class="button" value="提交" name="submit"></td>
				</tr>
				</tbody>
				</table>

				

				
				<div class="bk15"></div>
				
		</form>
</div>
</body>
</html>
<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
	for(i=1;i<=cnt;i++){
		if(i==cur){
			$('#div_'+name+'_'+i).show();
			$('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			$('#div_'+name+'_'+i).hide();
			$('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}
</script>