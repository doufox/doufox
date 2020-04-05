<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">账号管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/account'); ?>">全部账号</a>
                    <a class="list-group-item active" href="<?php echo url('admin/account/add'); ?>">添加账号</a>
                    <a class="list-group-item" href="<?php echo url('admin/account/me'); ?>">我的账号</a>
                    <a class="list-group-item" href="<?php echo url('admin/account/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $page_title; ?></span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/account'); ?>">列表</a>
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/account/add'); ?>">添加</a>
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
                                            <input type="text" class="form-control" name="data[username]" size="30" />
                                            <span class="show-tips">后台登陆账号</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>登陆密码：</th>
                                        <td>
                                            <input type="text" class="form-control" name="data[password]" size="30" />
                                            <span class="show-tips">后台登陆密码</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>账号姓名：</th>
                                        <td>
                                            <input type="text" class="form-control" name="data[realname]" size="30" />
                                            <span class="show-tips">账号显示姓名</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>超级管理员：</th>
                                        <td>
                                            <label class="label-group"><input name="data[roleid]" type="radio" />是</label>
                                            <label class="label-group"><input name="data[roleid]" type="radio" checked />否</label>
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
                                                <label class="label-group"><input name="auth[index-config]" type="checkbox" onClick="selectInput('index')" />系统设置</label>
                                            </td>
                                            <td align="left"></td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[account-index]" id="c_admin" type="checkbox" onClick="selectInput('admin')" />账号管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_admin" name="auth[account-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_admin" name="auth[account-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_admin" name="auth[account-del]" type="checkbox" />删除</label>
                                                <div class="show-tips">开启此项也意味着赋予最大权限</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[category-index]" id="c_category" type="checkbox" onClick="selectInput('category')" />栏目管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_category" name="auth[category-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_category" name="auth[category-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_category" name="auth[category-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[block-index]" id="c_block" type="checkbox" onClick="selectInput('block')" />区块管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_block" name="auth[block-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_block" name="auth[block-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_block" name="auth[block-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[content-index]" id="c_content" type="checkbox" onClick="selectInput('content')" />内容管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_content" name="auth[content-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_content" name="auth[content-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_content" name="auth[content-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[diytable-index]" id="c_diytable" type="checkbox" onClick="selectInput('diytable')" />自定义表</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_diytable" name="auth[diytable-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_diytable" name="auth[diytable-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_diytable" name="auth[diytable-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[form-index]" id="c_form" type="checkbox" onClick="selectInput('form')" />表单管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_form" name="auth[form-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_form" name="auth[form-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[member-index]" id="c_member" type="checkbox" onClick="selectInput('member')" />会员管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_member" name="auth[member-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_member" name="auth[member-del]" type="checkbox" />删除</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[template-index]" id="c_template" type="checkbox" onClick="selectInput('template')" />模板管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_template" name="auth[template-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_template" name="auth[template-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_template" name="auth[template-updatefilename]" type="checkbox" />备注</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[database-index]" id="c_database" type="checkbox" onClick="selectInput('database')" />数据备份</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_database" name="auth[database-import]" type="checkbox" />数据恢复</label>
                                                <label class="label-group"><input class="c_database" name="auth[database-repair]" type="checkbox" />修复表</label>
                                                <label class="label-group"><input class="c_database" name="auth[database-optimize]" type="checkbox" />优化表</label>
                                                <label class="label-group"><input class="c_database" name="auth[database-table]" type="checkbox" />查看表结构</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[html-index]" id="c_html" type="checkbox" onClick="selectInput('html')" />生成静态</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_html" name="auth[html-category]" type="checkbox" />生成栏目</label>
                                                <label class="label-group"><input class="c_html" name="auth[html-one_cat]" type="checkbox" />生成栏目附加</label>
                                                <label class="label-group"><input class="c_html" name="auth[html-all_cat]" type="checkbox" />生成栏目附加</label>
                                                <label class="label-group"><input class="c_html" name="auth[html-show]" type="checkbox" />生成内容页</label>
                                                <label class="label-group"><input class="c_html" name="auth[html-all_show]" type="checkbox" />生成内容页附加</label>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left">
                                                <label class="label-group"><input name="auth[models-index]" id="c_models" type="checkbox" onClick="selectInput('models')" />模型管理</label>
                                            </td>
                                            <td align="left">
                                                <label class="label-group"><input class="c_models" name="auth[models-add]" type="checkbox" />添加</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-edit]" type="checkbox" />编辑</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-del]" type="checkbox" />删除</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-field]" type="checkbox" />字段管理</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-addfield]" type="checkbox" />添加字段</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-editfield]" type="checkbox" />修改字段</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-delfield]" type="checkbox" />删除字段</label>
                                                <label class="label-group"><input class="c_models" name="auth[models-disable]" type="checkbox" />禁用/启用</label>
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
                                            <label class="label-group"><input id="catid-checkbox-<?php echo $v['catid']; ?>" class="c_add" type="checkbox" name="auth[catid-<?php echo $v['catid']; ?>]" /><?php echo $v['catname']; ?></label>
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

<?php include $this->admin_view('footer'); ?>