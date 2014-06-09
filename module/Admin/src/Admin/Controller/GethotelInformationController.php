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
use CentralDB\Model\DestinationModel;
use CentralDB\Model\OptionModel as CentralDBOptionModel;
use CentralDB\Model\BaoRecordModel;
use CentralDB\Model\RecordInfoModel;
use CentralDB\Model\RecordAttrModel;
use CentralDB\Model\CountryInfoModel;
use CentralDB\Model\HotelRoomModel;
use CentralDB\Model\RecordMultimediaModel;

use AceLibrary\Service\RoamfreeService;
use AceLibrary\Service\S3ImageUploadService;
use AceLibrary\Service\V3ProviderService;
use AceLibrary\Service\ExpediaService;
use AceLibrary\Upload;

class GethotelinformationController extends AceController {

    public $centralDBQueueModel;
    public $centralDBQueueProgressModel;
    public $centralDBOptionModel;
    public $centralDBDestinationModel;
	public $centralDBBaoRecordModel;
	public $centralDBRecordInfoModel;
	public $centralDBRecordAttrModel;
	public $centralDBCountryInfoModel;
	public $centralDBHotelRoomModel;
	public $centralDBRecordMultimediaModel;
	
    public $roamfreeService;
	public $v3ProviderService;
	public $expediaService;
	
	static $propertyCategory = array(
        '1' => array('name' => 'Hotel', 'code' => 'HOTEL'),
        '2' => array('name' => 'Motel', 'code' => 'MOTEL'),
        '3' => array('name' => 'Resort', 'code' => 'RESORT'),
        '4' => array('name' => 'Inn or lodge', 'code' => 'INN_OR_LODGE'),
        '5' => array('name' => 'Bed & breakfast', 'code' => 'BED_AND_BREAKFAST'),
        '6' => array('name' => 'Guest house', 'code' => 'GUEST_HOUSE')
    );
	
    public function __construct() {
		
    }
    
    public function importAction()
    {
		
    }
	
    public function processAction()
    {
    	$taskgroup = $this->getTaskGroup();
        
        switch ($taskgroup)
        {
			case "getHotelsFromRoamfree":
                $view = $this->forward()->dispatch('Admin\Controller\GetHotelInformation', array('action' => 'getHotelsFromRoamfree'));
				break;
			case "getHotelsFromV3":
				$view = $this->forward()->dispatch('Admin\Controller\GetHotelInformation', array('action' => 'getHotelsFromV3'));
				break;
			case "matchDestinationsWithExpedia":
				$view = $this->forward()->dispatch('Admin\Controller\GetHotelInformation', array('action' => 'matchDestinationsWithExpedia'));
				break;
			case "getHotelsFromExpedia":
				$view = $this->forward()->dispatch('Admin\Controller\GetHotelInformation', array('action' => 'getHotelsFromExpedia'));
				break;
			case "complete":
				echo '<div class="col-sm-12"><p class="alert alert-success">All Tasks Completed.</p></div>';
				exit;
        }   
		
		$view->setTerminal(true);		
		return $view;                 
    }
	
