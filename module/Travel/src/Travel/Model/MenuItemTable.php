<?php
namespace Travel\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
#use Zend\Db\Adapter\Driver\Pdo;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\AbstractSql;

class MenuItemTable
{

    public $tableGateway;

    public function __construct (AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


      public function fetchAll() { $resultSet = $this->tableGateway->select(); return $resultSet; }

      public function getAccommodationAttributes($id)
      {
      	$id  = (int) $id;
      	$resultset = $this->tableGateway->select(array('attr_record_id' => $id,'attr_record_type' => "ACCOMM"));


      	if (!$resultset) {
      	//	throw new \Exception("Could not find row $id");
      		return NULL;
      	}
      	return $resultset;
      }

      public function getItems($menuId)
      {
      	$resultSet = $this->tableGateway->select(array('menuitem_menu_id' => $menuId));

      	$result =  $resultSet->toArray();
      	foreach ($result as $key => $val) {
      		if ($val['menuitem_parent_id'] > 0) {
      			foreach ($result as $k => $v) {
      				if ($v['menuitem_id'] == $val['menuitem_parent_id'])
      					$result[$k]['children'][] = $result[$key];
      			}
      			unset($result[$key]);
      		}
      	}

      	return $result;
      }
}