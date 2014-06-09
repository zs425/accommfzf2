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
use CentralDB\Model\WebsiteCategoriesModel;

class SiteSettingForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'siteSettingForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array( 
            'name' => 'frm_type', 
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array( 
                'value' => 'index', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'size' => '60',
                'required' => 'required',
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'url', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'size' => '60',
                'required' => 'required',
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'size' => '60',
                'required' => 'required',
            ),             
        )); 
        
        $this->add(array( 
            'name' => 'adminemail', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'size' => '60',
                'required' => 'required', 
            ),             
        )); 
 
        $this->add(array( 
            'name' => 'frontpage', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'required' => 'required',
            ),             
        )); 
        
        $this->add(array(
            'name' => 'logo',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'supportemail',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
            ),
        ));
 
        $centralWebsiteCategoryModel = $sm->get('CentralDB\Model\WebsiteCategoriesModel');
       
        $websiteCat = $centralWebsiteCategoryModel->getWebsiteCategories();
        $aCategories = array();
        
        foreach ($websiteCat as $c)
        {
            $aCategories[$c['websitecategoryName']] = $c['websitecategoryName'];
        }
        
        $this->add(array(
            'name' => 'category',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'multiple' => 'multiple',
            ),
            'options' => array(
                'value_options' => $aCategories,
            ),
        ));
        
        $this->add(array(
            'name' => 'dropdownlimit',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
            ),
        ));
        
        $this->add(array(
            'name' => 'zfdebug',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'value_options' => array(
                    '0' => 'off',
                    '1' => 'on',
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
        
        /*function populateValues($values){  
            parent::populateValues($values);
            if ($fname = $values['logo']) {
                $image = new \Zend\Form\Element\Image('logo_image');
                $image->setImage($this->getView()->baseUrl() . '/uploads/' . $fname);
                $image->setLabel('Image:');
                $image->setOrder($this->getElement('logo')->getOrder()-1);
                $this->getElement('logo')->setLabel('');
                $this->addElement($image);
            }
        }*/
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
                                    
            $inputFilter->add($factory->createInput(
                array( 
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
                )
            )); 
     
            $inputFilter->add($factory->createInput(
                array( 
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
                )
            )); 
     
            $inputFilter->add($factory->createInput(
                array( 
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
                )
            )); 
     
            $inputFilter->add($factory->createInput(
                array( 
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
                )
            )); 
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}