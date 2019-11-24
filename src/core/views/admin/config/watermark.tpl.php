<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<script type="text/javascript">
    function setSateType(id) {
        if (id == 0) {
            $('#w_1').hide();
            $('.w_2').hide();
            $('#w_0').hide();
        } else if (id == 1) {
            $('.w_2').hide();
            $('#w_1').show();
            $('#w_0').show();
        } else if (id == 2) {
            $('#w_1').hide();
            $('.w_2').show();
            $('#w_0').show();
        }
    }
    setSateType(<?php echo $data['SITE_WATERMARK']; ?>);
</script>

<div class="container">
    <div class="page_menu">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="panel-title">系统设置</span></div>
            <div class="list-group">
                <a class="list-group-item" href="<?php echo url('admin/config'); ?>">基本设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                <a class="list-group-item active" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">图片水印</span>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table_form table table-bordered">
                        <tr>
                            <th width="100">水印类型：</th>
                            <td>
                                <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK'] == 1) { ?>checked<?php } ?> onClick="setSateType(1)">图片水印</label>
                                <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK'] == 2) { ?>checked<?php } ?> onClick="setSateType(2)">文字水印</label>
                                <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK'] == 0) { ?>checked<?php } ?> onClick="setSateType(0)">关闭</label>
                            </td>
                        </tr>
                        <tbody id="w_0">
                            <tr id="w_1">
                                <th>图片透明度：</th>
                                <td><input class="form-control" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25" />
                                    <div class="show-tips">填写范围（0-99），图片目录：/static/watermark/watermark.png</div>
                                </td>
                            </tr>
                            <tr class="w_2">
                                <th>水印文字：</th>
                                <td><input class="form-control" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25" />
                                    <div class="show-tips">默认字体文件：/static/fonts/elephant.ttf（若有中文请下载字体文件覆盖）</div>
                                </td>
                            </tr>
                            <tr class="w_2">
                                <th>文字大小：</th>
                                <td><input class="form-control" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25" />
                                    <div class="show-tips">单位像素，默认14</div>
                                </td>
                            </tr>
                            <tr>
                                <th>水印位置：</th>
                                <td>
                                    <table>
                                        <tr>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 1) { ?>checked="" <?php } ?> value="1" name="data[SITE_WATERMARK_POS]">顶部居左</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 2) { ?>checked="" <?php } ?> value="2" name="data[SITE_WATERMARK_POS]">顶部居中</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 3) { ?>checked="" <?php } ?> value="3" name="data[SITE_WATERMARK_POS]">顶部居右</label></td>
                                        </tr>
                                        <tr>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 4) { ?>checked="" <?php } ?> value="4" name="data[SITE_WATERMARK_POS]">中部居左</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 5) { ?>checked="" <?php } ?> value="5" name="data[SITE_WATERMARK_POS]">中部居中</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 6) { ?>checked="" <?php } ?> value="6" name="data[SITE_WATERMARK_POS]">中部居右</label></td>
                                        </tr>
                                        <tr>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 7) { ?>checked="" <?php } ?> value="7" name="data[SITE_WATERMARK_POS]">底部居左</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 8) { ?>checked="" <?php } ?> value="8" name="data[SITE_WATERMARK_POS]">底部居中</label></td>
                                            <td><label class="label-group"><input type="radio" <?php if (empty($data['SITE_WATERMARK_POS'])) { ?>checked="" <?php } ?> value="" name="data[SITE_WATERMARK_POS]">底部居右</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <th>缩略图宽高：</th>
                            <td>
                                <input class="form-control" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6" />
                                x&nbsp;
                                <input class="form-control" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6" />
                                &nbsp;px
                            </td>
                        </tr>
                    </table>
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>