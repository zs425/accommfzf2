<?php
namespace Weather\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * @author n3ziniuka5
 * @param \Weather\Service\WeatherService   $weatherService
 */
class WeatherController extends AbstractActionController
{
    protected $weatherService;
    
    public function indexAction() {
        $availableAreas = $this->getWeatherService()->getAvailableAreas();
        return array(
            'availableAreas'    => $availableAreas,
        );
    }
    
    protected function getWeatherService() {
        if(!$this->weatherService) {
            $this->weatherService = $this->getServiceLocator()->get('Weather\Service\WeatherService');
        }
        return $this->weatherService;
    }
}
