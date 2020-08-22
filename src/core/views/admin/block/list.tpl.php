<?php include $this->admin_view('header');?>
<?php include $this->admin_view('navbar');?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">区块管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/block'); ?>">全部区块</a>
                    <a class="list-group-item" href="<?php echo url('admin/block/add'); ?>">添加区块</a>
                    <a class="list-group-item" href="<?php echo url('admin/block/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">区块管理</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/block/add'); ?>">添加</a>
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
                                <a href="<?php echo url('admin/block/edit', array('id'=>$t['id'])); ?>" title="编辑"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="#modal-confirm" title="删除" data-toggle="modal" name="删除区块" onclick="block_delete(this);" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['name']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
</div>

<script type="text/javascript">
    function block_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById("modal-confirm-url").href = "<?php echo url('admin/block/del', array('id' => '')); ?>" + e.dataset.id;
            document.getElementById("modal-confirm-body").innerText = '确定删除区块"' + e.dataset.name + '"吗？';
        }
    }
</script>

<?php include $this->admin_view('footer');?>
