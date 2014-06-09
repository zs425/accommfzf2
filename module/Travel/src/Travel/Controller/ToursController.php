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
use Zend\Paginator\Adapter\ArrayAdapter as arrayAdapter;
use Travel\Form\ToursCategoryForm;
use Travel\Form\ToursBookingForm;
use Travel\View\Helper\AtdwClassifications;
use Travel\View\Helper\GetCategory;
use Travel\Form\ToursSearchForm;

/**
 * Class ToursController
 * @author Kirill Morozov
 * @package Travel\Controller
 * @property \AceLibrary\Service\ViatorService          $viatorService
 */
class ToursController extends AbstractActionController
{
    public $page;
    private $itemsPerPage = 10;
    private $pageRange = 5;
    protected $viatorService;
	
    public function indexAction(){
        
        ini_set('max_execution_time', 30000);
        $this->page = $this->params()->fromRoute('page', 1);
        $viaService = $this->getViatorService();
        
        $cfg = $this->getServiceLocator()->get('config');
        $fname = ROOT_PATH . $cfg['config_path'];
                
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
		
        $categories = $viaService->getCategories($destId);
		
		$cats = $viaService->getCategoriesFromResult($categories, $productsResult);
        
        //$cats = $viaService->removeEmptyCategories($categories->data, $destId);
        
        $paginator = new Paginator(new arrayAdapter($productsResult));
        $paginator->setCurrentPageNumber($this->page)
                  ->setItemCountPerPage($this->itemsPerPage)
                  ->setPageRange($this->pageRange);
        
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $viewRenderer = $this->getServiceLocator()->get('viewrenderer');
            $viewHtml = $viewRenderer->partialLoop('layout/viatorproduct-list', $paginator);
        
            $result = array(
                "success" => true,
                "HTML" => $viewHtml,
            );
            $this->response->setContent(\Zend\Json\Json::encode($result));        
            return $this->response;
        }
        
        return array(
            'products' => $paginator,
            'title' => "Tours",
            'categories' => $cats,
            'category' => '',
            'uri' => '/tours',
            'rootCat' => ''
        );
                  
