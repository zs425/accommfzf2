<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Travel for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Travel;

use Travel\Model\Attribute;
use Travel\Model\AttributeTable;
use Travel\Model\ContentBox;
use Travel\Model\ContentBoxTable;
use Travel\Model\Destination;
use Travel\Model\DestinationTable;
use Travel\Model\HotelRoom;
use Travel\Model\HotelRoomTable;
use Travel\Model\MenuItem;
use Travel\Model\MenuItemTable;
use Travel\Model\Multimedia;
use Travel\Model\MultimediaTable;
use Travel\Model\Product;
use Travel\Model\ProductInfo;
use Travel\Model\ProductInfoTable;
use Travel\Model\ProductTable;
use Travel\Model\OptionsModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public $instance;

    public function onBootstrap(MvcEvent $e)
    {
        /*
         * Alias
         * No $request->getUri() method in cli so I had to add this in order to make doctrine-module cli tool work.
         */
        if (PHP_SAPI != 'cli') {
            $sm          = $e->getApplication()->getServiceManager();
            $request     = $e->getRequest();
            $requestUri  = $request->getUri();
            $aliasModel  = $sm->get('Travel\Model\AliasModel');
            $systemRoute = $aliasModel->matchAlias($requestUri->getPath());
            if ($systemRoute) {
                $requestUri->setPath($systemRoute);
            }
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__)
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories'  => array(
                'Travel\Model\ProductTable'     => function ($sm) {
                    $tableGateway = $sm->get('ProductTableGateway');
                    $table        = new ProductTable($tableGateway);
                    return $table;
                },
                'ProductTableGateway'           => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product());
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\DestinationTable' => function ($sm) {
                    $tableGateway = $sm->get('DestinationTableGateway');
                    $table        = new DestinationTable($tableGateway);
                    return $table;
                },
                'DestinationTableGateway'       => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Destination());
                    return new TableGateway('bao_destinations', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\HotelRoomTable'   => function ($sm) {
                    $tableGateway = $sm->get('HotelRoomTableGateway');
                    $table        = new HotelRoomTable($tableGateway);
                    return $table;
                },
                'HotelRoomTableGateway'         => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new HotelRoom());
                    return new TableGateway('product_rooms', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\MultimediaTable'  => function ($sm) {
                    $tableGateway = $sm->get('MultimediaTableGateway');
                    $table        = new MultimediaTable($tableGateway);
                    return $table;
                },
                'MultimediaTableGateway'        => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Multimedia());
                    return new TableGateway('product_multimedia', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\ProductInfoTable' => function ($sm) {
                    $tableGateway = $sm->get('ProductInfoTableGateway');
                    $table        = new ProductInfoTable($tableGateway);
                    return $table;
                },
                'ProductInfoTableGateway'       => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProductInfo());
                    return new TableGateway('product_info', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\MenuItemTable'    => function ($sm) {
                    $tableGateway = $sm->get('MenuItemTableGateway');
                    $table        = new MenuItemTable($tableGateway);
                    return $table;
                },
                'MenuItemTableGateway'          => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new MenuItem());
                    return new TableGateway('menu_items', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\ContentBoxTable'  => function ($sm) {
                    $tableGateway = $sm->get('ContentBoxTableGateway');
                    $table        = new ContentBoxTable($tableGateway);
                    return $table;
                },
                'ContentBoxTableGateway'        => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ContentBox());
                    return new TableGateway('contentboxes', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\AttributeTable'   => function ($sm) {
                    $tableGateway = $sm->get('AttributeTableGateway');
                    $table        = new AttributeTable($tableGateway);
                    return $table;
                },
                'AttributeTableGateway'         => function ($sm) {
                    $dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Attribute());
                    return new TableGateway('product_attributes', $dbAdapter, null, $resultSetPrototype);
                },
                'Travel\Model\OptionsModel'  => function($sm) {
                	return new OptionsModel($sm);
                }
            ),
            'invokables' => array(
                'Travel\Model\DestinationModel'             => 'Travel\Model\DestinationModel',
                'Travel\Model\AliasModel'                   => 'Travel\Model\AliasModel',
                'Travel\Service\AccommodationSearchService' => 'Travel\Service\AccommodationSearchService',
                'Travel\Service\RoamFreeSearchService'      => 'Travel\Service\RoamFreeSearchService',
                'Travel\Service\V3SearchService'            => 'Travel\Service\V3SearchService',
                'Travel\Service\V3ProviderService'          => 'Travel\Service\V3ProviderService',
                'Travel\Model\ProductModel'                 => 'Travel\Model\ProductModel',
                'Travel\Model\SlideshowModel'               => 'Travel\Model\SlideshowModel',
                'Travel\Model\SlideshowImagesModel'         => 'Travel\Model\SlideshowImagesModel',
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'ThemeElement'        => 'Travel\View\Helper\ThemeElement',
                'thumbPath'           => 'Travel\View\Helper\ThumbPath',
                'imagePath'           => 'Travel\View\Helper\ImagePath',
                'GetMenuItems'        => 'Travel\View\Helper\GetMenuItems',
                'formBootstrapEditor' => 'Travel\View\Helper\FormBootstrapEditor',
                'option'              => 'Travel\View\Helper\Option',
                'UrlFilter'           => 'Travel\View\Helper\UrlFilter',
                'AtdwClassifications' => 'Travel\View\Helper\AtdwClassifications',
                'GetDestinations'     => 'Travel\View\Helper\GetDestinations',
                'getConfig'           => 'Travel\View\Helper\GetConfig',
                'displayProductArea'  => 'Travel\View\Helper\DisplayProductArea',
                'GetSlideshow'        => 'Travel\View\Helper\GetSlideshow',
            ),
        );
    }
}
