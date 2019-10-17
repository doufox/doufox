<div class="page-header">
    <a class="btn btn-link" href="<?php echo $site_url; ?>">首页</a>&nbsp;&gt;&nbsp;
<?php if ($catid) {  echo position($catid, '&gt;&nbsp;&nbsp;');  } else {  echo $page_position;  } ?>
</div>