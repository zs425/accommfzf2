<?php $productimagepath = '';// set image path
$imagepathdelim = "";
$imagepathid = '';

switch ($product_info->product_source) { // work out id used for image path
    		case 'v3':
    			$imagepathid = $product_info->product_id;
    			$imagepathdelim = "/";
    			break;
    		case 'roamfree':
    			$imagepathid = $product_info->product_source_id;
    			$imagepathdelim = "/";
    			break;
    		case 'hc':
    			$imagepathid = '';
    			$imagepathdelim = "";
    			break;
    		case 'atdw':
    			$imagepath = '';
    			$imagepathdelim = '';
    			$product_info->product_source = '';
    			break;

			default:$imagepath = $product_info->product_id;
    			break;

}

$productimagepath = "http://images.bookaccommodationonline.com.au/" . $product_info->product_source  . $imagepathdelim  . $imagepathid . $imagepathdelim;
$thumb40path = "http://images.bookaccommodationonline.com.au/40/" .  $product_info->product_source . $imagepathdelim  . $imagepathid . $imagepathdelim;


// set dest type
$desttype = '';
if ($product_info->product_city)
{
	$desttype = 'city';
	$destname = $product_info->product_city;
}
elseif
($product_info->product_area_id)
{
	$desttype = 'area';
	$destname = $product_info->product_area;
}
elseif ($product_info->product_region_id)
{
	$desttype = 'region';
	$destname = $product_info->product_region;
}
?>

<?php if ($product_info->product_layout == 'enhanced'):?><div class="header_slider" style="background-image:url(/shared/viewpages/accommodation/enhanced/bootstrap1/images/pattern_4.png); background-color:#222">

        	<div class="slides_container">

            	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
                    <div class="slide_text bottom left">
						<div class="slide_title"><strong>GOLF &amp; TRAVEL</strong></div>
	                    <p class="subtitle">5 resorts to get your swing back</p>
                    </div>
			  	</div>
			  	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
					<div class="slide_text bottom right">
	                    <div class="slide_title"><strong>YOSEMITE PARK</strong></div>
	                    <p class="subtitle">Hike the gorgeous trails of national parks</p>
                    </div>
			  	</div>
			  	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
                    <div class="slide_text bottom left">
	                    <div class="slide_title"><strong>EXPLORE WILD AFRICA</strong></div>
	                    <p class="subtitle">Safari is not just a browser anymore</p>
                    </div>
			  	</div>
			  	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
                    <div class="slide_text left middle">
	                    <div class="slide_title"><strong>Exotic Beaches</strong></div>
	                    <p class="subtitle">Carribean Paradise at your feet</p>
                    </div>
			  	</div>
			  	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
                    <div class="slide_text center top">
	                    <div class="slide_title"><strong>Shopping City Breaks</strong></div>
	                    <p class="subtitle">When money's not an issue, but time is...</p>
                    </div>
			  	</div>
			  	<div class="slide">
					<?php echo $this->loremPixel(1250, 467, false, 'sports', 'Sample Photo', 2);?>
                    <div class="slide_text right middle">
						<div class="slide_title"><strong>Trails for the history buffs</strong></div>
	                    <p class="subtitle">Peru's Machu Picchu is out of this world</p>
                    </div>
			  	</div>
</div>
          	<a href="#" class="prev">Prev</a><a href="#" class="next">Next</a>
            <div class="slider_pagination_wrap">
            	<div class="slider_pagination_inner" style="width: 1250px;">
				<ul class="slider_pagination">
					<li><a href="#0">GOLF &amp; TRAVEL</a></li>
	                <li><a href="#1">National Parks</a></li>
	                <li><a href="#2">WILD AFRICA</a></li>
	                <li><a href="#3">EXOTIC beaches</a></li>
	                <li><a href="#4">SHOPPING CITIES</a></li>
	                <li><a href="#5">HistorIC TRAILS</a></li>
	          	</ul>
                </div>
            </div>

          	<script>
				jQuery(document).ready(function($) {
						$('.header_slider').slides({
							generatePagination: false,
							generateNextPrev: true,
							paginationClass: 'slider_pagination',
							play: 5000,
							pause: 3500,
							hoverPause: true,
							effect: 'fade',
							crossfade: true,
							preload: true,

							preloadImage: '/shared/viewpages/accommodation/enhanced/bootstrap1/images/loading.gif'
						});
				});
			</script>
</div>
<?php endif;?>


 <div class="container">


          <br>
<div class="row">
  <div class="span9"><div class="well">

  <div class="container">

<div class="row">
  <div class="span8">


  <div class="page-header">
  <h1><?php echo $product_info->product_name; ?>
    <small>- <?php echo $destname?></small>

  </h1>
