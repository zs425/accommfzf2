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
use CentralDB\Model\OptionModel as CentralDBOptionModel;
use Admin\Model\OptionsModel;
use AceLibrary\Service\GeonamesService;
use AceLibrary\Service\HttpRestJsonClientService;

class TestController extends AceController {

    public $queueModel;
    public $queueProgressModel;
    public $optionsModel;
    public $centralDBOptionModel;
    public $httpRestJsonClient;
    
    public function testQueueModelAction() {
        //$config = $this->getServiceLocator()->get('config');
        //var_dump($config['GeoNamesUrl']);
        
        echo '<pre>';
        //$geonames = new GeonamesService($this->getServiceLocator()->get('AceLibrary\Service\HttpRestJsonClientService'));
        //var_dump($geonames->postalCodeCountryInfo(array('placename' => "Adelaide", "username"=> 'aceweb', 'country'=>'AU')));
        //var_dump($geonames->search(array('username' => 'aceweb', 'q'=>'Tanunda','country'=>'AU', 'type'=>'rdf')));
        //var_dump($geonames->hierarchy(array('username' => 'aceweb','country' => 'AU', 'geonameId'=>'2060604' )));
        //var_dump($geonames->children(array('username' => 'aceweb','country' => 'AU', 'geonameId'=>'6295630' )));
        //var_dump($geonames->children(array('username' => 'aceweb','country' => 'AU', 'geonameId'=>'6255151' )));// oceania
        //var_dump($geonames->countryInfo(array('username'=>'aceweb')));
        //var_dump($geonames->children(array('username' => 'aceweb','geonameId'=>'2077456' )));// australia
        //var_dump($geonames->get(array('username' => 'aceweb', 'geonameId' => '2164064')));
        
        
        //$geonames->countryInfo(array('username'=>'aceweb'));
        //var_dump($this->getQueueProgressModel()->getByQueueName('destinationtask'));
        var_dump($this->getOptionModel()->get('type', 'site'));
        exit;
        
    }
    
    public function getQueueModel() {
        if(!$this->queueModel) {
            $this->queueModel = $this->getServiceLocator()->get('CentralDB\Model\QueueModel');
        }
        return $this->queueModel;
    }    
    
    public function getQueueProgressModel() {
        if(!$this->queueProgressModel) {
            $this->queueProgressModel = $this->getServiceLocator()->get('CentralDB\Model\QueueProgressModel');
        }
        return $this->queueProgressModel;
    }
    
    public function getCentralDBOptionModel() {
        if(!$this->centralDBOptionModel) {
            $this->centralDBOptionModel = $this->getServiceLocator()->get('CentralDB\Model\OptionModel');
        }
        return $this->centralDBOptionModel;
    } 
    
    public function getOptionModel() {
        if(!$this->optionsModel) {
            $this->optionsModel = $this->getServiceLocator()->get('Admin\Model\OptionsModel');
        }
        return $this->optionsModel;
    }  
    
}
