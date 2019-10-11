<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="page_menu">
        <iframe name="leftMain" id="leftMain" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" src="<?php echo url('admin/content/category'); ?>"
            style="border:none" width="100%">
        </iframe>
    </div>
    <div class="page_content">
        <script type="text/javascript">
            // top.document.getElementById('position').innerHTML = '内容管理';
            function setC() {
                if($("#deletec").prop('checked')==true) {
                    $(".deletec").prop("checked",true);
                } else {
                    $(".deletec").prop("checked",false);
                }
            }
        </script>
        <div>
            <div class="content-menu">
                <div class="left">
                    <a href="<?php echo url('admin/content/all', array('catid'=>$catid, )); ?>" class="on">全部内容</a>
                    <a href="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>0)); ?>" class="on">未审核(<?php echo $statusNum[0]; ?>)</a>
                    <a href="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>1)); ?>" class="on">正常(<?php echo $statusNum[1]; ?>)</a>
                    <a href="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>2)); ?>" class="on">头条(<?php echo $statusNum[2]; ?>)</a>
                    <a href="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>3)); ?>" class="on">推荐(<?php echo $statusNum[3]; ?>)</a>
                    <a href="<?php echo url('admin/content/add', array('catid'=>$catid, 'modelid'=>$modelid)); ?>" class="add">发布内容</a>
                    <select class="select" name="movecatid" onchange="self.location.href=self.location.href + '&catid='+options[selectedIndex].value">
                        <option value="<?php echo url('admin/content/all', array('name'=>$name)); ?>">全部栏目</option>
                        <?php echo $category; ?>
                    </select>
                    <?php if (is_array($this->status_arr)) { ?>
                    <select class="select" name="pageselect" onchange="self.location.href=options[selectedIndex].value" >
                        <option value="<?php echo url('admin/content/all', array('catid'=>$catid ,'name'=>$name)); ?>" <?php if (!isset($status)) { ?>selected<?php } ?>>全部</option>
                        <?php foreach ($this->status_arr  as $key=>$t) { ?>
                        <option value="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>$key ,'name'=>$name)); ?>"  <?php if (isset($status) && $status==$key) { ?>selected<?php } ?>><?php echo $t; ?></option>
                        <?php } ?>
                    </select><?php } ?>
                </div>
                <div class="right">
                    <form method="get" action="">
                        <input type="hidden" name="s" value="admin"/>
                        <input type="hidden" name="c" value="content"/>
                        <input type="hidden" name="a" value="all"/>
                        <!-- <input type="hidden" name="name" value="<?php echo $name; ?>"/> -->
                        <input type="hidden" name="catid" value="<?php echo $catid; ?>"/>
                        <input type="text" name="title" size="18" value="<?php echo $title; ?>" class="form-control"/>
                        <input type="submit" class="button" value="搜索标题"/>
                    </form>
                </div>
            </div>
            <div class="table-list">
                <table width="100%">
                    <thead>
                        <tr>
                            <th align="left" width="20"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"></th>
                            <th align="left" width="30">ID</th>
                            <th align="left">标题</th>
                            <th align="left" width="80">栏目</th>
                            <th align="left" width="80">发布人</th>
                            <th align="left" width="150">最后更新时间</th>
                            <th align="left" width="200">操作</th>
                            <th align="left" width="40">排序</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($list)) { foreach ($list as $t) { ?>
                    <tr height="25">
                        <td align="left"><input name="del_<?php echo $t['id'].'_'.$t['catid']; ?>" type="checkbox" class="deletec"></td>
                        <td align="left"><?php echo $t['id']; ?></td>
                        <td align="left">
                        <div id="s_title" style="height:20px;overflow: hidden;">
                        <a href="<?php echo url('admin/content/edit', array('id'=>$t['id'])); ?>" title="<?php echo $t['title']; ?>">
                        <?php if (!$t['status']) { ?><font color="#FF0000">[未审]</font>
                        <?php } else if ($t['status']==2) { ?><font color="#0000FF">[头条]</font>
                        <?php } else if ($t['status']==3) { ?><font color="#f00">[推荐]</font>
                        <?php }  echo $t['title']; ?></a>
                        </div>
                        </td>
                        <td align="left">
                            <a href="<?php echo url('admin/content/index',array('catid'=>$t['catid'])); ?>"><?php echo $cats[$t['catid']]['catname']; ?></a>
                        </td>
                        <td align="left">
                            <a href="<?php echo url('admin/content/index',array('catid'=>$t['catid'], 'username'=>$t['username'])); ?>"><?php echo $t['username']; ?></a>
                        </td>
                        <td align="left">
                            <span style="<?php if (date('Y-m-d', $t['time']) == date('Y-m-d')) { ?>color:#F00<?php } ?>"><?php echo date('Y-m-d H:i:s', $t['time']); ?></span>
                        </td>
                        <td align="left">
                            <?php if (is_array($join)) { foreach ($join as $j) { ?>
                            <a href="<?php echo url('admin/form/list', array('cid'=>$t['id'], 'modelid'=>$j['modelid'])); ?>"><?php echo $j['modelname']; ?></a> |
                            <?php } } ?>
                            <a href="<?php echo $t[url]; ?>" target="_blank">查看</a> | 
                            <a href="<?php echo url('admin/content/edit',array('id'=>$t['id'])); ?>" clz="1">编辑</a> | 
                            <a href="javascript:admin_command.confirmurl('<?php echo url('admin/content/del/',array('catid'=>$t['catid'],'id'=>$t['id'])); ?>','确定删除 『 <?php echo $t['title']; ?> 』吗？ ')" >删除</a> 
                        </td>
                        <td align="left">
                            <input type="text" name="order_<?php echo $t['id']; ?>" style="width:25px; height:15px;" value="<?php echo $t['listorder']; ?>">
                        </td>
                    </tr>
                    <?php } } ?>
                    <tr height="25">
                        <td colspan="8" align="left">
                        <div class="pageleft">
                            <input type="submit" class="button" value="排序" name="submit_order" onClick="$('#list_form').val('order')">&nbsp;
                            <input type="submit" class="button" value="删除" name="submit_del" onClick="$('#list_form').val('del');return confirm_del();">&nbsp;
                            <input type="submit" class="button" value="设为正常" name="submit_status_1" onClick="$('#list_form').val('status_1')">&nbsp;
                            <input type="submit" class="button" value="设为头条" name="submit_status_2" onClick="$('#list_form').val('status_2')">&nbsp;
                            <input type="submit" class="button" value="设为推荐" name="submit_status_3" onClick="$('#list_form').val('status_3')">&nbsp;
                            <input type="submit" class="button" value="设为未审" name="submit_status_0" onClick="$('#list_form').val('status_0')">&nbsp;
                            批量移动至
                            <select name="movecatid">
                            <?php echo $category; ?>
                            </select>
                            <input type="submit" class="button" value="确定移动" name="submit_move" onClick="$('#list_form').val('move')"></div>
                            <div class="pageright"><?php echo $pagination; ?></div>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    <!-- <table width="100%"  class="table-list">
                        <thead>
                            <tr>
                                <th width="24" align="left">选择</th>
                                <th align="left">标题</th>
                                <th width="80" align="left">栏目</th>
                                <th width="80" align="left">更新时间</th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php if (is_array($list)) foreach ($list as $t) { ?>
                    <tr>
                        <td align="center">
                        <input type="checkbox" class="deletec" onClick="select_list(this,'<?php echo $t['title']; ?>',<?php echo $t['id']; ?>,'<?php echo $this->view->get_show_url($t); ?>')"  title="点击选择" ></td>
                        <td align="left">
                        <?php if (is_array($this->status_arr))  foreach ($this->status_arr  as $key=>$r) { ?>
                        <?php  if ($t['status']==$key) {?>
                        <a href="<?php echo url('admin/content/all', array('catid'=>$catid, 'status'=>$key,'name'=>$name)); ?>"><font color="#f00">[<?php echo $r; ?>]</font></a>
                        <?php }  ?>
                        <?php } ?><?php echo $t['title']; ?>
                        </td>
                        <td align="left">
                            <a href="<?php echo url('admin/content/all',array('catid'=>$t['catid'] ,'name'=>$name)); ?>"><?php echo $this->category_cache[$t['catid']]['catname']; ?></a>
                        </td>
                        <td align="left">
                            <span style="<?php if (date('Y-m-d', $t['time']) == date('Y-m-d')) { ?>color:#F00<?php } ?>" title="<?php echo date('H:i', $t['time']); ?>"><?php echo date('Y-m-d', $t['time']); ?></span>
                        </td>
                        
                    </tr>
                    <?php } ?>
                    <tr >
                        <td colspan="4"  align="left" style="border-bottom:0px;">
                            <div class="pageleft"><?php echo $pagelist; ?></div>
                        </td>
                    </tr>

                    </tbody>
                    </table> -->
            </div>
        </div>
        <script>
        function select_list(obj, title, id,url) {
            var relation_ids = window.parent.$('#<?php echo $name; ?>').val();
            var sid = 'v1' + id;
            if ($(obj).attr('class') == 'line_ff9966' || $(obj).attr('class') == null) {
                $(obj).attr('class', 'line_fbffe4');
                window.parent.$('#' + sid).remove();
                if (relation_ids != '') {
                    var r_arr = relation_ids.split(',');
                    var newrelation_ids = '';
                    $.each(r_arr, function (i, n) {
                        if (n != id) {
                            if (i == 0) {
                                newrelation_ids = n;
                            } else {
                                newrelation_ids = newrelation_ids + ',' + n;
                            }
                        }
                    });
                    window.parent.$('#<?php echo $name; ?>').val(newrelation_ids);
                }
            } else {
                $(obj).attr('class', 'line_ff9966');
                var str = "<li id='" + sid + "'><span><a href='" + url + "'\" target=\"_blank\">" + title + "</a></span><a href='javascript:;' class='close' onclick=\"remove_relation('" + sid + "'," + id + ",'<?php echo $name; ?>')\"></a></li>";
                window.parent.$('#<?php echo $name; ?>_text').append(str);
                if (relation_ids == '') {
                    window.parent.$('#<?php echo $name; ?>').val(id);
                } else {
                    relation_ids = relation_ids + ',' + id;
                    window.parent.$('#<?php echo $name; ?>').val(relation_ids);
                }
            }
        }
        </script>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
