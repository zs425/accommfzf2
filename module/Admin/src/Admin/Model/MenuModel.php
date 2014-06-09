<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\Menu;
use Travel\Model\AbstractModel;

/**
 * @author Kirill 
 * @property \Admin\Model\MenuModel $menuModel
 */
 
class MenuModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\Menu';
    protected $primaryColumn = 'menuId';
    
    public function getStructureForSelect() {
        $adapter = $this->getDbAdapter();
        $select = $this->getSql()->select();
        $select->from('menus');
        $select->columns(array('menu_id', 'label' => 'menu_title'));
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach($result as &$menu) {
            $menu['options'] = $this->getMainChildrenForSelect($menu['menu_id']);
            array_unshift($menu['options'], array('value' => $menu['menu_id'], 'label' => $menu['label']));
        }
        return $result;
    }
    
    public function getMainChildrenForSelect($menuId) {
        $adapter = $this->getDbAdapter();
        $where = new Where();
        $select = $this->getSql()->select();
        $select->from('menu_items');
        $select->columns(array('value' => 'menuitem_id', 'label' => 'menuitem_label'));
        $select->where($where)
                ->order('menuitem_weight ASC');
        $where->equalTo('menuitem_menu_id', $menuId)
              ->equalTo('menuitem_parent_id', 0);
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
    }
    
    public function getRootItems(){
        $adapter = $this->getDbAdapter();
        $select = $this->getSql()->select();
        $select->from('menus');
        $select->columns(array('menu_id', 'label' => 'menu_title', 'menu_desc' => 'menu_description'));
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $result;
    }
    
    public function addMenu($data) {
        $menu = new Menu();
        $menu->setMenuTitle($data['menu_title']);
        $menu->setMenuDescription($data['menu_description']);
        $this->getEntityManager()->persist($menu);
        $this->getEntityManager()->flush();
    }
    
    public function getMenu($id){
        $where = new Where();
        $adapter = $this->getDbAdapter();
        $select = $this->getSql()->select();
        $select->from('menus');
        $select->columns(array('menu_id', 'menu_title', 'menu_description'))
                ->where($where);
        $where->equalTo('menu_id', $id);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result->current();
    }
    
    public function editMenu($id, $data) {
        $menu = $this->getEntityManager()->find($this->entityClass, $id);
        if($menu) {
            $menu->setMenuTitle($data['menu_title']);
            $menu->setMenuDescription($data['menu_description']);
            $this->getEntityManager()->persist($menu);
            $this->getEntityManager()->flush();
        }
    }
    
}