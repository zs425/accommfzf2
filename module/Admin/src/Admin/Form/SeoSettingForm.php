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

class SeoSettingForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'seoSettingForm');
        
        $this->setAttribute('method', 'post');
        
        $this->add(array( 
            'name' => 'frm_type', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'value' => 'seo', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'keyword_h1', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'keyword_h2', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'keyword_alt', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
            ),             
        )); 
        
		$this->add(array( 
            'name' => 'keyword_p1', 
            'type' => 'textarea', 
            'attributes' => array( 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'keyword_p2', 
            'type' => 'textarea', 
            'attributes' => array( 
            ),             
        )); 
 
       $array = array(
                'front_title' => 'Front Title',
                'front_desc'  => 'Front Description',
                'accommlist_title' => 'Title for accommodation list pages',
                'accommlist_desc'  => 'Description for accommodation list pages',
                'attractionlist_title' => 'Title for attractions list pages',
                'attractionlist_desc'  => 'Description for attractions list pages',
                'eventlist_title' => 'Title for events list pages',
                'eventlist_desc'  => 'Description for events list pages',
                'area_name1'  => 'Area Name 1',
                'area_name2'  => 'Area Name 2',
                'area_name3'  => 'Area Name 3'
        );
        foreach ($array as $key => $value) {
            if(strstr($key, 'desc'))
            {
                $this->add(array( 
                    'name' => $key, 
                    'type' => 'textarea', 
                    'attributes' => array(
                        'cols' => '60',
                        'rows' => '2',
                    ),             
                ));
            }
            else{
                $this->add(array( 
                    'name' => $key, 
                    'type' => 'text', 
                    'attributes' => array(
                        'size' => '60',
                    ),             
                ));
            }
        }
        
        $this->add(array( 
            'name' => 'show_intro_block', 
            'type' => 'radio', 
            'options' => array(
                'value_options' => array(
                    '0' => 'No',
                    '1' => 'Yes',
                ),
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