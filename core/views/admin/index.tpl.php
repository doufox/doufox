<?php include $this->admin_tpl('header');?>

<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="page_menu">
        <div class="left-head">
            <span style="float:right;">
                <a href="javascript:void(0);" onClick="refresh();" class="refresh">
                    <img src="/static/img/space.gif" alt="刷新菜单" title="刷新菜单" height="18" width="16" />
                </a>
            </span>
            <label id='root_menu_name'>内容管理</label>
        </div>
        <div id="browser">
            <iframe name="leftMain" id="leftMain" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" src="<?php echo url('admin/content/category'); ?>"
                style="border:none" width="100%">
            </iframe>
        </div>
    </div>
    
    <div id="right">
        <?php include $this->admin_tpl('main');?>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
