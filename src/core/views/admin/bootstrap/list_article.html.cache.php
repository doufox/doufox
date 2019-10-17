<?php include $this->_include('header.html'); echo PHP_EOL; ?>

    <div class="main">
        <div class="container">
            <div class="w210 fl"><?php include $this->_include('sidebar.html'); echo PHP_EOL; ?></div>
            <div class="w740 fr bg">
                <?php include $this->_include('crumbs.html'); echo PHP_EOL; ?>
                <div class="">
                    <ul class="article-list">
                    <?php $return = $this->_listdata("catid=$catid page=$page cache=36000"); extract($return); if (is_array($return)) { foreach ($return as $key=>$vdata) { ?>
                    <li>
                        <span class="date"><?php echo date("Y-m-d", $vdata['time']); ?></span>
                        <a href="<?php echo $vdata['url']; ?>">· <?php echo $vdata['title']; ?></a>
                    </li>
                    <?php } } ?>
                    </ul>
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>

<?php include $this->_include('footer.html'); echo PHP_EOL; ?>
