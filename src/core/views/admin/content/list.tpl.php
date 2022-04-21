<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
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
            <form action="" method="post" class="form-inline">
                <input name="form" id="list_form" type="hidden" value="order">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">内容管理（栏目：<?php echo $cats[$catid]['catname']; ?>）</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/content/add', array('catid'=>$catid, 'modelid'=>$modelid)); ?>">内容添加</a>
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/category/edit', array('catid'=>$catid)); ?>">栏目设置</a>
                        </div>
                    </div>
                    <div class="panel-body">
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
                                <th width="160">最后更新时间</th>
                                <th>操作</th>
                                <th width="50">排序</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($list)) { foreach ($list as $t) { ?>
                            <tr>
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
                                    <?php if (!$t['status']) { ?>
                                        <a href="#modal-content-preview" data-toggle="modal" onclick="content_preview(<?php echo $t['id']?>)">预览</a>
                                    <?php } else { ?><a href="<?php echo $t[url]; ?>" target="_blank">查看</a> 
                                    <?php } ?>
                                    <a href="<?php echo url('admin/content/edit',array('id'=>$t['id'])); ?>" clz="1">编辑</a> 
                                    <a href="#modal-confirm" data-toggle="modal" name="删除" onclick="content_delete(this);" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['title']; ?>">删除</a>
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
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="panel-body text-center"><?php echo $pagination; ?></div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 内容预览 -->
<div class="modal fade" id="modal-content-preview" tabindex="-1" role="dialog" aria-labelledby="aria-content-preview">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aria-content-preview">内容预览</h4>
            </div>
            <div class="modal-body">
                <iframe id="content-preview-view" width="100%" frameborder="0" onload="setIframeHeight(this);"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function content_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById('modal-confirm-url').href = "<?php echo url('admin/content/del', array('catid'=>$catid, 'id' => '')); ?>" + e.dataset.id;
            document.getElementById('modal-confirm-body').innerText = '确定删除『' + e.dataset.name + '』吗？';
        }
    }
    function content_preview (x) {
        if (x) {
            document.getElementById('content-preview-view').src = "<?php echo url('admin/content/preview', array('id' => '')); ?>" + x;
            // document.getElementById('content-preview-name').innerText = '"' + name + '"';
        } else {
            document.getElementById('content-preview-view').src = '';
            document.getElementById('content-preview-view').height = '';
            // document.getElementById('content-preview-name').innerText = '';
        }
    }
    $('#modal-content-preview').on('hide.bs.modal', function () {
        content_preview();
    })
</script>

<?php include $this->admin_view('footer'); ?>