<li class="span3">
    <div class="thumbnail unit-bg">
        <a href="post.html">
            <?php echo $this->loremPixel(256, 140, false, 'sports', 'Hotel', 2); ?></a>

        <div class="caption">
            <h4><?php echo $product_name; ?></h4>

            <p><?php echo $this->urlFilter($url) ?></p>

            <p><?php echo $product_shortdesc ?></p>

            <p>
                <span class="view-deal"><a href="/<?= $this->categoryurl ?>/<?php echo $this->urlFilter($url) ?>"
                                           class="btn btn-large btn-success">View <i class="icon-chevron-right icon-white"> </i></a></span>
                <?php if ($product_lowrate): ?><span>From</span> </span><span class="help-inline text-highlight-small">
                    $<?php echo $product_lowrate ?></span><?php endif; ?>
            </p>

        </div>
    </div>
</li>