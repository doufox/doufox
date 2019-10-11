<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">插件管理</span></div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/plugin'); ?>">全部插件</a>
            <a class="list-group-item" href="<?php echo url('admin/plugin/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">插件配置</span>
                    <div class="pull-right">
                        <a href="<?php echo url('admin/plugin/reload'); ?>">重载</a>
                        <a href="<?php echo url('admin/plugin'); ?>">列表</a>
                    </div>
                </div>
                <div class="panel-body">
                    <p>插件详情</p>
                    <table class="table table-bordered table-hover table-condensed">
                        <tr>
                            <th width="90">名称</th>
                            <td><?php echo $data['name']; ?></td>
                        </tr>
                        <tr>
                            <th>版本</th>
                            <td><?php echo $data['version']; ?></td>
                        </tr>
                        <tr>
                            <th>状态</th>
                            <td><?php echo status_label($data['status'], '开启', '关闭'); ?></td>
                        </tr>
                        <tr>
                            <th>网站</th>
                            <td><a href="<?php echo $data['url']; ?>"><?php echo $data['url']; ?></a></td>
                        </tr>
                        <tr>
                            <th>制作者</th>
                            <td><?php echo $data['author']; ?></td>
                        </tr>
                        <tr>
                            <th>制作者网站</th>
                            <td><a href="<?php echo $data['author_url']; ?>"><?php echo $data['author_url']; ?></a></td>
                        </tr>
                        <tr>
                            <th>描述</th>
                            <td><?php echo $data['description']; ?></td>
                        </tr>
                        <tr>
                            <th>官方版</th>
                            <td><?php echo status_label($data['official'], '官方版', '非官方版'); ?></td>
                        </tr>
                    </table>
                    <p>插件配置</p>
                    <hr />
                    <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                    <table width="100%" class="table_form">
                        <tr>
                            <th width="80">插件名称：</th>
                            <td><input class="form-control" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="40" /></td>
                        </tr>
                        <tr>
                            <th width="80">编辑方式：</th>
                            <td>
                                <select id="type" class="form-control" name="data[type]" onChange="select_type(this.value)">
                                    <option value="0"> ... 请选择方式</option>
                                    <?php if (is_array($type)) {
                                        foreach ($type as $i => $v) { ?>
                                            <option value="<?php echo $i; ?>" <?php if ($data['type'] == $i) { ?>selected<?php } ?>><?php echo $v; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th width="80">备注：</th>
                            <td><input class="form-control" type="text" name="data[remark]" value="<?php echo $data['remark']; ?>" size="40" /></td>
                        </tr>
                        <tr id="text_1" style="display:none">
                            <th>插件内容：</th>
                            <td>
                                <textarea class="form-control" name="data[content_1]" id="data[content]" cols="60" rows="8"><?php echo $data['content']; ?></textarea>
                                <p class="show-tips">插件内容支持HTML标签</p>
                            </td>
                        </tr>
                        <tr id="text_2" style="display:none">
                            <th>插件图片：</th>
                            <td>
                                <div id="imgPreviewthumb"></div>
                                <div class="input-group">
                                    <input type="text" class="form-control" size="50" value="<?php echo $data[content]; ?>" name="data[content_2]" id="thumb" onmouseover="admin_command.preview_img('thumb')">
                                    <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" onClick="showImageUpload('thumb')">本地上传</button>
                                                <button type="button" class="btn btn-default" onClick="showImageUpload('thumb', 'gallery')">选择图库</button>
                                    </span>
                                </div>
                                <p class="show-tips">可直接输入图片地址</p>
                            </td>
                        </tr>
                        <tr id="text_3" style="display:none;">
                            <th>插件内容：</th>
                            <td>
                                <?php echo content_editor('content_3', array(0 => $data['content']), array('system' => 1)); ?>
                            </td>
                        </tr>
                    </table>
                    <hr />
                    <p>
                        <button type="button" class="btn btn-default">返回</button>
                        <button type="submit" name="submit" class="btn btn-default">提交</button>
                    </p>
                    <hr />
                    <p>说明<br />重载：将插件信息存入数据库并做缓存处理<br />更新缓存：将插件配置信息缓存</p>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function select_type(id) {
        $("#text_1").hide();
        $("#text_2").hide();
        $("#text_3").hide();
        $("#text_" + id).show();
    }
    <?php if ($data['type']) { ?>
        $("#text_<?php echo $data['type']; ?>").show();
    <?php } ?>
</script>

<?php include $this->admin_tpl('footer'); ?>