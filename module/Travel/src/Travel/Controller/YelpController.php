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
use Travel\Form\YelpSearchForm;

/**
 * Class ToursController
 * @author Kirill Morozov
 * @package Travel\Controller
 * @property \AceLibrary\Service\YelpService          $yelpService
 */
class YelpController extends AbstractActionController
{
    public $page;
    private $itemsPerPage = 10;
    private $pageRange = 5;
    protected $yelpService;
	
    public function indexAction(){
        
        ini_set('max_execution_time', 30000);
        $this->page = $this->params()->fromRoute('page', 1); 
        $yelpService = $this->getYelpService();
        
        $form = new YelpSearchForm($this->getServiceLocator());
		
		$cfg = $this->getServiceLocator()->get('config');
        $fname = ROOT_PATH . $cfg['config_path'];
                
        $reader = new \Zend\Config\Reader\Ini(); 
        $data   = $reader->fromFile($fname);
		
		$location = isset($data['providers']['yelp'])?$data['providers']['yelp']['id']:"Adelaide";
		
		$term = "yelp"; 
		
		if ($this->request->isPost())
        {
        	$values = $this->request->getPost()->toArray();
			$form->setData($values);
			if (isset($values["location"]) && $values["location"] != ""){
				$location = $values["location"];
			} 
			if (isset($values["term"]) && $values["term"]!=""){
				$term = $values["term"];
			}
		}
        
		$param = array("term"=>$term, "location"=>$location);
        $searchResult = $yelpService->searchYelp($param);
		
        $paginator = new Paginator(new arrayAdapter($searchResult->businesses));
        $paginator->setCurrentPageNumber($this->page)
                  ->setItemCountPerPage($this->itemsPerPage)
                  ->setPageRange($this->pageRange);
		  
        return array(
            'result' => $paginator,
            'term' => $term,
            'location' => $location,
            'form' => $form,
            'region' => $searchResult->region->center
        );
                  
    }

	public function viewbizAction(){
		$bizId = $this->params()->fromRoute("id");
		$yelpService = $this->getYelpService();
		$result = $yelpService->getYelpBusiness($bizId);
		
		return array(
			'result' => $result
		);
	}
    
    protected function getYelpService()
    {
        if (!$this->yelpService) {
            $this->yelpService = $this->getServiceLocator()->get('AceLibrary\Service\YelpService');
        }
        return $this->yelpService;
    }
}
