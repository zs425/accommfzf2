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
class YelpSearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'yelpSearchForm');

        $this->setInputFilter($this->getMyInputFilter());  
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/yelp');
        
                
        $term = new Element\Text();
        $term->setName('term');
        $term->setAttribute('id', 'term')
			 ->setAttribute('class', 'span2');
		
		$location = new Element\Text();
        $location->setName('location');
        $location->setAttribute('id', 'location')
			 ->setAttribute('class', 'span2');
                
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-searchForm');
        $submitButton->setValue($this->getTranslator()->translate('Search Yelp'));
        $submitButton->setAttribute('class', 'btn');

        $this->add($term)
			 ->add($location)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }

}