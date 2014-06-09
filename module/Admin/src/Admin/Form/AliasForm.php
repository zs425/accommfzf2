<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;
use AceLibrary\Form\AceForm;

class AliasForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'aliasForm');

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        
        $pathInput = new Element\Text();
        $pathInput->setName('alias_system');
        $pathInput->setAttribute('id', 'pathInput');
        $pathInput->setAttribute('placeholder', $this->getTranslator()->translate('Existing system path'));
        
        $routeInput = new Element\Text();
        $routeInput->setName('alias_route');
        $routeInput->setAttribute('id', 'routeInput');
        $routeInput->setAttribute('placeholder', $this->getTranslator()->translate('Route'));
        
		$submitButton = new Element\Button();
        $submitButton->setName('submit-aliasForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));
        $submitButton->setAttribute('class', 'btn btn-primary');
		$submitButton->setAttribute('type', 'submit');

        $this->add($pathInput)
             ->add($routeInput)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $pathInput = new Input('alias_system');
            $pathInput->setRequired(true);
            
            $regexValidator = new \Zend\Validator\Regex(array('pattern' => '#^/#'));
            $regexValidator->setMessage($this->getTranslator()->translate('Route must start with a slash \'/\''), $regexValidator::NOT_MATCH);
            $routeInput = new Input('alias_route');
            $routeInput->setRequired(true);
            $routeInput->getValidatorChain()
                       ->addValidator($regexValidator);
            
            $inputFilter->add($pathInput)
                        ->add($routeInput);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }
    
}