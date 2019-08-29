<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>
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
    function select_cats(e) {
        window.location.href = "<?php echo url('admin/content/index'); ?>&catid=" + e.options[e.options.selectedIndex].value;
    };
    function showPreviewArticle (id) {
        window.top.art.dialog({
            title: '预览文章',
            id: 'show',
            iframe: '<?php echo url("admin/content/preview"); ?>&id=' + id,
            width: '700px',
            height: '400px'
        });
    }
</script>

<div class="container">
    <div class="page_menu">
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
    <div class="page_content">
        <form action="" method="post" class="form-inline">
            <input name="form" id="list_form" type="hidden" value="order">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">内容管理</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/content/add', array('catid'=>$catid, 'modelid'=>$modelid)); ?>">添加</a>
                    </div>
                </div>
                <div class="panel-body">
                    <span>栏目：</span>
                    <select class="form-control input-sm" style="max-width: 100px; display: inline-block;" onchange="select_cats(this);"><?php echo $category; ?></select>
                    <span>状态：</span>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/index', array('catid'=>$catid)); ?>">全部</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/index', array('catid'=>$catid, 'status'=>1)); ?>">正常(<?php echo $count[1]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/index', array('catid'=>$catid, 'status'=>2)); ?>">头条(<?php echo $count[2]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/index', array('catid'=>$catid, 'status'=>3)); ?>">推荐(<?php echo $count[3]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/index', array('catid'=>$catid, 'status'=>0)); ?>">草稿(<?php echo $count[0]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/content/add',   array('catid'=>$catid, 'modelid'=>$modelid)); ?>">发布内容</a>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="20"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"></th>
                            <th width="30">ID</th>
                            <th>标题</th>
                            <th width="80">栏目</th>
                            <th width="80">发布人</th>
                            <th width="150">最后更新时间</th>
                            <th>操作</th>
                            <th width="50">排序</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($list)) { foreach ($list as $t) { ?>
                        <tr height="25">
                            <td><input name="del_<?php echo $t['id'].'_'.$t['catid']; ?>" type="checkbox" class="deletec"></td>
                            <td><?php echo $t['id']; ?></td>
                            <td>
                                <div id="s_title" style="height:20px;overflow: hidden;">
                                    <a href="<?php echo url('admin/content/edit', array('id'=>$t['id'])); ?>" title="<?php echo $t['title']; ?>">
                                    <?php if (!$t['status']) { ?><font color="#FF0000">[未审]</font>
                                    <?php } else if ($t['status']==2) { ?><font color="#0000FF">[头条]</font>
                                    <?php } else if ($t['status']==3) { ?><font color="#f00">[推荐]</font>
                                    <?php } echo $t['title']; ?></a>
                                </div>
                            </td>
                            <td>
                                <a href="<?php echo url('admin/content/index',array('catid'=>$t['catid'])); ?>"><?php echo $cats[$t['catid']]['catname']; ?></a>
                            </td>
                            <td>
                                <a href="<?php echo url('admin/content/index',array('catid'=>$t['catid'], 'username'=>$t['username'])); ?>"><?php echo $t['username']; ?></a>
                            </td>
                            <td>
                                <span style="<?php if (date('Y-m-d', $t['time']) == date('Y-m-d')) { ?>color:#F00<?php } ?>"><?php echo date('Y-m-d H:i:s', $t['time']); ?></span>
                            </td>
                            <td>
                                <?php if (is_array($join)) { foreach ($join as $j) { ?>
                                <a href="<?php echo url('admin/form/list', array('cid'=>$t['id'], 'modelid'=>$j['modelid'])); ?>"><?php echo $j['modelname']; ?></a> 
                                <?php } } ?>
                                <?php if (!$t['status']) { ?><a href="javascript:void(0);" onclick="showPreviewArticle(<?php echo $t['id']?>)">预览</a> 
                                <?php } else { ?><a href="<?php echo $t[url]; ?>" target="_blank">查看</a> 
                                <?php } ?>
                                <a href="<?php echo url('admin/content/edit',array('id'=>$t['id'])); ?>" clz="1">编辑</a> 
                                <a href="javascript:admin_command.confirmurl('<?php echo url('admin/content/del/',array('catid'=>$t['catid'],'id'=>$t['id'])); ?>','确定删除 『 <?php echo $t['title']; ?> 』吗？ ')" >删除</a> 
                            </td>
                            <td>
                                <input type="text" name="order_<?php echo $t['id']; ?>" style="width:25px; height:15px;" value="<?php echo $t['listorder']; ?>">
                            </td>
                        </tr>
                        <?php } } ?>
                        <tr height="25">
                            <td colspan="8">
                            <div class="pageleft">
                                <button type="submit" class="btn btn-default" value="排序" name="submit_order" onClick="$('#list_form').val('order')">排序</button>
                                <button type="submit" class="btn btn-default" value="删除" name="submit_del" onClick="$('#list_form').val('del');return confirm_del();">删除</button>
                                <button type="submit" class="btn btn-default" value="设为正常" name="submit_status_1" onClick="$('#list_form').val('status_1')">设为正常</button>
                                <button type="submit" class="btn btn-default" value="设为头条" name="submit_status_2" onClick="$('#list_form').val('status_2')">设为头条</button>
                                <button type="submit" class="btn btn-default" value="设为推荐" name="submit_status_3" onClick="$('#list_form').val('status_3')">设为推荐</button>
                                <button type="submit" class="btn btn-default" value="设为未审" name="submit_status_0" onClick="$('#list_form').val('status_0')">设为草稿</button>
                                批量移动至 <select class="form-control" name="movecatid"><?php echo $category; ?></select>
                                <button type="submit" class="btn btn-default" value="确定移动" name="submit_move" onClick="$('#list_form').val('move')">确定移动</button>
                                <div class="pageright"><?php echo $pagination; ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>