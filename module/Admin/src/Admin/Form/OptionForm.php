<?php
namespace Admin\Form; 
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;

class OptionForm extends Form {
    
    protected $inputFilter;
    protected $translator;
    protected $sm;
    
    public function __construct($sm) {
        parent::__construct('optionForm');
        $this->sm = $sm;

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $nameInput = new Element\Text();
        $nameInput->setName('optionName');
        $nameInput->setAttribute('id', 'optionName');
        $nameInput->setAttribute('placeholder', $this->getTranslator()->translate('Option name'));
        
        $valueInput = new Element\Text();
        $valueInput->setName('optionValue');
        $valueInput->setAttribute('id', 'optionValue');
        $valueInput->setAttribute('placeholder', $this->getTranslator()->translate('Option value'));
        
        $categoryInput = new Element\Text();
        $categoryInput->setName('optionCategory');
        $categoryInput->setAttribute('id', 'optionCategory');
        $categoryInput->setAttribute('placeholder', $this->getTranslator()->translate('Option category'));
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-optionForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));
        $submitButton->setAttribute('class', 'btn btn-primary');
		$submitButton->setAttribute('type', 'submit');

        $this->add($nameInput)
             ->add($valueInput)
             ->add($categoryInput)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $nameInput = new Input('optionName');
            $nameInput->setRequired(true);
            
            $valueInput = new Input('optionValue');
            $valueInput->setRequired(true);
            
            $categoryInput = new Input('optionCategory');
            $categoryInput->setRequired(true);            
            
            $inputFilter->add($nameInput)
                        ->add($valueInput)
                        ->add($categoryInput);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }
    
    public function getTranslator() {
        if(!$this->translator) {
            $this->translator = $this->sm->get('translator');
        }
        return $this->translator;
    }
    
}