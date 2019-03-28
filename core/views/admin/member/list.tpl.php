<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '会员列表';
    function setC() {
        if($("#deletec").prop('checked')==true) {
            $(".deletec").prop("checked",true);
        } else {
            $(".deletec").prop("checked",false);
        }
    }
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('admin/member/index'); ?>" class="add">会员管理</a>
		<a href="<?php echo url('admin/member/add'); ?>">添加会员</a>
		<a href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
	</div>
	<div class="bk10"></div>
	<div class="table-list">
		<form action="" method="post">
		<input name="form" id="list_form" type="hidden" value="">
		<table width="100%">
		<thead>
		<tr>
			<th width="25" align="left"><input name="deletec" id="deletec" type="checkbox" onclick="setC()"></th>
			<th width="30" align="left">ID </th>
			<th width="50" align="left">状态</th>
			<th align="left">用户名</th>
			<th align="left">昵称</th>
			<th width="80" align="left">会员模型</th>
			<th width="140" align="left">注册时间</th>
			<th width="110" align="left">注册IP</th>
			<th width="80" align="left">操作</th>
		</tr>
		</thead>
		<tbody class="line-box">
		<?php if (is_array($list)) { foreach ($list as $t) {  ?>
		<tr height="25">
			<td ><input name="del_<?php echo $t['id']; ?>_<?php echo $t['modelid']; ?>" type="checkbox" class="deletec"></td>
			<td align="left"><?php echo $t['id']; ?></td>
			<td align="left"><?php if (!$t['status']) { ?><font color="#FF0000">未审核</font><?php } else { ?>已审核<?php } ?></td>
			<td align="left"><a href="<?php echo url('admin/member/edit',array('id'=>$t['id'])); ?>"><?php echo $t['username']; ?></a></td>
			<td><?php echo $t['nickname']; ?></a></td>
			<td align="left"><a href="<?php echo url('admin/member/index', array('modelid'=>$t['modelid'])); ?>"><?php echo $membermodel[$t['modelid']]['modelname']; ?></a></td>
			<td align="left"><?php echo date('Y-m-d H:i:s', $t['regdate']); ?></td>
			<td align="left"><?php echo $t['regip']; ?></td>
			<td align="left"><a href="<?php echo url('admin/member/edit',array('id'=>$t['id'])); ?>">详细</a> | 
			<a href="javascript:admin_command.confirmurl('<?php echo url('admin/member/del/',array('modelid'=>$t['modelid'],'id'=>$t['id']));?>','确定删除会员 『 <?php echo $t['username']; ?> 』吗？ ')" >删除</a> 
			</td>
		</tr>
		<?php } } ?>
			<tr height="25">
				<td colspan="9" align="left">
				<div class="pageleft">
					<input type="submit" class="button" value="设为已审核" name="submit_status_1" onClick="$('#list_form').val('status_1')">&nbsp;
					<input type="submit" class="button" value="设为未审核" name="submit_status_0" onClick="$('#list_form').val('status_0')">
				</div>
				<div class="pageright"><?php echo $pagination; ?></div>
			</td>
		</tr>
		</tbody>
		</table>
		</form>
	</div>
	</div>
</body>
</html>