<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\MenuItem;
use Travel\Model\AbstractModel;

/**
 * @author Kirill 
 */
 
class MenuItemModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\MenuItem';
    protected $primaryColumn = 'menuitemId';
    
    public function getMenuItems($menuid){
        $adapter = $this->getDbAdapter();
        $where = new Where();
        $select = $this->getSql()->select();
        $select->from('menu_items');
        $select->where($where)
            ->order('menuitem_weight ASC');
        $where->equalTo('menuitem_menu_id', $menuid);
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        
        foreach ($result as $key=>$val) {
            if ($val['menuitem_parent_id'] > 0){
                foreach ($result as $k => $v) {
                    if ($v['menuitem_id'] == $val['menuitem_parent_id'])
                    $result[$k]['children'][] = $result[$key];
                }
                unset($result[$key]);
            }
        }
        
        return $result;
    }
    
    public function getMenuItem($id){
        $where = new Where();
        $adapter = $this->getDbAdapter();
        $select = $this->getSql()->select();
        $select->from('menu_items');
        $select->where($where);
        $where->equalTo('menuitem_id', $id);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result->current();
    }
    
    public function edit($id, $data) {
        $menuitem = $this->get($id);
        if($menuitem) {
            foreach ($data as $key=>$value){
                $menuitem->set($key, $value);
            }
            $this->getEntityManager()->persist($menuitem);
            $this->getEntityManager()->flush();
        }
    }
    
    public function getChildMenu($menuid, $itemid){
        $adapter = $this->getDbAdapter();
        $where = new Where();
        $select = $this->getSql()->select();
        $select->from('menu_items');
        $select->where($where)
            ->order('menuitem_weight ASC');
        $where->equalTo('menuitem_menu_id', $menuid)
                ->equalTo('menuitem_parent_id', $itemid);
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        
        return $result;
    }
    
    public function addMenuItem($data){
        $menuitem = new MenuItem();
        $menuitem->setMenuitemLabel($data["menuitem_label"]);
        $menuitem->setMenuitemMenuId($data["menuitem_menu_id"]);
        if ($data["menuitem_parent_id"] == $data["menuitem_menu_id"]){
            $data["menuitem_parent_id"] = "0";
        }
        $menuitem->setMenuitemParentId($data["menuitem_parent_id"]);
        $menuitem->setMenuitemType($data["menuitem_type"]);
        $menuitem->setMenuitemTitle($data["menuitem_title"]);
        $menuitem->setMenuitemUri($data["menuitem_uri"]);
        $menuitem->setMenuitemTarget($data["menuitem_target"]);
        $menuitem->setMenuitemVisible($data["menuitem_visible"]);
        $menuitem->setMenuitemWeight((int)$data["menuitem_weight"] + 1);
        $this->getEntityManager()->persist($menuitem);
        $this->getEntityManager()->flush();
    }

    public function editMenuItem($id, $data, $weight){
        $menuitem = $this->get($id);
        if ($menuitem){
            $menuitem->setMenuitemLabel($data["menuitem_label"]);
            $menuitem->setMenuitemMenuId($data["menuitem_menu_id"]);
            if ($data["menuitem_parent_id"] == $data["menuitem_menu_id"]){
                $data["menuitem_parent_id"] = "0";
            }
            $menuitem->setMenuitemParentId($data["menuitem_parent_id"]);
            $menuitem->setMenuitemType($data["menuitem_type"]);
            $menuitem->setMenuitemTitle($data["menuitem_title"]);
            $menuitem->setMenuitemUri($data["menuitem_uri"]);
            $menuitem->setMenuitemTarget($data["menuitem_target"]);
            $menuitem->setMenuitemVisible($data["menuitem_visible"]);
            $menuitem->setMenuitemWeight($weight);
            $this->getEntityManager()->persist($menuitem);
            $this->getEntityManager()->flush();
        }
    }
}