<?php
namespace Weather\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author n3ziniuka5
 * @param \Weather\Service\WeatherService   $weatherService
 */
class AjaxController extends AbstractActionController
{
    protected $weatherService;
    
    public function detailedForecastAction() {
        $location = $this->params()->fromRoute('slug');
        $locationName = $this->getWeatherService()->getAreaName($location);
        if(!$locationName) {
            exit;
        }
        $forecast = $this->getWeatherService()->getDetailedForecast($location);
        $jsonModel = new JsonModel(array(
            'forecast' => $forecast,
        ));
        return $jsonModel;
    }
    
    protected function getWeatherService() {
        if(!$this->weatherService) {
            $this->weatherService = $this->getServiceLocator()->get('Weather\Service\WeatherService');
        }
        return $this->weatherService;
    }
}
