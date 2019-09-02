<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">数据库管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/database/index'); ?>">数据表</a>
            <a class="list-group-item active" href="<?php echo url('admin/database/import'); ?>">备份列表</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">备份列表</span>
                    <div class="pull-right">
                        <a href="<?php echo url('admin/database/index'); ?>">数据表</a>
                    </div>
                </div>
                <div class="panel-body">备份目录：/data/bakup/</div>
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="66">
                                <label class="label-group"><input name="selectform" class="select_backups" type="checkbox" onClick="selectBackup()">全选</label>
                            </th>
                            <th width="160">备份时间</th>
                            <th>备份文件目录</th>
                            <th width="150">文件大小</th>
                            <th width="150">操作</th>
                        </tr>
                    </thead>
                    <?php if ($list) { ?>
                        <tbody>
                            <?php foreach ($list as $v) { ?>
                                <tr>
                                    <td>
                                        <label class="label-group"><input class="selectform" type="checkbox" name="paths[]" value="<?php echo $v['path'] ?>" />选择</label>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i:s', $v['path']) ?></td>
                                    <td><?php echo $v['sqldir'] ?></td>
                                    <td><?php echo $v['size'] ?></td>
                                    <td>
                                        <a href="javascript:admin_command.confirmurl('<?php echo url("admin/database/import", array("path" => $v['path'])) ?>', '确定恢复数据库吗')">恢复</a>
                                        <a href="javascript:showTableBackups(<?php echo $v['path'] ?>);">预览</a>
                                        <a href="javascript:void(0);">下载</a>
                                        <a href="javascript:admin_command.confirmurl('<?php echo url("admin/database", array("path" => $v['path'])) ?>', '确定删除吗？');">删除</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <td colspan="5">
                                <button type="submit" name="submit" class="btn btn-default" value="1">批量删除</button>
                            </td>
                        </tfoot>
                    <?php } else { ?>
                        <tbody>
                            <tr>
                                <td colspan="5">没有备份文件</td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function selectBackup() {
        if ($('.select_backups').prop('checked')) {
            $('.selectform').prop('checked', true);
        } else {
            $('.selectform').prop('checked', false);
        }
    }

    function showTableBackups(path) {
        window.top.art.dialog({
            title: '查看备份数据' + path,
            id: 'show',
            iframe: '<?php echo url("admin/database/view") ?>&file=' + path,
            width: '80%',
            height: '400px'
        });
    }
</script>

<?php include $this->admin_tpl('footer'); ?>