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

class ManualmatchdestinationController extends AceController {

    public $centralDBDestinationModel;
	public $centralDBRoamfreeDestinationsModel;
	public $centralDBRoamfreeCountriesModel;
	
	public function indexAction() {
		$this->layout()->heading = 'Manual Match Destinations';
		
		$destinationSearchForm = new DestinationSearchForm($this->getServiceLocator());
		$roamfreeDestinationSearchForm = new RoamfreeDestinationSearchForm($this->getServiceLocator());
        
        return array(
        	'destinationSearchForm' => $destinationSearchForm,
            'roamfreeDestinationSearchForm'  => $roamfreeDestinationSearchForm,
        );
	}
	
	public function searchRoamfreeDestinationAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
			if(isset($post['page'])) {
				$page = $post['page'];
			} else {
				$page = 1;
			}
			$itemsPerPage = 30;
			
			$result = $this->getCentralDBRoamfreeDestinationsModel()->getList(trim($post['roamfreeName']), trim($post['roamfreeId']), $post['searchOption'], $itemsPerPage, $page);
			
			$view = new ViewModel(array('items' => $result, 'page' => $page));
			$view->setTerminal(true);
			return $view;			
        }
		
		exit;		
	}

	public function searchDestinationAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
			if(isset($post['page'])) {
				$page = $post['page'];
			} else {
				$page = 1;
			}
			$itemsPerPage = 30;
			
			list($result, $pageCount) = $this->getCentralDBDestinationModel()->getList(trim($post['name']), trim($post['id']), $post['searchOption'], $itemsPerPage, $page);
			
			$pageInfo = array();
			$pageInfo['pageCount'] = $pageCount;
			$pageInfo['current'] = $page;
			$pageInfo['previous'] = $page - 1;
			$pageInfo['next'] = $page + 1;
			$pageInfo['first'] = 1;
			$pageInfo['last'] = $pageCount;
			
			if($pageInfo['previous'] <= 0) {
				$pageInfo['previous'] = NULL;
			}
			if($pageInfo['next'] > $pageCount) {
				$pageInfo['next'] = NULL;
			}
			
			$pageInfo['pagesInRange'] = array();
			
			if($pageCount <= 10) {
				for($i=1; $i<=$pageCount;$i++) {
					$pageInfo['pagesInRange'][] = $i;					
				}
			} else if($page < 5) {
				for($i=1; $i<=10;$i++) {
					$pageInfo['pagesInRange'][] = $i;					
				}
			} else if($page >= $pageCount - 5) {
				for($i=$pageCount-9; $i<=$pageCount; $i++) {
					$pageInfo['pagesInRange'][] = $i;					
				}
			} else {
				for($i=$page-4; $i<=$page+5; $i++) {
					$pageInfo['pagesInRange'][] = $i;					
				}
			}

			$view = new ViewModel(array('items' => $result, 'pageInfo' => $pageInfo));
			$view->setTerminal(true);
			return $view;			
        }
		
		exit;		
	}
    
	public function getInformationAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
			
			$type = $post['type'];
			$id = $post['id'];
			
			switch($type) {
				case "roamfree":
					$result = $this->getCentralDBRoamfreeCountriesModel()->findByRoamfreeId($id);
					if($result) {
						$result['roamfreeName'] = $result['roamfreename'];
						$result['roamfreeId'] = $result['roamfreeid'];
						$result['liveHotels'] = $result['livehotels'];
						$result['roamfreeParent'] = NULL;
						$result['destinationId'] = NULL;
					} else {
						$result = $this->getCentralDBRoamfreeDestinationsModel()->findByRoamfreeId($id);
					}
					break;
				case "destination":
					$result = $this->getCentralDBDestinationModel()->find($id);
					break;
				default:
					break;
			}
			
			$view = new ViewModel(array('result' => $result, 'type' => $type));
			$view->setTerminal(true);
			return $view;			
        }		
		exit;
	}
	
	public function manualMatchAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost()->toArray();
			
			$destinationId = $post['destinationId'];
			$roamfreeId = $post['roamfreeId'];
						
			$roamfreeDestination = $this->getCentralDBRoamfreeDestinationsModel()->save(array('roamfreeId' => $roamfreeId, 'destinationId' => $destinationId), array('roamfreeId'));
			//$roamfreeDestination = $this->getCentralDBRoamfreeDestinationsModel()->findByRoamfreeId($id);
			$roamfreeParent = $this->getCentralDBRoamfreeDestinationsModel()->findByRoamfreeId($roamfreeDestination['roamfreeParent']);
			$this->getCentralDBDestinationModel()->saveToDestinationTable(
														array(	'id' 				=> $destinationId, 
																'roamfreeId' 		=> $roamfreeId, 
																'roamfreeParent' 	=> $roamfreeParent['destinationId'],
																'destinationType'	=> $roamfreeDestination['destType'],
																'stateName'			=> $roamfreeDestination['stateName'],
																'stateSource'		=> $roamfreeDestination['stateSource'],
																'regionName'		=> $roamfreeDestination['regionName'],
																'regionSource'		=> $roamfreeDestination['regionSource'],																
																'areaName'			=> $roamfreeDestination['areaName'],
																'areaSource'		=> $roamfreeDestination['areaSource']
															),
														array('id'));			
		}
		exit;
	}
	
	public function addDestinationAction() {
		$this->layout()->heading = 'Add Destination';
		
		$destinationForm = new DestinationForm($this->getServiceLocator());
		$request = $this->getRequest();
		if ($request->isPost()) {
            $post = $request->getPost();
            $destinationForm->setData($post);
            if($destinationForm->isValid()) {
            	$data = $destinationForm->getData();
				if($data['parentId'] == 0) {
					$data['parentId'] = NULL;
				}
				if($data['parentId']) {
					if($parentDestination = $this->getCentralDBDestinationModel()->find($data['parentId'])) {
						$id = $this->getCentralDBDestinationModel()->saveToDestinationTable(array('name' => $data['name'], 'parentId' => $data['parentId'], 'originalSource' => 'manual', 'countryId' => 16));
						$childDestinationIds = $parentDestination['children'];
						if($childDestinationIds) {
							$array = unserialize($childDestinationIds);
						} else {
							$array = array();
						}
						$array[] = $id;
						$parentDestination['children'] = serialize($array);
						$array = unserialize($parentDestination['children']);
						$this->getCentralDBDestinationModel()->saveToDestinationTable($parentDestination, array('id'));
						
						return $this->redirect()->toRoute('zfcadmin/centraldb/manualmatchdestination');	
					} else {
						$destinationForm->get('parentId')->setMessages(array('Parent id does not exist.'));
					}
				} else {
					$this->getCentralDBDestinationModel()->saveToDestinationTable(array('name' => $data['name'], 'parentId' => $data['parentId'], 'originalSource' => 'manual', 'countryId' => 16));
					return $this->redirect()->toRoute('zfcadmin/centraldb/manualmatchdestination');
				}
            }			
		}
				
        return array(
        	'destinationForm' => $destinationForm,            
        );
	}
	
    public function getCentralDBDestinationModel() {
        if(!$this->centralDBDestinationModel) {
            $this->centralDBDestinationModel = $this->getServiceLocator()->get('CentralDB\Model\DestinationModel');
        }
        return $this->centralDBDestinationModel;
    } 
	
	public function getCentralDBRoamfreeDestinationsModel() {
        if(!$this->centralDBRoamfreeDestinationsModel) {
            $this->centralDBRoamfreeDestinationsModel = $this->getServiceLocator()->get('CentralDB\Model\RoamfreeDestinationsModel');
        }
        return $this->centralDBRoamfreeDestinationsModel;
	}
	
	public function getCentralDBRoamfreeCountriesModel() {
        if(!$this->centralDBRoamfreeCountriesModel) {
            $this->centralDBRoamfreeCountriesModel = $this->getServiceLocator()->get('CentralDB\Model\RoamfreeCountriesModel');
        }
        return $this->centralDBRoamfreeCountriesModel;
    }
}
