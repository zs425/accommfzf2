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
class ToursBookingForm extends AceForm {
    
    protected $inputFilter;
    protected $productId;
    
    public function __construct($sm, $productId, $currMonth = null) {
        parent::__construct($sm, 'toursBookingForm');
        
        $viaService = $sm->get('AceLibrary\Service\ViatorService');
        
        $this->productId = $productId;

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $result = $viaService->getAvailabilityDates($this->productId);
        $availableDates = $result->data;
        
        $product = $viaService->getProductDetails($this->productId);
        
        $months = array(); 
        $inx = 0;
        foreach ($availableDates as $month=>$dates){
            $months[$month] = $month;
            if (!$currMonth){
                    $currMonth = $month;
            }
        }
        
        $commenceMonth = new Element\Select();
        $commenceMonth->setName('commenceMonth');
        $commenceMonth->setAttribute('id', 'commenceMonth');
        $commenceMonth->setValueOptions($months);
        
        $dates = array();
        foreach ($availableDates->$currMonth as $date){
            $dates[$currMonth."-".$date] = $date;
        }
        
        $commenceDate = new Element\Select();
        $commenceDate->setName('commenceDate');
        $commenceDate->setAttribute('id', 'commenceDate');
        $commenceDate->setValueOptions($dates);
        
        $adultsOptions = array();
        for($i = 0; $i <= 20; $i++) {
            $adultsOptions[$i] = $i;
        }
        
        $ageBands = array();
        foreach ($product->data->ageBands as $key=>$band){
            $ageBands[$key] = new Element\Select();
            $ageBands[$key]->setName("ageBand[".$band->bandId."]");
            $ageBands[$key]->setValueOptions($adultsOptions);
            $this->add($ageBands[$key]);
        }
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-bookingForm');
        $submitButton->setValue($this->getTranslator()->translate('Check Availability'));
        $submitButton->setAttribute('class', 'btn');

        $this->add($commenceMonth)
             ->add($commenceDate)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $dateRangeValidator = new DateRangeValidator(array(
                'min'    => date('d M Y', time() + 60*60*24), //+24 hours
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