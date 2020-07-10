<?php include $this->admin_view('header');?>
<?php include $this->admin_view('navbar');?>
<?php include $this->admin_view('common/msg');?>

<link type="text/css" rel="stylesheet" href="/static/jquery.treeview/jquery.treeview.css" />
<script type="text/javascript" src="/static/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/static/jquery.treeview/jquery.treeview.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#category_nav").treeview({
                control: ".category_tree_switch",
                cookieId: "category_tree_nav",
                toggle: function (x, y) {
                    console.log(x, y);
                }
        });
    });
    function setC() {
        if($("#deletec").prop('checked')==true) {
            $(".deletec").prop("checked",true);
        } else {
            $(".deletec").prop("checked",false);
        }
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">栏目</span>
                    <div class="pull-right">
                        <div class="category_tree_switch">
                            <a href="#" style="display: none;">收缩</a>
                            <a href="#" style="display: none;">展开</a>
                            <a href="#">展开/收缩</a>
                        </div>
                    </div>
                </div>
                <?php echo $nav_categorys; ?>
            </div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">内容管理（链接：<?php echo $data['catname']; ?>）</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/category/edit', array('catid'=>$catid)); ?>">栏目设置</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div><?php print_r($data);?></div>
                    <div>URL:<?php print_r($data['url']);?></div>
                    <div>菜单栏显示:<?php print_r($data['ismenu']);?></div>
                    <div>自定义路径:<?php print_r($data['catpath']);?></div>
                    <div>打开方式:<?php print_r($data['isnewtab']);?></div>
                    <table width="100%" class="table_form">
                        <tbody>
                            <tr>
                                <th width="100"><font color="red">*</font>栏目名称：</th>
                                <td>
                                    <input type="text" class="form-control" size="30" value="<?php echo $data['catname']; ?>" name="data[catname]" id="dir" onBlur="ajaxdir()">
                                </td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font>链接地址：</th>
                                <td><input type="text" class="form-control" size="50" value="<?php echo $data['http']; ?>" name="data[http]"></td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font>栏目目录：</th>
                                <td><input type="text" class="form-control" size="30" value="<?php echo $data['catpath']; ?>" name="data[catpath]" id="dir_text"></td>
                            </tr>
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
                                <th width="100"><font color="red">*</font>菜单中显示：</th>
                                <td>
                                    <label class="label-group"><input type="radio" <?php if (!isset($data['ismenu']) || $data['ismenu']==0) { ?>checked<?php } ?> value="0" name="data[ismenu]">隐藏</label>
                                    <label class="label-group"><input type="radio" <?php if (isset($data['ismenu']) && $data['ismenu']==1) { ?>checked<?php } ?> value="1" name="data[ismenu]">显示</label>
                                </td>
                            </tr>
                            <tr>
                                <th width="100"><font color="red">*</font>打开方式：</th>
                                <td>
                                    <label class="label-group"><input type="radio" <?php if (!isset($data['isnewtab']) || $data['isnewtab']==0) { ?>checked<?php } ?> value="0" name="data[isnewtab]">当前窗口</label>
                                    <label class="label-group"><input type="radio" <?php if (isset($data['isnewtab']) && $data['isnewtab']==1) { ?>checked<?php } ?> value="1" name="data[isnewtab]">新窗口</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <hr />
                    <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
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
        } else {
            $("#categorytpl").val("");
            $("#listtpl").val("");
            $("#showtpl").val("");
            $("#searchtpl").val("");
        }
    }
    settype(<?php echo $data[typeid]; ?>);
</script>

<?php include $this->admin_view('footer'); ?>