</div>



<!-- Photo Gallery -->
<div id="gallery" class="carousel slide">
    <div class="carousel-content">
        <?php foreach ($product_info->multimedia as $i => $image):?>
            <?php //$imageInfo = getimagesize($productimagepath . $image['multimedia_path']); var_dump($imageInfo); die();?>
            <div class="<?php $i != 0 || print 'active '?>item"><img src="<?= $productimagepath?><?php echo $image['multimedia_path']?>" border="0"/></div>
        <?php endforeach;?>
    </div>
    <a style="line-height: 27px;" class="carousel-control left" href="#gallery" data-slide="prev">&lsaquo;</a>
    <a style="line-height: 27px;" class="carousel-control right" href="#gallery" data-slide="next">&rsaquo;</a>
    
    <div class="my-carousel-indicators">
        <?php foreach ($product_info->multimedia as $i => $image):?>
            <div class="gallery-thumb-wrapper">
	           <div class="gallery-thumb"><img data-target="#gallery" data-slide-to="<?php echo $i ?>" src="<?= $thumb40path?><?php echo $image['multimedia_path']?>" border="0"/></div>
	        </div>
        <?php endforeach;?>
    </div>
    
</div>
<script type="text/javascript">
$(document).ready(function () {
	var maxHeight = 0;
	var images = []
	$('.item > img').each(function(i) {
		var src = $(this).attr('src');
	    images[i] = new Image();

	    images[i].onload = function() {
		    var height = images[i].height;
		    if(height > maxHeight) {
			    maxHeight = height;
			    $('.carousel-content').height(maxHeight);
		    }
	    }
	    images[i].src = src;
	});
});
</script>
<!--/ Photo Gallery -->




</div>

</div>

  <div class="container">


<div class="row">
  <div class="span8"><div class="well">
  <h3>
   Information
  </h3>

<dl class="dl-horizontal">
<dt>Description</dt>
  <dd><?php echo $product_info->product_description?></dd>
  <?php if ($product_info->product_checkin): ?>
  <dt>Check in</dt>
  <dd><?php echo $product_info->product_checkin?></dd>
  <?php endif;?>
 <?php if ($product_info->product_checkout): ?> <dt>Check Out</dt>
  <dd><?php echo $product_info->product_checkout; ?></dd>
<?php endif;?>

    <dt></dt>
  <dd></dd>
  </dl>
</div>
<?php if ($product_info->attributes):?>
<div class="well">
<h3>Facilities</h3>
<?php foreach ($product_info->attributes as $attr):?>
<?php if ($attr['attr_type'] == 'Entity Facility') : ?>
<span class="label label-info " style="line-height:28px; "><?php echo $attr['attr_name']?></span>
<?php endif;?>
<?php endforeach;?>
</div>
<?php endif;?>




</div>
</div>
  </div>

 </div>

  </div></div>




  <div class="span3">

  <div class="nav nav-tabs nav-stacked" style="background:white; font-size:11px; ">
  <li class="active" style="font-size:12px; font-weight:bold;">
    <a href="#">Explore</a>
  </li>
  <li>

    <a href="#"><i style="padding-right:10px; margin-top:2px" class="icon-envelope"></i>Email this Listing</a>
  </li>
    <li>

    <a href="#"><i style="padding-right:10px; margin-top:2px" class="icon-envelope"></i>Add to Travel Planner</a>
  </li>
  <li>
    <a href="#"><i style="padding-right:10px; margin-top:2px" class="icon-print"></i>Print Listing</a>
  </li>

  <li>
    <a href="#"><i style="padding-right:10px; margin-top:2px" class="icon-star"></i>Add to Favourites</a>
  </li>

   <li>
    <a href="#"><i style="padding-right:10px; margin-top:2px" class="icon-search"></i>View Similar Properties</a>
  </li>


</div>




<ul class="nav nav-tabs nav-stacked" style="background:white; font-size:11px; ">
    <div id="propertyMap"></div>
</ul>
 </div>
</div>

 <!-- End Slider/Search Block -->

<script type="text/javascript">
google.maps.visualRefresh = true;
var propertyLocation = new google.maps.LatLng(<?php echo $product_info->product_lat?>, <?php echo $product_info->product_lon?>);
var map;
var marker;
function initialize() {
    var mapOptions = {
    	zoom: 17,
	    center: propertyLocation,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('propertyMap'), mapOptions);

    marker = new google.maps.Marker({
        map:map,
        title: '<?php echo $product_info->product_name; ?>',
        position: propertyLocation
    });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

    </div> <!-- /container -->

<?php  var_dump($product_info) ?>

