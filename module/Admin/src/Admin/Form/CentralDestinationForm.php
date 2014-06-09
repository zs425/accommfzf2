<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class CentralDestinationForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'centraldestinationform');
                                           
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        $this->setName('centraldestinationform');

        
        $this->add(array(
            'name' => 'baodestinationName',
            'type' => 'text',
            'options' => array(
                'size' => '80',
                'filters' => 'Zend\Filter\StringTrim',
            ),
        ));
        
        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Edit',
                'class' => 'btn btn-info',
            ),
        ));
        
        $this->add(array(
            'name' => 'baodestinationId',
            'type' => 'hidden',
            'options' => array(),
        ));
        
    }
    
}