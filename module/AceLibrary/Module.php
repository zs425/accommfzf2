<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/AceLibrary for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AceLibrary;

use AceLibrary\Service\CacheService;
use AceLibrary\Service\V3Service;
use AceLibrary\View\Helper\ThisRouteHelper;
use AceLibrary\Form\View\Helper\FormElementErrors;
use Zend\Db\Sql\Sql;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use Zend\Http\Client as HttpClient;
use AceLibrary\Service\HttpRestJsonClientService as HttpRestJsonClientService;

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
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AceLibrary\Sql' => function ($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new Sql($adapter);
                },
                'AceLibrary\Service\HttpRestJsonClientService' => function($serviceManager) {
                    $httpClient = $serviceManager->get('HttpClient');
                    $httpRestJsonClientService = new HttpRestJsonClientService($httpClient);
                    return $httpRestJsonClientService;
                },
                'HttpClient' => function($serviceManager) {
                    $httpClient = new HttpClient();
                    # use curl adapter as standard has problems with ssl
                    $httpClient->setAdapter('Zend\Http\Client\Adapter\Curl');                    
                    return $httpClient;
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'thisRoute' => function ($sm) {
                    $locator  = $sm->getServiceLocator();
                    $registry = $locator->get('AceLibrary\Service\RegistryService');
                    $e        = $registry->get('BootstrapEvent');
                    $helper   = new ThisRouteHelper($e);
                    return $helper;
                },
            ),
            'invokables' => array(
	            'formElementErrors' => 'AceLibrary\Form\View\Helper\FormElementErrors'
	        ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $sm           = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        //Flush Doctrine transactions
        $eventManager->attach('finish', function ($e) use ($sm) {
            $sm->get('Doctrine\ORM\EntityManager')->flush();
        });

        $translator = $sm->get('translator');
        AbstractValidator::setDefaultTranslator($translator);

        //Bind bootstrap event to registry
        $registry = $sm->get('AceLibrary\Service\RegistryService');
        $registry->set('BootstrapEvent', $e);
    }
}
