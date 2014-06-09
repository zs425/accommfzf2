<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Admin\Validator\UniqueValueValidator;
use Zend\Validator;
use AceLibrary\Form\AceForm;
use Admin\Model\MenuModel;

class MenuitemForm extends AceForm {
    
    protected $inputFilter;
    protected $menuModel;
    protected $menuitemModel;
    protected $menuid;
    protected $parentid; 
    protected $menuitemid;
    
    public function __construct($sm, $menuid, $parentid, $menuitemid = NULL) {
        parent::__construct($sm, 'menuitemForm');
        
        $this->menuid = $menuid;
        $this->parentid = $parentid;
        if ($menuitemid)
            $this->menuitemid = $menuitemid;
        
        $this->setInputFilter($this->getMyInputFilter());
        $this->setAttribute('method', 'post');
        
        $menuIdInput = new Element\Hidden();
        $menuIdInput->setName('menuitem_menu_id');
        $menuIdInput->setAttribute('value', $this->menuid);
        
        $labelInput = new Element\Text();
        $labelInput->setName('menuitem_label');
        
        $titleInput = new Element\Text();
        $titleInput->setName('menuitem_title');
        
        $uriInput = new Element\Text();
        $uriInput->setName('menuitem_uri');
         
        $menuSelectOptions = $this->getMenuModel()->getStructureForSelect();
        $parentSelect = new Element\Select();
        $parentSelect->setName('menuitem_parent_id');
        $parentSelect->setAttribute('id', 'menuitem_parent_id');
        
        $parentOptions = array();
        foreach($menuSelectOptions as $menus){
            if ($menus["menu_id"] == $this->menuid){
                foreach ($menus["options"] as $singleMenu){
                    $parentOptions[$singleMenu["value"]] = $singleMenu["label"];
                }
            }
        }
        
        $parentSelect->setValueOptions($parentOptions);
        
        $subMenus = $this->getMenuitemModel()->getChildMenu($this->menuid, $this->parentid);
        $orderOptions =array();
        $orderOptions["-1"] = "First order";
        foreach($subMenus as $menus){
            if ($menus["menuitem_id"] != $this->menuitemid){
                $orderOptions[$menus["menuitem_weight"]] = "After ".$menus["menuitem_label"];
            }
        }
        
        if ($this->menuid == 1) {
            $typeSelect = new Element\Select();
            $typeSelect->setName('menuitem_type');
            $typeOptions = array(
                    'Menu Item' => 'Menu Item',
                    'Accommodation By Area' => 'Accommodation By Area',
                    'Accommodation By Type' => 'Accommodation By Type',
                    'Attractions By Area' => 'Attractions By Area',
                    'Attractions By Type' => 'Attractions By Type',
                    'Tours By Area' => 'Tours By Area',
                    'Tours By Type' => 'Tours By Type',
                    'Travel Planner' => 'Travel Planner',
                    'Weather' => 'Weather'
                );
            
            $menus = $this->getMenuModel()->getRootItems();
            foreach($menus as $menu){
                if ($menu["menu_id"] > 2){
                    $typeOptions['menu_'.$menu["menu_id"]] = '[Menu] '.$menu['label'];
                }
            }
            $typeSelect->setValueOptions($typeOptions);
            $this->add($typeSelect);
        }
        
        $weightSelect = new Element\Select();
        $weightSelect->setName('menuitem_weight');
        $weightSelect->setAttribute('id', 'menuitem_weight');
        $weightSelect->setValueOptions($orderOptions);
        
        $targetSelect = new Element\Select();
        $targetSelect->setName('menuitem_target');
        $targetSelect->setValueOptions(array(
            '_self' => '_self',
            '_blank' => '_blank',
            '_parent' => '_parent',
            '_top' => '_top',
            )
        );
        
        $visibleCheck = new Element\Checkbox();
        $visibleCheck->setName('menuitem_visible');
        $visibleCheck->setAttribute("checked", "checked");
        
        $submitButton = new Element\Button();
        $submitButton->setName('submit-menuForm');
        $submitButton->setValue($this->getTranslator()->translate('Save item'));
        $submitButton->setAttribute('class', 'btn btn-primary');
        $submitButton->setAttribute('type', 'submit');
        
        $this->add($labelInput)
             ->add($menuIdInput)
             ->add($titleInput)
             ->add($uriInput)
             ->add($parentSelect)
             ->add($weightSelect)
             ->add($targetSelect)
             ->add($visibleCheck)
             ->add($submitButton);
    }
    
    public function getMyInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $labelInput = new Input('menuitem_label');
            $labelInput->setRequired(true);
            
            $titleInput = new Input('menuitem_title');
            $titleInput->setRequired(true);
            
            $inputFilter->add($labelInput)
                        ->add($titleInput);
            
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
    
    public function getMenuitemModel() {
        if(!$this->menuitemModel) {
            $this->menuitemModel = $this->getServiceManager()->get('Admin\Model\MenuItemModel');
        }
        return $this->menuitemModel;
    }
}