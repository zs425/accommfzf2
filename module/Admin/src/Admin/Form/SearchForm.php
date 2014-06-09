<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class SearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'aliasActionsForm');

        $this->setAttribute('method', 'post');
        
        $searchInput = new Element\Text();
        $searchInput->setName('search');
        $searchInput->setAttribute('placeholder', $this->getTranslator()->translate('Search'));
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-searchForm');
        $submitButton->setValue($this->getTranslator()->translate('Submit'));
        $submitButton->setAttribute('class', 'btn btn-primary');
		$submitButton->setAttribute('type', 'submit');

        $this->add($searchInput)
             ->add($submitButton);
    }
    
}