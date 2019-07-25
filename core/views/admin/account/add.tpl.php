<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/account'); ?>">全部账号</a>
        <a class="list-group-item active" href="<?php echo url('admin/account/add'); ?>">添加账号</a>
        <a class="list-group-item" href="<?php echo url('admin/account/me'); ?>">我的账号</a>
        <a class="list-group-item" href="<?php echo url('admin/account/cache'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $userid ? '修改' : '添加';?>账号</div>
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
                                        <label><input name="data[roleid]" type="radio" value="1" <?php if ($data['roleid']) echo 'checked' ?>>是</label>&nbsp;&nbsp;&nbsp;
                                        <label><input name="data[roleid]" type="radio" value="0" <?php if (!$data['roleid']) echo 'checked' ?>>否</label>
                                        <div class="show-tips">超级管理员不受权限所控制(注:系统必须含有一个超级管理员，否则会出问题)</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" id="auth" class="tab-pane">
                            <div class="show-tips">模型管理包含了内容、会员、表单、自定义、等模型设置</div>
                            <table width="100%" class="table_form">
                                <tbody>
                                    <tr height="25">
                                        <td align="left" width="100">
                                            <input name="auth[index-config]" value="1" id="c_index" type="checkbox" onClick="selectInput('index')" <?php if ($auth['index-config']) echo 'checked' ?>>
                                            <label for="c_index">系统设置</label>
                                        </td>
                                        <td align="left"></td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[account-index]" value="1" id="c_admin" type="checkbox" onClick="selectInput('admin')" <?php if ($auth['account-index']) echo 'checked' ?>>
                                            <label for="c_admin">账号管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_admin" name="auth[account-add]" type="checkbox" value="1" <?php if ($auth['account-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_admin" name="auth[account-edit]" type="checkbox" value="1" <?php if ($auth['account-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_admin" name="auth[account-del]" type="checkbox" value="1" <?php if ($auth['account-del']) echo 'checked' ?>><span>删除</span>
                                            <div class="show-tips">开启此项也意味着赋予最大权限</div>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[category-index]" value="1" id="c_category" type="checkbox" onClick="selectInput('category')" <?php if ($auth['category-index']) echo 'checked' ?>>
                                            <label for="c_category">栏目管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_category" name="auth[category-add]" type="checkbox" value="1" <?php if ($auth['category-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_category" name="auth[category-edit]" type="checkbox" value="1" <?php if ($auth['category-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_category" name="auth[category-del]" type="checkbox" value="1" <?php if ($auth['category-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[block-index]" value="1" id="c_block" type="checkbox" onClick="selectInput('block')" <?php if ($auth['block-index']) echo 'checked' ?>>
                                            <label for="c_block">区块管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_block" name="auth[block-add]" type="checkbox" value="1" <?php if ($auth['block-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_block" name="auth[block-edit]" type="checkbox" value="1" <?php if ($auth['block-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_block" name="auth[block-del]" type="checkbox" value="1" <?php if ($auth['block-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[content-index]" value="1" id="c_content" type="checkbox" onClick="selectInput('content')" <?php if ($auth['content-index']) echo 'checked' ?>>
                                            <label for="c_content">内容管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_content" name="auth[content-add]" type="checkbox" value="1" <?php if ($auth['content-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_content" name="auth[content-edit]" type="checkbox" value="1" <?php if ($auth['content-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_content" name="auth[content-del]" type="checkbox" value="1" <?php if ($auth['content-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[diytable-index]" value="1" id="c_diytable" type="checkbox" onClick="selectInput('diytable')" <?php if ($auth['diytable-index']) echo 'checked' ?>>
                                            <label for="c_diytable">自定义表</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_diytable" name="auth[diytable-add]" type="checkbox" value="1" <?php if ($auth['diytable-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_diytable" name="auth[diytable-edit]" type="checkbox" value="1" <?php if ($auth['diytable-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_diytable" name="auth[diytable-del]" type="checkbox" value="1" <?php if ($auth['diytable-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[form-index]" value="1" id="c_form" type="checkbox" onClick="selectInput('form')" <?php if ($auth['form-index']) echo 'checked' ?>>
                                            <label for="c_form">表单管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_form" name="auth[form-edit]" type="checkbox" value="1" <?php if ($auth['form-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_form" name="auth[form-del]" type="checkbox" value="1" <?php if ($auth['form-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[member-index]" value="1" id="c_member" type="checkbox" onClick="selectInput('member')" <?php if ($auth['member-index']) echo 'checked' ?>>
                                            <label for="c_member">会员管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_member" name="auth[member-edit]" type="checkbox" value="1" <?php if ($auth['member-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_member" name="auth[member-del]" type="checkbox" value="1" <?php if ($auth['member-del']) echo 'checked' ?>><span>删除</span>
                                        </td>
                                    </tr>

                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[template-index]" value="1" id="c_template" type="checkbox" onClick="selectInput('template')" <?php if ($auth['template-index']) echo 'checked' ?>>
                                            <label for="c_template">模板管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_template" name="auth[template-add]" type="checkbox" value="1" <?php if ($auth['template-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_template" name="auth[template-edit]" type="checkbox" value="1" <?php if ($auth['template-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_template" name="auth[template-updatefilename]" type="checkbox" value="1" <?php if ($auth['template-updatefilename']) echo 'checked' ?>><span>备注</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[database-index]" value="1" id="c_database" type="checkbox" onClick="selectInput('database')" <?php if ($auth['database-index']) echo 'checked' ?>>
                                            <label for="c_database">数据备份</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_database" name="auth[database-import]" type="checkbox" value="1" <?php if ($auth['database-import']) echo 'checked' ?>><span>数据恢复</span>
                                            <input class="c_database" name="auth[database-repair]" type="checkbox" value="1" <?php if ($auth['database-repair']) echo 'checked' ?>><span>修复表</span>
                                            <input class="c_database" name="auth[database-optimize]" type="checkbox" value="1" <?php if ($auth['database-optimize']) echo 'checked' ?>><span>优化表</span>
                                            <input class="c_database" name="auth[database-table]" type="checkbox" value="1" <?php if ($auth['database-table']) echo 'checked' ?>><span>查看表结构</span>
                                        </td>
                                    </tr>
                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[createhtml-index]" value="1" id="c_createhtml" type="checkbox" onClick="selectInput('createhtml')" <?php if ($auth['createhtml-index']) echo 'checked' ?>>
                                            <label for="c_createhtml">生成静态</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_createhtml" name="auth[createhtml-category]" type="checkbox" value="1" <?php if ($auth['createhtml-category']) echo 'checked' ?>><span>生成栏目</span>
                                            <input class="c_createhtml" name="auth[createhtml-one_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-one_cat']) echo 'checked' ?>><span>生成栏目附加</span>
                                            <input class="c_createhtml" name="auth[createhtml-all_cat]" type="checkbox" value="1" <?php if ($auth['createhtml-all_cat']) echo 'checked' ?>><span>生成栏目附加</span>
                                            <input class="c_createhtml" name="auth[createhtml-show]" type="checkbox" value="1" <?php if ($auth['createhtml-show']) echo 'checked' ?>><span>生成内容页</span>
                                            <input class="c_createhtml" name="auth[createhtml-all_show]" type="checkbox" value="1" <?php if ($auth['createhtml-all_show']) echo 'checked' ?>><span>生成内容页附加</span>
                                        </td>
                                    </tr>

                                    <tr height="25">
                                        <td align="left">
                                            <input name="auth[models-index]" value="1" id="c_models" type="checkbox" onClick="selectInput('models')" <?php if ($auth['models-index']) echo 'checked' ?>>
                                            <label for="c_models">模型管理</label>
                                        </td>
                                        <td align="left">
                                            <input class="c_models" name="auth[models-add]" type="checkbox" value="1" <?php if ($auth['models-add']) echo 'checked' ?>><span>添加</span>
                                            <input class="c_models" name="auth[models-edit]" type="checkbox" value="1" <?php if ($auth['models-edit']) echo 'checked' ?>><span>编辑</span>
                                            <input class="c_models" name="auth[models-del]" type="checkbox" value="1" <?php if ($auth['models-del']) echo 'checked' ?>><span>删除</span>
                                            <input class="c_models" name="auth[models-field]" type="checkbox" value="1" <?php if ($auth['models-field']) echo 'checked' ?>><span>字段管理</span>
                                            <input class="c_models" name="auth[models-addfield]" type="checkbox" value="1" <?php if ($auth['models-addfield']) echo 'checked' ?>><span>添加字段</span>
                                            <input class="c_models" name="auth[models-editfield]" type="checkbox" value="1" <?php if ($auth['models-editfield']) echo 'checked' ?>><span>修改字段</span>
                                            <input class="c_models" name="auth[models-delfield]" type="checkbox" value="1" <?php if ($auth['models-delfield']) echo 'checked' ?>><span>删除字段</span>
                                            <input class="c_models" name="auth[models-disable]" type="checkbox" value="1" <?php if ($auth['models-disable']) echo 'checked' ?>><span>禁用/启用</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" id="cate" class="tab-pane">
                            <div class="show-tips">禁止管理的栏目</div>
                            <ul width="100%" class="table_form">
                                <?php if (is_array($cats)) foreach ($cats as $k => $v) { ?>
                                    <?php if ($v['typeid'] != 1) continue; ?>
                                    <li>
                                        <input id="catid-checkbox-<?php echo $v['catid']; ?>" class="c_add" type="checkbox" value="1" name="auth[catid-<?php echo $v['catid']; ?>]" <?php if ($auth['catid-' . $v['catid']]) echo 'checked' ?>>
                                        <label for="catid-checkbox-<?php echo $v['catid']; ?>"><?php echo $v['catname']; ?></label>
                                    </li>
                                <?php } ?>
                            </ul>
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