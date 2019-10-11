<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">账号管理</span></div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/account'); ?>">全部账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/add'); ?>">添加账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/me'); ?>">我的账号</a>
            <a class="list-group-item" href="<?php echo url('admin/account/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title"><?php echo $page_title; ?></span>
                <div class="pull-right">
                    <a href="<?php echo url('admin/account'); ?>">列表</a>
                    <a href="<?php echo url('admin/account/add'); ?>">添加</a>
                </div>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">基本信息</a></li>
                    <li role="presentation"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">系统权限</a></li>
                    <li role="presentation"><a href="#cate" aria-controls="cate" role="tab" data-toggle="tab">栏目设置</a></li>
                </ul>
                <form action="" method="post" class="form-inline">
                    <div class="tab-content">
                        <div role="tabpanel" id="basic" class="tab-pane active">
                            <table width="100%" class="table_form">
                                <tr>
                                    <th width="100">登陆账号：</th>
                                    <td>
                                        <?php if ($data['username']) {
                                            echo $data['username'];
                                        } else { ?>
                                            <input type="text" class="form-control" name="data[username]" size="30" /><span class="show-tips">后台登陆账号</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>登陆密码：</th>
                                    <td>
                                        <input type="text" class="form-control" name="data[password]" size="30" />
                                        <?php if ($data['username']) { ?><span class="show-tips">不修改密码，请留空。</span>
                                        <?php } else { ?><span class="show-tips">后台登陆密码</span><?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>账号姓名：</th>
                                    <td>
                                        <input type="text" class="form-control" name="data[realname]" value="<?php echo $data['realname']; ?>" size="30" />
                                        <span class="show-tips">账号显示姓名</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>超级管理员：</th>
                                    <td>
                                        <label class="label-group"><input name="data[roleid]" type="radio" value="1" <?php if ($data['roleid']) echo 'checked'; ?> />是</label>
                                        <label class="label-group"><input name="data[roleid]" type="radio" value="0" <?php if (!$data['roleid']) echo 'checked'; ?> />否</label>
                                        <div class="show-tips">超级管理员不受权限所控制(注:系统必须含有一个超级管理员，否则会出问题)</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" id="auth" class="tab-pane">
                            <div class="show-tips">模型管理包含了内容、会员、表单、自定义、等模型设置</div>
                            <table width="100%" class="table_form">
                                <tbody>
                                    <tr>
                                        <td align="left" width="100">
                                            <label class="label-group"><input name="auth[index-config]" value="1" type="checkbox" onClick="selectInput('index')" <?php if ($auth['index-config']) echo 'checked' ?> />系统设置</label>
                                        </td>
                                        <td align="left"></td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[account-index]" id="c_admin" value="1" type="checkbox" onClick="selectInput('admin')" <?php if ($auth['account-index']) echo 'checked' ?> />账号管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_admin" name="auth[account-add]" type="checkbox" value="1" <?php if ($auth['account-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_admin" name="auth[account-edit]" type="checkbox" value="1" <?php if ($auth['account-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_admin" name="auth[account-del]" type="checkbox" value="1" <?php if ($auth['account-del']) echo 'checked'; ?> />删除</label>
                                            <div class="show-tips">开启此项也意味着赋予最大权限</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[category-index]" id="c_category" value="1" type="checkbox" onClick="selectInput('category')" <?php if ($auth['category-index']) echo 'checked'; ?> />栏目管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_category" name="auth[category-add]" type="checkbox" value="1" <?php if ($auth['category-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_category" name="auth[category-edit]" type="checkbox" value="1" <?php if ($auth['category-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_category" name="auth[category-del]" type="checkbox" value="1" <?php if ($auth['category-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[block-index]" id="c_block" value="1" type="checkbox" onClick="selectInput('block')" <?php if ($auth['block-index']) echo 'checked'; ?> />区块管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_block" name="auth[block-add]" type="checkbox" value="1" <?php if ($auth['block-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_block" name="auth[block-edit]" type="checkbox" value="1" <?php if ($auth['block-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_block" name="auth[block-del]" type="checkbox" value="1" <?php if ($auth['block-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[content-index]" id="c_content" value="1" type="checkbox" onClick="selectInput('content')" <?php if ($auth['content-index']) echo 'checked'; ?> />内容管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_content" name="auth[content-add]" type="checkbox" value="1" <?php if ($auth['content-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_content" name="auth[content-edit]" type="checkbox" value="1" <?php if ($auth['content-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_content" name="auth[content-del]" type="checkbox" value="1" <?php if ($auth['content-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[diytable-index]" id="c_diytable" value="1" type="checkbox" onClick="selectInput('diytable')" <?php if ($auth['diytable-index']) echo 'checked'; ?> />自定义表</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_diytable" name="auth[diytable-add]" type="checkbox" value="1" <?php if ($auth['diytable-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_diytable" name="auth[diytable-edit]" type="checkbox" value="1" <?php if ($auth['diytable-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_diytable" name="auth[diytable-del]" type="checkbox" value="1" <?php if ($auth['diytable-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[form-index]" id="c_form" value="1" type="checkbox" onClick="selectInput('form')" <?php if ($auth['form-index']) echo 'checked'; ?> />表单管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_form" name="auth[form-edit]" type="checkbox" value="1" <?php if ($auth['form-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_form" name="auth[form-del]" type="checkbox" value="1" <?php if ($auth['form-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[member-index]" id="c_member" value="1" type="checkbox" onClick="selectInput('member')" <?php if ($auth['member-index']) echo 'checked'; ?> />会员管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_member" name="auth[member-edit]" type="checkbox" value="1" <?php if ($auth['member-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_member" name="auth[member-del]" type="checkbox" value="1" <?php if ($auth['member-del']) echo 'checked'; ?> />删除</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[template-index]" id="c_template" value="1" type="checkbox" onClick="selectInput('template')" <?php if ($auth['template-index']) echo 'checked'; ?> />模板管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_template" name="auth[template-add]" type="checkbox" value="1" <?php if ($auth['template-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_template" name="auth[template-edit]" type="checkbox" value="1" <?php if ($auth['template-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_template" name="auth[template-updatefilename]" type="checkbox" value="1" <?php if ($auth['template-updatefilename']) echo 'checked'; ?> />备注</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[database-index]" id="c_database" value="1" type="checkbox" onClick="selectInput('database')" <?php if ($auth['database-index']) echo 'checked'; ?> />数据备份</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_database" name="auth[database-import]" type="checkbox" value="1" <?php if ($auth['database-import']) echo 'checked'; ?> />数据恢复</label>
                                            <label class="label-group"><input class="c_database" name="auth[database-repair]" type="checkbox" value="1" <?php if ($auth['database-repair']) echo 'checked'; ?> />修复表</label>
                                            <label class="label-group"><input class="c_database" name="auth[database-optimize]" type="checkbox" value="1" <?php if ($auth['database-optimize']) echo 'checked'; ?> />优化表</label>
                                            <label class="label-group"><input class="c_database" name="auth[database-table]" type="checkbox" value="1" <?php if ($auth['database-table']) echo 'checked'; ?> />查看表结构</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[createhtml-index]" id="c_createhtml" value="1" type="checkbox" onClick="selectInput('createhtml')" <?php if ($auth['createhtml-index']) echo 'checked'; ?> />生成静态</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_createhtml" name="auth[createhtml-category]" type="checkbox" value="1" <?php if ($auth['createhtml-category']) echo 'checked'; ?> />生成栏目</label>
                                            <label class="label-group"><input class="c_createhtml" name="auth[createhtml-one_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-one_cat']) echo 'checked'; ?> />生成栏目附加</label>
                                            <label class="label-group"><input class="c_createhtml" name="auth[createhtml-all_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-all_cat']) echo 'checked'; ?> />生成栏目附加</label>
                                            <label class="label-group"><input class="c_createhtml" name="auth[createhtml-show]" type="checkbox" value="1" <?php if ($auth['createhtml-show']) echo 'checked'; ?> />生成内容页</label>
                                            <label class="label-group"><input class="c_createhtml" name="auth[createhtml-all_show]" type="checkbox" value="1" <?php if ($auth['createhtml-all_show']) echo 'checked'; ?> />生成内容页附加</label>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <label class="label-group"><input name="auth[models-index]" id="c_models" value="1" type="checkbox" onClick="selectInput('models')" <?php if ($auth['models-index']) echo 'checked'; ?> />模型管理</label>
                                        </td>
                                        <td align="left">
                                            <label class="label-group"><input class="c_models" name="auth[models-add]" type="checkbox" value="1" <?php if ($auth['models-add']) echo 'checked'; ?> />添加</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-edit]" type="checkbox" value="1" <?php if ($auth['models-edit']) echo 'checked'; ?> />编辑</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-del]" type="checkbox" value="1" <?php if ($auth['models-del']) echo 'checked'; ?> />删除</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-field]" type="checkbox" value="1" <?php if ($auth['models-field']) echo 'checked'; ?> />字段管理</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-addfield]" type="checkbox" value="1" <?php if ($auth['models-addfield']) echo 'checked'; ?> />添加字段</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-editfield]" type="checkbox" value="1" <?php if ($auth['models-editfield']) echo 'checked'; ?> />修改字段</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-delfield]" type="checkbox" value="1" <?php if ($auth['models-delfield']) echo 'checked'; ?> />删除字段</label>
                                            <label class="label-group"><input class="c_models" name="auth[models-disable]" type="checkbox" value="1" <?php if ($auth['models-disable']) echo 'checked'; ?> />禁用/启用</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" id="cate" class="tab-pane">
                            <div class="show-tips">禁止管理的栏目</div>
                            <div width="100%" class="table_form">
                                <?php if (is_array($cats)) foreach ($cats as $k => $v) { ?>
                                    <?php if ($v['typeid'] != 1) continue; ?>
                                        <label class="label-group"><input id="catid-checkbox-<?php echo $v['catid']; ?>" class="c_add" type="checkbox" value="1" name="auth[catid-<?php echo $v['catid']; ?>]" <?php if ($auth['catid-' . $v['catid']]) echo 'checked'; ?> /><?php echo $v['catname']; ?></label>
                                <?php } ?>
                                </div>
                        </div>
                    </div>
                    <hr />
                    <button class="btn btn-default" type="submit" name="submit">提交</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function selectInput(c) {
        if ($("#c_" + c).prop('checked') == true) {
            $(".c_" + c).prop("checked", true);
        } else {
            $(".c_" + c).prop("checked", false);
        }
    }
</script>

<?php include $this->admin_tpl('footer'); ?>