<?php include $this->admin_tpl('header');?>

<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">区块管理</span></div>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo url('admin/block'); ?>">全部区块</a>
            <a class="list-group-item" href="<?php echo url('admin/block/add'); ?>">添加区块</a>
            <a class="list-group-item" href="<?php echo url('admin/block/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">区块管理</span>
                <div class="pull-right">
                    <a href="<?php echo url('admin/block/add'); ?>">添加区块</a>
                </div>
            </div>
            <table class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>区块名称</th>
                        <th>备注</th>
                        <th width="300">模板调用代码</th>
                        <th width="120">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($list)) { foreach ($list as $t) { ?>
                    <tr>
                        <td><?php echo $t['id']; ?></td>
                        <td><a href="<?php echo url('admin/block/edit',array('id'=>$t['id'])); ?>"><?php echo $t['name']; ?></a></td>
                        <td><?php echo $t['remark']; ?></td>
                        <td>{block <?php echo $t['id']; ?>}</td>
                        <td>
                            <a href="<?php echo url('admin/block/edit', array('id'=>$t['id'])); ?>">编辑</a>
                            <a href="javascript:admin_command.confirmurl('<?php echo url('admin/block/del',array('id'=>$t['id']));?>','确定删除[<?php echo $t['name']; ?>]区块吗？')" >删除</a>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
            <div class="panel-body">
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
