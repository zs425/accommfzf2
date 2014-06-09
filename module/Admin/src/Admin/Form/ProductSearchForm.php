<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class ProductSearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'productSearchForm');

        $this->setAttribute('method', 'post');
        $this->setName('productsearchform');  
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'name' => 'destination',
            'type' => 'text',
            'options' => array(
                'size' => '30',
                'filters' => 'Zend\Filter\StringTrim',
            ),
        ));
        
        $this->add(array(
            'name' => 'category',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    'ALL'     => 'All',
                    'ACCOMM' => 'Accommodation',
                    'ATTRACTION' => 'Attraction',
                    'EVENT' => 'Event',
                    'TOUR' => 'Tour',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'source',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    'ALL'     => 'All',
                    'roamfree' => 'Roamfree',
                    'atdw' => 'ATDW',
                    'expedia' => 'Expedia',
                    'hc' => 'Hotels Combined',
                    'v3' => 'V3',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'keyword',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $this->add(array(
            'name' => 'bao_id',
            'type' => 'text',
            'options' => array(
                'size' => '15',
                'filters' => 'Zend\Filter\StringTrim',
            ),
        ));
        
        $this->add(array(
            'name' => 'order',
            'type' => 'select',
            'options' => array(
                'value_options' => array(
                    ''     => 'Default',
                    'baorecord_source' => 'Source',
                    'baorecord_category' => 'Category',
                    'baorecord_state' => 'State',
                    'baorecord_region' => 'Region',
                    'baorecord_city' => 'City',
                    'baorecord_star_rating DESC' => 'Rating DESC',
                    'baorecord_created' => 'Created',
                    'baorecord_created DESC' => 'Created DESC',
                    'baorecord_modified' => 'Modified',
                    'baorecord_modified DESC' => 'Modified DESC',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'deleted',
            'type' => 'radio',
            'options' => array(
                'label' => 'Include Deleted Products',
                'value_options' => array(
                    '0' => 'No', 
                    'ALL'     => 'Yes',
                    '1' => 'Only Deleted',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'baodestination_id',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'search',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Search',
            ),
        ));
        
    }
    
}