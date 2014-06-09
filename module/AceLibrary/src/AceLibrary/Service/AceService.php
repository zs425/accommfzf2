<?php
namespace AceLibrary\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * @author n3ziniuka5
 * @property \Zend\ServiceManager\ServiceManager      $serviceManager
 * @property \Doctrine\ORM\EntityManager              $entityManager
 * @property Array                                    $config
 */
abstract class AceService implements ServiceManagerAwareInterface
{

    protected $serviceManager;
    protected $entityManager;
    protected $config;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = $this->getServiceManager()->get('config');
        }
        return $this->config;
    }
}