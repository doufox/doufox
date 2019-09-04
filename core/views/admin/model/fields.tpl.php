<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title"><?php echo $data['modelname']; ?></span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/model/index', array('typeid' => $typeid)); ?>">模型管理</a>
            <a class="list-group-item" href="<?php echo url('admin/model/fields', array('typeid' => $typeid, 'modelid' => $modelid)); ?>">字段管理</a>
            <a class="list-group-item" href="<?php echo url('admin/model/addfield', array('typeid' => $typeid, 'modelid' => $modelid)); ?>">添加字段</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $data['modelname'] . '[' . $modelTypeName[$typeid] . ']'; ?>字段管理</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/model/addfield', array('typeid' => $typeid, 'modelid' => $modelid)); ?>">添加字段</a>
                    </div>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>排序</th>
                            <th>字段别名</th>
                            <th>输入类型</th>
                            <th>字段名称</th>
                            <th>前台显示</th>
                            <th>是否必填</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($baseFields)) {
                            foreach ($baseFields as $k => $v) { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $v['name']; ?></td>
                                    <td></td>
                                    <td><?php echo $k; ?></td>
                                    <td><?php echo $v['show'] ? '显示' : '隐藏'; ?></td>
                                    <td>基础字段</td>
                                    <td>
                                        <a href="<?php echo url('admin/model/ajaxedit/', array('modelid' => $modelid, 'name' => $k)); ?>">编辑</a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        <?php if (is_array($list)) {
                            foreach ($list as $t) { ?>
                                <tr>
                                    <td>
                                        <input type="text" name="order_<?php echo $t['fieldid']; ?>" style="width:25px;height:15px;" value="<?php echo $t['listorder']; ?>"></td>
                                    <td><?php echo $t['name']; ?></td>
                                    <td>
                                        <?php if ($t['formtype'] == 'merge') {
                                            echo '<span style="color:#f00;font-weight:700;">组合字段<span>';
                                        } elseif ($t['formtype'] == 'input') {
                                            echo '单行文本';
                                        } elseif ($t['formtype'] == 'textarea') {
                                            echo '多行文本';
                                        } elseif ($t['formtype'] == 'editor') {
                                            echo '编辑器';
                                        } elseif ($t['formtype'] == 'select') {
                                            echo '下拉选择框';
                                        } elseif ($t['formtype'] == 'radio') {
                                            echo '单选按钮';
                                        } elseif ($t['formtype'] == 'checkbox') {
                                            echo '复选框';
                                        } elseif ($t['formtype'] == 'image') {
                                            echo '单图上传';
                                        } elseif ($t['formtype'] == 'file') {
                                            echo '单文件上传';
                                        } elseif ($t['formtype'] == 'files') {
                                            echo '多文件上传';
                                        } elseif ($t['formtype'] == 'date') {
                                            echo '日期时间';
                                        } elseif ($t['formtype'] == 'fields') {
                                            echo '<span style="color:#f00;font-weight:700;">多字段组合</span>';
                                        } else {
                                            echo $t['formtype'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $t['field']; ?></td>
                                    <td><?php if ($t['isshow']) echo '显示';
                                        else echo '隐藏'; ?></td>
                                    <td><?php if ($t['not_null']) echo '必填';
                                        else echo '选填'; ?></td>
                                    <td>
                                        <a href="<?php echo url('admin/model/editfield', array('typeid' => $typeid, 'fieldid' => $t['fieldid'])); ?>">[编辑]</a>
                                        <a href="<?php echo url('admin/model/disable', array('typeid' => $typeid, 'fieldid' => $t['fieldid'])); ?>"><?php if ($t['disabled'] == 1) { ?><font color="#FF0000">[启用]</font><?php } else { echo '[禁用]'; } ?></a>
                                        <?php if ($t['field'] == 'content') { ?><a href="javascript:;" style="color:#ACA899">[删除]</a> <?php } else { ?><a href="javascript:admin_command.confirmurl('<?php echo url('admin/model/delfield', array('typeid' => $typeid, 'fieldid' => $t['fieldid'])); ?>','一旦删除字段，将会把 【<?php echo $t['name']; ?>】字段的数据全部删除，确定删除 <?php echo $t['name']; ?> 吗？ ')">[删除]</a> <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <button class="btn btn-default" type="submit" name="submit" value="排序">排序</button>
                </div>
            </div>
    </div>
</div>
</div>

<?php include $this->admin_tpl('footer'); ?>