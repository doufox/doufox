<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<script type="text/javascript">
function confirm_del() {
    if (confirm('确定删除吗？')) {
        document.myform.submit();
        return true;
    } else {
        return false;
    }
}
function setC() {
    if($("#deletec").prop('checked')==true) {
        $(".deletec").prop("checked",true);
    } else {
        $(".deletec").prop("checked",false);
    }
}
</script>
<div class="container">
    <div class="list-group page_menu">
        <?php if (!$join) {?><a class="list-group-item" href="<?php echo url('index/form', array('modelid' => $modelid)); ?>" target="_blank">发布内容</a><?php };?>
        <a class="list-group-item" href="<?php echo url('admin/form/config', array('modelid' => $modelid, 'cid' => $cid)); ?>">表单设置</a>
    </div>
    <div class="page_content">
        <form action="" method="post" name="myform">
            <input name="form" id="list_form" type="hidden" value="order">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $page_title;?></span>
                    <div class="pull-right"></div>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="20"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"></th>
                            <th width="20">ID </th>
                            <th width="80">状态 </th>
                            <?php if (is_array($model['setting']['form']['show'])) {foreach ($model['setting']['form']['show'] as $f) {?>
                            <th><?php echo $model['fields']['data'][$f]['name']; ?></th>
                            <?php }}if ($join) {?><th>关联id</th><?php }?>
                            <th width="100">发布人</th>
                            <th width="150">更新时间</th>
                            <th width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($list)) {foreach ($list as $t) {?>
                    <tr>
                        <td><input name="del_<?php echo $t['id']; ?>" type="checkbox" class="deletec"></td>
                        <td><?php echo $t[id]; ?></td>
                        <td>
                            <?php if (!$t['status']) {?><font color="#f00">[未审核]</font>
                            <?php } else {?><font color="#999">正常</font><?php };?>
                        </td>
                        <?php if (is_array($model['setting']['form']['show'])) {foreach ($model['setting']['form']['show'] as $f) {?>
                        <td><?php echo $t[$f]; ?></td>
                        <?php }}if ($join) {?><td><a href="<?php echo url('admin/form/list', array('userid' => $t['userid'], 'modelid' => $modelid, 'cid' => $t['cid'])); ?>"><?php echo $t['cid']; ?></a></td><?php }?>
                        <td><?php if ($t['username']) {?><a href="<?php echo url('admin/form/list', array('userid' => $t['userid'], 'modelid' => $modelid, 'cid' => $cid)); ?>"><?php echo $t['username']; ?></a><?php } else {echo $t['ip'];}?></td>
                        <td><span style="<?php if (date('Y-m-d', $t['time']) == date('Y-m-d')) {?>color:#F00<?php }?>"><?php echo date('Y-m-d H:i:s', $t['time']); ?></span></td>
                        <td>
                            <a href="<?php echo url('admin/form/edit', array('id' => $t['id'], 'modelid' => $modelid, 'cid' => $cid)); ?>">查看</a>
                            <a href="<?php echo url('admin/form/edit', array('id' => $t['id'], 'modelid' => $modelid, 'cid' => $cid)); ?>">编辑</a>
                            <a href="javascript:admin_command.confirmurl('<?php $del = url('admin/form/del', array('modelid' => $modelid, 'id' => $t['id'], 'cid' => $cid));?>','确定删除 吗？')">删除</a>
                        </td>
                    </tr>
                    <?php }}?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <button type="submit" class="btn btn-default btn-sm" value="删除" name="submit_del" onClick="$('#list_form').val('del');return confirm_del();">删除</button>
                    <button type="submit" class="btn btn-default btn-sm" value="设置为审核" name="submit_status_1" onClick="$('#list_form').val('status_1')">设置为审核</button>
                    <button type="submit" class="btn btn-default btn-sm" value="设置为未审核" name="submit_status_0" onClick="$('#list_form').val('status_0')">设置为未审核</button>
                </div>
                <?php echo $pagination; ?>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
