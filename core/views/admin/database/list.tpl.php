<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">数据库管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo url('admin/database/index'); ?>">数据表</a>
            <a class="list-group-item" href="<?php echo url('admin/database/import'); ?>">备份列表</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">数据表</span>
                    <div class="pull-right">
                        <a href="<?php echo url('admin/database/import'); ?>">备份列表</a>
                    </div>
                </div>
                <input name="list_form" id="list_form" type="hidden" value="">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>选择</th>
                            <th>表名</th>
                            <th>类型</th>
                            <th>编码</th>
                            <th>行数</th>
                            <th>使用空间</th>
                            <th>碎片</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $v) { ?>
                            <tr>
                                <td>
                                    <label class="label-group">
                                        <input <?php if ($v['tables_sys']) {
                                                    echo 'class="selectform"';
                                                } ?> type="checkbox" name="table[]" value="<?php echo $v['Name']; ?>" />
                                        <?php if ($v['tables_sys']) {
                                            echo '<font color="#f00">系统表</font>';
                                        } else {
                                            echo '<font color="#369">其他表</font>';
                                        } ?>
                                    </label>
                                </td>
                                <td><?php echo $v['Name']; ?></td>
                                <td><?php echo $v['Engine']; ?></td>
                                <td><?php echo $v['Collation']; ?></td>
                                <td><?php echo $v['Rows']; ?></td>
                                <td><?php echo formatFileSize($v['Data_length'] + $v['Index_length']); ?></td>
                                <td><?php echo formatFileSize($v['Data_free']); ?></td>
                                <td>
                                    <a href="#" onclick="showTable('structure', '<?php echo $v['Name']; ?>')">结构</a>
                                    <a href="#" onclick="showTable('data', '<?php echo $v['Name']; ?>')">数据</a>
                                    <a href="<?php echo url("admin/database/repair", array("name" => $v['Name'])); ?>">修复</a>
                                    <a href="<?php echo url("admin/database/optimize", array("name" => $v['Name'])); ?>">优化</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <?php if (is_array($data)) { ?>
                    <tfoot>
                        <td colspan="8">
                            <label class="label-group"><input name="selectform" class="select_tables" type="checkbox" onClick="selectTables()">选择系统表</label>
                            <button type="submit" name="submit" class="btn btn-default" value="1">开始备份数据库</button>
                        </td>
                    </tfoot>
                    <?php } ?>
                </table>
                <div class="panel-body"></div>
            </div>
        </form>
    </div>
</div>

<!-- 数据库查看 -->
<div class="modal fade" id="modal-database-view" tabindex="-1" role="dialog" aria-labelledby="aria-database-view">
    <div class="modal-dialog modal-lg" role="document">
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
    function selectTables() {
        if ($('.select_tables').prop('checked')) {
            $('.selectform').prop("checked", true);
        } else {
            $('.selectform').prop("checked", false);
        }
    }
    function showTable(type, table) {
        if (table) {
            $('#modal-database-view').modal();
            if (type == 'structure') {
                document.getElementById('database-view-title').innerText = '表"' + table + '"结构';
                document.getElementById('database-view-body').src = "<?php echo url('admin/database/structure', array('name' => '')); ?>" + table;
                // $("#modal-database-view .modal-body").load("<?php echo url('admin/database/structure', array('name' => '')); ?>" + table);
            } else if (type == 'data') {
                document.getElementById('database-view-title').innerText = '表"' + table + '前10条数据';
                document.getElementById('database-view-body').src = "<?php echo url('admin/database/select', array('name' => '')); ?>" + table;
                // $("#modal-database-view .modal-body").load("<?php echo url('admin/database/select', array('name' => '')); ?>" + table);
            }
        }
    }
    $('#modal-database-view').on('hide.bs.modal', function() {
        document.getElementById('database-view-title').innerText = '系统提示';
        // $("#modal-database-view .modal-body").html('');
        document.getElementById('database-view-body').src = '';
        document.getElementById('database-view-body').height = '';
    })
</script>

<?php include $this->admin_tpl('footer'); ?>