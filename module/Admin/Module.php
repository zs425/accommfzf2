<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Admin\Service\AuthService;
use Zend\Session\SessionManager;
use Zend\Http\Response;
use Admin\Model\ContentModel;
use Admin\Model\AliasModel;
use Admin\Model\MenuModel;
use Admin\Model\MenuItemModel;
use Admin\Model\ProductModel;
use Admin\Model\DestinationModel;
use Admin\Model\ProductChangesModel;
use Admin\Model\ProductChangesdetailModel;
use Admin\View\Helper\LoggedUser;
use Admin\Model\OptionsModel;
use Admin\Model\SlideshowModel;
use Admin\Model\BlockModel;
use Admin\Model\UploadhandlerModel;
use Admin\Model\SlideshowImageModel;
use Admin\Model\ProductRoomModel;
use Admin\Model\ProductAttrModel;
use Admin\Model\ProductInfoModel;
use Admin\Model\ProductMultimediaModel;
use Admin\Controller\GeonamesController; 
use Zend\EventManager\EventManagerInterface; 

class Module implements AutoloaderProviderInterface {

    protected $sm;
    protected $authService;
    
    public function getAutoloaderConfig() {
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
                'Admin\Service\AuthService' => function($sm) {
                    return new AuthService($sm);
                },
                'Admin\SessionManager' => function($sm) {
                    $sessionManager = new SessionManager();
                    $sessionManager->setName('zfcadmin');
                    $sessionManager->start();
                    return $sessionManager;
                },
                'Admin\SessionStorage' => function($sm) {
                    return $sm->get('Admin\SessionManager')->getStorage();
                },
                'Admin\Model\ContentModel' => function($sm) {
                    return new ContentModel($sm);
                },
                'Admin\Model\AliasModel' => function($sm) {
                    return new AliasModel($sm);
                },
                'Admin\Model\MenuModel' => function($sm) {
                    return new MenuModel($sm);
                },
                'Admin\Model\MenuItemModel' => function($sm) {
                    return new MenuItemModel($sm);
                },
                'Admin\Model\OptionsModel' => function($sm) {
                	return new OptionsModel($sm);
                },
				'Admin\Model\SlideshowModel' => function($sm) {
                	return new SlideshowModel($sm);
                },
                'Admin\Model\BlockModel' => function($sm) {
                	return new BlockModel($sm);
                },
                'Admin\Model\UploadhandlerModel' => function($sm) {
                	return new UploadhandlerModel($sm);
                },
                'Admin\Model\SlideshowImageModel' => function($sm) {
                	return new SlideshowImageModel($sm);
                },
                'Admin\Model\ProductModel' => function($sm) {
                    return new ProductModel($sm);
                },
                'Admin\Model\ProductRoomModel' => function($sm) {
                    return new ProductRoomModel($sm);
                },
                'Admin\Model\ProductAttrModel' => function($sm) {
                    return new ProductAttrModel($sm);
                },
                'Admin\Model\ProductMultimediaModel' => function($sm) {
                    return new ProductMultimediaModel($sm);
                },
                'Admin\Model\ProductInfoModel' => function($sm) {
                    return new ProductInfoModel($sm);
                },
                'Admin\Model\DestinationModel' => function($sm) {
                    $model = new DestinationModel();
                    $model->setServiceLocator($sm);
                    return $model;
                },
                'Admin\Model\ProductChangesModel' => function($sm) {
                    return new ProductChangesModel($sm);
                },
                'Admin\Model\ProductChangesdetailModel' => function($sm) {
                    return new ProductChangesdetailModel($sm);
                },
           ),
        );
    }
    
    public function getViewHelperConfig()
    {
    	 
    	return array(
			'factories' => array(
				'loggedUser' => function($sm) {
					$locator = $sm->getServiceLocator();
					return new LoggedUser($locator);
				},
            ),
    	);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
    	$app = $e->getApplication();
    	$em  = $app->getEventManager();
    	$this->sm = $app->getServiceManager();
    
    	$em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'selectLayoutBasedOnRoute'));
    }
    
    public function selectLayoutBasedOnRoute(MvcEvent $e)
    {
    	$app    = $e->getApplication();
    	$config = $this->sm->get('config');
        	  
    	$match      = $e->getRouteMatch();
    	$controller = $e->getTarget();
		$view = $e->getViewModel();
		
    	if($match->getMatchedRouteName() == 'zfcadmin') {
    	    $layout = $config['zfcadmin']['admin_login_template'];
    	    $controller->layout($layout);
    	} 
    	else if(strpos($match->getMatchedRouteName(), 'zfcadmin') !== false) {
    	    if(!$this->getAuthService()->isLoggedIn()) {
    	        $response = $e->getResponse();
    	        $response->setStatusCode(403);
    	        $response->sendHeaders();
    	        exit();
    	    }
			if($view->terminate()) {
				$layout = null;
            } else {
    	    	$layout = $config['zfcadmin']['admin_layout_template'];
			}
    	    $controller->layout($layout);
    	}
    	$controller->layout()->action = $controller->params('action');
    }
    
    protected function getAuthService() {
        if(!$this->authService) {
            $this->authService = $this->sm->get('Admin\Service\AuthService');
        }
        return $this->authService;
    } 
    
    public function getControllerConfig() 
    { 
        return array( 
            'factories'  => array( 
                'Admin\Controller\Geonames' => function($sm) { 
                    $serviceLocator = $sm->getServiceLocator();
                    
                    return new GeonamesController($serviceLocator);                    
                    
                } 
            ), 
        ); 
    }     
    
}
