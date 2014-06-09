<?php
return array(
    'template_path_stack' => array(
        'test' 						=> __DIR__ . '/view',        
    ),
    'template_map' => array(
        'layout/layout'             => __DIR__ . '/view/layout/layout.phtml',
    	'layout/nav'			    => 'public/shared/topnav/megafixedbootstrap/megafixedbootstrap.php',
    	'layout/contentbox'         => 'public/shared/contentboxes/bootstrap2/bootstrap2.php',
        'layout/headerslider'       => 'public/shared/headerslider/headerslider.phtml',
        'layout/searchform'       => 'public/shared/searchform/searchform.phtml',
    	'layout/listbox'    	    => 'public/shared/list/accommodation/bootstrap1/bootstrap1.php',
        'layout/listbasic'          => 'public/shared/list/accommodation/basic/basic.php',
        'layout/product-list'		=> 'public/shared/list/accommodation/basic/product_list.php',
        'layout/viatorproduct-list' => 'public/shared/list/accommodation/basic/viatorproduct_list.php',
        'layout/yelp-list' 			=> 'public/shared/list/accommodation/basic/yelp_list.php',
    	'layout/viewaccommenhanced' => 'public/shared/viewpages/accommodation/enhanced/bootstrap1/bootstrap1.php',
    	'layout/viewattract'        => 'public/shared/viewpages/attractions/bootstrap1/bootstrap1.php',
        'layout/viewviator'         => 'public/shared/viewpages/viator/bootstrap1/bootstrap1.php',
        'application/index/index'   => __DIR__ . '/view/application/index/index.phtml',
        'error/404'                 => __DIR__ . '/view/error/404.phtml',
        'error/index'               => __DIR__ . '/view/error/index.phtml',  
        'paginator-slide'     		=> 'public/shared/list/accommodation/slidePaginator.php',  
        'viatorpaginator-slide'     => 'public/shared/list/accommodation/viatorSlidePaginator.php',  
        'yelppaginator-slide'     	=> 'public/shared/list/yelp/yelpSlidePaginator.php',
    ),	
);