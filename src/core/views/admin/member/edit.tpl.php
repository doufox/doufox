<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<script type="text/javascript">
    function ajaxemail() {
        $('#email_text').html('');
        $.post('<?php echo url('api/member/ajaxemail'); ?>&_=' + Math.random(), {
            email: $('#email').val(),
            id: '<?php echo $id; ?>'
        }, function(data) {
            $('#email_text').html(data.msg);
        });
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
                    <a class="list-group-item" href="<?php echo url('admin/member/index'); ?>">用户列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加用户</a>
                    <a class="list-group-item" href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
                    <a class="list-group-item" href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-inline">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">编辑用户</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/member'); ?>">列表</a>
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/member/add'); ?>">添加</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table_form">
                            <tbody>
                                <tr>
                                    <th width="100">用户类型：</th>
                                    <td><?php echo $model['modelname']; ?></td>
                                </tr>
                                <tr>
                                    <th>登陆账号：</th>
                                    <td><?php echo $data['username']; ?></td>
                                </tr>
                                <tr>
                                    <th>用户昵称：</th>
                                    <td><input class="form-control" type="text" size="50" value="<?php echo $data['nickname']; ?>" name="data[nickname]" maxlength="50"></td>
                                </tr>
                                <tr>
                                    <th>真实姓名：</th>
                                    <td><input class="form-control" type="text" size="50" value="<?php echo $data['realname']; ?>" name="data[realname]" maxlength="50"></td>
                                </tr>
                                <tr>
                                    <th>重置密码：</th>
                                    <td>
                                        <input class="form-control" type="text" size="50" value="" name="password">
                                        <span class="show-tips">不修改密码请留空。</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>电子邮箱：</th>
                                    <td>
                                        <input class="form-control" type="text" size="50" id="email" value="<?php echo $data['email']; ?>" name="data[email]" onBlur="ajaxemail()">
                                        <span class="show-tips" id="email_text"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>注册时间：</th>
                                    <td><?php echo date('Y-m-d H:i:s', $data['regdate']); ?></td>
                                </tr>
                                <tr>
                                    <th>注册IP：</th>
                                    <td><?php echo $data['regip']; ?></td>
                                </tr>
                                <tr>
                                    <th>状态：</th>
                                    <td>
                                        <label class="label-group"><input type="radio" <?php if (!isset($data['status']) || $data['status'] == 1) { ?>checked<?php } ?> value="1" name="data[status]">已审核</label>
                                        <label class="label-group"><input type="radio" <?php if (isset($data['status']) && $data['status'] == 0) { ?>checked<?php } ?> value="0" name="data[status]">未审核</label>
                                    </td>
                                </tr>
                                <?php if ($model) { echo $data_fields; } ?>
                            </tbody>
                        </table>
                        <hr />
                        <button type="submit" class="btn btn-primary btn-sm" value="提交" name="submit">提交</button>
                        <a class="btn btn-default btn-sm" href="<?php echo url('admin/member'); ?>">取消</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>