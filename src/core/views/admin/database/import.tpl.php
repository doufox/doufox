<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">数据库管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/database/index'); ?>">数据表</a>
                    <a class="list-group-item active" href="<?php echo url('admin/database/import'); ?>">备份列表</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">备份列表</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/database/index'); ?>">数据表</a>
                        </div>
                    </div>
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <label class="label-group"><input name="selectform" class="select_backups" type="checkbox" onClick="selectBackup()">全选</label>
                                </th>
                                <th>备份时间</th>
                                <th>备份目录</th>
                                <th>文件大小</th>
                                <th>操作</th>
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
                                            <a href="#" onclick="showTableBackups(<?php echo $v['path'] ?>);">预览</a>
                                            <a href="javascript:void(0);">下载</a>
                                            <a href="#" onclick="resetTable(<?php echo $v['path'] ?>);">恢复</a>
                                            <a href="#" onclick="deleteTable(<?php echo $v['path'] ?>);">删除</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } else { ?>
                            <tbody>
                                <tr>
                                    <td colspan="5">没有备份文件</td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                    <div class="panel-body"><button type="submit" name="submit" class="btn btn-default" value="1">批量删除</button></div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 确认框 -->
<div class="modal fade" id="modal-database-confirm" tabindex="-1" role="dialog" aria-labelledby="aria-database-confirm">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="database-confirm-title">系统提示</h4>
            </div>
            <div class="modal-body" id="database-confirm-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a type="button" class="btn btn-danger" id="database-confirm-url">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 数据库查看 -->
<div class="modal fade" id="modal-database-view" tabindex="-1" role="dialog" aria-labelledby="数据库查看">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="database-view-title">系统提示</h4>
            </div>
            <div class="modal-body">
                <iframe id="database-view-body" width="100%" frameborder="0" onload="setIframeHeight(this);"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
            </div>
        </div>
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
        if (path) {
            $('#modal-database-view').modal();
            document.getElementById('database-view-title').innerText = '查看备份文件"' + path + '"';
            document.getElementById('database-view-body').src = "<?php echo url('admin/database/view', array('file' => '')); ?>" + path;
        }
    }
    function resetTable(path) {
        if (path) {
            $('#modal-database-confirm').modal();
            document.getElementById('database-confirm-title').innerText = '系统提示';
            document.getElementById('database-confirm-body').innerHTML = '<p>确定将备份文件"' + path + '"恢复到系统吗？</p><p>此操作将会覆盖现有数据！</p>';
            document.getElementById('database-confirm-url').href = '<?php echo url("admin/database/import", array("path" => "")); ?>' + path;
        }
    }
    function deleteTable(path) {
        if (path) {
            $('#modal-database-confirm').modal();
            document.getElementById('database-confirm-title').innerText = '系统提示';
            document.getElementById('database-confirm-body').innerText = '确定删除备份文件"' + path + '"吗？';
            document.getElementById('database-confirm-url').href = '<?php echo url("admin/database/delbackedfile", array("path" => "")); ?>' + path;
        }
    }
    $('#modal-database-view').on('hide.bs.modal', function() {
        document.getElementById('database-view-title').innerText = '系统提示';
        document.getElementById('database-view-body').src = '';
        document.getElementById('database-view-body').height = '';
    });
    $('#modal-database-confirm').on('hide.bs.modal', function() {
        document.getElementById('database-confirm-title').innerText = '系统提示';
        document.getElementById('database-confirm-url').href = '';
        document.getElementById('database-confirm-body').innerText = '';
    });
</script>

<?php include $this->views('admin/footer'); ?>