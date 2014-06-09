<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class ProductActionsForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'productActionsForm');
                                           
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        $this->setName('productactionsform');
        
        $this->add(array(
            'name' => 'multiact',
            'type' => 'select',
            'options' => array(
                'label' => 'Actions : ',
                'value_options' => array(
                    'export'     => 'Export CSV',
                    'delete' => 'Delete Selected',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'destination',
            'type' => 'hidden',
            'options' => array(),
        ));
                
        $this->add(array(
            'name' => 'category',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'source',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'keyword',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'bao_id',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'order',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'deleted',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'baodestination_id',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Ok',
                'class' => 'btn btn-info',
            ),
        ));
        
    }
    
}