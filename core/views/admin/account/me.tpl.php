<?php include $this->admin_tpl('header');?>

<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/account'); ?>">全部账号</a>
        <a class="list-group-item" href="<?php echo url('admin/account/add'); ?>">添加账号</a>
        <a class="list-group-item active" href="<?php echo url('admin/account/me'); ?>">我的账号</a>
        <a class="list-group-item" href="<?php echo url('admin/account/cache'); ?>">更新缓存</a>
    </div>
    <div id="right">
        <div id="home">
            <div id="shortcut" class="shortcut">
                <a href="javascript:_open_url(107,'<?php echo url('admin/index/cache'); ?>');" title="更新缓存">更新缓存</a>
                <a href="<?php echo HTTP_URL; ?>" title="网站首页" target="_blank">网站首页</a>
            </div>
            <label id="position" class="position">我的账号</label>
        </div>
        <div id="frame_container" style="width:100%;">
            <form method="post" action="" id="myform" name="myform">
                <table width="100%" class="table_form">
                    <tr>
                        <th width="100">账号：</th>
                        <td><?php echo $data['username']; ?></td>
                    </tr>
                    <tr>
                        <th>姓名：</th>
                        <td>
                            <input class="input-text" type="text" name="data[realname]" value="<?php echo $data['realname']; ?>" size="30"/>
                            <div class="show-tips">账号显示姓名</div>
                        </td>
                    </tr>
                    <tr>
                        <th>密码：</th>
                        <td>
                            <input class="input-text" type="text" name="data[password]" value="" size="30"/>
                            <div class="show-tips">如果不修改密码，请留空。</div>
                        </td>
                    </tr>
                    <tr>
                        <th>后台分页数：</th>
                        <td><input class="input-text" type="text" name="data[list_size]" value="<?php echo $data['list_size']; ?>" size="3"/>条
                        <div class="show-tips">后台显示列表分页的数量 显示器大的多写点 </div></td>
                    </tr>
                    <tr>
                        <th>后台左栏宽度：</th>
                        <td>
                            <input class="input-text" type="text" name="data[left_width]" value="<?php echo $data['left_width']; ?>" size="3"/>px
                            <div class="show-tips"> 后台左栏宽度,单位px 默认为150 (修改后重新打开后台生效)</div>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><input class="button" type="submit" name="submit" value="提交" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
