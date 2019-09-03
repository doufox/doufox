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
                        <th>ID</th>
                        <th>区块名称</th>
                        <th>备注</th>
                        <th>模板调用代码</th>
                        <th>操作</th>
                    </tr>
                <tbody>
                    <?php if (is_array($list)) { foreach ($list as $t) { ?>
                    <tr>
                        <td><?php echo $t['id']; ?></td>
                        <td><a href="<?php echo url('admin/block/edit',array('id'=>$t['id'])); ?>"><?php echo $t['name']; ?></a></td>
                        <td><?php echo $t['remark']; ?></td>
                        <td>{block <?php echo $t['id']; ?>}</td>
                        <td>
                            <a href="<?php echo url('admin/block/edit', array('id'=>$t['id'])); ?>">编辑</a>
                            <a href="#modal-block-delete" data-toggle="modal" name="删除区块" onclick="block_delete(this);" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['name']; ?>">删除</a>
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

<!-- 区块删除提示 -->
<div class="modal fade" id="modal-block-delete" tabindex="-1" role="dialog" aria-labelledby="aria-block-delete">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aria-block-delete">系统提示</h4>
            </div>
            <div class="modal-body">
                <p>确定删除区块<span id="block-delete-name"></span>吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a type="button" id="block-delete-url" class="btn btn-primary" href="#">确定</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function block_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById('block-delete-url').href = "<?php echo url('admin/block/del', array('id' => '')); ?>" + e.dataset.id;
            document.getElementById('block-delete-name').innerText = '"' + e.dataset.name + '"';
        } else {
            document.getElementById('block-delete-url').href = '';
            document.getElementById('block-delete-name').innerText = '';
        }
    }
    $('#modal-block-delete').on('hide.bs.modal', function() {
        block_delete();
    })
</script>

<?php include $this->admin_tpl('footer');?>
