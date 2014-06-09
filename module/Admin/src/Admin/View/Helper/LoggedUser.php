<?php
namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;

/**
 * @author n3ziniuka5
 * @property \Admin\Service\AuthService		$authService
 */
class LoggedUser extends AbstractHelper 
{    
    protected $authService;
    
    public function __construct($sm) {
        $this->authService = $sm->get('Admin\Service\AuthService');
    }
    
    public function __invoke() {
        return $this->authService->getLoggedUser();
    }
}