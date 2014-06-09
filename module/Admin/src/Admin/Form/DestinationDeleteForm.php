<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class DestinationDeleteForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'destinationdeletefrom');
                                           
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        $this->setName('destinationdeleteform');

        
        $this->add(array(
            'name' => 'confirm',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'multiact',
            'type' => 'hidden',
            'attributes' => array(
                'value' => 'delete-local',
            ),
        ));
        
        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Delete',
                'class' => 'btn btn-info',
            ),
        ));
    }
    
}