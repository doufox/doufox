<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="panel-title">添加内容</span>
            <div class="pull-right">
                <a class="btn btn-default btn-xs" href="<?php echo url('admin/content', array('catid'=>$catid)); ?>">列表</a>
            </div>
        </div>
        <div class="panel-body">
            <form method="post" action="" class="form-inline">
                <input name="backurl" type="hidden" value="<?php echo $backurl; ?>">
                <table width="100%" class="table_form">
                    <tbody>
                        <tr>
                            <th width="80">
                                <font color="red">*</font>&nbsp;栏目：
                            </th>
                            <td>
                                <select class="form-control" name="data[catid]">
                                    <?php echo $category; ?>
                                </select>
                            </td>
                        </tr>
                        <?php if ($model['content']['title']['show']) { ?>
                            <tr>
                                <th>
                                    <font color="red">*</font>&nbsp;<?php echo $model['content']['title']['name']; ?>：
                                </th>
                                <td>
                                    <input type="text" class="form-control" size="50" id="title" value="<?php echo $data['title']; ?>" name="data[title]" onBlur="ajaxtitle()">
                                    <span class="show-tips" id="title_text">标题</span>
                                </td>
                            </tr>
                        <?php }
                        if ($model['content']['thumb']['show']) { ?>
                            <tr>
                                <th><?php echo $model['content']['thumb']['name']; ?>：</th>
                                <td>
                                    <div id="imgPreviewthumb"></div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" size="50" value="<?php echo $data['thumb']; ?>" name="data[thumb]" id="thumb" onmouseover="admin_command.preview_img('thumb')">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default" onClick="showImageUpload('thumb')">本地上传</button>
                                            <button type="button" class="btn btn-default" onClick="showImageUpload('thumb', 'gallery')">选择图库</button>
                                        </div>
                                    </div>
                                    <div class="show-tips">可直接输入图片地址</div>
                                </td>
                            </tr>

                        <?php }
                        if ($model['content']['keywords']['show']) { ?>
                            <tr>
                                <th><?php echo $model['content']['keywords']['name']; ?>：</th>
                                <td><input type="text" class="form-control" size="50" id="keywords" value="<?php echo $data['keywords']; ?>" name="data[keywords]">
                                    <div class="show-tips">多关键词之间用“,”隔开</div>
                                </td>
                            </tr>

                        <?php }
                        if ($model['content']['description']['show']) { ?>
                            <tr>
                                <th><?php echo $model['content']['description']['name']; ?>：</th>
                                <td><textarea class="form-control" style="width:100%;" rows="4" maxlength="255" id="description" name="data[description]"><?php echo $data['description']; ?></textarea></td>
                            </tr>
                        <?php }
                        echo $data_fields; ?>
                        <tr>
                            <th>状态：</th>
                            <td>
                                <label class="label-group"><input type="radio" <?php if (!isset($data['status']) || $data['status'] == 1) { ?>checked<?php } ?> value="1" name="data[status]">正常</label>
                                <label class="label-group"><input type="radio" <?php if ($data['status'] == 2) { ?>checked<?php } ?> value="2" name="data[status]">头条</label>
                                <label class="label-group"><input type="radio" <?php if ($data['status'] == 3) { ?>checked<?php } ?> value="3" name="data[status]">推荐</label>
                                <label class="label-group"><input type="radio" <?php if (isset($data['status']) && $data['status'] == 0) { ?>checked<?php } ?> value="0" name="data[status]">未审核</label>
                            </td>
                        </tr>
                        <tr>
                            <th>发布时间：</th>
                            <td>
                                <?php echo content_date('time'); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>阅读数：</th>
                            <td>
                                <input type="text" class="form-control" size="5" value="<?php echo $data['hits']; ?>" name="data[hits]">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr />
                <button type="submit" class="btn btn-default" value="提交" name="submit" onClick="$('#load').show()">提交</button>
                <span id="load" style="display:none"><img src="/static/img/loading.gif"></span>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function ajaxtitle() {
        $('#title_text').html('');
        $.post('<?php echo url('admin/content/ajaxtitle'); ?>&t=' + Math.random(), {
            title: $('#title').val(),
            id: <?php echo $data[id] ? $data[id] : 0; ?>
        }, function(data) {
            $('#title_text').html(data);
        });
    }
</script>

<?php include $this->admin_view('footer'); ?>