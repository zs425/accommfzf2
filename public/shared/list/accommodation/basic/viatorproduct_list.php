<?php 
    //var_dump($this);
    $images = $this->serviceManager()->get('AceLibrary\Service\ViatorService')->getProductPhotos($this->code); ?>
<li class="well">
    <div class="row-fluid">
        <div class="span2">
            <a href="<?php echo $this->thumbnailURL; ?>" class="preview" target="_blank" title="<?php echo $this->title; ?>">
                <img class="product-primary-image" src="<?php echo $this->thumbnailURL; ?>"/>
            </a>
        </div>
        
        <div class="span6">
            <h4 class="media-heading"><?php echo $this->title; ?></h4>
            <p class="role"><?php echo $this->primaryDestinationName;?></p>
            <p><?php echo $this->shortDescription; ?></p>
        </div>
        <div class="span4">
            <div class="btn-group">
                <a href="<?php echo $this->url("tours", array("action"=>"viewviator", "id"=>$this->code));?>" class="btn btn-info">Read More</a>
                <a href="#" class="btn btn-success">Add to Planner</a>
            </div>
        </div>        
        
    </div>
<?php if ($images):?>
    <div class="" style="margin-top:15px;">
        <?php foreach ($images->data as $image): ?>
            <?php //var_dump($image);?>
            <a href="<?php echo $image->photoURL; ?>" class="preview" target="_blank">
                <img class="product-gallery-image" src="<?php echo $image->thumbnailURL; ?>"/>
           </a>
        <?php endforeach;?>
    </div>
<?php  endif; ?>
</li>