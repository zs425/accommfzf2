<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class OptionsActionsForm extends AceForm {
    
    const ACTION_DELETE = 1;
    
    public function __construct($sm) {
        parent::__construct($sm, 'optionsActionsForm');

        $this->setAttribute('method', 'post');
        
        $actionSelect = new Element\Select();
        $actionSelect->setName('action');
        $options = array(
            self::ACTION_DELETE => $this->getTranslator()->translate('Delete selected'), 
        );
        $actionSelect->setValueOptions($options);
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-optionsActionsForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));

        $this->add($actionSelect)
             ->add($submitButton);
    }
    
}