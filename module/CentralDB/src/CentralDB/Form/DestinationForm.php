<?php
namespace CentralDB\Form; 

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class DestinationForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'destinationForm');

		$this->setInputFilter($this->getMyInputFilter());
		
        $this->setAttribute('method', 'post');
        $this->setName('destinationform');  
        
        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            /*'options' => array(
                'filters' => 'Zend\Filter\StringTrim',
            ),*/
        ));
		
		$this->add(array(
            'name' => 'parentId',
            'type' => 'text',
            'options' => array(
                'filters' => 'Zend\Filter\Int',
            ),
        ));
        
                
        $this->add(array(
            'name' => 'save',
            'type' => 'submit',
            'attributes' => array(
                'id' => 'saveDestination',
            ),
        ));        
    } 
	
	public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
                                    
            $inputFilter->add($factory->createInput(
                array( 
                    'name' => 'name', 
                    'required' => true,  
                )
            )); 
     
            $inputFilter->add($factory->createInput(
                array( 
                    'name' => 'parentId', 
                    'required' => false,  
                )
            )); 
     
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }   
}