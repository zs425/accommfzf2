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
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 *
 */
class BookingForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'bookingForm');

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $commenceDate = new Element\Text();
        $commenceDate->setName('commencing');
        $commenceDate->setAttribute('id', 'commenceDate');
        
        $nightsOptions = array();
        for($i = 1; $i <= 28; $i++) {
            $nightsOptions[$i] = $i;
        }
        $nightsSelect = new Element\Select();
        $nightsSelect->setName('nights');
        $nightsSelect->setAttribute('id', 'nightsSelect');
        $nightsSelect->setValueOptions($nightsOptions);
        $nightsSelect->setValue(2);
        
        $adultsOptions = array();
        for($i = 1; $i <= 20; $i++) {
        	$adultsOptions[$i] = $i;
        }
        $adultsSelect = new Element\Select();
        $adultsSelect->setName('adults');
        $adultsSelect->setAttribute('id', 'adultsSelect');
        $adultsSelect->setValueOptions($adultsOptions);
        $adultsSelect->setValue(2);
        
        $childrenOptions = array();
        for($i = 0; $i <= 20; $i++) {
        	$childrenOptions[$i] = $i;
        }
        $childrenSelect = new Element\Select();
        $childrenSelect->setName('children');
        $childrenSelect->setAttribute('id', 'childrenSelect');
        $childrenSelect->setValueOptions($childrenOptions);
        $childrenSelect->setValue(0);
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-bookingForm');
        $submitButton->setValue($this->getTranslator()->translate('Check Availability'));
        $submitButton->setAttribute('class', 'btn');

        $this->add($commenceDate)
             ->add($nightsSelect)
             ->add($adultsSelect)
             ->add($childrenSelect)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $dateRangeValidator = new DateRangeValidator(array(
            	'min'	=> date('d M Y', time() + 60*60*24), //+24 hours
            ));
            $commenceDate = new Input('commencing');
            $commenceDate->setRequired(true);
            $commenceDate->getValidatorChain()
            	->addValidator(new Date(array('format' => 'd M Y')))
            	->addValidator($dateRangeValidator);
            
            $inputFilter->add($commenceDate);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }

}