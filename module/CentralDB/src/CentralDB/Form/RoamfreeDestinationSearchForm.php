<?php
namespace CentralDB\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class RoamfreeDestinationSearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'roamfreeDestinationSearchForm');

        $this->setAttribute('method', 'post');
        $this->setName('roamfreedestinationsearchform');  
        
        $this->add(array(
            'name' => 'roamfreeName',
            'type' => 'text',
            'options' => array(
                'filters' => 'Zend\Filter\StringTrim',
            ),
        ));
		
		$this->add(array(
            'name' => 'roamfreeId',
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
                    '0' => 'Only Unmatched with Geonames Destinations', 
                    '1' => 'Only matched with Geonames Destinations',
                    'ALL' => 'All',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'search',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Search',
                'id' => 'searchRoamfreeDestination',
            ),
        ));        
    }    
}