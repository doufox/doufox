<?php include $this->_include('header.html'); echo PHP_EOL; ?>


    <div class="page-header">
        <h1><?php echo $site_name; ?> <small><?php echo $catname; ?></small></h1>
    </div>
    <div class="container-fluid">
        <?php echo $content; ?>
    </div>

<?php include $this->_include('footer.html'); echo PHP_EOL; ?>