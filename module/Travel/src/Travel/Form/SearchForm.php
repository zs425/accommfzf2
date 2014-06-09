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
class SearchForm extends AceForm {
    
    protected $inputFilter;
    
    public function __construct($sm) {
        parent::__construct($sm, 'searchForm');

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
        
        $guestsOptions = array();
        for($i = 1; $i <= 20; $i++) {
        	$guestsOptions[$i] = $i;
        }
        $guestsSelect = new Element\Select();
        $guestsSelect->setName('guests');
        $guestsSelect->setAttribute('id', 'guestsSelect');
        $guestsSelect->setValueOptions($guestsOptions);
        $guestsSelect->setValue(2);
        
        $areaOptions = $this->getServiceManager()->get('Travel\Model\DestinationModel')->getSearchAreasOptionValues();
        $areaSelect = new Element\Select();
        $areaSelect->setName('area');
        $areaSelect->setAttribute('id', 'areaSelect');
        $areaSelect->setValueOptions($areaOptions);
        
        $submitButton = new Element\Submit();
        $submitButton->setName('submit-searchForm');
        $submitButton->setValue($this->getTranslator()->translate('Search Accommodation'));
        $submitButton->setAttribute('class', 'btn');

        $this->add($commenceDate)
             ->add($nightsSelect)
             ->add($guestsSelect)
             ->add($areaSelect)
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