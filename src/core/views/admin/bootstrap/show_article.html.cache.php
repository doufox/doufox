<?php include $this->_include('header.html'); echo PHP_EOL; ?>
    <div class="main">
        <div class="container bg">
            <?php include $this->_include('crumbs.html'); echo PHP_EOL; ?>
            <div class="article">
                <h2 class="title"><?php echo $title; ?></h2>
                <div class="meta">
                    发布时间&nbsp;:&nbsp;<?php echo date("Y-m-d H:i:s", $time); ?>&nbsp;
                    阅读&nbsp;:&nbsp;<script type="text/javascript" src="<?php echo url('api/index/hits',array('id'=>$id)); ?>"></script>次&nbsp;
                    <?php if ($originalurl) { ?>&nbsp;<a href="<?php echo $originalurl; ?>" target="_blank">原文链接</a><?php } ?>
                </div>
                <div class="content">
                    <?php echo $content; ?>
                </div>
                <?php if ($content_page) { ?>
                <div class="pagination">
                    <?php if (is_array($content_page)) { foreach ($content_page as $t=>$u) { ?>
                    <a<?php if ($page!=$t) { ?> href="<?php echo $u; ?>"<?php } else { ?> style="background-color: #c00;"<?php } ?>><?php echo $t; ?></a>
                    <?php } } ?>
                </div>
                <?php } ?>
                <div class="blank10 clear"></div>
                <div class="article-tags"><?php echo $tag; ?></div>
            </div>
            <div class="blank20 clear"></div>
            <div class="comment">
                <div class="bg">
                    <h2>评论列表</h2>
                    <?php $return = $this->_listdata("table=form_comment cid=$id order=time"); extract($return); if (is_array($return)) { foreach ($return as $key=>$vdata) { ?>
                    <div><?php echo $vdata[content]; ?></div>
                    <?php } } ?>
                </div>
                <div class="blank20 clear"></div>
                <form action="<?php echo url('index/form', array('modelid'=>4, 'cid'=>$id)); ?>" method="post">
                    <h3>评论内容：</h3>
                    <textarea class="content" name="data[content]"></textarea></td>
                    <input type="submit" class="button" value="提 交" name="submit">
                </form>
            </div>

            <div class="article-prev-next">
                <?php if ($prev_page) { ?>
                <div class="article-prev">上一篇：<a href="<?php echo $prev_page['url']; ?>"><?php echo $prev_page['title']; ?></a></div>
                <?php }  if ($next_page) { ?>
                <div class="blank5 clear"></div>
                <div class="article-next">下一篇：<a href="<?php echo $next_page['url']; ?>"><?php echo $next_page['title']; ?></a></div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php include $this->_include('footer.html'); echo PHP_EOL; ?>