	public function matchDestinationsWithExpediaAction()
	{
		$message = "";
		$count = 0;
		$progresscount = 0;
		
	    $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('matchDestinationsWithExpedia');
		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('matchDestinationsWithExpedia', 'setupMatchDestination');
		} else {
			switch ($progress['status']) {
				/*case 'getCountry':
					// download
					foreach (array('State', 'Country') as $fname)
		            {
		            	$fname = 'Country';
		                $zippath = ROOT_PATH . '/data/' . $fname . '.zip';
		                $file = @file_get_contents('https://www.ian.com/affiliatecenter/include/' . $fname . '.zip');
                        @file_put_contents($zippath, $file);
		                // unzip
		                $zip = new \ZipArchive();
		                if ($zip->open(ROOT_PATH . '/data/' . $fname . '.zip') === TRUE)
		                {
		                    $zip->extractTo(ROOT_PATH . '/data');
		                    $zip->close();
		                }
		                unlink($zippath);
		            }
					var_dump('asdf');
					exit;
					
					foreach (\AceLibrary\Tool::searchdir(ROOT_PATH . '/data/') as $fname)
		            {
		                if (preg_match('/Country .*.txt/si', $fname))
		                    $cfile = $fname;
		                if (preg_match('/State .*.txt/si', $fname))
		                    $sfile = $fname;
		            }
		            if (!$sfile || !$cfile)
		            {
		                $this->logError(
		                        'Unable to get Country & State information from ian.com');
		                return false;
		            }

					$countryRows = explode("\n", file_get_contents(ROOT_PATH . '/data/' . $cfile));
		            // remove header
		            array_shift($countryRows);
		            $countries = array();
		            
		            foreach ($countryRows as $row)
		            {
		                $row = explode("|", $row);
		                if (sizeof($row) < 2)
		                    continue;
		                // Get only specified countries
		                if (in_array($row[0], array('AU')))
		                {
		                    $row[1] = trim($row[1], "\r\n");
							
							$cid = $rawdestination->addIfNotExists(array(
		                        'rawdest_name' => $row[1],
		                        'rawdest_source' => 'expedia',
		                        'rawdest_source_id' => $row[0],
		                        'rawdest_type' => 'COUNTRY',
		                        'rawdest_country' => $row[0],
		                        'rawdest_country_source' => $row[1],
		                        'rawdest_parent_id' => 0
		                            ));
		                    $this->log($row[1] . ' - ' . $row[0]);
		                    $countries[$row[0]] = array_merge($row, array($cid));
		                }
		            }
		            
		            unlink(ROOT_PATH . '/data/' . $cfile);
					unlink(ROOT_PATH . '/data/' . $sfile);
					break;*/
				case "setupMatchDestination":
					$destinations = $this->getCentralDBDestinationModel()->getAllDestinations();
					foreach($destinations as $d) {
						$country = $this->getCentralDBCountryInfoModel()->find($d['countryId']);
						$this->getCentralDBQueueModel()->setTask(serialize(array('id'=>$d['id'], 'countryCode' => $country['isoAlpha2'], 'name'=>$d['name'])), 'matchDestinationWithExpedia');
					}
					$count = count($destinations);
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('matchDestinationsWithExpedia', 'running', $count, '0');
					break;
					
				case "running":
					$task = $this->getCentralDBQueueModel()->getTask('matchDestinationWithExpedia');
					if ($task) {
						$message = unserialize($task['message']);
						$data = $this->getExpediaService()->getLocations($message['countryCode'], $message['name']);
                        
						if (isset($data['LocationInfoResponse']['LocationInfos']['LocationInfo']))
		                {                                                                       
		                	if(!is_array($data['LocationInfoResponse']['LocationInfos']['LocationInfo'])) {
		                		$data['LocationInfoResponse']['LocationInfos']['LocationInfo'] = array($data['LocationInfoResponse']['LocationInfos']['LocationInfo']);
		                	}
		                    foreach($data['LocationInfoResponse']['LocationInfos']['LocationInfo'] as $d) {
								if(isset($d['countryCode']) && $d['countryCode'] == $message['countryCode'] && $d['city'] == $message['name']) {
									$this->getCentralDBDestinationModel()->saveToDestinationTable(array('id' => $message['id'], 'expediaId' => $d['destinationId']), array('id'));
									break;
								}
							}
		                }
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('matchDestinationsWithExpedia', 'running', NULL, $progress['progress']+1);
						
						$count = $progress['total'];
						$progresscount = $progress['progress']+1;
						
						$this->getCentralDBQueueModel()->deleteQueue($task['id']);
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
	            'message' => "Matching destinations with expedia",
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}

	public function getHotelsFromExpediaAction()
	{
		$message = "";
		$count = 0;
		$progresscount = 0;
		
	    $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getHotelsFromExpedia');
	
		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromExpedia', 'setTasks');
		} else {
			switch ($progress['status']) {
				case 'setTasks':
					$destinations = $this->getCentralDBDestinationModel()->getDestinations(array('expediaId' => 'IS NOT NULL'));
					if (count($destinations)>0) {
	    				foreach($destinations as $d) {
	    					$hotels = $this->getExpediaService()->GetHotels($d['expediaId']);
							
							if(isset($hotels['HotelListResponse']['HotelList']['HotelSummary'])) {
								if(!is_array($hotels['HotelListResponse']['HotelList']['HotelSummary'])) {
									$hotels['HotelListResponse']['HotelList']['HotelSummary']= array($hotels['HotelListResponse']['HotelList']['HotelSummary']);
								}
							
								foreach($hotels['HotelListResponse']['HotelList']['HotelSummary'] as $hotel) {
									$this->getCentralDBQueueModel()->setTask(serialize(array('id'=>$d['id'], 'hotelId' => $hotel['hotelId'], 'expediaId'=>$d['expediaId'], 'name'=>$d['name'], 'countryId' => $d['countryId'])), 'getHotelsFromExpedia');                                    
								}	
	                            $count += count($hotels['HotelListResponse']['HotelList']['HotelSummary']);
							}	
						}
						$message = "set " . $count . " tasks";	    				
	    			} else {
	    				$message = "No information to process";
					}
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromExpedia', 'running', $count, '0');
					break;
				case 'running':
                    $task = $this->getCentralDBQueueModel()->getTask('getHotelsFromExpedia');
					if ($task) {
						$message = unserialize($task['message']);
						$hotel = $this->getExpediaService()->getHotelDetails($message['hotelId']);
						
						$hotel = $hotel['HotelInformationResponse'];
            
			            // error
			            if(isset($hotel['EanWsError'])) {
			                break;
			            }
			            			            
			          	// SAVE PRODUCT
			            // address
			            $address = $hotel['HotelSummary']['address1'];
			            if(isset($hotel['HotelSummary']['address2']))
			                $address .= $hotel['HotelSummary']['address2'];
			            if(isset($hotel['HotelSummary']['address3']))
			                $address .= $hotel['HotelSummary']['address3'];
			            if(isset($hotel['HotelSummary']['stateProvinceCode']) && !empty($stateCodes[$hotel['HotelSummary']['stateProvinceCode']])) {
			                $stateCode = $stateCodes[$hotel['HotelSummary']['stateProvinceCode']];
			                $stateSourceCode = $hotel['HotelSummary']['stateProvinceCode'];
			            }
			            $desc = $this->string_clean_up($hotel['HotelDetails']['propertyDescription']);
			            
						$baorecordRegion = $baorecordRegionId = $baorecordArea = $baorecordAreaId = null;
						$destination = $this->getCentralDBDestinationModel()->find($message['id']);						
						if($destination) {
						    $baorecordArea = $destination['areaName'];
			                $baorecordAreaId = $destination['areaSource'];
			                $baorecordRegion = $destination['regionName'];
			                $baorecordRegionId = $destination['regionSource'];
			            }
						
			            // bao record
			            $record = array(
			                'baorecordName' => ucwords(strtolower($hotel['HotelSummary']['name'])),
			                'baorecordShortdesc' => strtok($desc, "\n"),
			                'baorecordDescription' => $desc,
			                'baorecordCategory' => 'ACCOMM',
			                'baorecordSource' => 'expedia',
			                'baorecordSourceId' => $hotel['HotelSummary']['hotelId'],
			                'baorecordCountry' => $this->getCentralDBCountryInfoModel()->getCountryName($message['countryId']),
			                'baorecordState' => @$stateCode,
			                'baorecordRegion' => $baorecordRegion,
							'baorecordRegionId' => $baorecordRegionId,
			                'baorecordArea' => $baorecordArea,
							'baorecordAreaId' => $baorecordAreaId,
			                'baorecordCity' => $hotel['HotelSummary']['city'],
			                'baorecordAddress' => $address,
			                'baorecordPostcode' => isset($hotel['HotelSummary']['postalCode'])?$hotel['HotelSummary']['postalCode']:null,
			                'baorecordLat' => $hotel['HotelSummary']['latitude'],
			                'baorecordLon' => $hotel['HotelSummary']['latitude'],
			                'baorecordStarRating' => $hotel['HotelSummary']['hotelRating'],
			                'baorecordLowrate' => $hotel['HotelSummary']['lowRate'],
			                'baorecordHighrate' => $hotel['HotelSummary']['highRate'],
			                'baorecordCheckin' => isset($hotel['HotelDetails']['checkInTime'])?$hotel['HotelDetails']['checkInTime']:null, 
			                'baorecordCheckout' => isset($hotel['HotelDetails']['checkOutTime'])?$hotel['HotelDetails']['checkOutTime']:null
			            );
						
						$recordId = $this->getCentralDBBaoRecordModel()->addIfNotExists($record);
						$source_id = $hotel['HotelSummary']['hotelId'];
						
						// property type (Vertical Classification)
						if(isset($hotel['HotelSummary']['propertyCategory'])) {
				            $attr = array(
				                'baorecordattrType' => 'Vertical Classification',
				                'baorecordattrCode' => self::$propertyCategory[$hotel['HotelSummary']['propertyCategory']]['code'],
				                'baorecordattrName' => self::$propertyCategory[$hotel['HotelSummary']['propertyCategory']]['name'],
				                'baorecordattrRecordType' => 'ACCOMM',
				                'baorecordattrRecordId' => $recordId
				            );
				            $this->getCentralDBRecordAttrModel()->addIfNotExists($attr);
						}
			            // Airport code
			            if(isset($hotel['HotelSummary']['airportCode']) && !empty($hotel['HotelSummary']['airportCode'])) {
			                $attr = array(
			                    'baorecordattrType' => 'Airport Code',
			                    'baorecordattrCode' => $hotel['HotelSummary']['airportCode'],
			                    'baorecordattrName' => $hotel['HotelSummary']['airportCode'],
			                    'baorecordattrRecordType' => 'ACCOMM',
			                    'baorecordattrRecordId' => $recordId
			                );
			                $this->getCentralDBRecordAttrModel()->addIfNotExists($attr);
			            }
						
			            // Suppliers
			            if(isset($hotel['Suppliers']['Supplier']) && count($hotel['Suppliers']['Supplier'])) {
			            	if(!is_array($hotel['Suppliers']['Supplier'])) {
			            		$hotel['Suppliers']['Supplier'] = array($hotel['Suppliers']['Supplier']);
			            	}
			                foreach ($hotel['Suppliers']['Supplier'] as $supplier) {
		                        $attr = array(
		                            'baorecordattrType' => 'SUPPLIER',
		                            'baorecordattrCode' => @$supplier['id'],
		                            'baorecordattrName' => @$supplier['chainCode'],
		                            'baorecordattrRecordType' => 'ACCOMM',
		                            'baorecordattrRecordId' => $recordId
		                        );
		                        $this->getCentralDBRecordAttrModel()->addIfNotExists($attr);
		                    }			                
			            }
						
						//descriptions
			            $descriptions = array('propertyInformation', 'areaInformation', 'locationDescription', 
			                    'guaranteePolicy', 'depositPolicy', 'guaranteeCreditCardsAccepted', 'depositCreditCardsAccepted', 'roomInformation',
			                    'hotelPolicy', 'checkInInstructions', 'drivingDirections');
			            foreach ($descriptions as $desc) {
			                if (isset($hotel['HotelDetails'][$desc]) && !empty($hotel['HotelDetails'][$desc])) {
			                    $data = array(
			                        'recordinfoCode' => $desc,
			                        'recordinfoTitle' => $this->splitCamelCase($desc),
			                        'recordinfoBody' => $this->string_clean_up($hotel['HotelDetails'][$desc]),
			                        'recordinfoRecordId' => $recordId, 
			                    );
			                    // save mysql time
			                    $this->getCentralDBRecordInfoModel()->addIfNotExists($data);
			                }
			            }
						
			            // amenities
			            if(isset($hotel['PropertyAmenities']['PropertyAmenity'])) {
			                foreach ($hotel['PropertyAmenities']['PropertyAmenity'] as $amenity) {
			                    $attr = array(
			                        'baorecordattrType' => 'Entity Facility',
			                        'baorecordattrCode' => @$amenity['amenityId'],
			                        'baorecordattrName' => @$amenity['amenity'],
			                        'baorecordattrRecordType' => 'ACCOMM',
			                        'baorecordattrRecordId' => $recordId
			                    );
			                    $this->getCentralDBRecordAttrModel()->addIfNotExists($attr);
			                }
						}
						
			            // rooms
			            if(isset($hotel['RoomTypes']['RoomType'])) {
			                foreach ($hotel['RoomTypes']['RoomType'] as $room) {
			                    $roomData = array(
			                        'hotelroomName' => isset($room['description'])?$room['description']:null,
			                        'hotelroomShortdesc' => (isset ($room['descriptionLong']))?$room['descriptionLong']:null,
			                        'hotelroomDescription' => (isset($room['descriptionLong']))?$room['descriptionLong']:null,
			                        'hotelroomSource' => 'expedia',
			                        'hotelroomSourceId' => @$room['roomCode'].'::'.@$room['roomTypeId'],
			                        'hotelroomRecordId' => $recordId, 
			                    );
								
								$roomId = $this->getCentralDBHotelRoomModel()->addIfNotExists($roomData);
			                    
			                    // rooms amenities
			                    if(isset($room['roomAmenities']['RoomAmenity'])) {
			                        foreach ($room['roomAmenities']['RoomAmenity'] as $amenity) {
			                            $attr = array(
			                                'baorecordattrType' => 'Service Facility',
			                                'baorecordattrCode' => @$amenity['amenityId'],
			                                'baorecordattrName' => @$amenity['amenity'],
			                                'baorecordattrRecordType' => 'ROOM',
			                                'baorecordattrRecordId' => $roomId
			                            );
			                            $this->getCentralDBRecordAttrModel()->addIfNotExists($attr);
			                        }
								}
			                }
						}

			            // multimedia
			            
			            
			            if(isset($hotel['HotelImages']['HotelImage'])) {
			                $j = 1;
							if(!is_array($hotel['HotelImages']['HotelImage'])) {
								$hotel['HotelImages']['HotelImage'] = array($hotel['HotelImages']['HotelImage']);
							}
			                foreach ($hotel['HotelImages']['HotelImage'] as $image) {
			                    $path = $this->downloadImage($image['url'], $source_id, "expedia");
				                        
		                        if (empty($path)) {
		                            continue;
								}
			                    
								$data = array(
	                                'recordmultimediaType' => 'IMAGE',
	                                'recordmultimediaPath' => $path,
	                                'recordmultimediaDescription' => @$image['caption'],
	                                'recordmultimediaRecordType' => 'ACCOMM',
	                                'recordmultimediaSource' => 'expedia',
	                                'recordmultimediaRecordId' => $recordId,
	                            );
			                    $this->getCentralDBRecordMultimediaModel()->addIfNotExists($data);
			                    // add the first photo as default accommodation image
	                            if ($j++ == 1) {
	                                $this->getCentralDBBaoRecordModel()->save(array(
								                        'baorecordPhoto' =>  $path,
								                        'baorecordId' => $recordId
								                    ));
	                            }
			                }
			            }
						
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromExpedia', 'running', NULL, $progress['progress']+1);
						
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
			$message = 'message: Getting Hotel Information From Expedia';
	    }
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}

	public function getHotelsFromRoamfreeAction()
	{
		$message = "";
		$count = 0;
		$progresscount = 0;
		
	    $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getHotelsFromRoamfree');
	
		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromRoamfree', 'setTasks');
		} else {
			switch ($progress['status']) {
				case 'setTasks':
					$destinations = $this->getCentralDBDestinationModel()->getDestinations(array('roamfreeId' => 'IS NOT NULL'));
					if (count($destinations)>0) {
	    				foreach($destinations as $d) {
	    					$hotels = $this->getRoamfreeService()->GetHotels($d['roamfreeId']);
							if($hotels && !is_array($hotels)) {
                                $hotels = array($hotels);
                            }
							if(count($hotels)) {
								foreach($hotels as $hotelId) {
									$this->getCentralDBQueueModel()->setTask(serialize(array('id'=>$d['id'], 'hotelId' => $hotelId, 'roamfreeId'=>$d['roamfreeId'], 'name'=>$d['name'], 'countryId' => $d['countryId'])), 'getHotelsFromRoamfree');                                    
								}	
                                $count += count($hotels);
							}
						}
						$message = "set " . $count . " tasks";	    				
	    			} else {
	    				$message = "No information to process";
					}
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromRoamfree', 'running', $count, '0');
					break;
				case 'running':
				    $task = $this->getCentralDBQueueModel()->getTask('getHotelsFromRoamfree');
					if ($task) {
						$message = unserialize($task['message']);
						
						$hotel = $this->getRoamfreeService()->getHotelDetails(array($message['hotelId']));
                        
						$description = null;
						if(isset($hotel->Descriptions->HotelDescription)) {
					        foreach ($hotel->Descriptions->HotelDescription as $desc) {
					            // find description
					            if ($desc->Type == 'PRD') {
					                $description = $desc->Value;
								}
					            // check-in
					            if ($desc->Type == 'CIN') {
					                $checkIn = $desc->Value;
								}
					        }
						}
						
						$baorecordRegion = $baorecordRegionId = $baorecordArea = $baorecordAreaId = null;
						// get region
						/*$regionRow = $this->getCentralDBDestinationModel()->getDestinations(array(
																					'name' => str_replace(' ' . $hotel->LocalityName2, '', $hotel->LocalityName3),
																					'destinationType' => 'REGION',
																					'roamfreeId' => 'IS NOT NULL',
																					'stateName' => $hotel->LocalityName2
																				));
						if($regionRow) {
							$baorecordRegion = $regionRow[0]['name'];
							$baorecordRegionId = $regionRow[0]['id'];
						}
					
						// get area
						$areaRow = $this->getCentralDBDestinationModel()->getDestinations(array(
																					'name' => $hotel->LocalityName4,
																					'destinationType' => 'AREA',
																					'roamfreeId' => 'IS NOT NULL',
																					'stateName' => $hotel->LocalityName2
																				));
						if($areaRow) {
							$baorecordArea = $areaRow[0]['name'];
							$baorecordAreaId = $areaRow[0]['id'];
						}*/
						
						$baorecordArea = $hotel->LocalityName4;
						$baorecordRegion = str_replace(' ' . $hotel->LocalityName2, '', $hotel->LocalityName3);
												
						/*$destination = $this->getCentralDBDestinationModel()->find($message['id']);						
						if($destination) {
						    $baorecordArea = $destination['areaName'];
			                $baorecordAreaId = $destination['areaSource'];
			                $baorecordRegion = $destination['regionName'];
			                $baorecordRegionId = $destination['regionSource'];
			            }*/
						
						// add hotels
						$recordId = $this->getCentralDBBaoRecordModel()->addIfNotExists(array(
								            'baorecordName' => $hotel->Name,
								            'baorecordShortdesc' => strtok($description, "\n"),
								            'baorecordDescription' => $description,
								            'baorecordCategory' => 'ACCOMM',
								            'baorecordSource' => 'roamfree',
								            'baorecordSourceId' => $hotel->HotelId,
								            'baorecordCountry' => $this->getCentralDBCountryInfoModel()->getCountryName($message['countryId']),
								            'baorecordState' => $hotel->LocalityName2,
								            'baorecordRegion' => $baorecordRegion,
								            'baorecordRegionId' => $baorecordRegionId,
								            'baorecordArea' => $baorecordArea,
								            'baorecordAreaId' => $baorecordAreaId,
								            'baorecordCity' => $hotel->LocalityName5,
								            'baorecordAddress' => $hotel->Address,
								            'baorecordLat' => @$hotel->Latitude,
								            'baorecordLon' => @$hotel->Longitude,
								            'baorecordStarRating' => $hotel->Rating,
								            'baorecordCheckin' => @$checkIn
						                ));
						$source_id = $hotel->HotelId;
							
						// add descriptions
						if(isset($hotel->Descriptions->HotelDescription)) {
							foreach ($hotel->Descriptions->HotelDescription as $desc) {
					            if (!empty($desc->Type) && $desc->Type != 'PRD') {
					                $data = array(
					                    'recordinfoCode' => $desc->Type,
					                    'recordinfoTitle' => $desc->TypeName,
					                    'recordinfoBody' => $desc->Value,
					                    'recordinfoRecordId' => $recordId,
					                );
					                $this->getCentralDBRecordInfoModel()->addIfNotExists($data);						                
					            }
							}
						}
						
				        if (isset($hotel->CancellationPolicy) && !empty($hotel->CancellationPolicy)) {
				            $this->getCentralDBRecordInfoModel()->addIfNotExists(array(
									                'recordinfoCode' => 'CAP',
									                'recordinfoTitle' => 'Cancellation Policy',
									                'recordinfoBody' => $hotel->CancellationPolicy,
									                'recordinfoRecordId' => $recordId,
									            ));
						}
						
						// facilities
				        if (isset($hotel->Features->Feature)) {
				            if (!is_array($hotel->Features->Feature)) {
				                $hotel->Features->Feature = array($hotel->Features->Feature);
							}
				            foreach ($hotel->Features->Feature as $feature) {
				                $data = array(
				                    'baorecordattrType' => 'Entity Facility',
				                    'baorecordattrCode' => strtoupper(substr(str_replace(' ', '', $feature), 0, 9)),
				                    'baorecordattrName' => $feature,
				                    'baorecordattrRecordType' => 'ACCOMM',
				                    'baorecordattrRecordId' => $recordId
				                );						                
				                $this->getCentralDBRecordAttrModel()->addIfNotExists($data);
				            }
				        }
						
						// hotel type
				        if (isset($hotel->HotelTypes->HotelType)) {
				            if (!is_array($hotel->HotelTypes->HotelType)) {
				                $hotel->HotelTypes->HotelType = array($hotel->HotelTypes->HotelType);
							}
				            foreach ($hotel->HotelTypes->HotelType as $type) {
				                $data = array(
				                    'baorecordattrType' => 'Vertical Classification',
				                    'baorecordattrCode' => strtoupper(substr(str_replace(' ', '', $type), 0, 12)),
				                    'baorecordattrName' => $type,
				                    'baorecordattrRecordType' => 'ACCOMM',
				                    'baorecordattrRecordId' => $recordId
				                );
				                $this->getCentralDBRecordAttrModel()->addIfNotExists($data);
				            }
				        }
						
						// rooms
				        if (isset($hotel->Rooms->HotelRoom)) {
				            if (!is_array($hotel->Rooms->HotelRoom)) {
				                $hotel->Rooms->HotelRoom = array($hotel->Rooms->HotelRoom);
							}
				            foreach ($hotel->Rooms->HotelRoom as $room) {
				                $roomId = $this->getCentralDBHotelRoomModel()->addIfNotExists(array(
										                    'hotelroomName' => $room->Name,
										                    'hotelroomShortdesc' => strtok($room->Description, "\n"),
										                    'hotelroomDescription' => $room->Description,
										                    'hotelroomExtraperson' => $room->ExtraGuestCost,
										                    'hotelroomGuestmax' => $room->MaximumGuests,
										                    'hotelroomSource' => 'roamfree',
										                    'hotelroomSourceId' => $room->RoomId,
										                    'hotelroomRecordId' => $recordId,
														));
				                
				                // room facilities
				                if (isset($room->Features->Feature)) {
				                    if (!is_array($hotel->Features->Feature)) {
				                        $hotel->Features->Feature = array($hotel->Features->Feature);
									}
				                    foreach ($hotel->Features->Feature as $feature) {
				                        $data = array(
							                            'baorecordattrType' => 'Service Facility',
							                            'baorecordattrCode' => strtoupper(substr(str_replace(' ', '', $feature), 0, 9)),
							                            'baorecordattrName' => $feature,
							                            'baorecordattrRecordType' => 'ROOM',
							                            'baorecordattrRecordId' => $roomId
							                        );
				                        
										$this->getCentralDBRecordAttrModel()->addIfNotExists($data);						                        
				                    }
				                }
				                						               
								 
				                // room images
				                if (isset($room->Images->HotelImage)) {
				                    if (!is_array($room->Images->HotelImage)) {
				                        $room->Images->HotelImage = array($room->Images->HotelImage);
									}
				                    foreach ($room->Images->HotelImage as $image) {
				                        $path = $this->downloadImage($image->Url, $source_id, "roamfree");
				                        
				                        if (empty($path)) {
				                            continue;
										}
				                        $data = array(
				                            'recordmultimediaType' => 'IMAGE',
				                            'recordmultimediaPath' => $path,
				                            'recordmultimediaDescription' => $image->Description,
				                            'recordmultimediaRecordType' => 'ROOM',
				                            'recordmultimediaSource' => 'roamfree',
				                            'recordmultimediaRecordId' => $roomId
				                        );
				                        $this->getCentralDBRecordMultimediaModel()->addIfNotExists($data);
				                    }
				                }
									
				            }
				        }


						// photos & default image
				        if (isset($hotel->Images->HotelImage)) {
				            if (!is_array($hotel->Images->HotelImage)) {
				                $hotel->Images->HotelImage = array($hotel->Images->HotelImage);
							}
				            $i = 1;
				            foreach ($hotel->Images->HotelImage as $image) {
				            	$path = "";
				                if ($this->checkRemoteFile($image->Url)) {// if image exists on remote server then process it
				                    $path = $this->downloadImage($image->Url, $source_id, "roamfree");
				                }
				               	//    if (empty($path))
				                //      continue;
				                $data = array(
				                    'recordmultimediaType' => 'IMAGE',
				                    'recordmultimediaPath' =>  $path,
				                    'recordmultimediaDescription' => $image->Description,
				                    'recordmultimediaRecordType' => 'ACCOMM',
				                    'recordmultimediaSource' => 'roamfree',
				                    'recordmultimediaRecordId' => $recordId
				                );
				                
				                $this->getCentralDBRecordMultimediaModel()->addIfNotExists($data);
				                // add the first photo as default accommodation image
				                if ($i++ == 1) {
				                    $this->getCentralDBBaoRecordModel()->save(array(
								                        'baorecordPhoto' =>  $path,
								                        'baorecordId' => $recordId
								                    ));
				                }
				            }
				        }	
				        					
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromRoamfree', 'running', NULL, $progress['progress']+1);
						
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
			$message = 'message: Getting Hotel Information From Roamfree';
	    }
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}	
	
	public function getHotelsFromV3Action()
	{
		$message = "";
		$count = 0;
		$progresscount = 0;
		
	    $progress = $this->getCentralDBQueueProgressModel()->getByQueueName('getHotelsFromV3');
	
		if (!$progress) {
			$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromV3', 'setTasks');
		} else {
			switch ($progress['status']) {
				case 'setTasks':
					$records = $this->getV3ProviderService()->getProviderOptIns();
					
		            $count = 0;
		            foreach ($records as $r)
		            {
		            	if ($r->opted_in_effective)
		                { // only add opted in to array
		                    $count++;
							$this->getCentralDBQueueModel()->setTask($r->short_name, 'getHotelsFromV3');
		                }		                
		            }
					
					$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromV3', 'running', $count, '0');
					break;
				case 'running':
                    $task = $this->getCentralDBQueueModel()->getTask('getHotelsFromV3');
					if ($task) {
						$p = $task['message'];
						$info = $this->getV3ProviderService()->getProviderSearchs(array("shortName" => $p));						
						
						$baorecordRegion = $baorecordRegionId = $baorecordArea = $baorecordAreaId = null;
						$baorecordRegion = @$info->RegionGeocodeDetails->region;
						$destinations = $this->getCentralDBDestinationModel()->matchByNameStateRegion($info->ContactDetails->AddressDetails->city, $info->ContactDetails->AddressDetails->state);
						
						foreach ($destinations as $d)
	                    {
	                        switch ($d['destinationType'])
	                        {
	                            case 'CITY':
	                                $baorecordAreaId = $d['areaSource'];
	                                $baorecordArea = $d['areaName'];
	                                $baorecordRegionId = $d['regionSource'];
	                                $baorecordRegion = $d['regionName'];
	                                break;
	                            case 'REGION':	
	                                $baorecordRegion = $d['regionName'];
	                                $baorecordRegionId = $d['regionSource'];
	                                break;
	                            case 'AREA':
	                                $baorecordRegion = $d['regionName'];
	                                $baorecordRegionId = $d['regionSource'];
									$baorecordAreaId = $d['areaSource'];
	                                $baorecordArea = $d['name'];                                	                                
	                                break;	
	                            default:
	                                break;
	                        }
	                    }
						
						// add hotel						 
						$hotelinfo = array(
			                    'baorecordName' => @$info->full_name,
			                    'baorecordShortdesc' => @$info->ShortDescription,
			                    'baorecordDescription' => @$info->Description,
			                    'baorecordCategory' => @$this->getV3ProviderService()->getIndustryCategory(@$info->MarketingDetails->IndustryCategory->id),
			                    'baorecordSource' => "v3",
			                    'baorecordSourceId' => @$p,
			                    'baorecordCountry' => "Australia",
			                    'baorecordState' => @$info->RegionGeocodeDetails->state_abbreviation,
			                    'baorecordRegion' => @$baorecordRegion,
			                    'baorecordRegionId' => @$baorecordRegionId,
			                    'baorecordArea' => $baorecordArea,
			                    'baorecordAreaId' => $baorecordAreaId,
			                    'baorecordCity' => @$info->ContactDetails->AddressDetails->city,
			                    'baorecordAddress' => @$info->ContactDetails->AddressDetails->address_1,
			                    'baorecordPostcode' => @$info->ContactDetails->AddressDetails->post_code,
			                    'baorecordPhone' => @$info->ContactDetails->MainPhone->country_code . " " . @$info->ContactDetails->MainPhone->area_code . " " . @$info->ContactDetails->MainPhone->number,
			                    'baorecordEmail' => @$info->ContactDetails->PublicEmail->email_address,
			                    'baorecordWebsite' => @$info->ContactDetails->WebSite->url,
			                    'baorecordLat' => @$info->RegionGeocodeDetails->latitude,
			                    'baorecordLon' => @$info->RegionGeocodeDetails->longitude,
			                    'baorecordPhoto' => "",
			                    'baorecordStarRating' => "",
			                    'baorecordLowrate' => @$info->minimum_guide_price,
			                    'baorecordHighrate' => @$info->maximum_guide_price,
			                    'baorecordRateBasis' => "",
			                    'baorecordCheckin' => "",
			                    'baorecordCheckout' => "",
			                    'baorecordFrequency' => "",
			                    'baorecordStart' => "",
			                    'baorecordEnd' => "");
						$recordId = $this->getCentralDBBaoRecordModel()->addIfNotExists($hotelinfo);
						
						// get booking policies
		                if (isset($info->BookingDetails->BookingTerms) && !empty($info->BookingDetails->BookingTerms)) {
		                    $this->getCentralDBRecordInfoModel()->addIfNotExists(array(
		                        'recordinfoCode' => 'BCO',
		                        'recordinfoTitle' => 'Custom booking conditions',
		                        'recordinfoBody' => $info->BookingDetails->BookingTerms,
		                        'recordinfoRecordId' => $recordId,
		                    ));
						}
						
		                // get booking policies
		                if (isset($info->BookingDetails->ConditionsOfUse) && !empty($info->BookingDetails->ConditionsOfUse)) {
		                    $this->getCentralDBRecordInfoModel()->addIfNotExists(array(
		                        'recordinfoCode' => 'COU',
		                        'recordinfoTitle' => 'Conditions Of Use',
		                        'recordinfoBody' => $info->BookingDetails->ConditionsOfUse,
		                        'recordinfoRecordId' => $recordId,
		                    ));
						}
						
		                // get booking policies
		                if (isset($info->RegionGeocodeDetails->state_id) && !empty($info->RegionGeocodeDetails->state_id)) {
		                    $this->getCentralDBRecordInfoModel()->addIfNotExists(array(
		                        'recordinfoCode' => 'V3StateID',
		                        'recordinfoTitle' => 'V3 State ID',
		                        'recordinfoBody' => $info->RegionGeocodeDetails->state_id,
		                        'recordinfoRecordId' => $recordId,
		                    ));
						}
		
		                if (isset($info->RegionGeocodeDetails->region_id) && !empty($info->RegionGeocodeDetails->region_id)) {
		                    $this->getCentralDBRecordInfoModel()->addIfNotExists(array(
		                        'recordinfoCode' => 'V3RegionID',
		                        'recordinfoTitle' => 'V3 Region ID',
		                        'recordinfoBody' => $info->RegionGeocodeDetails->region_id,
		                        'recordinfoRecordId' => $recordId,
		                    ));
						}
		
		                /// @todo get photo for this provider
		                // room images
		                if ($info->Images->Image->relative_url)
		                {
							$path = $this->downloadImage($info->Images->Image->relative_url,  $recordId, 'v3');
		
		                    if (!empty($path))
		                    {
		
		                        $this->getCentralDBBaoRecordModel()->save(array(
										                        'baorecordPhoto' =>  $path,
										                        'baorecordId' => $recordId
										                    ));
		                    }
		                }
						
						$progress = $this->getCentralDBQueueProgressModel()->setQueueProgress('getHotelsFromV3', 'running', NULL, $progress['progress']+1);
						
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
			$message = 'message: Getting Hotel Information From V3';
	    }
		return array(
	            'message' => $message,
	            'count' => $count,
	            'progresscount' => $progresscount,
	        );
	}
	
	public function getTaskGroup()
    {
        $taskgroup = $this->getCentralDBOptionModel()->get('getHotelInformation', 'current_task');
        
        if (!$taskgroup)
            $taskgroup = $this->setTaskGroup();
		
		return $taskgroup;
    }
    
    public function setTaskGroup()
    {
        $taskgroup = $this->getCentralDBOptionModel()->get('getHotelInformation', 'current_task');
        switch ($taskgroup)
        {
			case 'getHotelsFromRoamfree':
				$this->getCentralDBOptionModel()->save('getHotelInformation', 'getHotelsFromV3', 'current_task');
                $taskgroup = 'getHotelsFromV3';
                break;
			case 'getHotelsFromV3':
				$this->getCentralDBOptionModel()->save('getHotelInformation', 'matchDestinationsWithExpedia', 'current_task');
                $taskgroup = 'matchDestinationsWithExpedia';
                break;
			case 'matchDestinationsWithExpedia':
				$this->getCentralDBOptionModel()->save('getHotelInformation', 'getHotelsFromExpedia', 'current_task');
                $taskgroup = 'complete';
                break;
			case "getHotelsFromExpedia":
				$this->getCentralDBOptionModel()->save('getHotelInformation', 'complete', 'current_task');
                $taskgroup = 'complete';
				break;
            default :
                $this->getCentralDBOptionModel()->save('getHotelInformation', 'getHotelsFromRoamfree', 'current_task');
                $taskgroup = 'getHotelsFromRoamfree';
                break;
        }
        return $taskgroup;
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
	
	public function getCentralDBBaoRecordModel() {
        if(!$this->centralDBBaoRecordModel) {
            $this->centralDBBaoRecordModel = $this->getServiceLocator()->get('CentralDB\Model\BaoRecordModel');
        }
        return $this->centralDBBaoRecordModel;
    }
	
	public function getCentralDBRecordInfoModel() {
        if(!$this->centralDBRecordInfoModel) {
            $this->centralDBRecordInfoModel = $this->getServiceLocator()->get('CentralDB\Model\RecordInfoModel');
        }
        return $this->centralDBRecordInfoModel;
    }
	public function getCentralDBRecordAttrModel() {
        if(!$this->centralDBRecordAttrModel) {
            $this->centralDBRecordAttrModel = $this->getServiceLocator()->get('CentralDB\Model\RecordAttrModel');
        }
        return $this->centralDBRecordAttrModel;
    }
	
	public function getCentralDBCountryInfoModel() {
        if(!$this->centralDBCountryInfoModel) {
            $this->centralDBCountryInfoModel = $this->getServiceLocator()->get('CentralDB\Model\CountryInfoModel');
        }
        return $this->centralDBCountryInfoModel;
    }
	
	public function getCentralDBHotelRoomModel() {
        if(!$this->centralDBHotelRoomModel) {
            $this->centralDBHotelRoomModel = $this->getServiceLocator()->get('CentralDB\Model\HotelRoomModel');
        }
        return $this->centralDBHotelRoomModel;
    }
	
	public function getCentralDBRecordMultimediaModel() {
        if(!$this->centralDBRecordMultimediaModel) {
            $this->centralDBRecordMultimediaModel = $this->getServiceLocator()->get('CentralDB\Model\RecordMultimediaModel');
        }
        return $this->centralDBRecordMultimediaModel;
    }
	
	public function getRoamfreeService() {
        if(!$this->roamfreeService) {
        	$this->roamfreeService = $this->getServiceLocator()->get('AceLibrary\Service\RoamfreeService');            
        }
        return $this->roamfreeService;
    }
	
	public function getV3ProviderService() {
        if(!$this->v3ProviderService) {
        	$this->v3ProviderService = $this->getServiceLocator()->get('AceLibrary\Service\V3ProviderService');            
        }
        return $this->v3ProviderService;
    }
	
	public function getExpediaService() {
        if(!$this->expediaService) {
        	$this->expediaService = $this->getServiceLocator()->get('AceLibrary\Service\ExpediaService');            
        }
        return $this->expediaService;
    }
	
	public function downloadImage($image, $source_id = NULL, $type = "roamfree") {
		if($type == 'v3') {
			$path = PUBLIC_PATH . '/images/multimedia/v3/' . $source_id;
			$image = "http://www.au.v3travel.com" . $image;
		} else if($type == 'expedia') {
			$path = PUBLIC_PATH . '/images/multimedia/expedia/' . $source_id;
		}else {
			$path = PUBLIC_PATH . '/images/multimedia/roamfree/' . $source_id;	
		} 
        
        $serverpath = pathinfo($image);
        $fname = $serverpath['basename']; // get file name by stripping original path
        
        $encoded_image = $serverpath['dirname'] . "/" . str_replace(" ", '%20', $fname);
		$fname = strtolower(str_replace(array(' ', '+'), '_', $fname)); 
        
        $fullpathtoimage = $path . '/' . $fname;
        $file = @file_get_contents($encoded_image);
		if($file) {
			if (!is_dir($path)) {
	            mkdir($path, 0777, true); 
			}	            
	        if ($source_id) {
	            @mkdir($path . "/40", 0777, true); 
	            @mkdir($path . "/100", 0777, true);             
			}
			
	        file_put_contents($fullpathtoimage, $file);
	        
	        $thumbnail40 = $this->resizeImage($fullpathtoimage, $path . "/40", 40, 40, 80, 'image_ratio_crop', true);
	        $thumbnail100 = $this->resizeImage($fullpathtoimage, $path . "/100" , 100, 100, 90, 'image_ratio_crop', true);
	        
	        $s3ImageUploadService = new S3ImageUploadService();
		    
			if(file_exists($fullpathtoimage)) {
			    $file = array('tmp_name' => $fullpathtoimage, 'name' => $fname, 'type' => 'image/jpeg');
				while(1) {
					try {
					    $s3ImageUploadService->imageUpload($file, $type . '/' . $source_id . '/');
						@unlink($fullpathtoimage);					    
						break;
					} catch (\Exception $e) {
			        	
			        }
				}
			}
			
			if(file_exists($thumbnail40->file_dst_pathname)) {
				$file = array('tmp_name' => $thumbnail40->file_dst_pathname, 'name' => $thumbnail40->file_dst_name, 'type' => 'image/jpeg');
				while(1) {
					try {
					    $s3ImageUploadService->imageUpload($file, '40/' . $type . '/' . $source_id . '/');
						@unlink($thumbnail40->file_dst_pathname);
						@rmdir($path . '/40');
					    break;
					} catch (\Exception $e) {
			        	
			        }
				}
			}
			
			if(file_exists($thumbnail100->file_dst_pathname)) {
				$file = array('tmp_name' => $thumbnail100->file_dst_pathname, 'name' => $thumbnail100->file_dst_name, 'type' => 'image/jpeg');
				while(1) {
					try {
					    $s3ImageUploadService->imageUpload($file, '100/' . $type . '/' . $source_id . '/');
						@unlink($thumbnail100->file_dst_pathname);
						@rmdir($path . '/100');
					    break;
					} catch (\Exception $e) {
			        	
			        }		
				}
			}
			
			@rmdir($path);
		}
		
        return $fname;
    }

	public function resizeImage($sourcePath, $destPath, $w = null, $h = null, $q = 90, $ratioType = 'image_ratio_no_zoom_in') {
        $thumb = new \AceLibrary\Upload();
        $thumb->upload($sourcePath);
        if ($w || $h) {
            $thumb->image_resize = true;
            $thumb->$ratioType = true;
            $thumb->image_y = $h;
            if ($h != '0') {
                $thumb->image_x = $w;
            }
            $thumb->jpeg_quality = $q;
        }
        if ($ratioType == 'image_ratio_fill')
            $thumb->image_background_color = '#FFFFFF';

        $thumb->file_safe_name = true;
        $thumb->file_auto_rename = false;
        $thumb->file_overwrite = true;
        $thumb->Process($destPath);

        return $thumb;
    }
	
	function checkRemoteFile($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (curl_exec($ch) !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
	
	public function string_clean_up($string) {
        return trim(
        str_replace(array('&amp;', '&apos;'), array('&', '\''), 
        htmlspecialchars_decode($string)));
    }
	
	private function splitCamelCase($str) 
    {
        return ucwords(implode(' ', preg_split('/(?<=\\w)(?=[A-Z])/', $str)));
    }
	
}
