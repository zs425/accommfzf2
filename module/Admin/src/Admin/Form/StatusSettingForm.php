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

class StatusSettingForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'statusSettingForm');
        
        $this->setAttribute('method', 'post');
        
        $this->add(array( 
            'name' => 'frm_type', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'id' => 'frm_type', 
                'value' => 'status', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'maintenance', 
            'type' => 'radio', 
            'options' => array(
                'value_options' => array(
                    '0' => 'Online',
                    '1' => 'Off-line',
                ),
            ),
        ));
        
        $this->add(array( 
            'name' => 'maintenance_msg', 
            'type' => 'textarea', 
            'attributes' => array(
                'class' => 'col-lg-12',
                'rows' => '3',
            ),             
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
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