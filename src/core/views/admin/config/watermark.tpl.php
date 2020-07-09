<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

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

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">系统设置</span></div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/config'); ?>">基本设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/member'); ?>">会员设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                    <a class="list-group-item active" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/attachment'); ?>">附件</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信公众号</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                    <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form method="post" action="" class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">图片水印</span>
                    </div>
                    <div class="panel-body">
                        <table class="table_form">
                            <tr>
                                <th>水印类型</th>
                                <td>
                                    <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK'] == 0) { ?>checked<?php } ?> onClick="setSateType(0)">关闭</label>
                                    <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK'] == 1) { ?>checked<?php } ?> onClick="setSateType(1)">图片水印</label>
                                    <label class="label-group"><input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK'] == 2) { ?>checked<?php } ?> onClick="setSateType(2)">文字水印</label>
                                </td>
                            </tr>
                            <tbody class="w_image" style="display:<?php if ($data['SITE_WATERMARK'] != 1) { ?>none<?php } ?>">
                                <tr>
                                    <th>水印图片</th>
                                    <td>
                                        <input class="form-control" type="text" readonly value="/static/watermark/watermark.png" size="50" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>图片透明度</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25" placeholder="填写范围（0-99）" max="99" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>图片宽度</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6" placeholder="宽度" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>图片高度</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6" placeholder="高度" />
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="w_text" style="display:<?php if ($data['SITE_WATERMARK'] != 2) { ?>none<?php } ?>">
                                <tr>
                                    <th>文字字体</th>
                                    <td>
                                        <input class="form-control" type="text" readonly value="/static/fonts/elephant.ttf" size="50" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>文字内容</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25" placeholder="水印文字内容" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>文字大小</th>
                                    <td>
                                        <input class="form-control" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25" placeholder="单位像素，默认14" />
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="w_comm" style="display:<?php if ($data['SITE_WATERMARK'] == 0) { ?>none<?php } ?>">
                                <tr>
                                    <th>水印位置</th>
                                    <td>
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" name="submit" class="btn btn-default">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>