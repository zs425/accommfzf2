<?php
// set dest type
$desttype = '';
if ($product_info->product_city) {
    $desttype = 'city';
    $destname = $product_info->product_city;
}
elseif
($product_info->product_area_id
) {
    $desttype = 'area';
    $destname = $product_info->product_area;
}
elseif ($product_info->product_region_id) {
    $desttype = 'region';
    $destname = $product_info->product_region;
}
?>

<div class="container">


<br>

<div class="row">
<div class="span9">
    <div class="well">

        <div class="container">

            <div class="row">
                <div class="span8">


                    <div class="page-header">
                        <h1><?php echo $product_info->product_name; ?>
                            <small>- <?php echo $destname ?></small>
                            <span style="font-size:23px; padding:10px; float:right;" class="label label-success">$340,000</span>
                        </h1>
                    </div>


                    <?php /********************* standard slideshow for low res images ****************************/ ?>

                    <?php if ($product_info->multimedia): ?>
                        <!-- Photo Gallery -->
                        <div id="gallery" class="carousel slide">
                            <div class="carousel-content">
                                <?php foreach ($product_info->multimedia as $i => $image): ?>
                                    <div class="<?php $i != 0 || print 'active ' ?>item"><img
                                            src="<?php echo $this->imagePath($product_info) . $image['multimedia_path'] ?>"
                                            border="0"/></div>
                                <?php endforeach; ?>
                            </div>
                            <a style="line-height: 27px;" class="carousel-control left" href="#gallery"
                               data-slide="prev">&lsaquo;</a>
                            <a style="line-height: 27px;" class="carousel-control right" href="#gallery"
                               data-slide="next">&rsaquo;</a>

                            <div class="my-carousel-indicators">
                                <?php foreach ($product_info->multimedia as $i => $image): ?>
                                    <div class="gallery-thumb-wrapper">
                                        <div class="gallery-thumb"><img data-target="#gallery"
                                                                        data-slide-to="<?php echo $i ?>"
                                                                        src="<?php echo $this->thumbPath($product_info) . $image['multimedia_path'] ?>"
                                                                        border="0"/></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
<? var_dump($product_info);?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            var maxHeight = 0;
                            var images = []
                            $('.item > img').each(function (i) {
                                var src = $(this).attr('src');
                                images[i] = new Image();

                                images[i].onload = function () {
                                    var height = images[i].height;
                                    if (height > maxHeight) {
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

                <?php
                if (isset($this->individualSearch)) {
                    if ($this->product_info->product_source == 'roamfree') {
                        echo $this->partial('viewpages/results/roamfree-individual', array('product' => $this->product_info, 'individualSearch' => $this->individualSearch));
                    }
                    else if ($this->product_info->product_source == 'v3') {
                        echo $this->partial('viewpages/results/v3-individual', array('product' => $this->product_info, 'individualSearch' => $this->individualSearch));
                    }
                }
                ?>

                <div class="row">
                    <div class="span8">
                        <div class="well">
                            <h3>
                                <?php echo $this->translate('Property Information'); ?>
                            </h3>

                            <dl class="dl-horizontal">
                                <dt><?php echo $this->translate('Description') ?></dt>
                                <dd><?php echo $product_info->product_description ?></dd>
                                <?php if ($product_info->product_checkin): ?>
                                    <dt><?php echo $this->translate('Check in') ?></dt>
                                    <dd><?php echo $product_info->product_checkin ?></dd>
                                <?php endif; ?>
                                <?php if ($product_info->product_checkout): ?>
                                    <dt><?php echo $this->translate('Check Out') ?></dt>
                                    <dd><?php echo $product_info->product_checkout; ?></dd>
                                <?php endif; ?>

                                <dt></dt>
                                <dd></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <?php if ($product_info->attributes): ?>
                    <div class="row">
                        <div class="span8">
                            <div class="well">
                                <h3><?php echo $this->translate('Facilities') ?></h3>
                                <?php foreach ($product_info->attributes as $attr): ?>
                                    <?php if ($attr['attr_type'] == 'Entity Facility') : ?>
                                        <span class="label label-info "
                                              style="line-height:28px; "><?php echo $attr['attr_name'] ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($product_info->hotel_rooms): ?>
                    <div class="row">
                        <div class="span8">
                            <h3><?php echo $this->translate('Room Descriptions') ?></h3>
                            <?php foreach ($product_info->hotel_rooms as $room): ?>
                                <div class="well"><h4><?php echo $room['room_name'] ?></h4>

                                    <p><?php echo $room['room_description'] ?></p>
                                    <?php if ($product_info->product_checkout): ?>
                                        <dt><?php echo $this->translate('Check Out') ?></dt>
                                        <dd><?php echo $product_info->product_checkout; ?></dd>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($product_info->product_info): ?>
                    <div class="row">
                        <div class="span8">
                            <div class="well">
                                <h3><?php echo $this->translate('Property Policies') ?></h3>
                                <dl class="dl-horizontal">
                                    <?php foreach ($product_info->product_info as $info): ?>
                                        <?php if ($info['info_title'] != 'V3 State ID' && $info['info_title'] != 'V3 Region ID'): ?>
                                            <dt><?php echo $info['info_title'] ?></dt>
                                            <dd><?php echo $info['info_body'] ?></dd>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>


<div class="span3">

    <div class="nav nav-tabs nav-stacked" style="background:white; font-size:11px; ">
        <li class="active" style="font-size:12px; font-weight:bold;"><a href="#"><?php echo $this->translate('Explore'); ?></a></li>
        <li><a href="#"><i style="padding-right:10px; margin-top:2px"
                           class="icon-envelope"></i><?php echo $this->translate('Email this Listing'); ?></a></li>
        <li><a href="#"><i style="padding-right:10px; margin-top:2px"
                           class="icon-envelope"></i><?php echo $this->translate('Add to Travel Planner'); ?></a></li>
        <li><a href="#"><i style="padding-right:10px; margin-top:2px"
                           class="icon-print"></i><?php echo $this->translate('Print Listing'); ?></a></li>
        <li><a href="#"><i style="padding-right:10px; margin-top:2px"
                           class="icon-star"></i><?php echo $this->translate('Add to Favourites'); ?></a></li>
        <li><a href="#"><i style="padding-right:10px; margin-top:2px"
                           class="icon-search"></i><?php echo $this->translate('View Similar Properties'); ?></a></li>
    </div>


    <ul class="nav nav-tabs nav-stacked" style="background:white; font-size:11px; ">
        <li class="active" style="font-size:12px; font-weight:bold;">
            <a href="#"><?php echo $this->translate('Check Availability') ?></a>
        </li>
        <div style="padding: 10px; padding-bottom: 1px;">
            <?php
            echo $this->partial('travel/accommodation/booking-form.phtml', array(
                'bookingForm' => $this->bookingForm,
                'action'      => $this->url('accommodationhome/definition', array('slug' => $product_info->product_id . '-' . $this->urlFilter($product_info->product_name)))
            ))?>
        </div>

    </ul>

    <ul class="nav nav-tabs nav-stacked">
        <div id="propertyMap"></div>
        </li>

    </ul>
</div>
</div>

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
            map: map,
            title: '<?php echo $product_info->product_name; ?>',
            position: propertyLocation
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- End Slider/Search Block -->


</div> <!-- /container -->