        /*return array(
            'searchForm' => $searchForm,
            'categoryForm' => $categoryForm,
            'products' => $paginator,
            'title' => "Tours",
            'categories' => $categories->data,
            'area' => $destId,
            'keyword' => $keyword,
            'category' => '',
            'uri' => '/tours',
            'rootCat' => ''
        );*/
    }
    
    public function categoryAction(){
        
        ini_set('max_execution_time', 30000);
        $category = $this->params()->fromRoute('id');
        $rootCat = "";
        $subCat = "";
        if (strpos($category, '_') !== FALSE)
        {
            list($rootCat, $subCat) = split('_', $category);
        }else{
            $rootCat = $category;
        }
        
        $this->page = $this->params()->fromRoute('page', 1);
        $viaService = $this->getViatorService();
        
        $cfg = $this->getServiceLocator()->get('config');
        $fname = ROOT_PATH . $cfg['config_path'];
                
        $reader = new \Zend\Config\Reader\Ini();
        $data   = $reader->fromFile($fname);
        
        $destId = $data['providers']['viator']['id'];
		$keyword = $data['providers']['viator']['keyword'];
        
        $categories = $viaService->getCategories($destId);
         
		 
		//Get all desitnation products for get Categories
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
		
		$cats = $viaService->getCategoriesFromResult($categories, $productsResult);
        
		// Get all products for destination and selected category
        if ($keyword == ""){
        	$searchResult = $viaService->getProductsByDestination($destId, $rootCat, $subCat);
        	$productsResult = $searchResult->data;
        }else{
			//Remove products not in selected category
        	foreach($productsResult as $key=>$product){
	            $inx = array_search($rootCat, $product->catIds);
	            if ($inx === FALSE){    
	                unset($productsResult[$key]);
	            }else{
	                if ($subCat != ""){
	                    if (isset($product->subCatIds)){
	                        $subCats = $product->subCatIds;
	                        if ($subCat != $subCats[$inx]){
	                            unset($productsResult[$key]);
	                        }
	                    }
	                    else{
	                        unset($productsResult[$key]);
	                    }
	                }
	            }
	        }
        }
        
        /**/
                
        $paginator = new Paginator(new arrayAdapter($productsResult));
        $paginator->setCurrentPageNumber($this->page)
                  ->setItemCountPerPage($this->itemsPerPage)
                  ->setPageRange($this->pageRange);
        
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            
            $viewRenderer = $this->getServiceLocator()->get('viewrenderer');
            $viewHtml = $viewRenderer->partialLoop('layout/viatorproduct-list', $paginator);
        
            $result = array( 
                "success" => true, 
                "HTML" => $viewHtml,
            );
            $this->response->setContent(\Zend\Json\Json::encode($result));        
            return $this->response;
        }
        
        $view = new ViewModel();
        $view->setTemplate('travel/tours/index');
        $view->setVariables(
            array(
                'products' => $paginator,
                'title' => "Tours",
                'categories' => $cats,
                'category' => '',
                'uri' => '/tours/category/'.$category,
                'rootCat' => $rootCat,
                'subCat' => $subCat
        ));
                  
        return $view;
    } 
    
    public function viewviatorAction(){ 
        
        ini_set('max_execution_time', 30000);
        $productId = $this->params()->fromRoute("id");
        $viaService = $this->getViatorService();
        
        $productDetail = $viaService->getProductDetails($productId);
        $productPhotos = $viaService->getProductPhotos($productId);
        $austDest = $viaService->getAustralianDestinations();
        foreach ($austDest as $dest){
            if ($dest->destinationId == $productDetail->data->destinationId){
                $productDest = $dest;
            }
        }
        
        if ($this->request->isPost())
        {
            $values = $this->request->getPost()->toArray();
            $toursForm = new ToursBookingForm($this->getServiceLocator(), $productId, $values["commenceMonth"]);
            $toursForm->setData($values);
            $toursForm->get("submit-bookingForm")->setValue('Update option');
            $ageBands = array();
            
            foreach ($values["ageBand"] as $key=>$bandCnt){
                if ($bandCnt != "0")
                    $ageBands[] = array("bandId"=>$key, "count"=>$bandCnt);
                
                $toursForm->get("ageBand[".$key."]")->setValue($bandCnt);
            }

            /*if ($values["adults"] != "0")
                $ageBands[] = array("bandId"=>"1", "count"=>$values["adults"]);
            
            if ($values["children"] != "0")
                $ageBands[] = array("bandId"=>"0", "count"=>$values["children"]);*/
            
            $tourGrades = $viaService->getTourgrades($productId, $values["commenceDate"], $ageBands);
			
            if ($tourGrades){
                $view = new ViewModel();
                $view->setTemplate('travel/tours/tourgrades');
                $view->setVariables(
                    array(
                        "tourgrades" => $tourGrades->data,
                        "toursForm" => $toursForm,
                        "product" => $productDetail->data,
                        "destination" => $productDest
                ));
                          
                return $view; 
            }
        }else{
            $toursForm = new ToursBookingForm($this->getServiceLocator(), $productId);
        }
        
        return array(
            "product" => $productDetail->data,
            "productPhotos" => $productPhotos->data,
            "destination" => $productDest,
            "toursForm" => $toursForm
        );
        
    }

	public function tourcalendarAction(){
        ini_set('max_execution_time', 30000);
		$productId = $this->params()->fromRoute("id");
        $viaService = $this->getViatorService();
		$tourid = $this->params()->fromQuery('tourid');
		$listdate = $this->params()->fromQuery('listdate');
		list($year, $month, $day) = explode("-", $listdate);
		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		$ageBand[] = array("bandId"=>"1", "count"=>"1");
		
		$tourDesc = "";
		$tourPrice = "";
		$tourTitle = "";
		
		$productDetail = $viaService->getProductDetails($productId);
		foreach ($productDetail->data->tourGrades as $tour) {
			if ($tour->gradeCode == $tourid){
				$tourDesc = $tour->gradeDescription;
				$tourPrice = $tour->priceFromFormatted;
				$tourTitle = $tour->gradeTitle;
			}
		}
		
		$austDest = $viaService->getAustralianDestinations();
        foreach ($austDest as $dest){
            if ($dest->destinationId == $productDetail->data->destinationId){
                $productDest = $dest;
            }
        }
		
		$tours = array();
		for ($i= 1; $i <= $days; $i++){
			$checkDate = date("Y-m-d", mktime(0,0,0, $month, $i, $year));
			$tourGrades = $viaService->getTourgrades($productId, $checkDate, $ageBand);
			if ($tourGrades){
				foreach($tourGrades->data as $tour){
					if ($tour->gradeCode == $tourid)
					{
						if ($tour->available){ 
							$tours[$checkDate] = $tour;
						}else {
							$tours[$checkDate] = null;
						}
						break;
					}
				}
			}else{
				$tours[$checkDate] = null;
			}
		}

		return array(
			"tours" => $tours,
			"tourDescription" => $tourDesc,
			"tourPrice" => $tourPrice,
			"tourTitle" => $tourTitle,
			"tourId" => $tourid,
			"product" => $productDetail->data,
			"destination" => $productDest,
			"selectedYear" => $year,
			"selectedMonth" => $month
		); 
	}
    
    // Ajax function for get available dates of month
    public function getDatesAction(){
        $values = $this->request->getPost()->toArray();
        $viaService = $this->getViatorService();
        $result = $viaService->getAvailabilityDates($values["productId"]);
        $availableDates = $result->data;
        $currMonth = $values["month"];
        
        $html = "";
        foreach ($availableDates->$currMonth as $date){
            $html = $html."<option value='".$currMonth."-".$date."'>".$date."</option>";
        }
        echo $html;
        exit;
    }
    
    protected function getViatorService()
    {
        if (!$this->viatorService) {
            $this->viatorService = $this->getServiceLocator()->get('AceLibrary\Service\ViatorService');
        }
        return $this->viatorService;
    }
}
