<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<script type="text/javascript">
    function set_url_type(type) {
        if (type && type == 'diy') {
            $('.url-type-diy').show();
            $('.url-type-default').hide();
        } else {
            $('.url-type-diy').hide();
            $('.url-type-default').show();
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
                <a class="list-group-item active" href="<?php echo url('admin/config/url'); ?>">URL设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/watermark'); ?>">图片水印</a>
                <a class="list-group-item" href="<?php echo url('admin/config/weixin'); ?>">微信设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/security'); ?>">安全设置</a>
                <a class="list-group-item" href="<?php echo url('admin/config/database'); ?>">数据库</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">URL设置</span>
                </div>
                <table width="100%" class="table_form table table-bordered">
                    <tbody>
                        <tr>
                            <th>入口文件</th>
                            <td>
                                <label class="label-group"><input name="data[HIDE_ENTRY_FILE]" type="radio" value="false" <?php if (!$data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>显示</label>
                                <label class="label-group"><input name="data[HIDE_ENTRY_FILE]" type="radio" value="true" <?php if ($data['HIDE_ENTRY_FILE']) { ?>checked<?php } ?>>隐藏</label>
                                <div class="show-tips"><?php echo $configTips['HIDE_ENTRY_FILE']; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <th width="150">显示模式</th>
                            <td>
                                <label class="label-group"><input name="data[DIY_URL]" type="radio" value="0" <?php if (!$data['DIY_URL']) { ?>checked<?php } ?> onClick="set_url_type();">普通模式</label>
                                <label class="label-group"><input name="data[DIY_URL]" type="radio" value="1" <?php if ($data['DIY_URL'] == 1) { ?>checked<?php } ?> onClick="set_url_type('diy');">伪静态</label>
                                <label class="label-group"><input name="data[DIY_URL]" type="radio" value="2" <?php if ($data['DIY_URL'] == 2) { ?>checked<?php } ?> onClick="set_url_type('diy');">静态</label>
                                <div class="show-tips">伪静态需要服务器支持并配置相关规则文件。更改模式后需 <a href="<?php echo url('admin/content/updateurl'); ?>">更新内容URL</a> 才生效</div>
                            </td>
                        </tr>
                        <tr class="url-type-default" style="display:<?php if ($data['DIY_URL']) { ?>none<?php } ?>">
                            <th>栏目参数格式：</th>
                            <td>
                                <label class="label-group"><input name="data[URL_LIST_TYPE]" type="radio" value="false" <?php if (!$data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目ID</label>
                                <label class="label-group"><input name="data[URL_LIST_TYPE]" type="radio" value="true" <?php if ($data['URL_LIST_TYPE']) { ?>checked<?php } ?>>栏目目录</label>
                                <div class="show-tips"><?php echo $configTips['URL_LIST_TYPE']; ?></div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="url-type-diy" style="display:<?php if (!$data['DIY_URL']) { ?>none<?php } ?>">
                        <tr>
                            <th width="150">栏目页</th>
                            <td>
                                <input class="form-control" type="text" name="data[LIST_URL]" value="<?php echo $data['LIST_URL']; ?>" size="40" />
                                <div class="show-tips">可以使用{catpath}和{catid}组合</div>
                            </td>
                        </tr>
                        <tr>
                            <th>栏目页-分页</th>
                            <td>
                                <input class="form-control" type="text" name="data[LIST_PAGE_URL]" value="<?php echo $data['LIST_PAGE_URL']; ?>" size="40" />
                                <div class="show-tips">可以使用{catpath}、{catid}和{page}组合</div>
                            </td>
                        </tr>
                        <tr>
                            <th>内容展示页</th>
                            <td>
                                <input class="form-control" type="text" name="data[SHOW_URL]" value="<?php echo $data['SHOW_URL']; ?>" size="40" />
                                <div class="show-tips">{id}必须存在，可以使用{catpath}和{id}组合</div>
                            </td>
                        </tr>
                        <tr>
                            <th>内容展示页-带分页</th>
                            <td>
                                <input class="form-control" type="text" name="data[SHOW_PAGE_URL]" value="<?php echo $data['SHOW_PAGE_URL']; ?>" size="40" />
                                <div class="show-tips">{id}必须存在，可以使用{catpath}、{id}和{page}组合</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel-body">
                    <button type="submit" name="submit" class="btn btn-default">提交</button>
                    <div class="show-tips">参数说明：&nbsp;{catpath} 表示栏目目录 ，{catid} 表示栏目ID ，{id} 表示内容ID，{page}表示分页参数</div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>