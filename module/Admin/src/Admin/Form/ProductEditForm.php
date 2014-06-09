<?php
namespace Admin\Form; 
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use AceLibrary\Form\AceForm;

class ProductEditForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'productEditForm');
                                           
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-inline');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setName('producteditform');
        
        $this->add(array(
            'name' => 'productName',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productShortdesc',
            'type' => 'textarea',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
            'attributes' => array(
            	'rows' => '3',
            	'class' => 'col-lg-12',
			),
        ));
        
        $this->add(array(
            'name' => 'productDescription',
            'type' => 'textarea',
            'options' => array( 
            ),
            'attributes' => array(
            	'rows' => '5',
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productCountry',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productState',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productRegion',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productCity',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productAddress',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productPhone',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productEmail',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productWebsite',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productLat',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productLon',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
               
        $this->add(array(
            'name' => 'productPhoto',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'productPhotoNew',
            'type' => 'file',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productStarRating',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productLowrate',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productHighrate',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productRateBasis',
            'type' => 'text',
            'options' => array( 
            ),
            'attributes' => array(
            	'class' => 'span12',
			),
        ));
        
        $this->add(array(
            'name' => 'productId',
            'type' => 'hidden',
            'options' => array(),
        ));
        
        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Save Product',
                'class' => 'btn btn-info',
            ),
        ));
        
    }
    
}