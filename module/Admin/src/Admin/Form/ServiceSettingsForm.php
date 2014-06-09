<?php
namespace Admin\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Form\Element;
use Zend\InputFilter\Input;
use Zend\Validator;
use AceLibrary\Form\AceForm;
use Zend\Filter;

class ServiceSettingsForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'serviceSettingsForm');
        
        $this->setAttribute('method', 'post');
        
        $this->add(array( 
            'name' => 'frm_type', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'id' => 'frm_type', 
                'value' => 'services', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'siteprofile', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'siteprofile', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'twitter_url', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'twitter_url', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'facebook_url', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'facebook_url', 
            ),             
        )); 

        $this->add(array(                
            'name' => 'submit', 
            'type' => 'Zend\Form\Element\Submit', 
            'attributes' => array( 
                'id' => 'submit', 
                'value' => 'Save',
                'class' => 'btn btn-success',
            ), 
        ));   
    }
}