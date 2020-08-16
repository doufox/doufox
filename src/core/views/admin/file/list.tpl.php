<?php include $this->admin_view('header');?>
<?php include $this->admin_view('navbar');?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/file/index'); ?>">文件列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/file/index'); ?>">文件上传</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件管理(当前目录：<?php echo $dir; ?>)</span>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs">新建</button>
                    </div>
                </div>
                <table class="table table-bordered table-hover" id="main-table" role="grid">
                    <thead>
                        <tr role="row">
                            <th style="width: 37.2px;" class="custom-checkbox-header" rowspan="1" colspan="1">
                                <input type="checkbox" class="custom-control-input" onclick="checkbox_toggle()">
                            </th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Modified</th>
                            <th>Perms</th>
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($istop) { ?>
                        <tr>
                            <td></td>
                            <td colspan="6"><a href="<?php echo $pdir; ?>"><img src="/static/img/folder-closed.gif">上一层目录</a></td>
                        </tr>
                        <?php } foreach ($list as $k => $t) { ?>
                        <tr role="row">
                            <td class="custom-checkbox-td sorting_1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="3399" name="file[]" value="core">
                                    <label class="custom-control-label" for="3399"></label>
                                </div>
                            </td>
                            <td class="filename">
                                <img src="/static/img/ext/<?php echo $t['ico']; ?>">&nbsp;
                                <a href="<?php if ($t['url']) { echo $t['url']; } else { ?>javascript:;<?php } ?> " 
                                    rel="<?php echo $dir; echo $t['name']; ?>"
                                    title="<?php echo $t['name']; ?>"><?php echo $t['name']; ?></a>
                            </td>
                            <td>Folder </td>
                            <td>06.08.20 13:12</td>
                            <td><a title="Change Permissions" href="?p=&amp;chmod=core">0755</a> </td>
                            <td>?:?</td>
                            <td> <a title="Delete" href="?p=&amp;del=core"
                                    onclick="return confirm('Delete Folder?\n \n ( core )');"> <i class="fa fa-trash-o"
                                        aria-hidden="true"></i></a>
                                <a title="Rename" href="#" onclick="rename('', 'core');return false;"><i class="fa fa-pencil-square-o"
                                        aria-hidden="true"></i></a>
                                <a title="Copy to..." href="?p=&amp;copy=core"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                                <a title="Direct link" href="https://doufox.com/core/" target="_blank"><i class="fa fa-link"
                                        aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="gray" rowspan="1" colspan="1"></td>
                            <td class="gray" colspan="6">
                                Full Size: <span class="badge badge-light"><?php echo formatFileSize($all_files_size); ?></span>
                                File: <span class="badge badge-light"><?php echo $num_files; ?></span>
                                Folder: <span class="badge badge-light"><?php echo $num_folders; ?></span>
                                Memory used: <span class="badge badge-light"><?php echo formatFileSize(@memory_get_usage(true)); ?></span>
                                Partition size: <span class="badge badge-light"><?php echo formatFileSize(@disk_free_space($root_path)); ?></span>
                                free of: <span class="badge badge-light"><?php echo formatFileSize(@disk_total_space($root_path)); ?></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer');?>
