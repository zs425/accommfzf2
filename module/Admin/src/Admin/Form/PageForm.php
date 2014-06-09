<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;
use Zend\Validator;
use AceLibrary\Form\AceForm;

class PageForm extends AceForm {
    
    protected $inputFilter;
    protected $menuModel;
    
    public function __construct($sm) {
        parent::__construct($sm, 'pageForm');
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $titleInput = new Element\Text();
        $titleInput->setName('content_title');
        $titleInput->setAttribute('id', 'titleInput');
        $titleInput->setAttribute('placeholder', $this->getTranslator()->translate('Page title'));
        
        $bodyInput = new Element\Textarea();
        $bodyInput->setName('content_body');
        $bodyInput->setAttribute('id', 'bodyInput');
        
        $menuInput = new Element\Text();
        $menuInput->setName('menu_input');
        $menuInput->setAttribute('id', 'menuInput');
        $menuInput->setAttribute('placeholder', $this->getTranslator()->translate('Menu item'));
        
        $menuSelectOptions = $this->getMenuModel()->getStructureForSelect();
        //var_dump($menuSelectOptions);die();
        $menuSelect = new Element\Select();
        $menuSelect->setName('menu_select');
        $menuSelect->setAttribute('id', 'menuSelect');
        $menuSelect->setValueOptions($menuSelectOptions);
        
        $menuWeightInput = new Element\Text();
        $menuWeightInput->setName('menu_weight');
        $menuWeightInput->setAttribute('id', 'menuWeightInput');
        $menuWeightInput->setAttribute('placeholder', $this->getTranslator()->translate('Menu item weight'));
        $menuWeightInput->setValue(0);
        
        $aliasInput = new Element\Text();
        $aliasInput->setName('alias_route');
        $aliasInput->setAttribute('id', 'aliasInput');
        $aliasInput->setAttribute('placeholder', $this->getTranslator()->translate('URL alias'));
        
        $statusSelectOptions = array(
    		'published' => 'Published',
    		'draft' => 'Draft',
        );
        $statusSelect = new Element\Select();
        $statusSelect->setName('content_status');
        $statusSelect->setAttribute('id', 'contentStatus');
        $statusSelect->setValueOptions($statusSelectOptions);
        
        $metaTitleInput = new Element\Text();
        $metaTitleInput->setName('content_metatitle');
        $metaTitleInput->setAttribute('id', 'metaTitleInput');
        $metaTitleInput->setAttribute('placeholder', $this->getTranslator()->translate('Meta title'));
        
        $metaKeywordsInput = new Element\Textarea();
        $metaKeywordsInput->setName('content_metakeywords');
        $metaKeywordsInput->setAttribute('id', 'metaKeywordsInput');
        
        $metaDescriptionInput = new Element\Text();
        $metaDescriptionInput->setName('content_metadescription');
        $metaDescriptionInput->setAttribute('id', 'metaDescriptionInput');
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-pageForm');
        $submitButton->setValue($this->getTranslator()->translate('Save page'));
        $submitButton->setAttribute('class', 'btn btn-primary');
		$submitButton->setAttribute('type', 'submit');
		
		$this->add($titleInput)
             ->add($bodyInput)
             ->add($menuInput)
             ->add($menuSelect)
             ->add($menuWeightInput)
             ->add($aliasInput)
             ->add($statusSelect)
             ->add($metaTitleInput)
             ->add($metaKeywordsInput)
             ->add($metaDescriptionInput)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $titleInput = new Input('content_title');
            $titleInput->setRequired(true);
            
            $routeInput = new Input('alias_route');
            $routeInput->setRequired(false);
            $routeInput->getValidatorChain()
                       ->addValidator(new \Zend\Validator\Regex(array('pattern' => '#^/#')));
            
            $menuWeightInput = new Input('menu_weight');
            $menuWeightInput->setRequired(true);
            $menuWeightInput->getValidatorChain()
                            ->addValidator(new Validator\Digits())
                            ->addValidator(new Validator\StringLength(array('max' => 3)));
            
            $inputFilter->add($titleInput)
                        ->add($menuWeightInput)
                        ->add($routeInput);
            
            $this->inputFilter= $inputFilter;
        }
        return $this->inputFilter;
    }
    
    public function getMenuModel() {
        if(!$this->menuModel) {
            $this->menuModel = $this->getServiceManager()->get('Admin\Model\MenuModel');
        }
        return $this->menuModel;
    }
    
}