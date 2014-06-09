<?php
namespace CentralDB\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class DestinationSearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'destinationSearchForm');

        $this->setAttribute('method', 'post');
        $this->setName('destinationsearchform');  
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'options' => array(
                'filters' => 'Zend\Filter\StringTrim',
            ),
        ));
		
		$this->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'filters' => 'Zend\Filter\Int',
            ),
        ));
        
        $this->add(array(
            'name' => 'searchOption',
            'type' => 'radio',
            'options' => array(
                'label' => 'Search Terms',
                'value_options' => array(
                    '0' => 'Only Unmatched with Roamfree', 
                    '1' => 'Only matched with Roamfree',
                    'ALL' => 'All',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'search',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Search',
                'id' => 'searchDestination',
            ),
        ));        
    }    
}