<?php
namespace Weather\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * @author n3ziniuka5
 * @property \Zend\ServiceManager\ServiceManager    $sm
 * @property \Weather\Service\WeatherService        $weatherService
 */
class AreaName extends AbstractHelper {

    protected $sm;
    protected $weatherService;

    public function __construct($sm) {
        $this->sm = $sm;
    }

    public function __invoke($location) {
        return $this->getWeatherService()->getAreaName($location);
    }
    
    protected function getWeatherService() {
        if(!$this->weatherService) {
            $this->weatherService = $this->sm->get('Weather\Service\WeatherService');
        }
        return $this->weatherService;
    }
}