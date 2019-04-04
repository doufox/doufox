<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '会员信息';
</script>

<script type="text/javascript">
    function ajaxemail() {
        $('#email_text').html('');
        $.post('<?php echo url('api/member/ajaxemail'); ?>&rid=' + Math.random(), {
            email: $('#email').val(),
            id: <?php echo $id; ?>
        }, function(data) {
            $('#email_text').html(data.msg);
        });
    }
</script>
<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/member/index'); ?>">会员管理</a>
        <a href="<?php echo url('admin/member/add'); ?>">添加会员</a>
        <div class="options">
            <a href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
            <a href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="table_form">
        <form method="post" action="" id="myform" name="myform">
            <table width="100%" class="table_form ">
                <tbody>
                    <tr>
                        <th width="100">会员类型：</th>
                        <td>
                            <?php echo $model['modelname']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>登陆账号：</th>
                        <td>
                            <?php echo $data['username']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>会员昵称：</th>
                        <td><input type="text" class="input-text" size="50" value="<?php echo $data['nickname']; ?>" name="data[nickname]" maxlength="50"></td>
                    </tr>
                    <tr>
                        <th>重置密码：</th>
                        <td><input type="text" class="input-text" size="50" value="" name="password">
                            <div class="show-tips">不修改密码请留空。</div>
                        </td>
                    </tr>
                    <tr>
                        <th>电子邮箱：</th>
                        <td><input type="text" class="input-text" size="50" id="email" value="<?php echo $data['email']; ?>" name="data[email]" onBlur="ajaxemail()">
                            <div class="show-tips" id="email_text"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>注册时间：</th>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $data['regdate']); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>注册IP：</th>
                        <td>
                            <?php echo $data['regip']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>会员状态：</th>
                        <td>
                            <label><input type="radio" <?php if (!isset($data['status']) || $data['status'] == 1) {?>checked<?php }?> value="1" name="data[status]"> 已审核</label> &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" <?php if (isset($data['status']) && $data['status'] == 0) {?>checked<?php }?> value="0" name="data[status]"> 未审核</label>
                        </td>
                    </tr>
                    <?php if ($model) {echo $data_fields;}?>
                    <tr>
                        <th>&nbsp;</th>
                        <td><input type="submit" class="button" value="提交" name="submit"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
</body>

</html>