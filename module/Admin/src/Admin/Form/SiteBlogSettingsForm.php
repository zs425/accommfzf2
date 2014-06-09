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

class SiteBlogSettingsForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'siteBlogSettingsForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $this->add(array( 
            'name' => 'frm_type', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'id' => 'frm_type', 
                'value' => 'blog', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'blog_url', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'blog_url', 
                'placeholder' => 'Blog Url', 
                //'required' => 'required', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'blogfeed', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'blogfeed', 
                'placeholder' => 'Blog Feed Url', 
                //'required' => 'required', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'blog_user', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'id' => 'blog_user', 
                'placeholder' => 'Blog User', 
                //'required' => 'required', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'blog_pass', 
            'type' => 'Zend\Form\Element\Password', 
            'attributes' => array( 
                'id' => 'blog_pass', 
                'placeholder' => 'Blog Password', 
                //'required' => 'required', 
            ),             
        )); 
        
 
        $this->add(array( 
            'name' => 'submit', 
            'type' => 'Zend\Form\Element\Submit', 
            'attributes' => array( 
                'id' => 'submit', 
                'value' => 'Save', 
            ), 
        ));   
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
                                    
            $inputFilter->add($factory->createInput(array(
                'name' => 'blog_url', 
                'required' => true, 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array ( 
                        'name' => 'StringLength', 
                        'options' => array( 
                            'encoding' => 'UTF-8', 
                            'max' => '60', 
                        ), 
                    ), 
                ), 
            ))); 
     
            $inputFilter->add($factory->createInput(array( 
                'name' => 'blogfeed', 
                'required' => true, 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array ( 
                        'name' => 'StringLength', 
                        'options' => array( 
                            'encoding' => 'UTF-8', 
                            'max' => '150', 
                        ), 
                    ), 
                ), 
            ))); 
     
            $inputFilter->add($factory->createInput(array(
                'name' => 'blog_user', 
                'required' => true, 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array ( 
                        'name' => 'StringLength', 
                        'options' => array( 
                            'encoding' => 'UTF-8', 
                            'max' => '15', 
                        ), 
                    ), 
                ), 
            ))); 
     
            $inputFilter->add($factory->createInput(array(
                'name' => 'blog_pass', 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array ( 
                        'name' => 'StringLength', 
                        'options' => array( 
                            'encoding' => 'UTF-8', 
                            'max' => '15', 
                        ), 
                    ), 
                ), 
            ))); 
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    
}