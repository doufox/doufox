<?php include $this->admin_tpl('header');?>

<script type="text/javascript">
	window.top.document.getElementById('position').innerHTML = '添加字段';
	function loadformtype(type) {
		$("#content").html('loading...');
		$.get("<?php echo url('admin/model/ajaxformtype'); ?>&type=" + type, function(data) {
			$("#content").html(data);
		});
		var merge = $('#merge').val();
		$('#hidetbody').show();
		$('#select-ed').show();
		loadmerge(merge);
		if (type=='input') {
			$('#hidetbody').hide();
		}
		if (type=='editor') {
			$('#hidetbody').hide();
		}
		if (type=='merge') {
			$('#hidetbody').hide();
		}
		if (type=='fields') {
			$('#hidetbody').hide();
			$('#select-ed').hide();
		}
		if (type=='checkbox') {
			$('#hidetbody').hide();
		}
		if (type=='image') {
			$('#hidetbody').hide();
		}
		if (type=='file') {
			$('#hidetbody').hide();
		}
		if (type=='files') {
			$('#hidetbody').hide();
		}
		if (type=='date') {
			$('#hidetbody').hide();
		}
	}
	function ajaxname() {
		var field = $('#field').val();
		if (field == '') {
			$.post("<?php echo url('api/index/pinyin', array('id' => rand())); ?>", { name:$("#name").val() }, function(data){ $("#field").val(data); });
		}
	}
	function setlength() {
		var type = new Array();
		type['SMALLINT']='5';
		type['MEDIUMINT']='8';
		type['DECIMAL']='10,2';
		type['VARCHAR']='255';
		type['TEXT']='50000';
		var name = $('#type').val();
		if (name) {
			v = type[name];
			$('#length').val(v);
		}
	}
	function loadmerge(v) {
		if (v) {
			$('#hidetbody').hide();
			$('#select-ed').hide();
		} else {
			$('#hidetbody').show();
			$('#select-ed').show();
		}
	}
	<?php if (isset($data['merge']) && $data['merge']) { ?>
	$(function(){
		loadmerge(<?php echo $data['merge']; ?>);
	});
<?php } ?>
</script>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/model/index', array('typeid'=>$typeid)); ?>" class="on"><em>模型管理</a>
		<a href="<?php echo url('admin/model/fields/', array('typeid'=>$typeid, 'modelid'=>$modelid)); ?>" class="on"><em>字段管理</em></a>
		<a href="<?php echo url('admin/model/addfield/', array('typeid'=>$typeid, 'modelid'=>$modelid)); ?>" class="add"><em>添加字段</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table_form">
		<form action="" method="post">
		<input name="modelid" type="hidden" value="<?php echo $modelid; ?>">
		<input name="fieldid" type="hidden" value="<?php echo $data['fieldid']; ?>">
		<table width="100%" class="table_form">
		<tr>
			<th width="100">模型名称： </th>
			<td><?php echo $model_data['modelname']; ?></td>
		</tr>
		<?php if ($merge && (empty($data['formtype']) || (isset($data['formtype']) && $data['formtype']!='fields'))) { ?>
		<tr>
			<th>多字段组合： </th>
			<td>
			<select name="merge" id="merge" onChange="loadmerge(this.value)">
			<?php if (!isset($data['merge']) || empty($data['merge'])) { ?><option value="">-</option><?php }  if (is_array($merge)) { $count=count($merge);foreach ($merge as $t) { ?>
			<option value="<?php echo $t['fieldid']; ?>" <?php if ($t['fieldid']==$data['merge']) { ?>selected<?php } ?>><?php echo $t['name']; ?></option>
			<?php } } ?>
			</select>
			<div class="show-tips">该字段将会属于该“组合字段”。</div></td>
		</tr>
		<?php } ?>
		<tr>
			<th><font color="red">*</font> 字段别名： </th>
			<td><input class="input-text" type="text" name="name" value="<?php echo $data['name']; ?>" size="30" id="name" onBlur="ajaxname()"/><div class="show-tips">例如：副标题。</div></td>
		</tr>
		<tr>
			<th><font color="red">*</font> 字段名称： </th>
			<td><input class="input-text" type="text" id="field" name="field" value="<?php echo $data['field']; ?>" size="30" <?php if ($data[fieldid]) { ?>disabled<?php } ?> /><div class="show-tips">mysql中字段名称，如：cms 必须英文字母开头、数字和下划线组成。</div>
		</tr>
		<tr>
			<th><font color="red">*</font> 字段类别： </th>
			<td><select name="formtype" id="formtype" onChange="loadformtype(this.value)" <?php if ($data['fieldid']) { ?>disabled<?php } ?>>
			<option value="">--请选择字段类别--</option>
			<?php if (is_array($formtype)) { foreach ($formtype as $k=>$t) { ?>
			  <option value="<?php echo $k; ?>" <?php if ($k==$data['formtype']) { ?>selected<?php }  ?>><?php echo $t; ?></option>
			<?php } } ?>
			</select><div class="show-tips">表单的输入类型</div>
			</td>
		</tr>
		<tr>
			<th>相关配置： </th>
			<td><div id="content">
			<?php 
			if ($data['fieldid']) { 
				$func = "form_".$data['formtype'];
				if (function_exists($func)) {
					eval("echo ".$func."(".$data['setting'].");");
				}
			} ?>
			</div></td>
		</tr>
		<?php if (!in_array($data['formtype'], array('input', 'editor', 'merge', 'checkbox', 'image', 'file', 'files', 'date', 'fields'))) { ?>
		<tbody id="hidetbody">
		<tr>
			<th><font color="red">*</font> 字段类型： </th>
			<td>
			<?php if ($data['type']) {  echo $data['type'];  } else { ?>
			<select name="type" onChange="setlength()" id="type">
				<option value="">--请选择字段类型--</option>
				<option value="SMALLINT">五位整型(SMALLINT)</option>
				<option value="MEDIUMINT">八位整型(MEDIUMINT)</option>
				<option value="DECIMAL">小数类型(DECIMAL)</option>
				<option value="VARCHAR">字符类型(VARCHAR)</option>
				<option value="TEXT">文本类型(TEXT)</option>
			</select>
			<div class="show-tips">储存类型 请慎重，一旦创建不能更改。</div>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<th><font color="red">*</font> 最大长度： </th>
			<td><?php if ($data['fieldid']) {  echo $data['length'];  } else { ?><input class="input-text" type="text" id="length" name="length" value="<?php echo $data['length']; ?>" size="30"/>
			<div class="show-tips">不能超过字段类型最大长度。</div><?php } ?></td>
		</tr>
		<tr>
			<th>字段索引： </th>
			<td>
			<?php if ($data['indexkey']=='INDEX') {  echo '普通索引';  } else if ($data['indexkey']=='UNIQUE') {  echo '唯一索引';  } else {  if ($data['fieldid']) {  echo '无索引';  } else { ?>
				<select name="indexkey">
				<option value="">---</option>
				<option value="UNIQUE">唯一索引</option>
				<option value="INDEX">普通索引</option>
				</select>
				<div class="show-tips">不懂就留空吧。</div>
				<?php }  } ?>
			</td>
		</tr>
		</tbody>
		<?php } ?>
		<tr>
			<th>输入提示： </th>
			<td><input class="input-text" type="text" name="tips" value="<?php echo $data['tips']; ?>" size="30"/><div class="show-tips">输入框旁边的提示信息。</div></td>
		</tr>
		<?php if ($typeid==1) { ?>
		<tr>
			<th>前台显示：</th>
			<td>
			<input type="radio" <?php if (!isset($data['isshow']) || $data['isshow']==1) { ?>checked<?php } ?> value="1" name="isshow"> 显示&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" <?php if (isset($data['isshow']) && $data['isshow']==0) { ?>checked<?php } ?> value="0" name="isshow"> 隐藏
			<div class="show-tips">前台游客/会员发布时是否显示该字段。</div>
			</td>
		</tr>
		<?php } ?>
		<tbody id="select-ed" style="<?php if (isset($data['formtype']) && $data['formtype']=='fields') { ?>display:none<?php } ?>">
		<tr>
			<th>是否必填：</th>
			<td>
			<input <?php if ($data['formtype']=='merge') { ?>disabled<?php } ?> type="radio" <?php if (!isset($data['not_null']) || empty($data['not_null'])) { ?>checked<?php } ?> value="0" name="not_null" onclick="$('#pattern_data').hide();"> 选填&nbsp;&nbsp;&nbsp;&nbsp;
			<input <?php if ($data['formtype']=='merge') { ?>disabled<?php } ?> type="radio" <?php if (isset($data['not_null']) && $data['not_null']) { ?>checked<?php } ?> value="1" name="not_null" onclick="$('#pattern_data').show();"> 必填
			</td>
		</tr>
		</tbody>
		<tbody id="pattern_data" style="<?php if (!isset($data['not_null']) || empty($data['not_null'])) { ?>display:none<?php } ?>">
		<tr>
			<th>数据校验正则： </th>
			<td><input class="input-text" type="text" name="pattern" id="pattern" value="<?php echo $data['pattern']; ?>" size="40"/><select onChange="javascript:$('#pattern').val(this.value)" name="pattern_select">
			<option value="">常用正则</option>
			<option value="/^[0-9.-]+$/">数字</option>
			<option value="/^[0-9-]+$/">整数</option>
			<option value="/^[a-z]+$/i">字母</option>
			<option value="/^[0-9a-z]+$/i">数字+字母</option>
			<option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
			<option value="/^[0-9]{5,20}$/">QQ</option>
			<option value="/^http:\/\//">超级链接</option>
			<option value="/^(1)[0-9]{10}$/">手机号码</option>
			<option value="/^[0-9-]{6,13}$/">电话号码</option>
			<option value="/^[0-9]{6}$/">邮政编码</option>
			</select><div class="show-tips">选填，通过此正则校验提交数据的合法性，如果不想校验请留空。</div>
			</td>
		</tr>
		<tr>
			<th>如未通过提示： </th>
			<td><input class="input-text" type="text" name="errortips" value="<?php echo $data['errortips']; ?>" size="30"/><div class="show-tips">数据校验未通过的提示信息。例如:xxx内容不能为空</div></td>
		</tr>
		</tbody>
		<tr>
			<th>&nbsp;</th>
			<td><input class="button" type="submit" name="submit" value="提交" onClick="$('#load').show()" />
			<span id="load" style="display:none"><img src="/static/img/loading.gif"></span></td>
		</tr>
		</table>
		</form>
	</div>
</div>
</body>
</html>