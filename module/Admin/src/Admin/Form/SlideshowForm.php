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



class SlideshowForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm) {
        parent::__construct($sm, 'slideshowForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $nameInput = new Element\Text();
        $nameInput->setName('slideshow_name');
        $nameInput->setAttribute('id', 'slideshow_name');
        $nameInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow name'));
        
        $typeSelect = new Element\Select();
        $typeSelect->setName('slideshow_script');
        $typeSelect->setAttribute('id', 'slideshow_script');
        $typeSelect->setValueOptions(array(
        								'default'				=> 'Default Slideshow',
										'nivoslider'			=>	'Nivo Slider - the world\'s most awesome jQuery slider',
								        'jqfancytransitions'	=>	'Image Gallery With Fancy Transitions Effects (jqfancytransitions)',
								        'jcarousellite' 		=>	'jCarouselLite + jQuery easing - Wide slider with ability to assign description for each slide',
										'FeaturedContentSlider' =>	'Featured Content Slider',
										'wideslider'			=>	'Wide Slider',
								    	'cycle' 				=>	'Cycle',
								    	'aviaslider' 			=>	'AviaSlider',
								    	'galleriffic'			=>	'Galleriffic',
										'EstroSlider'			=>	'Estro Slider'
									));
        
        $effectSelect = new Element\Select();
        $effectSelect->setName('slideshow_effect');
        $effectSelect->setAttribute('id', 'slideshow_effect');
        $effectSelect->setValueOptions(array(
										'random' 				=> 'Random',
							            'fold' 					=> '[Nivo slider] Fold',
							            'fade' 					=> '[Nivo slider] Fade',
								        'sliceDown'				=> '[Nivo slider] Slice Down',
								        'sliceUp'				=> '[Nivo slider] Slice Up',
								        'sliceDownLeft' 		=> '[Nivo slider] Slice Down Left',
								        'sliceUpLeft' 			=> '[Nivo slider] Slice Up Left',
								        'sliceUpDown' 			=> '[Nivo slider] Slice Up Down',
								        'sliceUpDownLeft'		=> '[Nivo slider] Slice Up Down Left',
								        
								    	'wave'					=> '[JqFancy] Wave',
								        'zipper'				=> '[JqFancy] Zipper',
								        'curtain'				=> '[JqFancy] Curtain',
								        
								    	'jCarouselLite'			=> '[jCarouselLite] Default',
								        
								    	'featuredcontentslider' => '[FeaturedContentSlider] Default',
								        
								    	'wideslider' 			=> '[Wide Slider] Default',
								    	
								    	'growX'	     			=> '[cycle] growX',
								    	'scrollUp'	 			=> '[cycle] scrollUp',
								    	'scrollDown' 			=> '[cycle] scrollDown',
								    	'scrollLeft' 			=> '[cycle] scrollLeft',
								    	'scrollRight'			=> '[cycle] scrollRight',
								    	'scrollHorz' 			=> '[cycle] scrollHorz',
								    	'scrollVert' 			=> '[cycle] scrollVert',
								    	'shuffle'	 			=> '[cycle] shuffle',
								    	'slideX'	 			=> '[cycle] slideX',
								    	'slideY'	 			=> '[cycle] slideY',
								    	'toss'		 			=> '[cycle] toss',
								    	'turnUp'	 			=> '[cycle] turnUp',
								    	'turnDown'	 			=> '[cycle] turnDown',
								    	'turnLeft'	 			=> '[cycle] turnLeft',
								    	'turnRight'	 			=> '[cycle] turnRight',
								    	'uncover'	 			=> '[cycle] uncover',
										
								    	'slide'					=> '[Avia Slider] slide',
								    	'aviafade'				=> '[Avia Slider] fade',
								    	'drop'					=> '[Avia Slider] drop',
								    	
								    	'galleriffic' 			=> '[Galleriffic] Default',
								        'estroslider'			=> '[EstroSlider] Default'
									));
        
        $widthInput = new Element\Text();
        $widthInput->setName('slideshow_width');
        $widthInput->setAttribute('id', 'slideshow_width');
        $widthInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow width'));
		
		$heightInput = new Element\Text();
        $heightInput->setName('slideshow_height');
        $heightInput->setAttribute('id', 'slideshow_height');
        $heightInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow height'));
		
		$thumbnailWidthInput = new Element\Text();
        $thumbnailWidthInput->setName('thumbnail_width');
        $thumbnailWidthInput->setAttribute('id', 'thumbnail_width');
        $thumbnailWidthInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow thumbnail width'));
		
		$thumbnailHeightInput = new Element\Text();
        $thumbnailHeightInput->setName('thumbnail_height');
        $thumbnailHeightInput->setAttribute('id', 'thumbnail_height');
        $thumbnailHeightInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow thumbnail height'));
		
		$delayInput = new Element\Text();
        $delayInput->setName('slideshow_delay');
        $delayInput->setAttribute('id', 'slideshow_delay');
        $delayInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow delay'));
		
		$navigationCheck = new Element\Checkbox();
        $navigationCheck->setName('slideshow_navigation');
        $navigationCheck->setAttribute('id', 'slideshow_navigation');
		$navigationCheck->setCheckedValue('1');
		$navigationCheck->setUncheckedValue('0');
		
		
		$slugInput = new Element\Text();
        $slugInput->setName('slideshow_slug');
        $slugInput->setAttribute('id', 'slideshow_slug');
		$slugInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow slug'));
		
		$uriInput = new Element\Text();
        $uriInput->setName('slideshow_uri');
        $uriInput->setAttribute('id', 'slideshow_uri');
		$uriInput->setAttribute('placeholder', $this->getTranslator()->translate('Slideshow URI For example "/"'));
        
		$submitButton = new Element\Submit();
        $submitButton->setName('submit-slideshowForm');
        $submitButton->setValue($this->getTranslator()->translate('Save and manage images'));
        $submitButton->setAttribute('class', 'btn btn-info');
        
        $this->add($nameInput)
             ->add($typeSelect)
             ->add($effectSelect)
             ->add($widthInput)
             ->add($heightInput)
             ->add($thumbnailWidthInput)
             ->add($thumbnailHeightInput)
             ->add($delayInput)
             ->add($navigationCheck)
			 ->add($slugInput)
			 ->add($uriInput)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
			$factory     = new InputFactory();
						
			$inputFilter->add($factory->createInput(array(
                'name'     => 'slideshow_name',
                'required' => true,                
            )));
            
			$inputFilter->add($factory->createInput(array(
                'name'     => 'slideshow_width',
                'required' => false,    
                'filters'  => array(
                    array('name' => 'int')
                ),                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'slideshow_height',
                'required' => false,    
                'filters'  => array(
                    array('name' => 'int')
                ),                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'thumbnail_width',
                'required' => false,    
                'filters'  => array(
                    array('name' => 'int')
                ),                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'thumbnail_height',
                'required' => false,    
                'filters'  => array(
                    array('name' => 'int')
                ),                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'slideshow_delay',
                'required' => false,    
                'filters'  => array(
                    array('name' => 'int')
                ),                
            )));
			
			$this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    
}