<li class="well">
    <div class="row-fluid">
        <div class="span2">
            <a href="<?php echo $this->image_url; ?>" class="preview" target="_blank" title="<?php echo $this->title; ?>">
                <img class="product-primary-image" src="<?php echo $this->image_url; ?>"/>
            </a>
        </div>
        
        <div class="span6">
            <h4 class="media-heading"><a href="<?php echo $this->url;?>" target="_blank"><?php echo $this->name; ?></a></h4>
            <p class="rating"><img src="<?php echo $this->rating_img_url;?>"/><span>&nbsp;&nbsp;<?php echo $this->review_count;?> reviews</span></p>
            <p><?php
            if (isset($this->categories)){
	            $cats = array(); 
	            foreach ($this->categories as $cat){
	            	$cats[] = $cat[0];
	            }
				echo implode($cats, ","); 
			}
            ?></p> 
        </div>
        <div class="span4">
            <p><?php if (isset($this->location->neighborhoods)){echo implode($this->location->neighborhoods, ",");}?></p>
            <p>
            	<?php echo implode($this->location->display_address, "<br/>");?>
            	<?php if (isset($this->display_phone)){ echo "<br/>".$this->display_phone;}?>
            </p>
        </div>        
        
    </div>
    <?php if(isset($this->snippet_image_url) && $this->snippet_image_url != ""){?>
    <div class="row-fluid" style="margin-top:15px;">
        <div class="span12">
        	<div class="snippet_img span1" style="width:30px; height:30px;float:left;margin-right:10px;"><img src="<?php echo $this->snippet_image_url;?>" width="30px" height="30px"/></div>
        	<div class="span10" style="float:left;line-height:15px;"><?php echo $this->snippet_text;?></div>
        </div>
    </div>
    <?php }?>
</li>