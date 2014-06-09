<?php $images = $this->serviceManager()->get('Travel\Model\MultimediaTable')->getProductPhotos($product_id, 'ACCOMM', $product_source_id)->toArray(); ?>
<li class="well">
    <div class="row-fluid">
    	<div class="span2">
    		<a href="<?php echo $this->thumbPath($product, $product->product_photo, "http://images.bookaccommodationonline.com.au/"); ?>" class="preview" target="_blank" title="<?php echo $product_name; ?>">
    			<img class="product-primary-image" src="<?php echo $this->thumbPath($product, $product->product_photo, "http://images.bookaccommodationonline.com.au/", 100); ?>"/>
    		</a>
    	</div>
        
        <div class="span7">
            <h4 class="media-heading"><?php echo $product_name; ?></h4>
            <p class="role"><?php echo $this->displayProductArea($product);?></p>
            <p><?php echo $product_shortdesc ?></p>
        </div>
        <div class="span3">
            <div class="btn-group">
                <a href="/<?= $this->categoryurl ?>/<?php echo $this->urlFilter($url) ?>" class="btn btn-info">Read More</a>
                <a href="#" class="btn btn-success">Add to Planner</a>
            </div>
        </div>        
        
    </div>
<?php if ($images):?>
	<div class="" style="margin-top:15px;">
        <?php foreach ($images as $image): ?>
        	<a href="<?php echo $this->thumbPath($product, $image['multimedia_path'], "http://images.bookaccommodationonline.com.au/"); ?>" class="preview" target="_blank">
            	<img class="product-gallery-image" src="<?php echo $this->thumbPath($product, $image['multimedia_path'], "http://images.bookaccommodationonline.com.au/",  40); ?>"/>
           </a>
        <?php endforeach;?>
    </div>
<?php  endif; ?>
</li>