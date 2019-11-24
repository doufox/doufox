<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="page_menu">
        <div class="panel panel-default">
            <div class="panel-heading">模型类型</div>
            <div class="list-group">
                <?php foreach ($modelTypeName as $key => $value) { ?>
                    <a class="list-group-item <?php if ($typeid == $key) {echo 'active';} ?>" href="<?php echo url('admin/model/index', array('typeid' => $key)); ?>"><?php echo $value; ?></a>
                <?php } ?>
                <a class="list-group-item" href="<?php echo url('admin/model/add', array('typeid' => $typeid)); ?>">添加<?php echo $modelname ? $modelname : '模型'; ?></a>
                <a class="list-group-item" href="<?php echo url('admin/model/cache'); ?>">更新缓存</a>
            </div>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post" class="form-inline">
            <input hidden name="modelid" type="hidden" value="<?php echo $data['modelid']; ?>">
            <input hidden name="joinid" type="hidden" value="<?php echo $data['joinid']; ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $page_title; ?></span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/model/index', array('typeid' => $typeid)); ?>"><?php echo $modelTypeName[$typeid]; ?></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table width="100%" class="table_form">
                        <tr>
                            <th width="150">模型类型：</th>
                            <td><?php echo $modelTypeName[$typeid]; ?></td>
                        </tr>
                        <tr>
                            <th>
                                <font color="red">*</font> 名称：
                            </th>
                            <td><input class="form-control" type="text" name="modelname" value="<?php echo $data['modelname']; ?>" size="30" /></td>
                        </tr>
                        <tr>
                            <th>
                                <font color="red">*</font> 数据表名：
                            </th>
                            <td>
                                <input class="form-control" type="text" name="tablename" value="<?php echo $data['tablename']; ?>" size="30" <?php if ($data['modelid']) { ?>disabled<?php } ?> />
                                <div class="show-tips">只能由小写英文和数字组成(无需加表前缀)，此项不能修改。</div>
                            </td>
                        </tr>
                        <tbody>
                            <?php if ($typeid != 3) { ?>
                                <tr>
                                    <th>表单模型关联：</th>
                                    <td>
                                        <?php foreach ($formmodel as $t) { ?>
                                            <label class="label-group"><input type="checkbox" value="<?php echo $t['modelid']; ?>" name="join[]" <?php echo $t['select_status']; ?> /><?php echo $t['modelname']; ?></label>
                                        <?php } ?>
                                        <div class="show-tips">用于拓展内容（如评论，留言等）。</div>
                                    </td>
                                </tr>
                            <?php } if ($typeid != 4) { ?>
                            <tr>
                                <th>栏目展示模板：</th>
                                <td><input class="form-control" type="text" name="categorytpl" value="<?php echo $data['categorytpl']; ?>" size="30" />
                                    <div class="show-tips">例如：category_news.html。不填写则会是category_+模型名称拼音</div>
                                </td>
                            </tr>
                            <tr>
                                <th>内容列表模板：</th>
                                <td><input class="form-control" type="text" name="listtpl" value="<?php echo $data['listtpl']; ?>" size="30" />
                                    <div class="show-tips">例如：list_news.html。</div>
                                </td>
                            </tr>
                            <tr>
                                <th>内容展示模板：</th>
                                <td><input class="form-control" type="text" name="showtpl" value="<?php echo $data['showtpl']; ?>" size="30" />
                                    <div class="show-tips">例如：show_news.html。</div>
                                </td>
                            </tr>
                            <tr>
                                <th>搜索展示模板：</th>
                                <td>
                                    <input class="form-control" type="text" name="searchtpl" value="<?php echo $data['searchtpl']; ?>" size="30" />
                                    <div class="show-tips">例如：search_news.html。</div>
                                </td>
                            </tr>
                            <?php } if ($typeid == 4) { ?>
                                <tr>
                                    <th>搜索展示模板：</th>
                                    <td>
                                        <input class="form-control" type="text" name="pagetpl" value="<?php echo $data['pagetpl']; ?>" size="30" />
                                        <div class="show-tips">例如：page.html。</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr />
                    <button type="submit" class="btn btn-default btn-sm" value="提交" name="submit">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>