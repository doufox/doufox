<div class="recommend">
    <div class="container bg">
        <div class="hd">
            <h3>Recommend</h3>
            <a class="next"></a>
            <a class="prev"></a>
        </div>
        <div class="bd">
            <ul class="picList">
                <?php $return = $this->_listdata("status=3 num=10 cache=36000"); extract($return); if (is_array($return)) { foreach ($return as $key=>$vdata) { ?>
            <li>
                <div class="pic">
                    <a href="<?php echo $vdata['url']; ?>"><img src="<?php echo thumb($vdata[thumb]); ?>" /></a>
                </div>
                <div class="title">
                    <a href="<?php echo $vdata['url']; ?>"><?php echo strcut($vdata[title], 24); ?></a>
                </div>
            </li>
                <?php } } ?>
            </ul>
        </div>
    </div>
</div>