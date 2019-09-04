<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">账号管理</span></div>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo url('admin/account'); ?>">全部账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/add'); ?>">添加账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/me'); ?>">我的账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title"><?php echo $page_title; ?></span>
                <div class="pull-right">
                    <a href="<?php echo url('admin/account/add'); ?>">添加账号</a>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>账号</th>
                        <th>姓名</th>
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($list)) foreach ($list as $t) { ?>
                        <tr height="25">
                            <td><?php echo $t['userid']; ?></td>
                            <td><a title="编辑账号" href="<?php echo url('admin/account/edit', array('userid' => $t['userid'])); ?>"><?php echo $t['username']; ?></a></td>
                            <td><?php echo $t['realname']; ?></td>
                            <td><?php if ($t['roleid'] == 1) {
                                                        echo '超级管理员';
                                                    } else {
                                                        echo '一般账号';
                                                    } ?></td>
                            <td>
                                <a href="<?php echo url('admin/account/edit', array('userid' => $t['userid'])); ?>">编辑</a>
                                <a href="#modal-account-delete" data-toggle="modal" name="删除账号" onclick="account_delete(this);" data-id="<?php echo $t['userid']; ?>" data-name="<?php echo $t['username']; ?>">删除</a>
                            </td>
                        </tr>
                    <?php } ?>
                <tbody>
            </table>
            <div class="panel-body"></div>
        </div>
    </div>
</div>

<!-- 账号删除提示 -->
<div class="modal fade" id="modal-account-delete" tabindex="-1" role="dialog" aria-labelledby="aria-account-delete">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aria-account-delete">系统提示</h4>
            </div>
            <div class="modal-body">
                <p>确定删除账号<span id="account-delete-name"></span>吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a type="button" id="account-delete-url" class="btn btn-primary" href="#">确定</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function account_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById('account-delete-url').href = "<?php echo url('admin/account/del', array('userid' => '')); ?>" + e.dataset.id;
            document.getElementById('account-delete-name').innerText = '"' + e.dataset.name + '"';
        } else {
            document.getElementById('account-delete-url').href = '';
            document.getElementById('account-delete-name').innerText = '';
        }
    }
    $('#modal-account-delete').on('hide.bs.modal', function () {
        account_delete();
    })
</script>

<?php include $this->admin_tpl('footer'); ?>