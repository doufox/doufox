<?php include $this->admin_view('header');?>
<?php include $this->admin_view('navbar');?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">表单管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/form/list', array('modelid' => $modelid, 'cid' => $cid)); ?>">信息管理</a>
            <a class="list-group-item" href="<?php echo url('admin/form/config', array('modelid' => $modelid, 'cid' => $cid)); ?>">表单设置</a>
            <?php if (!$join) {?><a class="list-group-item" href="<?php echo url('index/form', array('modelid' => $modelid)); ?>" target="_blank">发布内容</a><?php }; ?>
        </div>
    </div>
    <div class="page_content">
        <form method="post" action="" class="form-inline">
            <input type="hidden" value="<?php echo $catid; ?>" name="catid">
            <input type="hidden" value="<?php echo $data['typeid']; ?>" name="typeid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $page_title; ?></span>
                    <div class="pull-right"></div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">基本选项</a></li>
                        <li role="presentation"><a href="#usage" aria-controls="usage" role="tab" data-toggle="tab">模板调用</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="basic" class="tab-pane active">
                            <table width="100%" class="table_form">
                                <tbody>
                                    <tr>
                                        <th width="200">表单名称：</th>
                                        <td><input type="text" class="form-control" value="<?php echo $model['modelname']; ?>" name="data[modelname]"></td>
                                    </tr>
                                    <tr>
                                        <th>表单类型：</th>
                                        <td><?php echo $join_info; ?></td>
                                    </tr>
                                    <tr>
                                        <th>表单提交模板：</th>
                                        <td>
                                            <input type="text" class="form-control" value="<?php echo $model['categorytpl']; ?>" name="data[categorytpl]">
                                            <div class="show-tips">默认为form.html</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>提交权限：</th>
                                        <td>
                                            <label class="label-group"><input type="radio" <?php if (empty($model['setting']['form']['post'])) {?>checked<?php }?> value="0" name="setting[form][post]">游客</label>
                                            <label class="label-group"><input type="radio" <?php if ($model['setting']['form']['post'] == 1) {?>checked<?php }?> value="1" name="setting[form][post]">会员</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>是否开启验证码：</th>
                                        <td>
                                            <label class="label-group"><input type="radio" <?php if (empty($model['setting']['form']['code'])) {?>checked<?php }?> value="0" name="setting[form][code]">关闭</label>
                                            <label class="label-group"><input type="radio" <?php if ($model['setting']['form']['code'] == 1) {?>checked<?php }?> value="1" name="setting[form][code]">打开</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>是否审核：</th>
                                        <td>
                                            <label class="label-group"><input type="radio" <?php if (empty($model['setting']['form']['check'])) {?>checked<?php }?> value="0" name="setting[form][check]">关闭</label>
                                            <label class="label-group"><input type="radio" <?php if ($model['setting']['form']['check'] == 1) {?>checked<?php }?> value="1" name="setting[form][check]">打开</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>是否在会员中心显示：</th>
                                        <td>
                                            <label class="label-group"><input type="radio" <?php if (empty($model['setting']['form']['member'])) {?>checked<?php }?> value="0" name="setting[form][member]">关闭</label>
                                            <label class="label-group"><input type="radio" <?php if ($model['setting']['form']['member'] == 1) {?>checked<?php }?> value="1" name="setting[form][member]">打开</label>
                                            <div class="show-tips">会员中心能查看到用户提交的内容</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>同一会员（游客）提交一次：</th>
                                        <td>
                                            <label class="label-group"><input type="radio" <?php if ($model['setting']['form']['num'] == 1) {?>checked<?php }?> value="1" name="setting[form][num]">一次</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>同一IP提交间隔：</th>
                                        <td>
                                            <input type="text" class="form-control" value="<?php echo $model['setting']['form']['time']; ?>" name="setting[form][ip]">
                                            <div class="show-tips">单位分钟</div>
                                        </td>
                                    </tr>
                                    <?php if (is_array($model['fields']['data'])) {foreach ($model['fields']['data'] as $t) {?>
                                    <tr>
                                        <th>表单自定义字段：<?php echo $t['name']; ?>: </th>
                                        <td>
                                            <label class="label-group"><input type="checkbox" value="<?php echo $t['field']; ?>" name="setting[form][show][]" <?php if (@in_array($t['field'], $model['setting']['form']['show'])) {?>checked<?php }?>>在后台管理列表显示</label>
                                            <label class="label-group"><input type="checkbox" value="<?php echo $t['field']; ?>" name="setting[form][membershow][]" <?php if (@in_array($t['field'], $model['setting']['form']['membershow'])) {?>checked<?php }?>>在会员中心管理列表显示</label>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" id="usage" class="tab-pane">
                            <table width="100%" class="table_form">
                                <tbody>
                                    <tr>
                                        <th>表单提交地址：</th>
                                        <td><?php echo $form_url; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>表单列表数据调用（供参考）：</th>
                                        <td>
                                            <textarea class="form-control" style="width:90%;height:70px;overflow: hidden;color:#777777"><?php echo $list_code; ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer');?>