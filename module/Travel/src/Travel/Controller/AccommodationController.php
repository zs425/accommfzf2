<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Travel for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Travel\Controller;

use Travel\Form\BookingForm;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Travel\Form\SearchForm;
use Travel\View\Helper\AtdwClassifications;
use Travel\View\Helper\GetCategory;
/**
 * Class AccommodationController
 * @package Travel\Controller
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Model\ProductModel                 $productModel
 * @property \Travel\Service\AccommodationSearchService $accommodationSearchService
 * @property \Travel\Model\DestinationModel             $destinationModel
 */
class AccommodationController extends AbstractActionController
{
    private $productTable;
    private $destinationTable;
    private $hotelRoomTable;
    private $multimediaTable;
    private $productInfoTable;
    private $productAttributesTable;
	private $attributeTable;
    private $menuItemTable;
    public $category;
    public $destCurrent;
    public $destination;
    public $classification;
    public $city;
    public $slug;
    public $page;
	private $itemsPerPage = 10;
	private $pageRange = 5;

    protected $productModel;
    protected $accommodationSearchService;
    protected $destinationModel;

    public function indexAction()
    {
        $viewParams     = array();
        $this->category = $this->params('category');

        $this->city = $this->params('location3');
        $this->page = $this->params('page');
		
        // $dest = new Model_Destination();
        $this->destCurrent = array(
            'CITY'  => $this->params('location3'),
            'AREA'  => $this->params('location2'),
            'STATE' => $this->params('location1')
        );
		
		if ($this->params('classification')){
			$classification = array_search($this->params('classification'), AtdwClassifications::$aliases);
			$this->classification = $this->getAttributeTable()->getByCode($classification);						
		} 		
				
		if (($d = $this->destCurrent['CITY']) || ($d = $this->destCurrent['AREA']) || ($d = $this->destCurrent['STATE'])) {

            $this->destination = $this->getDestinationTable()->getByUrl($d);

            $viewParams['destination'] = $d;
        }
		
		$enabledProviders    = $this->getProductModel()->getEnabledProviders();
        $product             = $this->getProductTable()->getNewList($this->getProductAbbrev($this->category), $this->page, $this->destination, $this->classification, $enabledProviders);
		
		$paginator = new Paginator(new paginatorIterator($product));
		$paginator->setCurrentPageNumber($this->page)
				  ->setItemCountPerPage($this->itemsPerPage)
				  ->setPageRange($this->pageRange);
		
        $accommodationCounts = $this->getDestinationModel()->getAccommodationCountsInAreas($this->getProductAbbrev($this->category), $this->classification);
		$breadcrumbs         = $this->getDestinationModel()->getAccommodationBreadcrumbs($this->getProductAbbrev($this->category), $this->destination, $this->classification);

        if ($this->getProductAbbrev($this->category) == 'ACCOMM') {
        	if($this->classification){
        		$viewParams['countRoute'] = 'accommcategorycity';
        	} else {
            	$viewParams['countRoute'] = 'accommcity';
			}
        }
        else if ($this->getProductAbbrev($this->category) == 'ATTRACTION') {
        	if($this->classification){
        		$viewParams['countRoute'] = 'attractioncategorycity';
			} else {
				$viewParams['countRoute'] = 'attractioncity';	
			}            
        }
        //$viewParams['products']            = $product;
        $viewParams['products']            = $paginator;
        $viewParams['categoryurl']         = $this->getCategoryUrl($this->category);
        $viewParams['accommodationCounts'] = $accommodationCounts;
        $viewParams['breadcrumbs']         = $breadcrumbs;
		$viewParams['classification']      = $this->classification;
		
		if($this->classification) {
			$viewParams['title'] = "Browse Accommodation " . $this->classification->attr_name . " By Area";
		} else {
			$getCategory = new GetCategory();
			$viewParams['title'] = "Browse Accommodation " . $getCategory->category($this->category) . " By Area";
		}
		
		$uri = $_SERVER['REQUEST_URI'];
		$uri = rtrim($uri, "/" . $this->page);
		$viewParams['uri']         		   = $uri;
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			/* ajax process here */
			$view = new ViewModel;
			$view->setTemplate('layout/product-list');
			$view->setVariables(array('products' => $paginator, 'uri' => $uri));
			$viewHtml = $this->getServiceLocator()->get('viewrenderer')->render($view);
		
			$result = array(
				"success" => true,
				"HTML" => $viewHtml,
			);
			$this->response->setContent(\Zend\Json\Json::encode($result));		
			return $this->response;
		}
		
