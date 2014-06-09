<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Admin\Form\LoginForm;
use AceLibrary\Controller\AceController;

class AdminController extends AceController {

    protected $authService;
    
    public function indexAction() {
        if($this->getAuthService()->isLoggedIn()) {
            return $this->redirect()->toRoute('zfcadmin/dashboard');
        }
        $loginForm = new LoginForm($this->getServiceLocator());
        $error = '';
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $loginForm->setData($request->getPost());
            if($loginForm->isValid()) {
                $formData = $loginForm->getData();
                $success = $this->getAuthService()->authenticate($formData['username'], $formData['password'], $formData['rememberMe']);
                if($success) {
                    return $this->redirect()->toRoute('zfcadmin/dashboard');
                }
                $error = $this->getTranslator()->translate('Wrong username or password');
            }
            else {
                //Hide form errors, need to find a better solution in the future.
                $loginForm->get('username')->setMessages(array());
                $loginForm->get('password')->setMessages(array());
                $error = $this->getTranslator()->translate('Wrong username or password');
            }
        }
        
        return array(
            'loginForm' => $loginForm,
            'error'     => $error,
        );
    }
    
    public function dashboardAction() {
        //layout ant view variables
        $this->layout()->heading = $this->getTranslator()->translate('Dashboard');
        $this->layout()->subHeading = $this->getTranslator()->translate('Welcome to admin panel');        
        return array();
    }
    
    public function logoutAction() {
        $this->getAuthService()->logout();
        return $this->redirect()->toRoute('zfcadmin');
    }
    
    protected function getAuthService() {
        if(!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('Admin\Service\AuthService');
        }
        return $this->authService;
    }
    
}
