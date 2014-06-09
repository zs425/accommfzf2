<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class SlideshowActionsForm extends AceForm {
    
    protected $inputFilter;
    
    const ACTION_DELETE = 1;
    
    public function __construct($sm) {
        parent::__construct($sm, 'slideshowActionsForm');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        
        $actionSelect = new Element\Select();
        $actionSelect->setName('action');
        $options = array(
            self::ACTION_DELETE => $this->getTranslator()->translate('Delete selected'), 
        );
        $actionSelect->setValueOptions($options);
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-slideshowActionsForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));
        $submitButton->setAttribute('class', 'btn btn-info');

        $this->add($actionSelect)
             ->add($submitButton);
    }
    
}