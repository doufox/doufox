<?php include $this->admin_tpl('header');?>

<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '账号管理';
</script>
<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/account'); ?>" class="add">全部账号</a>
        <a href="<?php echo url('admin/account/add'); ?>">添加账号</a>
        <a href="<?php echo url('admin/account/me'); ?>">我的账号</a>
        <a href="<?php echo url('admin/account/cache'); ?>" class="options">更新缓存</a>
    </div>
    <div class="bk10"></div>
    <table width="100%"  class="table-list">
        <thead>
            <tr>
                <th align="left" width="30">ID</th>
                <th align="left">账号</th>
                <th align="left">姓名</th>
                <th align="left">角色</th>
                <th align="left" width="120">操作</th>
            </tr>
        </thead>
        <tbody class="line-box">
            <?php if (is_array($list)) foreach ($list as $t) { ?>
            <tr height="25">
                <td align="left"><?php echo $t['userid']; ?></td>
                <td align="left"><a title="编辑账号" href="<?php echo url('admin/account/edit', array('userid'=>$t['userid'])); ?>"><?php echo $t['username']; ?></a></td>
                <td align="left"><?php echo $t['realname']; ?></td>
                <td align="left"><?php if($t['roleid'] == 1) {echo '超级管理员';} else {echo '一般账号';} ?></td>
                <td align="left">
                    <a href="<?php echo url('admin/account/edit',array('userid'=>$t['userid'])); ?>">编辑</a> |
                    <a href="javascript:admin_command.confirmurl('<?php echo url('admin/account/del', array('userid'=>$t['userid']));?>','确定删除账号：『<?php echo $t['username']; ?> 』吗？')" >删除</a>
                </td>
            </tr>
            <?php } ?>
        <tbody>
    </table>
</div>
</body>
</html>