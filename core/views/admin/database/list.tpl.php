<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item active" href="<?php echo url('admin/database/index'); ?>">数据表</a>
        <a class="list-group-item" href="<?php echo url('admin/database/import'); ?>">备份列表</a>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">数据库管理</div>
                <input name="list_form" id="list_form" type="hidden" value="">
                <table width="100%" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th align="left" width="80">选择</th>
                            <th align="left">表名</th>
                            <th align="left">类型</th>
                            <th align="left">编码</th>
                            <th align="left">行数</th>
                            <th align="left">使用空间</th>
                            <th align="left">碎片</th>
                            <th align="left" width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $v) {?>
                        <tr>
                            <td>
                                <label>
                                    <input <?php if ($v['tables_sys']) {echo 'class="selectform"';}?> type="checkbox" name="table[]" value="<?php echo $v['Name']; ?>"/>
                                    <?php if ($v['tables_sys']) {echo '<font color="#f00">系统表</font>';} else {echo '<font color="#369">其他表</font>';}?>
                                </label>
                            </td>
                            <td><?php echo $v['Name']; ?></td>
                            <td><?php echo $v['Engine']; ?></td>
                            <td><?php echo $v['Collation']; ?></td>
                            <td><?php echo $v['Rows']; ?></td>
                            <td><?php echo formatFileSize($v['Data_length'] + $v['Index_length']); ?></td>
                            <td><?php echo formatFileSize($v['Data_free']); ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="showTableStructure('<?php echo $v['Name']; ?>')">结构</a>
                                <a href="javascript:void(0);" onclick="showTableDatas('<?php echo $v['Name']; ?>')">数据</a>
                                <a href="<?php echo url("admin/database/repair", array("name" => $v['Name'])); ?>">修复</a>
                                <a href="<?php echo url("admin/database/optimize", array("name" => $v['Name'])); ?>">优化</a>
                            </td>
                        </tr>
                        <?php }if (is_array($data)) {?>
                        <tr height="28">
                            <td colspan="8">
                                <label><input name="selectform" class="select_tables" type="checkbox" onClick="selectTables()">&nbsp;选择系统表</label>&nbsp;&nbsp;
                                <button type="submit" name="submit" class="btn btn-default" value="1">开始备份数据库</button>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <div class="panel-body">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function selectTables () {
        if ($('.select_tables').prop('checked')) {
            $('.selectform').prop("checked", true);
        } else {
            $('.selectform').prop("checked", false);
        }
    }

    function showTableStructure (table) {
        window.top.art.dialog({
            title: '表 ' + table + ' 结构',
            id: 'show',
            iframe: '<?php echo url("admin/database/structure") ?>&name=' + table,
            width: '700px',
            height: '400px'
        });
    }
    function showTableDatas (table) {
        window.top.art.dialog({
            title: '表 ' + table + ' 数据（最多查询10条）',
            id: 'show',
            iframe: '<?php echo url("admin/database/select") ?>&name=' + table,
            width: '80%',
            height: '80%'
        });
    }
</script>

<?php include $this->admin_tpl('footer');?>
