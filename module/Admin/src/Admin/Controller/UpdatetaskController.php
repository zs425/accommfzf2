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
use Travel\Model\OptionsModel;
use CentralDB\Model\BaoRecordModel;
use CentralDB\Model\RecordInfoModel;
use CentralDB\Model\RecordAttrModel;
use CentralDB\Model\HotelRoomModel;
use CentralDB\Model\RecordMultimediaModel;
use CentralDB\Model\UpdatesModel;
use Admin\Model\DestinationModel;
use Admin\Model\ProductModel;

class UpdatetaskController extends AceController {

    public $optionModel;
	public $destinationModel;
	public $productModel;
    public $centralDBDestinationModel;	
	public $centralDBBaoRecordModel;
	public $centralDBRecordInfoModel;
	public $centralDBRecordAttrModel;
	public $centralDBHotelRoomModel;
	public $centralDBRecordMultimediaModel;
	public $centralDBUpdatesModel;
	
	protected $_log = "\n";
	protected $logJson = array();
	protected $LOG_SEPARATOR = "\n --------------- \n\n";
	protected $startTime = 0;
	protected $status;
	
	public function __construct() {
        $this->startTime = microtime(true);
        error_reporting(E_ERROR);
    }
    
    public function restartsiteupdateAction()
    {
    	$this->getOptionModel()->save('status', 'updatedrecords', 'update');
        echo "status changed to updatedrecords";
    }

	public function updateAction()
    {
    	$this->status = $this->getOptionModel()->get('status', 'update');
		
        // Check status and date
        $lastUpdate = $this->getOptionModel()->get('lastUpdate', 'update');
		
        // Initial import
        if (!$lastUpdate && !$this->status)
        {
            $this->getOptionModel()->save('status', 'destinations', 'update');
            $this->status = 'destinations';
            $this->log('Start Initial Import', true);
        } elseif (($lastUpdate + (900)) > time()) {
        	// Don't start. Update has been completed few minutes ago
            $this->log('Update completed', true);
            return false;
        } elseif (($lastUpdate + (3600 * 24)) > time()) {
        	// Don't start. Wait for 24 hours before start next update
            $this->log('Waiting for 24 hours before start next update action...', true);
            return false;
        } elseif (!$this->status) {
        	// error
            $this->log('Errror. Unknown action', true);
            return false;
        }
		
		// call action which corresponds to the current update status
        // @example: Status "Products" => $this->updProducts();
        $action = 'upd' . str_replace(' ', '', ucwords($this->status));

        if (!method_exists(__CLASS__, $action))
        {
            $this->logError("Action \"$action\" is not implemented in " . __CLASS__);
            return false;
        }

        $this->log("Current Action: " . ucwords($this->status), true);


        /*         * ********** UPDATE **********
         * @see methods which start with "upd" in this controller eg. $this->updDestinations();
         */

        $completed = $this->$action();
        if ($completed)
        {
            $this->log('"' . ucwords($this->status) . '" action completed. Move to the next action.');
            $this->nextStatus();
        }

        // action completed
        $time = sprintf("Execution time: %f sec.", microtime(true) - $this->startTime);
        $this->log($time, true);
    }

	public function updDestinations()
    {
    	$ids = explode(', ', $this->getOptionModel()->get('ids', 'site'));
        $type = $this->getOptionModel()->get('type', 'site');
		
        if (!$type || !$ids)
        {
            $this->log('Please configure site first.');
            $this->_logJson['error'] = 'Please configure site first.';
            exit();
        }
		
		$log = $this->getCentralDBDestinationModel()->importDestinations($type, $ids);
        //  print_r($log);
        $this->log($log['log']);
        $this->_logJson['total'] = 10;
        //    $this->_logJson['progress'] = '99';
        $this->_logJson['progressTask'] = 'Get Destinations';

        $this->_logJson['totalproducts'] = $log['records'];
        $this->_logJson['progress'] = $log['records'];
        $this->_logJson['percent'] = 100;
        //$this->_logJson['products'] = $log['log'];
        $this->_logJson['message'] = $log['log'];
        //$this->_logJson['complete'] = false;
        return true;
    }

