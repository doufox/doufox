<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<script type="text/javascript">
    function setC() {
        if ($("#deletec").prop('checked') == true) {
            $(".deletec").prop("checked", true);
        } else {
            $(".deletec").prop("checked", false);
        }
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">用户管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/member/index'); ?>">用户列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加用户</a>
                    <a class="list-group-item" href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">用户列表</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/member/add'); ?>">添加</a>
                        </div>
                    </div>
                    <input name="form" id="list_form" type="hidden" value="">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th><input name="deletec" id="deletec" type="checkbox" onclick="setC()"></th>
                                <th>ID</th>
                                <th>状态</th>
                                <th>登录账号</th>
                                <th>昵称</th>
                                <th>真实姓名</th>
                                <th>用户类型</th>
                                <th>注册时间</th>
                                <th>注册IP</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($list)) {
                                foreach ($list as $t) { ?>
                                    <tr>
                                        <td><input name="del_<?php echo $t['id']; ?>_<?php echo $t['modelid']; ?>" type="checkbox" class="deletec"></td>
                                        <td><?php echo $t['id']; ?></td>
                                        <td><?php if (!$t['status']) { ?><font color="#FF0000">禁用</font><?php } else { ?>正常<?php } ?></td>
                                        <td><a href="<?php echo url('admin/member/edit', array('id' => $t['id'])); ?>"><?php echo $t['username']; ?></a></td>
                                        <td><?php echo $t['nickname']; ?></a></td>
                                        <td><?php echo $t['realname']; ?></a></td>
                                        <td><a href="<?php echo url('admin/member/index', array('modelid' => $t['modelid'])); ?>"><?php echo $membermodel[$t['modelid']]['modelname']; ?></a></td>
                                        <td><?php echo date('Y-m-d H:i:s', $t['regdate']); ?></td>
                                        <td><?php echo $t['regip']; ?></td>
                                        <td>
                                            <a href="<?php echo url('admin/member/edit', array('id' => $t['id'])); ?>">详情</a>
                                            <a href="#modal-confirm" data-toggle="modal" name="删除用户" onclick="member_delete(this);" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['username']; ?>">删除</a>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <div class="panel-body">
                        <?php echo $pagination; ?>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default" name="submit_status_1" value="1" onClick="$('#list_form').val('status_1')">设为启用</button>
                        <button type="submit" class="btn btn-default" name="submit_status_0" value="1" onClick="$('#list_form').val('status_0')">设为禁用</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function member_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById('modal-confirm-url').href = "<?php echo url('admin/member/del', array('modelid' => $t['modelid'], 'id' => '')); ?>" + e.dataset.id;
            document.getElementById('modal-confirm-body').innerText = '确定删除用户"' + e.dataset.name + '"吗？';
        }
    }
</script>

<?php include $this->views('admin/footer'); ?>