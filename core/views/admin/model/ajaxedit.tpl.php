<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '字段编辑';
    $(document).keyup(function(event) {
        if (event.keyCode ==13) {
            $("#submit").trigger("click");
        }
    });
</script>

<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/model/index', array('typeid'=>$typeid)); ?>">模型管理</a>
        <a href="<?php echo url('admin/model/fields/', array('typeid'=>$typeid, 'modelid'=>$modelid)); ?>">字段管理</a>
        <a href="javascript:;" class="on">编辑</a>
    </div>
    <div class="bk10 bottom-line"></div>
    <div class="table_form">
        <form action="" method="post">
        <table width="100%" class="table_form">
        <tr>
            <th width="200">模型名称： </th>
            <td><?php echo $name; ?></td>
        </tr>
        <tr>
            <th><font color="red">*</font> 字段别名： </th>
            <td><input class="input-text" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="20" /><div class="show-tips">例如：标题。</div></td>
        </tr>
        <tr>
            <th>是否显示：</th>
            <td>
            <input type="radio" <?php if ($data['show']) { ?>checked<?php } ?> value="1" name="data[show]"> 显示
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" <?php if (empty($data['show'])) { ?>checked<?php } ?> value="0" name="data[show]" > 隐藏
            </td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input class="button" type="submit" name="submit" id="submit" value="提交" /></td>
        </tr>
        </table>
        </form>
    </div>
</div>
</body>
</html>