 	public function updProducts()
    {
    	$sourcesArr = explode('::', $this->getOptionModel()->get('source', 'update'));
		$source = array_shift($sourcesArr);
		
        $totalcount = $this->getOptionModel()->get('total', $source);
		$recordIds = explode('::', $this->getOptionModel()->get('records', $source));
		
        $this->_logJson['progressTask'] = 'Source: ' . $source;
        if ($source == 'roamfree') {
            $this->_logJson['total'] = 20;
		}
        // first iteration - get product ids
        if (!$recordIds || !count($recordIds) || (isset($recordIds[0]) && empty($recordIds[0]))) {
            $this->log('Retrieve record ids');
            $destinations = $this->getDestinationModel()->fetchAll();
			
			// getProductIdsByDestinations
            if (count($destinations)) {
                $recordIds = $this->getCentralDBBaoRecordModel()->getProductIdsByDestinations($destinations, $source);		
			}
            if (count($recordIds) && (isset($recordIds[0]) && !empty($recordIds[0]))) {
                $this->getOptionModel()->save('records', implode('::', $recordIds), $source);
			}
            $this->_logJson['totalproducts'] = $totalcount = count($recordIds);
            $this->getOptionModel()->save('total', $totalcount, $source);
        }
		
        $count = 40; // set amount of records to process
        $offset = $this->getOptionModel()->get('offset', $source, 0);
        $ids = array_slice($recordIds, $offset, $count); // get array of ids to process this time
        //  Zend_Debug::dump($ids);
        if (count($ids)) {
            $this->log('Object: ' . ($offset + $count) . ' of ' . count($recordIds));
            $percent = count($recordIds) / $count / 100;
            $this->_logJson['progress'] = $offset / $count / $percent; // should use jquery here to have progress bar
            $products = $this->getCentralDBBaoRecordModel()->getProducts($ids); // get products from central db
            $productcount = count($products);
            $this->_logJson['totalproducts'] = $totalcount;
            $progress = $this->_logJson['progress'] = ($offset + $productcount);
            $this->_logJson['percent'] = ceil(($progress / $totalcount) * 100);
            // $this->_logJson['products'] = array of products
            $this->_logJson['message'] = "Added " . $productcount . " products";
			
            $this->getProductModel()->updateProducts($products); // edit those records in current install
            $this->getOptionModel()->save('offset', $offset + $count, $source); // save information into options table for next run
        } else {
            // if section is complete then process records to move on to next provider or action
            $this->log(ucfirst($source) . ' completed. move to the next action');
            // $this->_logJson['completed'] = ucfirst($source);
            // $this->_logJson['progress'] = 100;
            $this->_logJson['percent'] = 100;
            $this->_logJson['message'] = "Complete: next section";
            // next source
            $providersstring = $this->getOptionModel()->get('source', 'update');
            $newprovidersstring = explode('::', $providersstring);

            if (($pos = strpos($providersstring, '::')) !== false) {
                //      echo "pos : $pos<br/>";
                $new_str = substr($providersstring, $pos + 2);
                //     echo "new string:<br/>";
                $this->getOptionModel()->save('source', $new_str, 'update');
                //  print_r($new_str); // debug
            }


            if ($source == 'roamfree') {
                $this->_logJson['total'] = 40;
            } else {
                $this->_logJson['total'] = 60;
            }
            // remove current tracking numbers
            $this->getOptionModel()->remove('records', $source);
            $this->getOptionModel()->remove('offset', $source);
            $this->getOptionModel()->remove('total', $source);
            // finish
            if (!count($sourceArr)) {
            	return true;
			}
            return false;
        }
    }

	public function updUpdatedrecords()
    {
        $currentupdate = $this->getOptionModel()->get('updaterunning', 'update'); // get current update no from options
        if (!$currentupdate) { 
        	// if there isnt a current update then check to see if one is needed
            $centralupdateid = $this->getCentralDBUpdatesModel()->getLatest();
            settype($centralupdateid, 'integer');
            $updateNo = $this->getOptionModel()->get('updateNo', 'update'); // get the version of the last completed update 
            if (!$updateNo) {
            	// if there is no updates then set to 0
                $updateNo = 0;
            }
            if ($updateNo < $centralupdateid) {
                $currentupdate = ++$updateNo;
                $this->getOptionModel()->save('updaterunning', $currentupdate, 'update');
            } else {
                $noupdateneeded = true;
            }
        } else {
            $noupdateneeded = true;
        }
        $this->_logJson['progressTask'] = "Setup Update # $currentupdate";
        if (!$noupdateneeded) {
            $ids = $this->getDestinationModel()->getArrayOfAreaIds();
            $prodarray = array();
            // get product changes and put them into array
            $changes = $this->getCentralDBDestinationModel()->getAreaChanges($ids, 'product', $currentupdate);
            foreach ($changes as $change)
            {
                $prodarray[] = $change['id'];
            }
            $this->options->save('products', implode('::', $prodarray), 'update');
            $this->options->save('productcount', count($prodarray), 'update');
            // get hotel room changes
            $prodarray = array();
            $changes = $changemodel->getAreaChanges($ids, 'hotelroom', $currentupdate);
            foreach ($changes as $change) {
                $prodarray[] = $change['id'];
            }
            $this->options->save('hotelrooms', implode('::', $prodarray), 'update');
            $this->options->save('hotelroomcount', count($prodarray), 'update');
            // get image changes
            $imagechanges = $changemodel->getAreaChanges($ids, 'image', $currentupdate);
            $imagearray = array();
            foreach ($imagechanges as $imagechange) {
                $imagearray[] = $imagechange['id'];
            }
            $this->options->save('images', implode('::', $imagearray), 'update');
            $this->options->save('imagecount', count($imagearray), 'update');

            // get attributes
            $changes = $changemodel->getAreaChanges($ids, 'attribute', $currentupdate);
            $attrarray = array();
            foreach ($changes as $change) {
                $attrarray[] = $change['id'];
            }
            $this->options->save('attributes', implode('::', $attrarray), 'update');
            $this->options->save('attributecount', count($attrarray), 'update');
            // set first status to use, or if there is nothing to update the update the updateNo
            if (count($prodarray) > 0) {
                $this->options->save('status', 'updateproducts', 'update');
            } elseif (count($imagearray) > 0) {
                $this->options->save('status', 'updateimages', 'update');
            } elseif (count($attrarray) > 0) {
                $this->options->save('status', 'updateattributes', 'update');
            } else {
                $this->options->save('status', 'updatedrecords', 'update');
                $rev = $this->options->get('updateNo', 'update');
                $this->options->save('source', 'updaterecords', 'update');
                $currentupdate = $this->options->get('updaterunning', 'update');
                settype($centralupdateid, 'integer');


                $this->options->save('updateNo', $currentupdate++, 'update');

                $this->options->remove('updaterunning', 'update');
                //     $this->options->save('status', 'searchindex', 'update');
            }
        }
    }

