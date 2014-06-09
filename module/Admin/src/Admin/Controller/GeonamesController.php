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
use CentralDB\Model\QueueModel;
use CentralDB\Model\QueueProgressModel;
use CentralDB\Model\AmadeusCitiesModel;
use CentralDB\Model\CountryInfoModel;
use CentralDB\Model\OptionModel as CentralDBOptionModel;
use CentralDB\Model\RoamfreeCountriesModel;
use CentralDB\Model\RoamfreeDestinationsModel;

use AceLibrary\Service\GeonamesService;
use AceLibrary\Service\YahooGeoPlanetService;
use AceLibrary\Service\HttpRestJsonClientService;
use AceLibrary\Service\RoamfreeService;

use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

class GeonamesController extends AceController {

    public $centralDBQueueModel;
    public $centralDBQueueProgressModel;
    public $centralDBOptionModel;
    public $centralDBDestinationModel;
	public $centralDBAmadeusCitiesModel;
	public $centralDBCountryInfoModel;
	public $centralDBRoamfreeCountriesModel;
	public $centralDBRoamfreeDestinationsModel ;
	
    //public $httpRestJsonClient;
    public $geonamesService;
	public $yahooGeoPlanetService;
	public $roamfreeService;
	
    public $queue_name;
    public $child_queue_name;
    public $current_task;
    public $queue_progress;
	public $countryId;
	
	static $HIERARCHY = array(
        "1" => 'COUNTRY',
        "2" => 'STATE',
        "3" => 'REGION',
        "4" => 'AREA',
        "5" => 'CITY',
        "6" => 'DISTRICT'
    );
    
    public function __construct(ServiceLocator $serviceLocator) {
        $this->queue_name = 'destinationtask';
        $this->child_queue_name = 'childdestionations';
		$this->countryId = 16; //Australia
        
        $this->current_task = $serviceLocator->get('CentralDB\Model\OptionModel')->get('destinationtask', 'current_task');
        $this->queue_progress = $serviceLocator->get('CentralDB\Model\QueueProgressModel')->getByQueueName($this->queue_name);                
    }
    
    public function importAction()
    {
    	if (!$this->queue_progress){
            $this->getCentralDBQueueProgressModel()->setQueueProgress($this->queue_name, 'running');
            $this->getCentralDBQueueModel()->setTask('1,2077456,', $this->queue_name);
            $message = "Australia Added.";
        } else {
            $message = $this->queue_progress['status'];
        } 
		return array(
            'message' => $message,
        );       
    }
	
	public function listDestinationsAction()
	{
		var_dump('1234');
		exit;
	}
    
