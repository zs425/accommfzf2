<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use AceLibrary\Controller\AceController;
use Admin\Form\MenuForm;
use Admin\Form\MenuitemForm;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * @author Kirill
 * @property \Zend\I18n\Translator\Translator    $translator
 *
 */
class MenusController extends AceController {
    
    protected $menuModel;
    
    protected $menuitemModel;
    
    public function indexAction() {
        
        $model = $this->getMenuModel();
        $menus = $model->getRootItems();
        
        return array(
            'menus' => $menus, 
        );
    }
    
    // Add menu action
    public function addMenuAction(){
        $menuForm = new MenuForm($this->getServiceLocator());
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost(); 
            $menuForm->setData($post);
            if($menuForm->isValid()) {
                $this->getMenuModel()->addMenu($menuForm->getData());
                return $this->redirect()->toRoute('zfcadmin/menus');
            }
        }
        $this->layout()->heading = 'Add Menu';
        return array(
            'menuForm'  => $menuForm,
        );
    }
    
    
    // Edit menu action                                  
    public function editMenuAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 0) {         
            return $this->redirect()->toRoute('zfcadmin/menus');
        }
        $menu = $this->getMenuModel()->getMenu($id);
        
        if(!$menu) {
            return $this->redirect()->toRoute('zfcadmin/menus');
        }
        
        $menuForm = new MenuForm($this->getServiceLocator());
        $request = $this->getRequest();
        if($request->isPost()) { 
            $post = $request->getPost();
            $menuForm->setData($post);
            if($menuForm->isValid()) {
                $data = $menuForm->getData();
                $this->getMenuModel()->editMenu($id, $data);
                return $this->redirect()->toRoute('zfcadmin/menus');
            }
        }
        else {
            $menuForm->setData($menu);
        }
        
        return array(
            'menuForm'  => $menuForm,
            'id'        => $id,
        );
    }
    
    //Delete menu action
    public function deleteMenuAction() {
        $id = (int) $this->params()->fromRoute('id');
        if($id != 0) {
           $this->getMenuModel()->delete($id);
        }
        return $this->redirect()->toRoute('zfcadmin/menus');
    }
    
    // View menu items action
    public function viewItemsAction(){
        $id = (int) $this->params()->fromRoute('id');
        if ($id !=0){
            $menu = $this->getMenuModel()->getMenu($id);
            $menuItems = $this->getMenuItemModel()->getMenuItems($id);
            return array(
                'menu' => $menu,
                'menuItems' => $menuItems,
            );
        }else{
            return $this->redirect()->toRoute('zfcadmin/menus');
        }
    }
     
    // Toggle menu item action
    public function toggleItem($id, $state){
        $menuItemModel = $this->getMenuItemModel();
        $menuItemModel->edit($id, array('menuitemVisible' => $state));
    }
    
    public function toggleVisibleAction(){
        $request = $this->getRequest()->getPost();
        $action = $request->action;
        $id = $request->id;
        
        if ($action == "show")
            $state = "1";
        else
            $state = "0";
        $this->toggleItem($id, $state);
        exit;
    }
    
    // Add menu item action 
    public function addItemAction(){
        $id = (int) $this->params()->fromRoute('id');
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            $parentId = $post->menuitem_parent_id;
            if ($parentId == $id){
                $parentId = 0;
            }
            
            $menuitemForm = new MenuitemForm($this->getServiceLocator(), $id, $parentId);
            
            $menuitemForm->setData($post);
            $menuitemModel = $this->getMenuItemModel();
            if($menuitemForm->isValid()) {
                $weight = (int)$post->menuitem_weight;
                $childMenus = $menuitemModel->getChildMenu($id, $parentId);
                foreach($childMenus as $child){
                    if ((int)$child["menuitem_weight"] > $weight){
                        $menuitemModel->edit($child["menuitem_id"], array('menuitemWeight' => (int)$child["menuitem_weight"] + 1));
                    }
                }
                $menuitemModel->addMenuItem($menuitemForm->getData());
                return $this->redirect()->toRoute('zfcadmin/menus', array('action'=>'viewItems', 'id'=>$id));
            }
        }else{
            $menuitemForm = new MenuitemForm($this->getServiceLocator(), $id, 0);
        }
        $this->layout()->heading = 'Add Menu Item';
        return array(
            'menuitemForm'  => $menuitemForm,
            'id' => $id,
        );
    }
    
    //Delete menu item action
    public function deleteItemAction() {
        $id = (int) $this->params()->fromRoute('id');
        $menuitemModel = $this->getMenuItemModel();
        if($id != 0) {
            $menuitem = $menuitemModel->get($id);
            $menuId = $menuitem->getMenuitemMenuId();
            $childMenus = $menuitemModel->getChildMenu($menuId, $menuitem->getMenuitemParentId());
            $weight = (int)$menuitem->getMenuitemWeight();
            foreach($childMenus as $child){
                if ((int)$child["menuitem_weight"] > $weight){
                    $menuitemModel->edit($child["menuitem_id"], array('menuitemWeight' => (int)$child["menuitem_weight"] - 1));
                }
            }
            $menuitemModel->delete($id);
            
            return $this->redirect()->toRoute('zfcadmin/menus', array('action'=>'viewItems', 'id' => $menuId));
        }
        return $this->redirect()->toRoute('zfcadmin/menus');
    }
    
    // Ajax get menu order action
    public function getMenuOrderAction(){
        $request = $this->getRequest()->getPost();
        $id = $request->id;
        $menuid = $request->menuid;
        
        if ($id == $menuid){
            $id = "0";
        }
        
        $subMenus = $this->getMenuitemModel()->getChildMenu($menuid, $id);
        $orderOptionStr = "<option value='-1'>First Order</option>";
        foreach($subMenus as $menus){
            $orderOptionStr = $orderOptionStr."<option value='".$menus["menuitem_weight"]."'>After ".$menus["menuitem_label"]."</option>";
        }
        echo $orderOptionStr;
        exit;
    }
    
    // Edit menu item action
    public function editItemAction(){
        $id = (int) $this->params()->fromRoute('id');
        $menuitemModel = $this->getMenuItemModel();
        if($id == 0) {
            return $this->redirect()->toRoute('zfcadmin/menus');
        }
        
        $menuitem = $menuitemModel->getMenuItem($id);

        if (!$menuitem){
            return $this->redirect()->toRoute('zfcadmin/menus');
        }
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();

            $menuid = $menuitem["menuitem_menu_id"];
            if ($post["menuitem_parent_id"] == $menuitem["menuitem_parent_id"]){
                $childMenus = $menuitemModel->getChildMenu($menuid, $menuitem["menuitem_parent_id"]);
                if ($post["menuitem_weight"] > $menuitem["menuitem_weight"]){
                    foreach($childMenus as $menu){
                        if ($menu["menuitem_weight"] > $menuitem["menuitem_weight"] && $menu["menuitem_weight"] <= $post["menuitem_weight"]){
                            $menuitemModel->edit($menu["menuitem_id"], array("menuitemWeight" => (int)$menu["menuitem_weight"] - 1));
                        }
                    }
                    $newWeight = (int)$post["menuitem_weight"];
                }else{
                    foreach($childMenus as $menu){
                        if ($menu["menuitem_weight"] > $post["menuitem_weight"] && $menu["menuitem_weight"] < $menuitem["menuitem_weight"]){
                            $menuitemModel->edit($menu["menuitem_id"], array("menuitemWeight" => (int)$menu["menuitem_weight"] + 1));
                        }
                    }
                    $newWeight = (int)$post["menuitem_weight"] + 1;
                }
                
                $menuitemForm = new MenuitemForm($this->getServiceLocator(), $menuid, $menuitem["menuitem_parent_id"], $id);
                $menuitemForm->setData($post);
                if($menuitemForm->isValid()) {
                    $menuitemModel->editMenuItem($id, $menuitemForm->getData(), $newWeight);
                }
                
                return $this->redirect()->toRoute('zfcadmin/menus', array('action'=>'viewItems', 'id'=>$menuid));
            }else{
                $oldChildMenus = $menuitemModel->getChildMenu($menuid, $menuitem["menuitem_parent_id"]);
                foreach ($oldChildMenus as $oldMenu){
                    if ($oldMenu["menuitem_weight"] > $menuitem["menuitem_weight"]){
                        $menuitemModel->edit($oldMenu["menuitem_id"], array("menuitemWeight" => (int)$oldMenu["menuitem_weight"] - 1));
                    }
                }
                if ($menuid == $post["menuitem_parent_id"])
                    $parentId = 0;
                else
                    $parentId = $post["menuitem_parent_id"];
                $newChildMenus = $menuitemModel->getChildMenu($menuid, $parentId);
                foreach($newChildMenus as $newMenu){
                    if ($newMenu["menuitem_weight"] > $post["menuitem_weight"]){
                        $menuitemModel->edit($newMenu["menuitem_id"], array("menuitemWeight" => (int)$newMenu["menuitem_weight"] + 1));
                    }
                }
                
                $menuitemForm = new MenuitemForm($this->getServiceLocator(), $menuid, $parentId, $id);
                $menuitemForm->setData($post);
                if($menuitemForm->isValid()) {
                    $menuitemModel->editMenuItem($id, $menuitemForm->getData(), (int)$post["menuitem_weight"] + 1);
                }
                return $this->redirect()->toRoute('zfcadmin/menus', array('action'=>'viewItems', 'id'=>$menuid));
            }
        }else{
            $menuitemForm = new MenuitemForm($this->getServiceLocator(), $menuitem["menuitem_menu_id"], $menuitem["menuitem_parent_id"], $id);
            $menuitem["menuitem_weight"] = (int)$menuitem["menuitem_weight"] - 1;
            $menuitemForm->setData($menuitem);
        }
        
        return array(
            'menuitemForm'  => $menuitemForm,
            'id' => $menuitem["menuitem_menu_id"],
            'itemId' => $id,
        );
    }
    
    // Ajax set menu order action
    public function setMenuOrderAction(){
        $request = $this->getRequest()->getPost();
        $menuOrder = $request->itemsOrder;
        $menuItemModel = $this->getMenuItemModel();
        
        foreach ($menuOrder as $inx=>$id){
            $menuitem = $menuItemModel->getMenuItem($id);
            $menuItemModel->editMenuItem($id, $menuitem, $inx);
        }
        exit;
    }
    
    protected function getMenuModel() {
        if(!$this->menuModel) {
            $this->menuModel = $this->getServiceLocator()->get('Admin\Model\MenuModel');
        }
        return $this->menuModel;
    }
    
    protected function getMenuItemModel() {
        if (!$this->menuitemModel){
            $this->menuitemModel = $this->getServiceLocator()->get('Admin\Model\MenuItemModel');
        }
        return $this->menuitemModel;
    }
}
