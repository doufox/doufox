<?php include $this->views('admin/header');?>
<?php include $this->views('admin/navbar');?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">栏目管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/category'); ?>">全部栏目</a>
                    <a class="list-group-item" href="<?php echo url('admin/category/add'); ?>">添加栏目</a>
                    <a class="list-group-item" href="<?php echo url('admin/category/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo $catid ? '编辑' : '添加';?>栏目</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/category'); ?>">列表</a>
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/category/add'); ?>">添加</a>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">基本信息</a></li>
                        <li role="presentation"><a href="#advance" aria-controls="advance" role="tab" data-toggle="tab">高级设置</a></li>
                    </ul>
                    <form method="post" action="" class="form-inline">
                        <input type="hidden" value="<?php echo $catid; ?>" name="catid">
                        <!-- <input type="hidden" value="<?php echo $data['typeid']; ?>" name="typeid"> -->
                        <div class="tab-content">
                            <div role="tabpanel" id="basic" class="tab-pane active">
                                <table width="100%" class="table_form">
                                    <?php if ($add) { ?>
                                    <tbody>
                                        <tr>
                                            <th width="100">批量添加：</th>
                                            <td>
                                                <label class="label-group"><input type="radio" value="0" name="addall" onclick='$("#addall").hide();$("#_addall").show();' checked>否</label>
                                                <label class="label-group"><input type="radio" value="1" name="addall" onclick='$("#addall").show();$("#_addall").hide();'>是</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id='addall' style="display:none">
                                        <tr>
                                            <th><font color="red">*</font>栏目列表：</th>
                                            <td>
                                                <textarea class="form-control" style="width:200px;height:110px" name="names"></textarea>
                                                <div class="show-tips">格式：栏目名称|栏目目录 一行一个 如： 新闻|news</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php } ?>
                                    <tbody id='_addall'>
                                        <tr>
                                            <th width="100"><font color="red">*</font>栏目名称：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['catname']; ?>" name="data[catname]" id="dir" onBlur="ajaxdir()">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><font color="red">*</font>栏目目录：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['catpath']; ?>" name="data[catpath]" id="dir_text">
                                                <div class="show-tips">栏目的 URL 路径，仅支持字母格式</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <th width="100"><font color="red">*</font>上级栏目：</th>
                                            <td>
                                                <select class="form-control" id="parentid" name="data[parentid]">
                                                    <option value="0">作为顶级栏目</option>
                                                    <?php echo $category_select; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="100"><font color="red">*</font>菜单导航：</th>
                                            <td>
                                                <label class="label-group"><input type="radio" <?php if (!isset($data['ismenu']) || $data['ismenu']==0) { ?>checked<?php } ?> value="0" name="data[ismenu]">隐藏</label>
                                                <label class="label-group"><input type="radio" <?php if (isset($data['ismenu']) && $data['ismenu']==1) { ?>checked<?php } ?> value="1" name="data[ismenu]">显示</label>
                                                <div class="show-tips">作为菜单显示在导航栏</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><font color="red">*</font>栏目类型：</th>
                                            <td>
                                                <label class="label-group"><input type="radio" value="1" name="data[typeid]" <?php if ($data['typeid']==1) { ?>checked<?php } ?> onClick="settype(1)" <?php if ($catid && !$add) { ?>disabled<?php } ?>>内部栏目</label>
                                                <label class="label-group"><input type="radio" value="2" name="data[typeid]" <?php if ($data['typeid']==2) { ?>checked<?php } ?> onClick="settype(2)" <?php if ($catid && !$add) { ?>disabled<?php } ?>>内部单页</label>
                                                <label class="label-group"><input type="radio" value="3" name="data[typeid]" <?php if ($data['typeid']==3) { ?>checked<?php } ?> onClick="settype(3)" <?php if ($catid && !$add) { ?>disabled<?php } ?>>外部链接</label>
                                                <label class="label-group"><input type="radio" value="4" name="data[typeid]" <?php if ($data['typeid']==4) { ?>checked<?php } ?> onClick="settype(4)" <?php if ($catid && !$add) { ?>disabled<?php } ?>>独立单页</label>
                                            </td>
                                        </tr>
                                        <tr class="type_3" style="display:none;">
                                            <th><font color="red">*</font>链接地址：</th>
                                            <td><input type="text" class="form-control" size="50" value="<?php echo $data['http']; ?>" name="data[http]"></td>
                                        </tr>
                                        <tr class="type_3" style="display:none;">
                                            <th><font color="red">*</font>跳转方式：</th>
                                            <td>
                                                <label class="label-group"><input type="radio" <?php if (!isset($data['redirect']) || $data['redirect']==0) { ?>checked<?php } ?> value="0" name="data[redirect]">跳转页确认</label>
                                                <label class="label-group"><input type="radio" <?php if (isset($data['redirect']) && $data['redirect']==1) { ?>checked<?php } ?> value="1" name="data[redirect]">直接跳转</label>
                                                <div class="show-tips">在【跳转确认页面】进行URL跳转</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table width="100%" class="type_1 table_form" style="display:none;">
                                    <tbody>
                                        <tr>
                                            <th width="100"><font color="red">*</font>内容模型：</th>
                                            <td>
                                                <select class="form-control" onChange="change_tpl(this.value)" id="modelid" name="data[modelid]" <?php if ($catid && !$add) { ?>disabled<?php } ?>>
                                                    <option value="">==选择内容模型==</option>
                                                    <?php if (is_array($content_model)) { foreach ($content_model as $t) { ?>
                                                    <option value="<?php echo $t['modelid']; ?>" <?php if ($t['modelid']==$data['modelid']) { ?>selected<?php } ?>><?php echo $t['modelname']; ?></option>
                                                    <?php } } ?>
                                                </select>
                                                <div class="show-tips">只有内部栏目才能选择内容模型</div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>栏目模板：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['categorytpl']; ?>" name="data[categorytpl]" id="categorytpl" maxlength="50" />
                                                <div class="show-tips">栏目内容及子栏目列表展示页模板，当有下级栏目时有效</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>列表模板：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['listtpl']; ?>" name="data[listtpl]" id="listtpl" maxlength="50" />
                                                <div class="show-tips">栏目中内容列表展示页模板</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>内容模板：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['showtpl']; ?>" name="data[showtpl]" id="showtpl" maxlength="50" />
                                                <div class="show-tips">栏目中内容页展示页模板</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>搜索模板：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['searchtpl']; ?>" name="data[searchtpl]" id="searchtpl" maxlength="50" />
                                                <div class="show-tips">搜索结果列表展示页模板</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>消息模板：</th>
                                            <td>
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['msgtpl']; ?>" name="data[msgtpl]" id="msgtpl" maxlength="50" />
                                                <div class="show-tips">内容不能展示时的消息页面</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table width="100%" class="type_2 table_form" style="display:none;">
                                    <tbody>
                                        <tr>
                                            <th width="100"><font color="red">*</font>单页模型：</th>
                                            <td>
                                                <select class="form-control" onChange="change_tpl(this.value)" name="data[pagetpl]" <?php if ($catid && !$add) { ?>disabled<?php } ?>>
                                                    <option value="">==选择单页模板==</option>
                                                    <?php if (is_array($page_model)) { foreach ($page_model as $t) { ?>
                                                    <option value="<?php echo $t['pagetpl']; ?>" <?php if ($t['pagetpl']==$data['pagetpl']) { ?>selected<?php } ?>><?php echo $t['modelname']; ?></option>
                                                    <?php } } ?>
                                                </select>
                                                <div class="show-tips">只有内部单页才能选择单页模型</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="100">单页模板：</th>
                                            <td id="show_template">
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['pagetpl']; ?>" name="data[pagetpl]" id="pagetpl">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><font color="red">*</font>单页内容：</th>
                                            <td>
                                                <?php echo content_editor('content', array(0=>$data['content']), array('system'=>1)); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" id="advance" class="tab-pane">
                                <table width="100%" class="table_form">
                                    <tr>
                                        <th width="100">查看权限：</th>
                                        <td>
                                            <label class="label-group"><input name="data[islook]" type="radio" value="0"<?php if ($data['islook']==0) { ?> checked<?php } ?> >任何人可查看</label>
                                            <label class="label-group"><input name="data[islook]" type="radio" value="1"<?php if ($data['islook']==1) { ?> checked<?php } ?> >登录用户可查看</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>投稿权限：</th>
                                        <td>
                                            <label class="label-group"><input name="data[ispost]" type="radio" value="0"<?php if ($data['ispost']==0) { ?> checked<?php } ?> >禁止投稿</label>
                                            <label class="label-group"><input name="data[ispost]" type="radio" value="1"<?php if ($data['ispost']==1) { ?> checked<?php } ?> >任何人可投稿</label>
                                            <label class="label-group"><input name="data[ispost]" type="radio" value="2"<?php if ($data['ispost']==2) { ?> checked<?php } ?> >登录用户可投稿</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>投稿审核：</th>
                                        <td>
                                            <label class="label-group"><input name="data[verify]" type="radio" value="0"<?php if ($data['verify']==0 || !$data['verify']) { ?> checked<?php } ?> >需要审核</label>
                                            <label class="label-group"><input name="data[verify]" type="radio" value="1"<?php if ($data['verify']==1) { ?> checked<?php } ?> >无需审核</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>打开位置：</th>
                                        <td>
                                            <label class="label-group"><input name="data[isnewtab]" type="radio" value="0"<?php if ($data['isnewtab']==0 || !$data['isnewtab']) { ?> checked<?php } ?> >当前窗口</label>
                                            <label class="label-group"><input name="data[isnewtab]" type="radio" value="1"<?php if ($data['isnewtab']==1) { ?> checked<?php } ?> >新窗口</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>内容数目：</th>
                                        <td>
                                            <input type="text" class="form-control" size="5" value="<?php echo $data['pagesize']; ?>" name="data[pagesize]">
                                            <div class="show-tips">栏目列表页每页展示的内容数目</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>栏目图片：</th>
                                        <td>
                                            <div id="imgPreviewimage"></div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" size="30" value="<?php echo $data['image']; ?>" name="data[image]" id="image" onmouseover="admin_command.preview_img('image')">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" onClick="showImageUpload('image')">本地上传</button>
                                                    <button type="button" class="btn btn-default" onClick="showImageUpload('image', 'gallery')">选择图库</button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SEO标题：</th>
                                        <td><input type="text" maxlength="60" size="60" value="<?php echo $data['seo_title']; ?>"   name="data[seo_title]" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>关键字：</th>
                                        <td><input type="text" maxlength="60" size="60" value="<?php echo $data['seo_keywords']; ?>"  name="data[seo_keywords]" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>描述：</th>
                                        <td><textarea class="form-control" style="width:90%;height:50px" name="data[seo_description]"><?php echo $data['seo_description']; ?></textarea></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr />
                        <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function ajaxdir() {
        var dir = $('#dir').val();
        var dir_text = $('#dir_text').val();
        if (dir_text == '' && dir != '') {
            $.post("<?php echo url('api/index/pinyin'); ?>&_t=" + new Date().getTime(), { name: dir }, function (data) { $("#dir_text").val(data); });
        }
    }
    var data = <?php echo $json_model; ?>;
    function settype(id) {
        $(".type_1").hide();
        $(".type_2").hide();
        $(".type_3").hide();
        $(".type_"+id).show();
        if (id ==2) {
            var page = $("#pagetpl").val();
            if (page) {}
            else {
                $("#pagetpl").val("page.html")
            }
        }
    }
    function change_tpl(mid) {
        if (mid) {
            $("#categorytpl").val(data[mid]['categorytpl']);
            $("#listtpl").val(data[mid]['listtpl']);
            $("#showtpl").val(data[mid]['showtpl']);
            $("#searchtpl").val(data[mid]['searchtpl']);
            $("#pagetpl").val(data[mid]['pagetpl']);
            $("#msgtpl").val(data[mid]['msgtpl']);
        } else {
            $("#categorytpl").val("");
            $("#listtpl").val("");
            $("#showtpl").val("");
            $("#searchtpl").val("");
            $("#pagetpl").val("");
            $("#msgtpl").val("");
        }
    }
    settype(<?php echo $data['typeid']; ?>);
</script>

<?php include $this->views('admin/footer'); ?>