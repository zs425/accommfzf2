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



class WebsiteForm extends AceForm {
    
    protected $inputFilter;
        
    public function __construct($sm, $websiteCategoriesModel) {
        parent::__construct($sm, 'websiteForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $nameInput = new Element\Text();
        $nameInput->setName('websiteName');
        $nameInput->setAttribute('id', 'websiteName');
        $nameInput->setAttribute('placeholder', $this->getTranslator()->translate('Website name'));
		
		$urlInput = new Element\Text();
        $urlInput->setName('websiteUrl');
        $urlInput->setAttribute('id', 'websiteUrl');
        $urlInput->setAttribute('placeholder', $this->getTranslator()->translate('Website url'));
        
		$slugInput = new Element\Text();
        $slugInput->setName('websiteSlug');
        $slugInput->setAttribute('id', 'websiteSlug');
        $slugInput->setAttribute('placeholder', $this->getTranslator()->translate('Website slug'));
		
		$fileInput = new Element\File('file');
		$fileInput->setName('websitePreviewsmall_file');
        $fileInput->setAttribute('id', 'websitePreviewsmall_file');
        
        $hiddenInput = new Element\Hidden();
        $hiddenInput->setName('websitePreviewsmall');
        $hiddenInput->setAttribute('id', 'websitePreviewsmall');
		
		$descInput = new Element\Textarea();
        $descInput->setName('websiteShortdesc');
        $descInput->setAttribute('id', 'websiteShortdesc');
        $descInput->setAttribute('placeholder', $this->getTranslator()->translate('Website Description'));
        
		
        $categorySelect = new Element\Select();
        $categorySelect->setName('websiteCategories');
        $categorySelect->setAttribute('id', 'websiteCategories');
		//$categorySelect->setRegisterInArrayValidator(false);
		
		$categories = $websiteCategoriesModel->getWebsiteCategories();
		
		$tempCat = array();
		foreach($categories as $category) {
			$tempCat[$category['websitecategorySlug']] = $category['websitecategoryName'];
		}
		
		$categorySelect->setValueOptions($tempCat);
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-websiteForm');
        $submitButton->setValue($this->getTranslator()->translate('Save website'));
        $submitButton->setAttribute('class', 'btn btn-primary');
		$submitButton->setAttribute('type', 'submit');
        
        $this->add($nameInput)
             ->add($urlInput)
             ->add($slugInput)
             ->add($fileInput)
             ->add($hiddenInput)
             ->add($descInput)
             ->add($categorySelect)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
			$factory     = new InputFactory();
            						
			$inputFilter->add($factory->createInput(array(
                'name'     => 'websiteName',
                'required' => true,                
            )));
            
			$inputFilter->add($factory->createInput(array(
                'name'     => 'websiteUrl',
                'required' => true,                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'websiteSlug',
                'required' => true,                
            )));
			
			/*$inputFilter->add($factory->createInput(array(
                'name'     => 'websitePreviewsmall',
                'required' => true,                
            )));*/
            
            //$fileInput = new Input('websitePreviewsmall_file');
            //$fileInput->setRequired(true);
            //$fileInput->getValidatorChain()
            //    ->addValidator(new \Zend\Validator\File\Extension(array('jpg', 'jpeg', 'gif', 'png'), true));
                
            //$inputFilter->add($fileInput);
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'websitePreviewsmall',
                'required' => true,                
            )));
            
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'websiteShortdesc',
                'required' => false,                
            )));
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'websiteCategories',
                'required' => false,                
            )));
			
			$this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
    
    
}