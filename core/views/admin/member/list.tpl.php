<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>
<script type="text/javascript">
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
        <a class="list-group-item active" href="<?php echo url('admin/member/index'); ?>">会员管理</a>
        <a class="list-group-item" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
        <a class="list-group-item" href="<?php echo url('member/register'); ?>" target="_blank">前台注册</a>
        <a class="list-group-item" href="<?php echo url('admin/member/cache'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">会员列表</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/member/add'); ?>">添加会员</a>
                    </div>
                </div>
                <input name="form" id="list_form" type="hidden" value="">
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="25" align="left"><input name="deletec" id="deletec" type="checkbox" onclick="setC()"></th>
                            <th width="40" align="left">ID </th>
                            <th width="60" align="left">状态</th>
                            <th align="left">登录账号</th>
                            <th align="left">昵称</th>
                            <th width="80" align="left">会员模型</th>
                            <th width="160" align="left">注册时间</th>
                            <th width="110" align="left">注册IP</th>
                            <th width="100" align="left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($list)) { foreach ($list as $t) { ?>
                        <tr>
                            <td ><input name="del_<?php echo $t['id']; ?>_<?php echo $t['modelid']; ?>" type="checkbox" class="deletec"></td>
                            <td><?php echo $t['id']; ?></td>
                            <td><?php if (!$t['status']) { ?><font color="#FF0000">未审核</font><?php } else { ?>已审核<?php } ?></td>
                            <td><a href="<?php echo url('admin/member/edit',array('id'=>$t['id'])); ?>"><?php echo $t['username']; ?></a></td>
                            <td><?php echo $t['nickname']; ?></a></td>
                            <td><a href="<?php echo url('admin/member/index', array('modelid'=>$t['modelid'])); ?>"><?php echo $membermodel[$t['modelid']]['modelname']; ?></a></td>
                            <td><?php echo date('Y-m-d H:i:s', $t['regdate']); ?></td>
                            <td><?php echo $t['regip']; ?></td>
                            <td>
                                <a href="<?php echo url('admin/member/edit',array('id'=>$t['id'])); ?>">详细</a> | 
                            <a href="javascript:admin_command.confirmurl('<?php echo url('admin/member/del/',array('modelid'=>$t['modelid'],'id'=>$t['id']));?>','确定删除会员 『 <?php echo $t['username']; ?> 』吗？ ')" >删除</a> 
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <?php echo $pagination; ?>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-default" name="submit_status_1" value="1" onClick="$('#list_form').val('status_1')">设为已审核</button>
                    <button type="submit" class="btn btn-default" name="submit_status_0" value="1" onClick="$('#list_form').val('status_0')">设为未审核</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>