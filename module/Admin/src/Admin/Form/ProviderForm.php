<?php
namespace Admin\Form;
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
class ProviderForm extends AceForm {

    protected $inputFilter;

    public function __construct($sm) {
        parent::__construct($sm, 'providerForm');

        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $roamfreeForm = new \Zend\Form\Form();
        $roamfreeForm->setName('roamfree');
        $roamfreeForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $roamfreeForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $roamfreeForm->add(array(
            'name' => 'web_id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $roamfreeForm->setWrapElements(true);
        $this->add($roamfreeForm);
        
        $expediaForm = new \Zend\Form\Form();
        $expediaForm->setName('expedia');
        $expediaForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $expediaForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        $expediaForm->setWrapElements(true);
        $this->add($expediaForm);
        
        $atdwForm = new \Zend\Form\Form();
        $atdwForm->setName('atdw');
        $atdwForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $atdwForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $atdwForm->setWrapElements(true);
        $this->add($atdwForm);
        
        $viatorForm = new \Zend\Form\Form();
        $viatorForm->setName('viator');
        $viatorForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $viatorForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $viatorForm->add(array(
            'name' => 'keyword',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $viatorForm->setWrapElements(true);        
        $this->add($viatorForm);
        
        $v3Form = new \Zend\Form\Form();
        $v3Form->setName('v3');
        $v3Form->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $v3Form->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        $v3Form->setWrapElements(true);
        $this->add($v3Form);
        
        $hotelsForm = new \Zend\Form\Form();
        $hotelsForm->setName('hotelscombined');
        $hotelsForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $hotelsForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        
        $hotelsForm->add(array(
            'name' => 'whitelabelurl',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
        $hotelsForm->setWrapElements(true);
        $this->add($hotelsForm);
		
		$yelpForm = new \Zend\Form\Form();
        $yelpForm->setName('yelp');
        $yelpForm->add(array(
            'name' => 'enable',
            'type' => 'checkbox',
            'options' => array(),
        ));
        
        $yelpForm->add(array(
            'name' => 'id',
            'type' => 'text',
            'options' => array(
                'class' => 'largeInput',
            ),
        ));
		
		$yelpForm->setWrapElements(true);
        $this->add($yelpForm);
        
        $this->add(array(
            'name' => 'save',
            'type' => 'submit',
            'options' => array(),
            'attributes' => array(
                'class' => 'btn btn-success',
                'value' => 'Save',
            ),
        ));
        
        $this->prepare();
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