<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class LoginForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'login');

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        
        $usernameInput = new Element\Text();
        $usernameInput->setName('username');
        $usernameInput->setAttribute('id', 'usernameInput');
        $usernameInput->setAttribute('placeholder', $this->getTranslator()->translate('Username'));
        
        $passwordInput = new Element\Password();
        $passwordInput->setName('password');
        $passwordInput->setAttribute('id', 'passwordInput');
        $passwordInput->setAttribute('placeholder', $this->getTranslator()->translate('Password'));
        
        $rememberMe = new Element\Checkbox();
        $rememberMe->setName('rememberMe');
        $rememberMe->setAttribute('id', 'rememberMe');
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit');
        $submitButton->setValue($this->getTranslator()->translate('Sign in'));
        $submitButton->setAttribute('class', 'btn btn-danger');

        $this->add($usernameInput)
             ->add($passwordInput)
             ->add($rememberMe)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $usernameInput = new Input('username');
            $usernameInput->setRequired(true);
            
            $passwordInput = new Input('password');
            $passwordInput->setRequired(true);
            
            $inputFilter->add($usernameInput)
                        ->add($passwordInput);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }

}