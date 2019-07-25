<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item active" href="<?php echo url('admin/template/index'); ?>">模板管理</a>
        <a class="list-group-item" href="<?php echo url('admin/template/add'); ?>">添加模板</a>
        <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <form action="<?php echo url('admin/template/updatefilename'); ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">模板管理</div>
                <table class="table table-bordered table-condensed table-hover" width="100%">
                    <thead>
                        <tr>
                            <th align="left">文件</th>
                            <th align="left">备注</th>
                            <th align="left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="left" colspan="3">当前位置：<?php echo $local ?></td>
                        </tr>
                        <?php if ($dir != '') { ?>
                            <tr>
                                <td align="left" colspan="3">
                                    <a href="<?php if (urldecode(dirname($dir)) == '.') {
                                                    echo '?s=admin&c=template';
                                                } else {
                                                    echo '?s=admin&c=template&dir=' . urldecode(dirname($dir) . DS);
                                                } ?>">
                                        <img src="/static/img/folder-closed.gif" />返回上一次目录</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (is_array($list)) {
                            foreach ($list as $v) :
                                $filename = basename($v);
                                if (is_dir($v))
                                    echo '<tr><td align="left"><img src="/static/img/folder-closed.gif" /> <a href="?s=admin&c=template&dir=' . urldecode($dir . $filename . DS) . '">' . $filename . '</a></td><td align="left"><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td><td></td> </tr>';
                            endforeach;
                            foreach ($list as $v) :
                                $filename = basename($v);
                                if (!is_dir($v)) {
                                    echo '<tr><td align="left"><img src="/static/img/file.gif" /> ' . $filename . '</td><td align="left"><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td>';
                                    $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
                                    if (in_array($ext, array('html', 'css', 'js')))
                                        echo '<td> <a href="?s=admin&c=template&a=edit&dir=' . urldecode($dir) . '&file=' . urldecode($filename) . '">编辑</a> </td></tr>';
                                    else
                                        echo '<td></td></tr>';
                                }
                            endforeach;
                        } ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <button type="submit" class="btn btn-default" name="dosubmit" value="更新备注">更新备注</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>