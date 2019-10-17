<?php include $this->_include('header.html'); echo PHP_EOL; ?>

<div class="main sitemap">
    <div class="container">
        <?php include $this->_include('crumbs.html'); echo PHP_EOL; ?>
        <ul>
            <?php $return = $this->_category(" ");  if (is_array($return)) { foreach ($return as $key=>$vdata) { $arrchilds = @explode(',', $vdata['arrchilds']);    $current = in_array($catid, $arrchilds);?>
                <li><a href="<?php echo $vdata['url']; ?>"><?php echo $vdata['catname']; ?></a></li>
            <?php } } ?>
        </ul>
    </div>
</div>
<?php include $this->_include('footer.html'); echo PHP_EOL; ?>