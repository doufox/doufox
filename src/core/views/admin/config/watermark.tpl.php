<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<script type="text/javascript">
    function setSateType(id) {
        if (id == 0) {
            $('.w_comm').hide();
            $('.w_image').hide();
            $('.w_text').hide();
        } else if (id == 1) {
            $('.w_comm').show();
            $('.w_image').show();
            $('.w_text').hide();
        } else if (id == 2) {
            $('.w_comm').show();
            $('.w_image').hide();
            $('.w_text').show();
        }
    }
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
                <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">图片水印</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 col-md-2 control-label">水印类型</label>
                        <div class="col-sm-9 col-md-10">
                            <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK'] == 0) { ?>checked<?php } ?> onClick="setSateType(0)">关闭</label>
                            <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK'] == 1) { ?>checked<?php } ?> onClick="setSateType(1)">图片水印</label>
                            <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK'] == 2) { ?>checked<?php } ?> onClick="setSateType(2)">文字水印</label>
                        </div>
                    </div>
                    <div class="form-group w_image" style="display:<?php if ($data['SITE_WATERMARK'] != 1) { ?>none<?php } ?>">
                        <label for="SITE_WATERMARK_IMAGE" class="col-sm-3 col-md-2 control-label">图片位置</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_WATERMARK_IMAGE" class="form-control" type="text" readonly value="/static/watermark/watermark.png" />
                        </div>
                    </div>
                    <div class="form-group w_image" style="display:<?php if ($data['SITE_WATERMARK'] != 1) { ?>none<?php } ?>">
                        <label for="SITE_WATERMARK_ALPHA" class="col-sm-3 col-md-2 control-label">图片透明度</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_WATERMARK_ALPHA" class="form-control" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25" placeholder="填写范围（0-99）" />
                        </div>
                    </div>
                    <div class="form-group form-inline w_image" style="display:<?php if ($data['SITE_WATERMARK'] != 1) { ?>none<?php } ?>">
                        <label for="SITE_THUMB_WIDTH" class="col-sm-3 col-md-2 control-label">缩略图宽高</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_THUMB_WIDTH" class="form-control" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6" placeholder="宽度" />
                            x&nbsp;
                            <input class="form-control" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6" placeholder="高度" />
                            &nbsp;px
                        </div>
                    </div>
                    <div class="form-group w_text" style="display:<?php if ($data['SITE_WATERMARK'] != 2) { ?>none<?php } ?>">
                        <label for="SITE_WATERMARK_FONT" class="col-sm-3 col-md-2 control-label">字体位置</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_WATERMARK_FONT" class="form-control" type="text" readonly value="/static/fonts/elephant.ttf" />
                        </div>
                    </div>
                    <div class="form-group w_text" style="display:<?php if ($data['SITE_WATERMARK'] != 2) { ?>none<?php } ?>">
                        <label for="SITE_WATERMARK_TEXT" class="col-sm-3 col-md-2 control-label">水印内容</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_WATERMARK_TEXT" class="form-control" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25" placeholder="水印文字内容" />
                        </div>
                    </div>
                    <div class="form-group w_text" style="display:<?php if ($data['SITE_WATERMARK'] != 2) { ?>none<?php } ?>">
                        <label for="SITE_WATERMARK_SIZE" class="col-sm-3 col-md-2 control-label">文字大小</label>
                        <div class="col-sm-9 col-md-10">
                            <input id="SITE_WATERMARK_SIZE" class="form-control" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25" placeholder="单位像素，默认14" />
                        </div>
                    </div>
                    <div class="form-group w_comm" style="display:<?php if ($data['SITE_WATERMARK'] == 0) { ?>none<?php } ?>">
                        <label class="col-sm-3 col-md-2 control-label">水印位置</label>
                        <div class="col-sm-9 col-md-10">
                            <table>
                                <tr>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 1) { ?>checked="" <?php } ?> value="1" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 2) { ?>checked="" <?php } ?> value="2" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 3) { ?>checked="" <?php } ?> value="3" name="data[SITE_WATERMARK_POS]"></label></td>
                                </tr>
                                <tr>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 4) { ?>checked="" <?php } ?> value="4" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 5) { ?>checked="" <?php } ?> value="5" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 6) { ?>checked="" <?php } ?> value="6" name="data[SITE_WATERMARK_POS]"></label></td>
                                </tr>
                                <tr>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 7) { ?>checked="" <?php } ?> value="7" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if ($data['SITE_WATERMARK_POS'] == 8) { ?>checked="" <?php } ?> value="8" name="data[SITE_WATERMARK_POS]"></label></td>
                                    <td><label class="label-group"><input type="radio" <?php if (empty($data['SITE_WATERMARK_POS'])) { ?>checked="" <?php } ?> value="" name="data[SITE_WATERMARK_POS]"></label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>