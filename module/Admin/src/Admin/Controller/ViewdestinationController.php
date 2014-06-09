<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use AceLibrary\Controller\AceController;
use CentralDB\Model\RoamfreeDestinationsModel;
use CentralDB\Model\RoamfreeCountriesModel;
use CentralDB\Form\DestinationSearchForm;
use CentralDB\Form\DestinationForm;
use CentralDB\Form\RoamfreeDestinationSearchForm;

class ViewdestinationController extends AceController {

    public $centralDBDestinationModel;
	public $centralDBCountryInfoModel;
	
	public function indexAction() {
		$this->layout()->heading = 'View Destinations';		
		$countries = $this->getCentralDBCountryInfoModel()->getAllCountries();
		
		$defaultCountryId = 16;
		$destinations = $this->getCentralDBDestinationModel()->getDestinations(array('countryId' => $defaultCountryId, 'parentId' => NULL));
		
		return array('countries' => $countries, 'defaultCountryId' => $defaultCountryId, 'destinations' => $destinations);
	}
	
	public function getChildrenAction(){
		$request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost()->toArray();
			$parentId = $post['id'];
			$destinations = $this->getCentralDBDestinationModel()->getDestinations(array('parentId' => $parentId));
			echo json_encode($destinations);
		}
		exit;	
	}
	
	public function viewDestinationAction() {
		$request = $this->getRequest();
        if($request->isPost()) {
        	$post = $request->getPost()->toArray();
			$countryId = $post['countryId'];
			$destinations = $this->getCentralDBDestinationModel()->getDestinations(array('countryId' => $countryId, 'parentId' => NULL));
			$view = new ViewModel(array('destinations' => $destinations));
			$view->setTerminal(true);
			return $view;	
		}
		exit;
	}

	public function getInformationAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
			
			$id = $post['id'];
			
			$result = $this->getCentralDBDestinationModel()->find($id);
			
			$view = new ViewModel(array('result' => $result));
			$view->setTerminal(true);
			return $view;			
        }		
		exit;
	}
	
	public function getCentralDBCountryInfoModel() {
        if(!$this->centralDBCountryInfoModel) {
            $this->centralDBCountryInfoModel = $this->getServiceLocator()->get('CentralDB\Model\CountryInfoModel');
        }
        return $this->centralDBCountryInfoModel;
    }
	
    public function getCentralDBDestinationModel() {
        if(!$this->centralDBDestinationModel) {
            $this->centralDBDestinationModel = $this->getServiceLocator()->get('CentralDB\Model\DestinationModel');
        }
        return $this->centralDBDestinationModel;
    }	
}
