<?php
namespace AceLibrary\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;

/**
 * Class AbstractViewHelper
 * @package Travel\View\Helper
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\View\HelperPluginManager         $helperPluginManager
 * @property \Doctrine\ORM\EntityManager            $entityManager
 */
abstract class AbstractViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    protected $helperPluginManager;
    protected $entityManager;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->helperPluginManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->helperPluginManager;
    }

    public function getServiceManager()
    {
        return $this->getServiceLocator()->getServiceLocator();
    }

    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }
}