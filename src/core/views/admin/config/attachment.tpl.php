<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<script type="text/javascript">
    function switch_type(type) {
        $('.storage-types').hide();
        switch (type) {
            case 'location':
                $('.storage-types.location').show();
                break;
            case 'ftp':
                $('.storage-types.ftp').show();
                break;
            case 'qiniu':
                $('.storage-types.qiniu').show();
                break;
            default:
                $('.storage-types.location').show();
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
                    <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                    <a class="list-group-item active" href="<?php echo url('admin/config/attachment'); ?>">附件设置</a>
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
                        <span class="panel-title">附件设置(开发中)</span>
                    </div>
                    <div class="panel-body">
                        <table class="table_form">
                            <tr>
                                <th>存储形式</th>
                                <td>
                                    <label class="label-group"><input name="data[STORAGE_TYPE]" type="radio" value="0" <?php if (empty($data['STORAGE_TYPE'])) { ?>checked<?php } ?> onClick="switch_type();">网站空间</label>
                                    <label class="label-group"><input name="data[STORAGE_TYPE]" type="radio" value="1" <?php if ($data['STORAGE_TYPE'] == 1) { ?>checked<?php } ?> onClick="switch_type('ftp');">FTP</label>
                                    <label class="label-group"><input name="data[STORAGE_TYPE]" type="radio" value="2" <?php if ($data['STORAGE_TYPE'] == 2) { ?>checked<?php } ?> onClick="switch_type('qiniu');">七牛云</label>
                                </td>
                            </tr>
                            <tbody class="storage-types location" style="display:<?php if ($data['STORAGE_TYPE']) { ?>none<?php } ?>">
                                <tr>
                                    <th>存储路径</th>
                                    <td>/upload</td>
                                </tr>
                            </tbody>
                            <tbody class="storage-types ftp" style="display:<?php if ($data['STORAGE_TYPE'] != 1) { ?>none<?php } ?>">
                                <tr>
                                    <th>FTP</th>
                                    <td>FTP设置</td>
                                </tr>
                            </tbody>
                            <tbody class="storage-types qiniu" style="display:<?php if ($data['STORAGE_TYPE'] != 2) { ?>none<?php } ?>">
                                <tr>
                                    <th>七牛云</th>
                                    <td>七牛云设置</td>
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