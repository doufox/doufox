<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<script type="text/javascript">
    function cdisabled(id, c) {
        if (c == 1) {
            window.location.href = "<?php echo url('admin/model/cdisabled/', array('typeid' => $typeid, 'modelid' => '')); ?>" + id;
            return true;
        }
        if (confirm('禁用模型之后，该模型是数据将会无法访问，确定禁用吗？')) {
            window.location.href = "<?php echo url('admin/model/cdisabled/', array('typeid' => $typeid, 'modelid' => '')); ?>" + id;
        }
    }
</script>

<div class="container">
    <div class="page_menu">
        <div class="panel panel-default">
            <div class="panel-heading">模型类型</div>
            <div class="list-group">
                <?php foreach ($modelTypeName as $key => $value) { ?>
                    <a class="list-group-item <?php if ($typeid == $key) {echo 'active';} ?>" href="<?php echo url('admin/model/index', array('typeid' => $key)); ?>"><?php echo $value; ?></a>
                <?php } ?>
                <a class="list-group-item" href="<?php echo url('admin/model/add', array('typeid' => $typeid)); ?>">添加<?php echo $modelname ? $modelname : '模型'; ?></a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title"><?php echo $modelname ? $modelname : '模型管理'; ?></span>
                <div class="pull-right">
                    <a class="btn btn-default btn-xs" href="<?php echo url('admin/model/add', array('typeid' => $typeid)); ?>">添加<?php echo $modelname ? $modelname : '模型'; ?></a>
                </div>
            </div>
            <table class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>模型名称</th>
                        <th>模型类型</th>
                        <th>数据表名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($list)) {
                        foreach ($list as $t) {
                            $setting = string2array($t['setting']);
                            $disable = isset($setting['disable']) && $setting['disable'] == 1 ? 1 : 0; ?>
                            <tr>
                                <td align="left"><?php echo $t['modelid']; ?></td>
                                <td align="left"><?php echo $t['modelname']; ?></td>
                                <td align="left"><?php echo $modelTypeName[$t['typeid']]; ?></td>
                                <td align="left"><?php echo $t['tablename']; ?></td>
                                <td align="left">
                                    <a href="<?php echo url('admin/model/fields', array('typeid' => $typeid, 'modelid' => $t['modelid'])); ?>">字段管理</a>
                                    <a href="<?php echo url('admin/model/edit', array('typeid' => $typeid, 'modelid' => $t['modelid'])); ?>">编辑</a>
                                    <a href="javascript:cdisabled(<?php echo $t['modelid']; ?>, <?php echo $disable; ?>);"><?php if ($disable) { ?><font color=red><?php echo '启用'; ?></font><?php } else {
                                                                                                                                                                                                    echo '禁用 ';
                                                                                                                                                                                                } ?></a>
                                    <a href="javascript:admin_command.confirmurl('<?php echo url('admin/model/del', array('typeid' => $typeid, 'modelid' => $t['modelid'])); ?>','确定删除 『 <?php echo $t['modelname']; ?> 』吗？ ')">删除</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                <tbody>
            </table>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>