<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

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
<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">会员管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/member/index'); ?>">会员列表</a>
            <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
            <a class="list-group-item" href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
            <a class="list-group-item" href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">编辑会员</span>
                    <div class="pull-right">
                        <a href="<?php echo url('admin/member/add'); ?>">添加会员</a>
                        <a href="<?php echo url('admin/member'); ?>">会员列表</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table_form">
                        <tbody>
                            <tr>
                                <th width="100">会员类型：</th>
                                <td><?php echo $model['modelname']; ?></td>
                            </tr>
                            <tr>
                                <th>登陆账号：</th>
                                <td><?php echo $data['username']; ?></td>
                            </tr>
                            <tr>
                                <th>会员昵称：</th>
                                <td><input class="form-control" type="text" size="50" value="<?php echo $data['nickname']; ?>" name="data[nickname]" maxlength="50"></td>
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
                            <?php if ($model) {
                                echo $data_fields;
                            } ?>
                        </tbody>
                    </table>
                    <hr />
                    <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>