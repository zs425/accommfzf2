<?php
namespace Admin\Form; 
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class AliasActionsForm extends AceForm {
    
    const ACTION_DELETE = 1;
    
    public function __construct($sm) {
        parent::__construct($sm, 'aliasActionsForm');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        
        $actionSelect = new Element\Select();
        $actionSelect->setName('action');
        $options = array(
            self::ACTION_DELETE => $this->getTranslator()->translate('Delete selected'), 
        );
        $actionSelect->setValueOptions($options);
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-aliasActionsForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));
        $submitButton->setAttribute('class', 'btn btn-info');

        $this->add($actionSelect)
             ->add($submitButton);
    }
    
}