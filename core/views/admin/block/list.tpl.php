<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '区块管理';
</script>
<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/block'); ?>" class="on">全部区块</a>
        <a href="<?php echo url('admin/block/add'); ?>" class="add">添加区块</a>
        <a href="<?php echo url('admin/block/cache'); ?>" class="options">更新缓存</a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post" name="myform">
            <table width="100%">
                <thead>
                    <tr>
                        <th width="25" align="left">ID</th>
                        <th align="left">区块名称</th>
                        <th align="left">备注</th>
                        <th width="300" align="left">模板调用代码</th>
                        <th width="80" align="left">操作</th>
                    </tr>
                </thead>
                <tbody class="line-box">
                    <?php if (is_array($list)) { foreach ($list as $t) { ?>
                    <tr height="25">
                        <td align="left"><?php echo $t['id']; ?></td>
                        <td align="left"><a href="<?php echo url('admin/block/edit',array('id'=>$t['id'])); ?>"><?php echo $t['name']; ?></a></td>
                        <td align="left"><?php echo $t['remark']; ?></td>
                        <td align="left">{block <?php echo $t['id']; ?>}</td>
                        <td align="left">
                            <a href="<?php echo url('admin/block/edit',array('id'=>$t['id'])); ?>">编辑</a> | 
                            <a href="javascript:admin_command.confirmurl('<?php echo url('admin/block/del/',array('id'=>$t['id']));?>','确定删除 『<?php echo $t['name']; ?> 』栏目吗？')" >删除</a>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

</body>
</html>