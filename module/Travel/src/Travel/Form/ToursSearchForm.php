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
class ToursSearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'toursSearchForm');

        $viaService = $sm->get('AceLibrary\Service\ViatorService');
        
        $this->setInputFilter($this->getMyInputFilter());  
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/tours');
        
                
        $commenceDate = new Element\Text();
        $commenceDate->setName('commencing');
        $commenceDate->setAttribute('id', 'commenceDate');
                
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-searchForm');
        $submitButton->setValue($this->getTranslator()->translate('Search Tours'));
        $submitButton->setAttribute('class', 'btn');

        $this->add(commencing)
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