    public function processAction()
    {
    	$taskgroup = $this->getTaskGroup();
        
        switch ($taskgroup)
        {
            case "getStructure":
                $view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getHierarchy'));
				break;
            case "getParents":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getParents'));
				break;
            case "getChildren":
                $view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getChildren'));
				break;
            case "getInformation":
                $view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getInformation'));                
                break;
			case "getIATACodes":
                $view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getIATACodes'));
                break;
			case "geoplanetCountries":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getGeoplanetCountries'));
                break;
			case "setupGeoplanet":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'setupGeoplanet'));                
                break;
			case "matchGeoplanet":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'matchGeoplanet'));
                break;
			case "getRoamfreeCountries":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getRoamfreeCountries'));
                break;
			case "getRoamfreeStates":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getRoamfreeStates'));
                break;
			case "getRoamfreeChildren":
				$view = $this->forward()->dispatch('Admin\Controller\Geonames', array('action' => 'getRoamfreeChildren'));
                break;
            case "complete":
				echo '<div class="col-sm-12"><p class="alert alert-success">All Tasks Completed.</p></div>';
				exit;
        }   
		
		$view->setTerminal(true);		
		return $view;                 
    }

	public function getRoamfreeChildrenAction()
    {
    	$message = "getting Roamfree Children.<br/>";
		$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getRoamfreeChildren');
		if($progress) {
			if($progress['status'] == 'complete'){
				$this->setTaskGroup();
			} else {
		    	$task = $this->getCentralDBQueueModel()->getTask('getRoamfreeChildren');
				if ($task) {
			        $taskDetails = unserialize($task['message']);
			        $roamFreeParent_id = $taskDetails['roamfreeId'];
					
					$message .= "--- " . $taskDetails['name'] . " ---<br/>"; 
			        $rf = $this->getRoamfreeService()->getLocalities($roamFreeParent_id); // get children locations of the parent

			        if(isset($rf->Locality)){
				        if(isset($rf->Locality->Level)) {
				        	$area = $rf->Locality;
				        	$message .= $this->getRoamfreeChildren($area, $task['message']); 
				        } else {
				        	foreach ($rf->Locality as $area) {
								$message .= $this->getRoamfreeChildren($area, $task['message']);				            
							}
				        }
					}
					$this->getCentralDBQueueModel()->deleteQueue($task['id']);
		        } else {
		        	$progress['status'] = 'complete';
					$this->getCentralDBQueueProgressModel()->save($progress);
		        }
			}
		} else {
			$this->getCentralDBQueueProgressModel()->setQueueProgress('getRoamfreeChildren', 'running', 0, '0');
		}
		return array('message' => $message);
    }

	public function getRoamfreeStatesAction()
    {
    	$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getRoamfreeStates');
		if($progress) {
			if($progress['status'] == 'complete') {
				$this->setTaskGroup();
			} else {
				$roamfree_parent_id = '405';
		        $states = $this->getRoamfreeService()->GetLocalities($roamfree_parent_id); 
                
				$message = "";
		        foreach ($states->Locality as $state) {
		            $message .= $state->Name . "<br/>";
		            
		            //match destination
		            $destinations = $this->getCentralDBDestinationModel()->matchLocation(array('name' => $state->Name));
		            // put info of roamfree id's into database.
		            $id = null;
					
		            if($destinations) {
		            	$destination = $destinations[0];
		            	$destination['roamfreeId'] = $state->LocalityId;
						//$destination['roamfreeParent'] = '405';
						$destination['destinationType'] = self::$HIERARCHY[$state->Level];
						$destination['roamfreeParent'] = '';
						$this->getCentralDBDestinationModel()->saveToDestinationTable($destination, 'id');
						$id = $destination['id'];
					}
		            $rfData = array('roamfreeName' => $state->Name, 
		            				'roamfreeId' => $state->LocalityId,
		            				'liveHotels' => $state->LiveHotels,
		            				'level' => $state->Level,
		            				'destType' => self::$HIERARCHY[$state->Level],
		            				'roamfreeParent' => $roamfree_parent_id,
		            				'destinationId' => $id
									);
		            $this->getCentralDBRoamfreeDestinationsModel()->save($rfData, array('roamfreeId'));
					
		            // set tasks for getChildren for each of the states.
		            $this->getCentralDBQueueModel()->setTask(
		            						serialize(
		            							array(
		            								'roamfreeId' 	=> $state->LocalityId, 
		            								'id' 			=> $id,
		            								'parent_id' 	=> null,
		            								'name' 			=> null,
		            								'abbr' 			=> $state->Name,
		            								'hierarchy'		=> array('AU', $state->Name),
												)
											), 
											'getRoamfreeChildren'
										);
					
		        }
				$this->getCentralDBQueueProgressModel()->setQueueProgress('getRoamfreeStates', 'complete', 0, '0');
			}
		} else {
			$this->getCentralDBQueueProgressModel()->setQueueProgress('getRoamfreeStates', 'running', 0, '0');
		}
		return array('message' => 'getting Roamfree States.');
    }

	public function getRoamfreeCountriesAction()
    {
    	$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getRoamfreeCountries');
		if($progress) {
			if($progress['status'] == 'complete'){
				$this->setTaskGroup();
			} else {
		        $countries = $this->getRoamfreeService()->getCountries();
		        foreach ($countries as $country) {
		            $array = array(
		                'isocode' => $country->IsoCode,
		                'livehotels' => $country->LiveHotels,
		                'roamfreeid' => $country->LocalityId,
		                'roamfreename' => $country->Name);
		            $save = $this->getCentralDBRoamfreeCountriesModel()->save($array, array('isocode', 'roamfreeid'));
					
		            $countryInfo = $this->getCentralDBCountryInfoModel()->findByIsoCode($country->IsoCode);
		            if($countryInfo) {
		            	$countryInfo['roamfreeid'] = $country->LocalityId;
						$this->getCentralDBCountryInfoModel()->save($countryInfo);
		            }
		        }
				$this->getCentralDBQueueProgressModel()->setQueueProgress('getRoamfreeCountries', 'complete', 0, '0');
			}
		} else {
			$this->getCentralDBQueueProgressModel()->setQueueProgress('getRoamfreeCountries', 'running', 0, '0');
		}
		return array('message' => 'getting Roamfree countries.');
    }
	
	public function matchGeoplanetAction()
    {
    	$message = "";
		$count = 0;
		$progresscount = 0;
        $inc = 10;
        $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('matchGeoplanet');
        $records = $this->getCentralDBQueueModel()->getByQueueName('matchGeoplanet', $inc);
		
		if($progress) {
			if($progress['status'] == 'complete'){
				$this->setTaskGroup();
			} else {
				if($records) {
					foreach ($records as $r) {
			            $d = $this->getCentralDBDestinationModel()->find($r['message']);
                        $message .= "finding {$d['geonamesId']}<br>";
			            $gp = $this->getYahooGeoPlanetService()->findByGeonamesId($d['geonamesId']);
			            if (isset($gp->query->results->concordance->woeid)) {
			                $d['woeId'] = $gp->query->results->concordance->woeid;
			            }
			            if (isset($gp->query->results->concordance->wiki)) {
			                $d['wikiId'] = $gp->query->results->concordance->wiki;
			            }
			            if (isset($gp->query->results->concordance->osm)) {
			                $d['osmId'] = $gp->query->results->concordance->osm;
			            }
			            if (isset($gp->query->results->concordance->locode)) {
			                $d['locode'] = $gp->query->results->concordance->locode;
			            }
			            if (isset($gp->query->results->concordance->iso)) {
			                $d['iso'] = $gp->query->results->concordance->iso;
			            }
						
						$this->getCentralDBDestinationModel()->saveToDestinationTable($d, array('id'));
			            $this->getCentralDBQueueModel()->deleteQueue($r['id']);            
			        }
			        $count = $progress['total'];
			        $progress['progress'] = $progress['progress'] + $inc;			
                    $progresscount = $progress['progress'];
					$this->getCentralDBQueueProgressModel()->save($progress);
				} else {
					$progress['status'] = 'complete';
					$this->getCentralDBQueueProgressModel()->save($progress);
				}
			}
		} else {
			$this->setTaskGroup();
		}		
		
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );

    }

	public function getGeoplanetCountriesAction()
    {
    	$message = "";
		
		$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('geoplanetCountries');
		if ($progress) {
			if($progress['status'] == "complete") {
				$this->setTaskGroup();
			} else {
		    	$results = $this->getYahooGeoPlanetService()->getCountries();
		        foreach($results->places->place as $country) {
		            $message .= $country->name . "<br>";
		            $matchCountry = $this->getCentralDBCountryInfoModel()->getByName($country->name);
		            if ($matchCountry) {
		                $woe = $this->getYahooGeoPlanetService()->findByWoeId($country->woeid);
		                //var_dump($woe);
		                $matchCountry['geoplanetid'] = $country->woeid;
		                if (isset($woe->query->results->concordance->geonames)) {
		                	$matchCountry['geonamesid'] = $woe->query->results->concordance->geonames;
						}
						$this->getCentralDBCountryInfoModel()->save($matchCountry);
		            } else {
		            	$message .= "NOT FOUND";
					}
		        }
				$progress['status'] = "complete";
				$this->getCentralDBQueueProgressModel()->save($progress);
			}
		} else {
            $this->getCentralDBQueueProgressModel()->setQueueProgress('geoplanetCountries', 'running', 0, '0');
        }
		
		return array('message' => $message);
    }

	public function setupGeoplanetAction()
    {
    	$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('setupGeoplanet');
		
		if ($progress) {
			if($progress['status'] == "complete") {
				$this->setTaskGroup();
			} else {
		        $destinations = $this->getCentralDBDestinationModel()->getAllDestinations();
		        foreach ($destinations as $d) {
					$this->getCentralDBQueueModel()->setTask($d['id'], 'matchGeoplanet');
		        }
				$this->getCentralDBQueueProgressModel()->setQueueProgress('setupGeoplanet', 'complete', null, 0);	
		        $this->getCentralDBQueueProgressModel()->setQueueProgress('matchGeoplanet', 'running', count($destinations), '0');
			}
		} else {
            $this->getCentralDBQueueProgressModel()->setQueueProgress('setupGeoplanet', 'running', null, 0);
        }
        return array('message' => 'Running match geoplanet.');
    }
    
	public function getIataCodesAction()
    {
        $increment = 3;
        $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getIATACodes');
		$progresscount = 0;
		$count = 0;
		$message = "";
        if ($progress) {
			$progress['progress'] = (is_null($progress['progress']))?0:$progress['progress']; 
            $progresscount = $progress['progress'];
            $count = $progress['total'];
			if ($this->queue_progress['status'] == 'complete') {
                $this->setTaskGroup();
            } else if ($progress['progress'] <= $count) {
				$cities = $this->getCentralDBAmadeusCitiesModel()->getCitiesByCountry('AU', $progress['progress'], $increment);
            	
            	foreach ($cities as $city) {
                	$matchedcity = $this->getIATA($city['cityCode']);
                
                	if (is_array($matchedcity)) {
						$destination = $this->getCentralDBDestinationModel()->getDestinationByGeonamesId($matchedcity['geonameId']);
						if ($destination){
							$destination['iataCode'] = $matchedcity['name'];
                    		$this->getCentralDBDestinationModel()->saveToDestinationTable($destination, array('id'));
						} else {
                    		$this->getCentralDBQueueModel()->setTask($city['cityCode'], 'notInDbIata');
						}
                    	$message .= "Matched {$city['cityCode']} with {$destination['name']}<br>";
                	} else {
                    	$message .= "no matches for " . $city['cityCode'] . "<br>";
                    	$this->getCentralDBQueueModel()->setTask($city['cityCode'], 'unmatchedIata');
                	}
            	}
            	$this->getCentralDBQueueProgressModel()->setQueueProgress('getIATACodes', 'running', $count, $progress['progress'] + $increment);
            } else {
            	$progress['status'] = "complete";
            	$this->getCentralDBQueueProgressModel()->save($progress);
            }
        } else {
            $count = count($this->getCentralDBAmadeusCitiesModel()->getCitiesByCountry('AU', 'all'));
            $this->getCentralDBQueueProgressModel()->setQueueProgress('getIATACodes', 'running', $count, 0);
        }
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
    }
    
    public function getHierarchyAction()
    {
    	$message = "";
		$count = 0;
        $task = $this->getCentralDBQueueModel()->getTask('destinationtask');
        
        if ($this->queue_progress['status'] == 'complete') {
            $this->setTaskGroup();
        } elseif (!$task && ($this->queue_progress['status'] == 'running')) {
            $this->queue_progress['status'] = 'complete';
            $this->getCentralDBQueueProgressModel()->save($this->queue_progress);          
            
        } elseif ($task && ($this->queue_progress['status'] == 'running')) {
            $taskdetails = explode(',', $task['message']);
            $complete_task = $this->getChildren($taskdetails[0], $taskdetails[1], $taskdetails[2]);
            $destination = $this->getCentralDBDestinationModel()->getDestinationByGeonamesId($taskdetails[1]);
            
            if (is_array($complete_task)) {
                $this->getCentralDBQueueModel()->deleteQueue($task['id']);
                
                $message .= 'Created ' . count($complete_task) . ' child elements for ' . $destination['name'] . '(' . $taskdetails[1] . ')(tier ' . $taskdetails[0] . ')';
                $message .= "<br>Deleting " . $taskdetails[1] . " From Queue";
                
            } else {
                $this->getCentralDBQueueModel()->deleteQueue($task['id']);
                $message .= 'No Child elements for ' . $destination['name'] . '(' . $taskdetails[1] . ')(tier ' . $taskdetails[0] . ')';
                $message .= "<br>Deleting " . $taskdetails[1] . " From Queue";                
            }
            $fullqueue = $this->getCentralDBQueueModel()->getAllByQueueName($this->queue_name);
            $count = $this->queue_progress['total'] = count($fullqueue);
            $this->getCentralDBQueueProgressModel()->save($this->queue_progress);
			  
        }   	
		return array(
	            'message' => $message,
	            'count' => $count,
	        );
    }

	public function getParentsAction()
    {
    	$message = "";
		$count = 0;
    	$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getParents');
        if (!$progress){
            $progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getParents','setTasks');
            $message .= "setting tasks";
		} else{
			switch ($progress['status']) {
	            case 'setTasks':
	                $geonames = $this->getCentralDBDestinationModel()->getNoParent();
					foreach($geonames as $g)
					{
						$this->getCentralDBQueueModel()->setTask($g['id'],'getParents');
						$this->getCentralDBDestinationModel()->setParentId($g['id']);
					}

	                $progress['status'] = 'complete';
	                $this->getCentralDBQueueProgressModel()->save($progress);
	               	break;
	
	            case 'complete':
	                $this->setTaskGroup();
	                break;	
			}		
		}
       	$message .= " status : " . $progress['status'];
		return array(
	            'message' => $message,
	            'count' => $count,
	        );
    }
    
	public function getChildrenAction()
	{
		$message = "";
		$count = 0;
		$progresscount = 0;
		
		$progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getChildren');

		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getChildren','setTasks');
		} else {
			switch ($progress['status']) {
				case 'setTasks':
					$geonames = $this->getCentralDBDestinationModel()->getRecordsWithChildren();
					if (count($geonames)>0) {
						foreach($geonames as $g) {
							$this->getCentralDBQueueModel()->setTask($g['id'], 'getChildren');
						}
						$message = "set " . count($geonames) . " tasks";
					} else {
						$message = "No children to process";
					}
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getChildren','running', count($geonames),'0');
					break;
				
				case 'running':
					$task = $this->getCentralDBQueueModel()->getTask('getChildren');
					if ($task) {
						$childids = $this->getCentralDBDestinationModel()->getChildIds($task['message']);
						$this->getCentralDBDestinationModel()->saveToDestinationTable(array('children' => $childids, 'id' =>$task['message']), array('id'));
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getChildren','running', NULL,$progress['progress']+1);
						$this->getCentralDBQueueModel()->deleteQueue($task['id']);
						$count = $progress['total'];
						$progresscount = $progress['progress']+1;
					} else {
						$progress['status'] = 'complete';
						$this->getCentralDBQueueProgressModel()->save($progress);
					}
					break;

				case 'complete':
					$this->setTaskGroup();
					break;
			}
		}
        return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}

	public function getInformationAction()
	{
    	$message = "";
		$count = 0;
		$progresscount = 0;
		
	    $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getInformation');
	
		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getInformation', 'setTasks');
		} else {
			switch ($progress['status']) {
				case 'setTasks':
					$geonames = $this->getCentralDBDestinationModel()->getAllDestinations();
					if (count($geonames)>0) {
	    				foreach($geonames as $g) {
	        				$this->getCentralDBQueueModel()->setTask(serialize(array('id'=>$g['id'], 'geonamesid'=>$g['geonamesId'])), 'getInformation');
						}
						$message = "set " . count($geonames) . " tasks";
	    				$count = count($geonames);
	    				$progresscount = "progresscount: 0";
	    			} else {
	    				$message = "No information to process";
					}
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getInformation','running', count($geonames),'0');
					break;
				case 'running':
					$task = $this->getCentralDBQueueModel()->getTask('getInformation');
					if ($task) {
						$message = unserialize($task['message']);
						//$geonamesService = new GeonamesService($this->getServiceLocator()->get('AceLibrary\Service\HttpRestJsonClientService'));						
						//$area = $geonamesService->get(array('username' => 'aceweb', 'geonameId' => $message['geonamesid']));
						$area = $this->getGeonamesService()->get(array('username' => 'aceweb', 'geonameId' => $message['geonamesid']));
						
						$data = array();
						$data['id'] = $message['id'];
						if ($area['alternateNames']) {
							$data['alternateNames'] = serialize($area['alternateNames']);
						}
						if ($area['adminName1']) {
							$data['geonamesAdminname1'] = $area['adminName1'];
						}
						if ($area['adminName2']) {
							$data['geonamesAdminname2']= $area['adminName2'];
						}
						if ($area['adminName3']) {
							$data['geonamesAdminname3']= $area['adminName3'];
						}
						if ($area['adminName4']) {
							$data['geonamesAdminname4']= $area['adminName4'];
						}
						if ($area['adminName5']) {
							$data['geonamesAdminname5']= $area['adminName5'];
						}
						if ($area['bbox']) {
							$data['geonamesBbox'] = serialize($area['bbox']);
						}
						if ($area['fcode']) {
							$data['geonamesFcode'] = serialize($area['fcode']);
						}
						if ($area['population']) {
							$data['geonamesPopulation'] = serialize($area['population']);
						}
						if ($area['fclName']) {
							$data['geonamesFclname'] = serialize($area['fclName']);
						}
						if ($area['srtm3']) {
							$data['geonamesSrtm3'] = serialize($area['srtm3']);
						}
						if ($area['fcl']) {
							$data['geonamesFcl'] = serialize($area['fcl']);
						}
						if (isset($area['wikipediaURL'])) {
							$data['wikipediaUrl'] = serialize($area['wikipediaURL']);
						}
	
						$this->getCentralDBDestinationModel()->saveToDestinationTable($data, array('id'));
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getInformation','running', NULL,$progress['progress']+1);
						
						$this->getCentralDBQueueModel()->deleteQueue($task['id']);
						
						$count = $progress['total'];
						$progresscount = $progress['progress']+1;
					} else {
						$progress['status'] = 'complete';
						$this->getCentralDBQueueProgressModel()->save($progress);
					}
					break;
	
				case 'complete':
					$this->setTaskGroup();
					break;
			}
			$message = 'message: Getting Location Information';
	    }
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}
	
    public function getTaskGroup()
    {
        $taskgroup = $this->getCentralDBOptionModel()->get('destinationtask', 'current_task');
        
        if (!$taskgroup)
            $taskgroup = $this->setTaskGroup();
		
		return $taskgroup;
    }
    
    public function setTaskGroup()
    {
        $taskgroup = $this->getCentralDBOptionModel()->get('destinationtask', 'current_task');
        switch ($taskgroup)
        {
            case 'getStructure':
				$this->getCentralDBOptionModel()->save('destinationtask', 'getParents', 'current_task');
                $taskgroup = 'getParents';
                break;
            case 'getParents':
                $this->getCentralDBOptionModel()->save('destinationtask', 'getChildren', 'current_task');
                $taskgroup = 'getChildren';
                break;
            case 'getChildren':
                $this->getCentralDBOptionModel()->save('destinationtask', 'getInformation', 'current_task');
                $taskgroup = 'getInformation';
                break;
            case 'getInformation':
                $task = $this->getCentralDBOptionModel()->save('destinationtask', 'getIATACodes', 'current_task');
                $taskgroup = 'getIATACodes';
                break;
			case 'getIATACodes':
                $taskgroup = 'geoplanetCountries';
                $task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
                break;
			case 'geoplanetCountries':
                $taskgroup = 'setupGeoplanet';
                $task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
                break;
			case 'setupGeoplanet':
				$taskgroup = 'matchGeoplanet';
				$task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
				break;
			case 'matchGeoplanet':
				$task = $this->getCentralDBOptionModel()->save('destinationtask', 'getRoamfreeCountries', 'current_task');
                $taskgroup = 'getRoamfreeCountries';
                break;
			case 'getRoamfreeCountries':
				$taskgroup = 'getRoamfreeStates';
                $task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
				break;
			case 'getRoamfreeStates':
				$taskgroup = 'getRoamfreeChildren';
				$task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
				break;
			case 'getRoamfreeChildren':
				$taskgroup = 'complete';
                $task = $this->getCentralDBOptionModel()->save('destinationtask', $taskgroup, 'current_task');
				break;
            case 'complete':
                $taskgroup = 'complete';
                break;
            default :
                $this->getCentralDBOptionModel()->save('destinationtask', 'getStructure', 'current_task');
                $taskgroup = 'getStructure';
                break;
        }
        return $taskgroup;
    }
    
    public function getChildren($tier = 1, $id = 0, $parent = NULL)
    {
        //$geonames = new GeonamesService($this->getServiceLocator()->get('AceLibrary\Service\HttpRestJsonClientService'));
        
        //$region = $geonames->children(array('username' => 'aceweb', 'geonameId' => $id));
        $region = $this->getGeonamesService()->children(array('username' => 'aceweb', 'geonameId' => $id));
        
        if (count($region) > 0) {
            $array = array();
            foreach ($region as $city) {
            	if(isset($city['geonameId'])){
	                $array[] = array('id' => $city['geonameId'], 'tier' => $tier + 1, 'parent' => $id, 'grandparent' => $parent);
	                $data = array('name' => $city['name'], 'geonamesParent' => $id, 'tier' => $tier + 1, 'geonamesId' => $city['geonameId'], 'lat' => $city['lat'], 'lon' => $city['lng'], 'countryId' => $this->countryId);
	                $variables = array('name', 'geonamesId', 'lat', 'lon', 'tier');
	                $this->getCentralDBDestinationModel()->saveToDestinationTable($data, $variables);
	                //add tasks
	                $this->getCentralDBQueueModel()->setTask($tier + 1 . ',' . $city['geonameId'] . ',' . $id, 'destinationtask');					
				}
            }
            return $array;
        } else {
            return false;  
        } 
    }

	public function getIATA($city = 'ADL')
    {
        $featurearray = array('PPLA', 'ADM2', 'PPLA2', 'PPL', 'PPLC', 'PPLL');

        foreach ($featurearray as $featureCode) {
            $results = $this->getGeonamesService()->search(array('username' => 'aceweb', 'name_equals' => $city, 'featureCode' => $featureCode, 'formatted' => 'tr', 'lang' => 'iata'));
            if (count($results) > 0) {
                $found = $this->arraysearch($city, $results);

                if (count($found) > 0) {
                    return $found;
                } else {
                    Zend_Debug::dump($found);
                    continue;
                }
            } else {
            	continue;	
            }
        }
    }
	
	public function getRoamfreeChildren($area, $task_message)
	{
		$taskDetails = unserialize($task_message);
        $parent_id = $taskDetails['id'];
        $roamFreeParent_id = $taskDetails['roamfreeId'];
		$hierarchy = $taskDetails['hierarchy'];
					
		$message = "";
		$replacename = str_replace(' ' . $taskDetails['abbr'], '', $area->Name);
        $destinations = $this->getCentralDBDestinationModel()->matchLocation(array('name' => $replacename, 'roamfreeId' => null));
        $id = null;
        if (count($destinations)) {
            if ((count($destinations))) {
                $message .= "$replacename match ";
                $this->getCentralDBDestinationModel()->saveToDestinationTable(
                												array(
                													'roamfreeId' => $area->LocalityId,
                													'roamfreeParent' => $parent_id,
                													'destinationType' =>  self::$HIERARCHY[$area->Level],
                													'stateName' => (isset($hierarchy[1]) && ($area->Level > 2))?$hierarchy[1] : null,
                													'regionName' => (isset($hierarchy[2]) && ($area->Level > 3))?$hierarchy[2] : null,
                													'areaName' => (isset($hierarchy[3]) && ($area->Level > 4))?$hierarchy[3] : null,
                													'id' => $destinations[0]['id']
																	),
                												array('id')
															);
				$message .= "update id : " . $destinations[0]['id'] . "<br/>";
				
                $id = $destinations[0]['id'];
                
            } else {
                $message .= $replacename . "either more than one or didn't match state" . "<br>";
                $message .= "count : " . count($destinations) . "<br>";
                $this->getCentralDBQueueModel()->setTask($task_message, 'unmatchedRoamfree');                    
            }
        } else {
            $message .= "$replacename geonames<br/>";
            //$resultsppl = $this->getGeonamesService()->search(array('username' => 'aceweb', 'name_equals' => $replacename, 'country' => 'AU', 'featureCode' => array('PPL', 'ADM1', 'ADM2', 'PPLA', 'PPLA2'), 'formatted' => 'tr', 'lang' => 'iata'));
            //var_dump($resultsppl);
        }
		
		
		$rfData = array('roamfreeName' 		=> $area->Name, 
        				'roamfreeId' 		=> $area->LocalityId,
        				'liveHotels' 		=> $area->LiveHotels,
        				'level' 			=> $area->Level,
        				'destType'			=> self::$HIERARCHY[$area->Level],
        				'stateName' 		=> (isset($hierarchy[1]) && ($area->Level > 2))?$hierarchy[1] : null,
        				'regionName' 		=> (isset($hierarchy[2]) && ($area->Level > 3))?$hierarchy[2] : null,
						'areaName' 			=> (isset($hierarchy[3]) && ($area->Level > 4))?$hierarchy[3] : null,
						'roamfreeParent' 	=> $roamFreeParent_id,
        				'destinationId' 	=> $id
						);
		     
        $this->getCentralDBRoamfreeDestinationsModel()->save($rfData, array('roamfreeId'));
        
        //if (!$area->IsLowestLevel) {
        	$hierarchy[] = $replacename;
            $this->getCentralDBQueueModel()->setTask(serialize(array(
					                            'roamfreeId' => $area->LocalityId,
					                            'id' => $id,
					                            'parent_id' => null,
					                            'name' => $replacename,
					                            'abbr' => $taskDetails['abbr'],
					                            'hierarchy' => $hierarchy,
					                        )), 'getRoamfreeChildren');

        //}
		
		return $message;
	}
	
	function arraysearch($needle, $haystack)
    {
        foreach ($haystack as $k) {
            if (isset($k['name'])) {
                if ($k["name"] == $needle)
                    return $k;
            }
        }
        return FALSE;
    }
	
    public function getCentralDBQueueModel() {
        if(!$this->centralDBQueueModel) {
            $this->centralDBQueueModel = $this->getServiceLocator()->get('CentralDB\Model\QueueModel');
        }
        return $this->centralDBQueueModel;
    }    
    
    public function getCentralDBQueueProgressModel() {
        if(!$this->centralDBQueueProgressModel) {
            $this->centralDBQueueProgressModel = $this->getServiceLocator()->get('CentralDB\Model\QueueProgressModel');
        }
        return $this->centralDBQueueProgressModel;
    }
    
    public function getCentralDBOptionModel() {
        if(!$this->centralDBOptionModel) {
            $this->centralDBOptionModel = $this->getServiceLocator()->get('CentralDB\Model\OptionModel');
        }
        return $this->centralDBOptionModel;
    } 
    
    public function getCentralDBDestinationModel() {
        if(!$this->centralDBDestinationModel) {
            $this->centralDBDestinationModel = $this->getServiceLocator()->get('CentralDB\Model\DestinationModel');
        }
        return $this->centralDBDestinationModel;
    } 
	
	public function getCentralDBAmadeusCitiesModel() {
        if(!$this->centralDBAmadeusCitiesModel) {
            $this->centralDBAmadeusCitiesModel = $this->getServiceLocator()->get('CentralDB\Model\AmadeusCitiesModel');
        }
        return $this->centralDBAmadeusCitiesModel;
    } 
		
	public function getCentralDBCountryInfoModel() {
        if(!$this->centralDBCountryInfoModel) {
            $this->centralDBCountryInfoModel = $this->getServiceLocator()->get('CentralDB\Model\CountryInfoModel');
        }
        return $this->centralDBCountryInfoModel;
    }
	
	public function getCentralDBRoamfreeCountriesModel() {
        if(!$this->centralDBRoamfreeCountriesModel) {
            $this->centralDBRoamfreeCountriesModel = $this->getServiceLocator()->get('CentralDB\Model\RoamfreeCountriesModel');
        }
        return $this->centralDBRoamfreeCountriesModel;
    }

	public function getCentralDBRoamfreeDestinationsModel() {
        if(!$this->centralDBRoamfreeDestinationsModel) {
            $this->centralDBRoamfreeDestinationsModel = $this->getServiceLocator()->get('CentralDB\Model\RoamfreeDestinationsModel');
        }
        return $this->centralDBRoamfreeDestinationsModel;
    }
	 
	public function getGeonamesService() {
        if(!$this->geonamesService) {
        	$this->geonamesService = new GeonamesService($this->getServiceLocator()->get('AceLibrary\Service\HttpRestJsonClientService'));            
        }
        return $this->geonamesService;
    }
	
	public function getYahooGeoPlanetService() {
        if(!$this->yahooGeoPlanetService) {
        	$this->yahooGeoPlanetService = new YahooGeoPlanetService();            
        }
        return $this->yahooGeoPlanetService;
    }
	
	public function getRoamfreeService() {
        if(!$this->roamfreeService) {
        	$this->roamfreeService = $this->getServiceLocator()->get('AceLibrary\Service\RoamfreeService');            
        }
        return $this->roamfreeService;
    }    
}
