<?php include $this->_include('header.html'); echo PHP_EOL; ?>

<div class="page-header">
    <h1><?php echo $site_name; ?> <small><?php echo $site_slogan; ?></small></h1>
</div>
<div class="main home-card">
    <div class="container">
        <?php $return = $this->_category(" ");  if (is_array($return)) { foreach ($return as $key=>$vdata) { $arrchilds = @explode(',', $vdata['arrchilds']);    $current = in_array($catid, $arrchilds);?>
        <div class="newwarp bg">
            <div class="newstitle">
                <h3><a href="<?php echo $vdata['url']; ?>" class="more"><?php echo $vdata['catname']; ?></a></h3>
                <a href="<?php echo $vdata['url']; ?>" class="more">more&gt;&gt;</a>
            </div>
            <?php $return = $this->_listdata("catid=$vdata[catid] status=2 num=1"); extract($return); if (is_array($return)) { foreach ($return as $key=>$vdata) { ?>
            <div class="newsfocus">
                <div><a href="<?php echo $vdata['url']; ?>"><img src="<?php echo thumb($vdata[thumb]); ?>" /></a></div>
                <h3><a href="<?php echo $vdata['url']; ?>" title="<?php echo $vdata['title']; ?>"><?php echo strcut($vdata[title],34); ?></a></h3>
                <p><?php echo strcut($vdata[description],80); ?> </p>
            </div>
            <?php } } ?>
            <ul class="indexnewslist">
                <?php $return = $this->_listdata("catid=$vdata[catid] order=time num=3"); extract($return); if (is_array($return)) { foreach ($return as $key=>$vdata) { ?>
                <li><span><?php echo date("Y-m-d", $vdata['time']); ?></span> · <a href="<?php echo $vdata['url']; ?>"><?php echo strcut($vdata[title],34,''); ?></a></li>
                <?php } } ?>
            </ul>
        </div>
        <?php } } ?>
    </div>
    <div class="link bg"><?php $this->block(6);?></div>
</div>
<?php include $this->_include('recommend_article.html'); echo PHP_EOL;  include $this->_include('footer.html'); echo PHP_EOL; ?>