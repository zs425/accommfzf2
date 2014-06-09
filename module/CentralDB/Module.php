<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/CentralDB for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CentralDB;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use CentralDB\Model\DestinationModel;
use CentralDB\Model\WebsitesModel;
use CentralDB\Model\WebsiteCategoriesModel;
use CentralDB\Model\QueueModel;
use CentralDB\Model\QueueProgressModel;
use CentralDB\Model\OptionModel;
use CentralDB\Model\AmadeusCitiesModel;
use CentralDB\Model\CountryInfoModel;
use CentralDB\Model\RoamfreeCountriesModel;
use CentralDB\Model\RoamfreeDestinationsModel;
use CentralDB\Model\BaoRecordModel;
use CentralDB\Model\RecordInfoModel;
use CentralDB\Model\RecordAttrModel;
use CentralDB\Model\HotelRoomModel;
use CentralDB\Model\RecordMultimediaModel;
use CentralDB\Model\UpdatesModel;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
        	'factories' => array(
                'CentralDB\Model\DestinationModel'  => function($sm) {
                    return new DestinationModel($sm);
                },
                'CentralDB\Model\WebsitesModel'  => function($sm) {
                    return new WebsitesModel($sm);
                },
                'CentralDB\Model\WebsiteCategoriesModel'  => function($sm) {
                    return new WebsiteCategoriesModel($sm);
                },
                'CentralDB\Model\QueueModel'  => function($sm) {
                    return new QueueModel($sm);
                },
                'CentralDB\Model\QueueProgressModel'  => function($sm) {
                    return new QueueProgressModel($sm);
                },
                'CentralDB\Model\OptionModel'  => function($sm) {
                    return new OptionModel($sm);
                },
                'CentralDB\Model\AmadeusCitiesModel'  => function($sm) {
                    return new AmadeusCitiesModel($sm);
                },
                'CentralDB\Model\CountryInfoModel'  => function($sm) {
                    return new CountryInfoModel($sm);
                },
                'CentralDB\Model\RoamfreeCountriesModel'  => function($sm) {
                    return new RoamfreeCountriesModel($sm);
                },
                'CentralDB\Model\RoamfreeDestinationsModel'  => function($sm) {
                    return new RoamfreeDestinationsModel($sm);
                },
                'CentralDB\Model\BaoRecordModel'  => function($sm) {
                    return new BaoRecordModel($sm);
                },
                'CentralDB\Model\RecordInfoModel'  => function($sm) {
                    return new RecordInfoModel($sm);
                },
                'CentralDB\Model\RecordAttrModel'  => function($sm) {
                    return new RecordAttrModel($sm);
                },
                'CentralDB\Model\HotelRoomModel'  => function($sm) {
                    return new HotelRoomModel($sm);
                },
                'CentralDB\Model\RecordMultimediaModel'  => function($sm) {
                    return new RecordMultimediaModel($sm);
                },
                'CentralDB\Model\UpdatesModel'  => function($sm) {
                    return new UpdatesModel($sm);
                }
            )
        );
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e) {
        $sm = $e->getApplication()->getServiceManager();
        
        $config = $sm->get('config');
        if(isset($config['zenddevelopertools']['profiler']['enabled']) && $config['zenddevelopertools']['profiler']['enabled']) {
            $sm->get('doctrine.sql_logger_collector.central');
        }
        $eventManager = $e->getApplication()->getEventManager();
        //Flush Doctrine transactions
        $eventManager->attach('finish', function($e) use ($sm) {
            $sm->get('doctrine.entitymanager.central')->flush();
        });
    }

}
