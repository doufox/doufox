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
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/member/index'); ?>">会员管理</a>
        <a class="list-group-item active" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
        <a class="list-group-item" href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
        <a class="list-group-item" href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">添加会员</div>
                <div class="panel-body">
                    <table width="100%" class="table_form">
                        <tbody>
                            <tr>
                                <th width="100">会员类型：</th>
                                <td><?php echo $model['modelname']; ?>
                                    <select class="form-control" name="data[modelid]">
                                        <option value="0"> == 会员类型 == </option>
                                        <?php if (is_array($membermodel)) {
                                            foreach ($membermodel as $t) { ?>
                                                <option value="<?php echo $t['modelid']; ?>"><?php echo $t['modelname']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>登陆账号：</th>
                                <td>
                                    <input class="form-control" type="text" size="20" value="" name="data[username]" maxlength="20" />
                                </td>
                            </tr>
                            <tr>
                                <th>会员昵称：</th>
                                <td><input class="form-control" type="text" size="50" value="" name="data[nickname]" maxlength="50"></td>
                            </tr>
                            <tr>
                                <th>登陆密码：</th>
                                <td><input class="form-control" type="text" size="50" value="" name="data[password]"></td>
                            </tr>
                            <tr>
                                <th>电子邮箱：</th>
                                <td>
                                    <input class="form-control" type="text" size="50" id="email" value="" name="data[email]" onBlur="ajaxemail()">
                                    <span class="show-tips" id="email_text"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>设置状态：</th>
                                <td>
                                    <label><input type="radio" <?php if (!isset($data['status']) || $data['status'] == 1) { ?>checked<?php } ?> value="1" name="data[status]"> 已审核</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" <?php if (isset($data['status']) && $data['status'] == 0) { ?>checked<?php } ?> value="0" name="data[status]"> 未审核</label>
                                </td>
                            </tr>
                            <?php if ($model) {
                                echo $data_fields;
                            } ?>
                            <tr>
                                <th>&nbsp;</th>
                                <td><button type="submit" class="btn btn-default" value="1" name="submit">提交</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>