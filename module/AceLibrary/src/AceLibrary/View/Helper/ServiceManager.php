<?php
namespace AceLibrary\View\Helper;

use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceManager extends AbstractViewHelper
{

    /**
     * Get ServiceManager instance
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function __invoke()
    {
        return $this->getServiceManager();
    }

}