	/**
     * Manage the order of update process actions here
     */
    public function nextStatus()
    {
        switch ($this->status) {
            // this is only called for updates
            case 'updatedrecords':
                $this->getOptionModel()->save('updateNo', $rev++, 'update');
                break;
            // Destinations
            case 'destinations':
                $this->getOptionModel()->save('status', 'products', 'update');
				$this->getOptionModel()->save('source', 'roamfree::v3::expedia::', 'update');
                break;
            case 'products':
                $providersstring = $this->getOptionModel()->get('source', 'update');
                if (!($pos = strpos($providersstring, '::')) !== false)
                {
                    $this->getOptionModel()->save('status', 'viator', 'update');
                }
                break;
            case 'site':
                $this->getOptionModel()->save('status', 'searchindex', 'update');
            case 'viator':
                $this->getOptionModel()->save('status', 'searchindex', 'update');
                break;
            case 'searchindex':
                // start again
                $this->getOptionModel()->save('status', 'updatedrecords', 'update');
                $rev = $this->getOptionModel()->get('updateNo', 'update');

                $this->getOptionModel()->save('source', 'updaterecords', 'update');
                $this->getOptionModel()->save('source', 'roamfree::v3::expedia::', 'update');
                $currentupdate = $this->getOptionModel()->get('updaterunning', 'update');
                $this->getOptionModel()->save('updateNo', $currentupdate, 'update');
                $this->getOptionModel()->remove('updaterunning', 'update');
                $this->getOptionModel()->remove('products', 'update');
                $this->getOptionModel()->remove('productcount', 'update');
                $this->getOptionModel()->remove('images', 'update');
                $this->getOptionModel()->remove('imagecount', 'update');
                $this->getOptionModel()->remove('attributes', 'update');
                $this->getOptionModel()->remove('attributecount', 'update');
                $this->getOptionModel()->remove('hotelrooms', 'update');
                $this->getOptionModel()->remove('hotelroomcount', 'update');
                // insert date & revision for tracking updates
                break;
        }
    }

	protected function log($msg, $separator = false)
    {
        $this->_log .= $msg . "\n";
        if ($separator) {
            $this->_log .= $this->LOG_SEPARATOR;
		}
        return true;        
    }

    protected function logError($msg, $separator = false)
    {
        $this->log($msg, $separator);        
    }
	
    public function getOptionModel() {
        if(!$this->optionModel) {
            $this->optionModel = $this->getServiceLocator()->get('Travel\Model\OptionsModel');
        }
        return $this->optionModel;
    } 
    
	public function getDestinationModel() {
        if(!$this->destinationModel) {
            $this->destinationModel = $this->getServiceLocator()->get('Admin\Model\DestinationModel');
        }
        return $this->destinationModel;
    } 
    
	public function getProductModel() {
        if(!$this->productModel) {
            $this->productModel = $this->getServiceLocator()->get('Admin\Model\ProductModel');
        }
        return $this->productModel;
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
	
	public function getCentralDBUpdatesModel() {
        if(!$this->centralDBUpdatesModel) {
            $this->centralDBUpdatesModel = $this->getServiceLocator()->get('CentralDB\Model\UpdatesModel');
        }
        return $this->centralDBUpdatesModel;
    }
	
}
