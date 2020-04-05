<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">模型类型</div>
                <div class="list-group">
                    <?php foreach ($modelTypeName as $key => $value) { ?>
                        <a class="list-group-item <?php if ($typeid == $key) {echo 'active';} ?>" href="<?php echo url('admin/model/index', array('typeid' => $key)); ?>"><?php echo $value; ?></a>
                    <?php } ?>
                    <a class="list-group-item" href="<?php echo url('admin/model/add', array('typeid' => $typeid)); ?>">添加<?php echo $modelname ? $modelname : '模型'; ?></a>
                    <a class="list-group-item" href="<?php echo url('admin/model/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
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
                                $disable = isset($setting['disable']) && $setting['disable'] == 1 ? 1 : 0;
                                $status = $disable == 1 ? '<font color=red>启用</font>' : '禁用';
                                unset($setting);
                            ?>
                                <tr>
                                    <td><?php echo $t['modelid']; ?></td>
                                    <td><?php echo $t['modelname']; ?></td>
                                    <td><?php echo $modelTypeName[$t['typeid']]; ?></td>
                                    <td><?php echo $t['tablename']; ?></td>
                                    <td>
                                        <a href="<?php echo url('admin/model/fields', array('typeid' => $typeid, 'modelid' => $t['modelid'])); ?>">字段管理</a>
                                        <a href="<?php echo url('admin/model/edit', array('typeid' => $typeid, 'modelid' => $t['modelid'])); ?>">编辑</a>
                                        <a href="javascript:model_disable('<?php echo $t['modelid']; ?>', '<?php echo $disable; ?>');"><?php echo $status; ?></a>
                                        <a href="javascript:model_delete('<?php echo $t['modelid']; ?>', '<?php echo $t['modelname']; ?>')">删除</a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 提示 -->
<div class="modal fade" id="modal-model-alert" tabindex="-1" role="dialog" aria-labelledby="aria-model-alert">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aria-model-alert">系统提示</h4>
            </div>
            <div class="modal-body" id="model-alert-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a type="button" id="model-alert-url" class="btn btn-primary" href="#">确定</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function model_delete(id, name) {
        if (id && name) {
            $('#modal-model-alert').modal();
            document.getElementById('model-alert-url').href = '<?php echo url("admin/model/del", array("modelid" => "")); ?>' + id;
            document.getElementById('model-alert-body').innerText = '确定删除模型"' + name + '"吗？';
        }
    }
    function model_disable (id, cur) {
        $('#modal-model-alert').modal();
        document.getElementById('model-alert-url').href = '<?php echo url("admin/model/cdisabled", array("typeid" => $typeid, "modelid" => "")); ?>' + id;
        document.getElementById('model-alert-body').innerText = cur == 1 ? '确定启用模型吗？' : '禁用之后，该模型的数据将无法访问，确定禁用吗？';
    }
    $('#modal-model-alert').on('hide.bs.modal', function() {
        document.getElementById('model-alert-url').href = '';
        document.getElementById('model-alert-body').innerText = '';
    })
</script>

<?php include $this->admin_view('footer'); ?>