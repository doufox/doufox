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
                    <span class="panel-title">文件预览：<?php echo $file; ?></span>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs">新建</button>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-noborder table-condensed" role="grid">
                        <tbody>
                            <tr>
                                <td style="width: 100px;">文件</td>
                                <td><?php echo $file; ?></td>
                            </tr>
                            <tr>
                                <td>文件路径：</td>
                                <td><?php echo $file_path; ?></td>
                            </tr>
                            <tr>
                                <td>文件类型：</td>
                                <td><?php echo $file_type; ?></td>
                            </tr>
                            <tr>
                                <td>文件名：</td>
                                <td><?php echo $this->encode_html($filename) ?></td>
                            </tr>
                            <tr>
                                <td>文件路径：</td>
                                <td><?php echo $this->encode_html($file_path) ?></td>
                            </tr>
                            <tr>
                                <td>文件大小：</td>
                                <td><?php echo $this->get_filesize($filesize) ?><?php if ($filesize >= 1000) : ?> (<?php echo sprintf('%s bytes', $filesize) ?>)<?php endif; ?></td>
                            </tr>
                            <tr>
                                <td>MIME类型：</td>
                                <td><?php echo $mime_type ?></td>
                            </tr>
                        <?php if ($is_zip) { ?>
                            <tr>
                                <td>文件数量</td>
                                <td><?php echo $total_files; ?></td>
                            </tr>
                            <tr>
                                <td>压缩文件大小</td>
                                <td> <?php echo $total_comp; ?></td>
                            </tr>
                            <tr>
                                <td>全部文件大小</td>
                                <td><?php echo $total_uncomp; ?></td>
                            </tr>
                            <tr>
                                <td>压缩率</td>
                                <td><?php echo $ratio; ?> %</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>Size</td>
                            </tr>
                        <?php } if ($is_image) { ?>
                            <tr>
                                <td>图片尺寸</td>
                                <td><?php echo $image_size; ?></td>
                            </tr>
                        <?php } if ($is_text) { ?>
                            <tr>
                                <td>Charset</td>
                                <td><?php echo $charset; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <p>
                        <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">返回</button>
                        <?php if ($is_text) { ?>
                        <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑</a>
                        <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑器编辑</a>
                        <?php } if ($is_zip) { ?>
                        <a href="<?php echo url('admin/file/unzip', array('file' => $filename)); ?>" class="btn btn-default">解压</a>
                        <a href="<?php echo url('admin/file/unzip', array('file' => $filename, 'tofolder' => 1)); ?>" class="btn btn-default">解压到</a>
                        <?php } ?>
                        <a href="<?php echo url('admin/file/download', array('file' => $filename)); ?>" class="btn btn-default">下载</a>
                    </p>
                    <?php if ($is_zip) { ?>
                    <p>压缩包内文件列表：</p>
                    <div class="alert alert-info"><?php echo $content; ?></div>
                    <?php } elseif ($is_image) { ?>
                        <img class="img-responsive img-thumbnail" src="<?php echo $content; ?>" alt="图片预览" />
                    <?php } elseif ($is_audio) { ?>
                        <audio src="<?php echo $content; ?>" controls preload="metadata"></audio>
                    <?php } elseif ($is_video) { ?>
                        <video src="<?php echo $content; ?>" width="640" height="360" controls preload="metadata"></video>
                    <?php } elseif ($is_text) {
                        echo $content;
                    } ?>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">返回</button>
                <?php if ($is_text) { ?>
                    <button type="button" class="btn btn-default">编辑</button>
                    <button type="button" class="btn btn-default">编辑器编辑</button>
                <?php } if ($is_zip) { ?>
                    <button type="button" class="btn btn-default">解压</button>
                <?php } ?>
                    <button type="button" class="btn btn-default">压缩</button>
                    <button type="button" class="btn btn-default">删除</button>
                    <a href="<?php echo $download_url; ?>" class="btn btn-default">下载</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer');?>
