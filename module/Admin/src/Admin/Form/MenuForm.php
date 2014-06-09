<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;
use Zend\Validator;
use AceLibrary\Form\AceForm;

class MenuForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'menuForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $titleInput = new Element\Text();
        $titleInput->setName('menu_title');
        $titleInput->setAttribute('id', 'titleInput');
        $titleInput->setAttribute('placeholder', $this->getTranslator()->translate('Menu title'));
        
        $descInput = new Element\Textarea();
        $descInput->setName('menu_description');
        $descInput->setAttribute('id', 'descInput');
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-menuForm');
        $submitButton->setValue($this->getTranslator()->translate('Save menu'));
        $submitButton->setAttribute('class', 'btn btn-primary');
        $submitButton->setAttribute('type', 'submit');
        
        $this->add($titleInput)
             ->add($descInput)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $titleInput = new Input('menu_title');
            $titleInput->setRequired(true);
            
            $inputFilter->add($titleInput);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }
}