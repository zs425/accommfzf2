<?php
$output = ''; // set $output to blank variable
$items = $this->getMenuItems('getItems', '1');
$config = $this->serviceManager()->get('Config');
$attributemodel = $this->serviceManager()->get('Travel\Model\AttributeTable');
$viaService = $this->serviceManager()->get('AceLibrary\Service\ViatorService');
$optionModel = $this->serviceManager()->get('Admin\Model\OptionsModel');

//var_dump($config);
 //get MenuItems from view helper
foreach ($items[0] as $item) // loop through items to get top level items
{

    if (!$item['menuitem_visible']) // if it is not visible then don't show it
        continue;
    $children = false;
    $caret = $toggle = $dropdown = '';
    if (isset($item['children']) && count($item['children']))
    { // display caret and dropdown classes for any items with secondary menu
        $caret = '<b class="caret"></b>';
        $toggle = 'class="dropdown-toggle" data-toggle="dropdown"';
        $dropdown = ' class="dropdown"';
        $href = "#";
    }
    else
    { // if no secondary menu then show the item
        $href = $item['menuitem_uri'];
    }
    $output .= '<li' . $dropdown . '><a href="' . $href . '" '/* target="' . $item['menuitem_target'] . '" '*/ . $toggle . ' >' . $item['menuitem_label'] . $caret . '</a>';
    // sub
    if (isset($item['children']) && count($item['children']))
    {$bytypeend ='';
    $submenuwidth = "";
    $destspan = '';
    }

    if (count($item['children']) > 1)
    {
    	$checkquery = $this->getMenuItems('getAreas');

    	$destcount = count($checkquery);

    	$destspancount = (int)((ceil(($destcount)/25)*2) + 2);
    	$destspan = "span" . $destspancount;
    	//$output .= '<!--/.' . $destcount -->';


    }

    $output .= '
            <ul class="dropdown-menu ' . $destspan . '">';
    $ul = false; // what is this for?
    foreach ($item['children'] as $key => $sub)
    {
    	if (!$sub['menuitem_visible'])
    		continue;
    	// regular menu item
    	if ($sub["menuitem_type"] == 'Menu Item')
    	{
    		// check is starting ul needed
    		if (!$ul)
    		{
    			$output .= "<ul class='span2'>";
    			$ul = true;
    		}
    		$output .= '     <li><a href="' . $sub['menuitem_uri'] . '" target="' . $sub['menuitem_target'] . '">' . $sub['menuitem_label'] . '</a></li>';
    		// ending ul
    		if (!isset($item['children'][$key + 1]))
    			$output .= '</ul>';
    		continue;
    	}
    	// separated menu as submenu for meganav
    	elseif (strstr($sub["menuitem_type"], 'menu_'))
    	{
    		$includedMenu = $menuitems->getItems(str_replace('menu_', '', $sub["menuitem_type"]));
    		if (count($includedMenu))
    		{
    			$output .= '<ul class="dropdown-menu">
                        ';
    			if (!empty($sub["menuitem_label"]))
    				$output .= '\n      <li><h2><a href="javascript:;">' . $sub["menuitem_label"] . '</a></h2></li>
                            ';
    			foreach ($includedMenu as $incItem)
    			{
    				$output .= '\n     <li><a href="' . $incItem['menuitem_uri'] . '" target="' . $incItem['menuitem_target'] . '">' . $incItem['menuitem_label'] . '</a></li>';
    			}
    			$output .= '</ul>';
    		}
    		continue;
    	}
    	// planner
    	elseif ($sub["menuitem_type"] == 'Travel Planner')
    	{
    		$output .= '
                    <li class="span3">
                    <div class="dropdownplanner">
                        <div class="ntop"><h3>' . $sub["menuitem_label"] . '</h3></div>
                    <div class="content">
                        <div class="boxText"></div>
                	<h5 class="step">Step 1</h5>
                        <div class="boxText">Click "Add To Planner" from pages that interest you to see it below.
                        <br class="clear"/>
                	</div>
                        <div id="planner">
                            <ul>' . /*$this->planner()->items() .TODO FIX PLANNER*/ '</ul>
                        </div>
                        <br class="clear" />
                        <h5 class="step">Step 2</h5>
                        <div class="boxText">
                            <h4><a href="/planner">View Your Planner</a></h4>
                            <br class="clear"/>
                            <p>Here you can view your map, and print a list of the places your want to go</p>
                            <br class="clear"/>
                        </div>
                    </div>
                </div>
              </li>';
    		continue;
    	}
    	// weather
    	elseif ($sub["menuitem_type"] == 'Weather')
    	{
    		$output .= '<li class="span3">';
    		
    		$output .= $this->partial('widgets/weather');
    		
    		$output .= '</li>';
    		continue;
    	}
    	// products by type/area
    	$bytypeend = "</ul>";

    	$output .= '<li class="span2">
                    <ul class="unstyled">';



    	if (!empty($sub["menuitem_label"])){
            if ($sub["menuitem_type"] != 'Tours By Area'){
                $output .= '
                        <li><h2><a href="javascript:;">' . $sub["menuitem_label"] . '</a></h2></li>';
            }
    	}
    	switch ($sub["menuitem_type"])
    	{
    		// BY AREA
    		case 'Accommodation By Area':
    		case 'Attractions By Area':
    			if ($sub["menuitem_type"] == 'Accommodation By Area')
    			{
    				$type = 'ACCOMM';
    				$route = 'accommcity';
					$home_url = 'accommodationhome';
    			} else
    			{
    				$type = 'ATTRACTION';
    				$route = 'attractioncity';
					$home_url = 'attractionshome';
    			}

    			$i = 1;
				$output .= '
                            <li><h3 style="text-align: left;"><a href="'. $this->url($home_url) . '">View All</a></h3></li>'. PHP_EOL;;
				
    			$destinations = $this->getDestinations('getDestinationBlock',$type, $route);
    			foreach ($destinations[0] as $dest)
    			{
    				$i++;
					
    				if ($i != 1 && $i % 10 == 1 )
    				{
    					$output .= '
                                </ul>
                              </li>
                              <li class="span2" style="margin-top:30px;">
                                <ul class="unstyled">
                                    <!--<li><h2><a href="#">&emsp;</a></h2></li>-->';
    				}
					$attractionCityUrl = $this->url($route, array('category' => 'attractions', 'location3' => $dest['baodestination_url'], 'page' => null) );
    			//	$attractionCityUrl = "#";
    				$output .= '
                            <li><a href="' . $attractionCityUrl . '">' . $dest['baodestination_name'] . '</a></li>'. PHP_EOL;;
							
					
    			}
    			$output .= "<!--/.test -->";
    			break;
    			// BY TYPE
    		case 'Accommodation By Type':
    		case 'Attractions By Type':
    			if ($sub["menuitem_type"] == 'Accommodation By Type')
    			{
    				$type = 'ACCOMM';
    				$route = 'accommcategory';
    			} else
    			{
    				$type = 'ATTRACTION';
    				$route = 'attractioncategory';
    			}


    			$attributes = $attributemodel->getList('Vertical Classification', $type);
    			foreach ( $attributes as $attr)

    			{
    				/*$output .= '
                            <li><a href="' . $this->url(array("classification" => strtolower($this->atdwClassification($attr->attr_code))), $route) . '">' . $attr->attr_name . '</a></li>';
    			*/
    				$output .= '<li><a href="' . $this->url($route,array("classification" => $this->atdwClassifications($attr->attr_code)) ) .  '">' . $attr->attr_name . '</a></li>';

    			}
    			break;
    			// TOURS
    		case 'Tours By Area':
                /*$i = 1;
                $output .= '
                            <li><h3 style="text-align: left;"><a href="'. $this->url("tours") . '">View All</a></h3></li>'. PHP_EOL;;
                
                $destinations = $viaService->getAustralianAreas();
                 
                foreach($destinations as $dest){
                    $i++;
                    
                    if ($i != 1 && $i % 10 == 1 )
                    {
                        $output .= '
                                </ul>
                              </li>
                              <li class="span2" style="margin-top:30px;">
                                <ul class="unstyled">';
                    }
                    $output .= '
                            <li><a href="' . $this->url("tours", array("action"=> "destination", "id" => strtolower($dest->destinationId))) . '">' . $dest->destinationName . '</a></li>'.PHP_EOL;;
                }
    			/*$model = new Model_Viatour();
    			foreach ($model->getAreas() as $a)
    			{
    				$output .= '
                            <li><a href="' . $this->url(array("destination" => strtolower($a->product_city)), 'tourarea') . '">' . $a->product_region . ', ' . $a->product_state . '</a></li>';
    			}*/
                break;
    		case 'Tours By Type':
                $fname = ROOT_PATH . $config['config_path'];
                        
                $reader = new \Zend\Config\Reader\Ini();
                $data   = $reader->fromFile($fname);
                
                $destId = $data['providers']['viator']['id'];
		        $keyword = $data['providers']['viator']['keyword'];
				
		        if ($keyword == ""){
		            $searchResult = $viaService->getProductsByDestination($destId);
		            $productsResult = $searchResult->data;
		        }else{
		            $productsResult = array();
		            $searchResult = $viaService->getProductsByKeyword($keyword, $destId);
		            foreach ($searchResult->data as $product){
		                $productsResult[] = $product->data;
		            }
		        }
                //$destId = $optionModel->get("baodestination_id");
                $output .= '
                            <li><h3 style="text-align: left;"><a href="'. $this->url("tours") . '">View All</a></h3></li>'. PHP_EOL;;
				
				$categories = $viaService->getCategories($destId);
		
				$categories = $viaService->getCategoriesFromResult($categories, $productsResult);
                 
                foreach($categories as $category){
                    $output .= '
                            <li><a href="' . $this->url("tours", array("action"=>"category", "id"=>strtolower($category->id))) . '">' . $category->groupName . '</a></li>'.PHP_EOL;;
                }
    	/*		$model = new Model_Viatour();
    			foreach ($model->getCategories() as $c)
    			{
    				$output .= '
                            <li><a href="' . $this->url(array("category" => strtolower($c)), 'tourcateg') . '">' . $c . '</a></li>';
    			}*/
    			break;
    	}
    $output .= '
                </ul></li>';

    }
    $output .= '
                </ul></li>';

}?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">Barossa Valley Accommodation</a>

            <div class="nav-collapse">
                <ul class="nav">
                <?php echo $output ?>

                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('ul.dropdown-menu').each(function(){
			count = $(this).children('li').length;
			if(count >= 1) {
				width = $(this).children('li').outerWidth(true);
				count = $(this).children('li').length;
				console.log(count);
				console.log(width);
				$(this).css('width', (width * count) + 'px');	
			}
			
		});
	});	
</script>
<style>
	
</style>
