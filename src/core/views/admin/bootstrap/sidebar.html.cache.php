<div class="sidebar bg">
  <div class="sidebar-header">Category</div>
    <div class="sidebar-body">
      <ul>
<?php $return = $this->_category(" ");  if (is_array($return)) { foreach ($return as $key=>$vdata) { $arrchilds = @explode(',', $vdata['arrchilds']);    $current = in_array($catid, $arrchilds);?>
        <li<?php if ($current) { ?> class="select"<?php } ?>><s></s><a href="<?php echo $vdata['url']; ?>"><?php echo $vdata['catname']; ?></a></li>
<?php } } ?>
    </ul>
  </div>
</div>
