<?php
namespace Travel\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;
use Zend\Validator\Regex;
use Zend\Validator\Date;
use AceLibrary\Form\AceForm;
use AceLibrary\Validator\DateRangeValidator;

/**
 * @author Kirill Morozov
 *
 */
class ToursCategoryForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'toursCategoryForm');

        $this->setInputFilter($this->getMyInputFilter()); 
        $this->setAttribute('method', 'post');
        
        $commencing = new Element\Hidden();
        $commencing->setName('commencing');
        $commencing->setAttribute('id', 'commencing');
        
       $this->add($area);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }

}