		$searchForm       = new SearchForm($this->getServiceLocator());
		if(count($this->destination) == 1) {
			$searchForm->setData(array('area' => $this->destination[0]['baodestination_id']));	
		}		
		$viewParams['searchForm'] = $searchForm;		
        return $viewParams;
    }

	public function getProductsAsyncAction()
    {
        //$viewParams     = array();
        $this->category = $this->params('category');

        $this->city = $this->params('location3');
        $this->page = $this->params('page');
		
        // $dest = new Model_Destination();
        $this->destCurrent = array(
            'CITY'  => $this->params('location3'),
            'AREA'  => $this->params('location2'),
            'STATE' => $this->params('location1')
        );
		
		
		if (($d = $this->destCurrent['CITY']) || ($d = $this->destCurrent['AREA']) || ($d = $this->destCurrent['STATE'])) {

            $this->destination = $this->getDestinationTable()->getByUrl($d);

            $viewParams['destination'] = $d;
        }
		
		$enabledProviders    = $this->getProductModel()->getEnabledProviders();
        $product             = $this->getProductTable()->getNewList($this->getProductAbbrev($this->category), $this->page, $this->destination, $this->classification, $enabledProviders);
		
		$paginator = new Paginator(new paginatorIterator($product));
		$paginator->setCurrentPageNumber($this->page)
				  ->setItemCountPerPage($this->itemsPerPage)
				  ->setPageRange($this->pageRange);
        //$viewParams['products']            = $paginator;
        
		$uri = $_SERVER['REQUEST_URI'];
		$uri = rtrim($uri, "/" . $this->page);
		$viewParams['uri']         		   = $uri;
        //return $viewParams;
		
		$view = new ViewModel;
		$view->setTemplate('article-template');
		$view->setVariables(array('products' => $paginator, 'uri' => $uri));
		
		$viewHtml = $this->getServiceLocator()->get('viewrenderer')->render($view);
		
		$result = array(
			"success" => true,
			"HTML" => $viewHtml,
		);
		$this->response->setContent(\Zend\Json\Json::encode($result));		
		return $this->response;
		
    }
    public function fooAction()

    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /accommodation/accommodation/foo
        return array();
        echo "<h1>travel controller</h1>";
    }

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction()
    {
    	$viewParams  = array();
        $bookingForm = new BookingForm($this->getServiceLocator());
        $request     = $this->getRequest();

        $this->category = $this->params('category');
        $this->slug     = $this->params('slug');

        $urlParams = explode('-', $this->params('slug'));
        $id        = $urlParams[0];
        if (isset($urlParams[1])) {
            $url = $urlParams[1];
        }

        $product = $this->getProductTable()->getProduct($id);

        if ($request->isPost()) {
            $post = $request->getPost();
            $bookingForm->setData($post);
            if ($bookingForm->isValid()) {
                $bookingFormData                = $bookingForm->getData();
                $productDoctrine                = $this->getProductModel()->get($id);
                $search                         = array();
                $search['results']              = $this->getAccommodationSearchService()->getProductResults($productDoctrine, $bookingFormData['commencing'], $bookingFormData['nights'], $bookingFormData['adults'], $bookingFormData['children']);
                $search['params']               = array();
                $search['params']['commencing'] = $bookingFormData['commencing'];
                $search['params']['nights']     = $bookingFormData['nights'];
                $search['params']['adults']     = $bookingFormData['adults'];
                $search['params']['children']   = $bookingFormData['children'];
                $viewParams['individualSearch'] = $search;
            }
        }

        $product->category = $this->getProductType($product->product_category);
        $area_info         = $this->getDestinationTable()->getDestination($product->product_area_id);
        $region_info       = $this->getDestinationTable()->getDestination($product->product_region_id);

        $product->setArea_info($area_info);
        $product->setRegion_info($region_info);
        //	$product->setMultimedia($this->getMultimediaTable()->getMultimedia($product->product_id)->toArray());
        $product->setMultimedia($this->getMultimediaTable()->getProductPhotos($product->product_id, 'ACCOMM', $product->product_source_id)->toArray());
        $product->setProduct_info($this->getProductInfoTable()->getInfo($product->product_id)->toArray());
        $product->setAttributes($this->getProductAttributesTable()->getAccommodationAttributes($product->product_id)->toArray());
        if ($product->category == 'accommodation') {
            $hotelrooms = $this->getHotelRoomTable()->getRooms($product->product_id);
            $product->setHotel_rooms($hotelrooms->toArray());
        }

        $viewParams['products']    = $product;
        $viewParams['bookingForm'] = $bookingForm;
        return $viewParams;
    }

    public function getProductTable()
    {
        if (!$this->productTable) {
            $this->productTable = $this->getServiceLocator()->get('Travel\Model\ProductTable');
        }

        return $this->productTable;
    }

    public function getDestinationTable()
    {
        if (!$this->destinationTable) {
            $this->destinationTable = $this->getServiceLocator()->get('Travel\Model\DestinationTable');
        }

        return $this->destinationTable;
    }

    public function getHotelRoomTable()
    {
        if (!$this->hotelRoomTable) {
            $this->hotelRoomTable = $this->getServiceLocator()->get('Travel\Model\HotelRoomTable');
        }

        return $this->hotelRoomTable;
    }

    public function getMultimediaTable()
    {
        if (!$this->multimediaTable) {
            $this->multimediaTable = $this->getServiceLocator()->get('Travel\Model\MultimediaTable');
        }

        return $this->multimediaTable;
    }

    public function getProductInfoTable()
    {

        if (!$this->productInfoTable) {
            $this->productInfoTable = $this->getServiceLocator()->get('Travel\Model\productInfoTable');
        }

        return $this->productInfoTable;

    }

    public function getProductAttributesTable()
    {

        if (!$this->productAttributesTable) {
            $this->productAttributesTable = $this->getServiceLocator()->get('Travel\Model\AttributeTable');
        }

        return $this->productAttributesTable;

    }

    public function getMenuItemTable()
    {

        if (!$this->menuItemTable) {
            $this->menuItemTable = $this->getServiceLocator()->get('Travel\Model\MenuItemTable');
        }

        return $this->menuItemTable;

    }

    public function getProductType($producttype)
    {
        switch ($producttype) {
            case 'ACCOMM' :
                $producttype = "accommodation";
                break;
            case 'ATTRACTION' :
                $producttype = "attractions";
                break;
            case 'EVENT' :
                $producttype = "event";
                break;

            default :
                break;
        }
        return $producttype;
    }

    public function getProductAbbrev($producttype)
    {
        switch ($producttype) {
            case 'accommodation' :
                $producttype = "ACCOMM";
                break;
            case 'attractions' :
                $producttype = "ATTRACTION";
                break;
            case 'event' :
                $producttype = "EVENT";
                break;

            default :
                break;
        }
        return $producttype;

    }

    public function getCategoryUrl($producttype)
    {
        switch ($producttype) {
            case 'ACCOMM' :
                $producttype = "accommodation";
                break;
            case 'ATTRACTION' :
                $producttype = "attractions";
                break;
            case 'EVENT' :
                $producttype = "event";
                break;

            default :
                break;
        }
        return $producttype;

    }

    protected function getProductModel()
    {
        if (!$this->productModel) {
            $this->productModel = $this->getServiceLocator()->get('Travel\Model\ProductModel');
        }
        return $this->productModel;
    }

	protected function getAttributeTable()
    {
        if (!$this->attributeTable) {
            $this->attributeTable = $this->getServiceLocator()->get('Travel\Model\AttributeTable');
        }
        return $this->attributeTable;
    }

    protected function getAccommodationSearchService()
    {
        if (!$this->accommodationSearchService) {
            $this->accommodationSearchService = $this->getServiceLocator()->get('Travel\Service\AccommodationSearchService');
        }
        return $this->accommodationSearchService;
    }

    protected function getDestinationModel()
    {
        if (!$this->destinationModel) {
            $this->destinationModel = $this->getServiceLocator()->get('Travel\Model\DestinationModel');
        }
        return $this->destinationModel;
    }
}
