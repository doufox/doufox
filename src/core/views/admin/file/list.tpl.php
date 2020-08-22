<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg'); ?>

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
                                <td colspan="6">
                                    <a href="<?php echo $pdir; ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i> 上一层目录</a>
                                </td>
                            </tr>
                        <?php }
                        foreach ($list as $k => $t) { ?>
                            <tr role="row">
                                <td class="custom-checkbox-td sorting_1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="3399" name="file[]" value="core">
                                        <label class="custom-control-label" for="3399"></label>
                                    </div>
                                </td>
                                <td>
                                    <i class="<?php echo $t['ico']; ?>"></i>&nbsp;
                                    <a href="<?php echo $t['url']; ?>" title="<?php echo $t['name']; ?>"><?php echo $t['name']; ?></a>
                                </td>
                                <td>
                                    <?php if ($t['is_dir']) { ?>
                                        <span>文件夹</span>
                                    <?php } else { ?>
                                        <span title="<?php echo $t['filesize_raw']; ?>"><?php echo $t['filesize']; ?></span>
                                    <?php } ?>
                                </td>
                                <td>06.08.20 13:12</td>
                                <td><a title="Change Permissions" href="?p=&amp;chmod=core">0755</a> </td>
                                <td>?:?</td>
                                <td> <a title="Delete" href="?p=&amp;del=core" onclick="return confirm('Delete Folder?\n \n ( core )');"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <a title="Rename" href="#" onclick="rename('', 'core');return false;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a title="Copy to..." href="?p=&amp;copy=core"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                                    <a title="Direct link" href="https://doufox.com/core/" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
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
                <div>
                    <ul class="list-inline footer-action">
                        <li class="list-inline-item"><button class="btn btn-small btn-primary" onclick="select_all();"><i class="fa fa-check-square"></i></button></li>
                        <li class="list-inline-item"><a href="#/unselect-all" class="btn btn-small btn-outline-primary btn-2" onclick="unselect_all();return false;"><i class="fa fa-window-close"></i> Unselect all </a></li>
                        <li class="list-inline-item"><a href="#/invert-all" class="btn btn-small btn-outline-primary btn-2" onclick="invert_all();return false;"><i class="fa fa-th-list"></i> Invert Selection </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="delete" id="a-delete" value="Delete" onclick="return confirm('Delete selected files and folders?')">
                            <a href="javascript:document.getElementById('a-delete').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-trash"></i> Delete </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="zip" id="a-zip" value="zip" onclick="return confirm('Create archive?')">
                            <a href="javascript:document.getElementById('a-zip').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i> Zip </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="tar" id="a-tar" value="tar" onclick="return confirm('Create archive?')">
                            <a href="javascript:document.getElementById('a-tar').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i> Tar </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="copy" id="a-copy" value="Copy">
                            <a href="javascript:document.getElementById('a-copy').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-files-o"></i> Copy </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>