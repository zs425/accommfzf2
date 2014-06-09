<?php
namespace Travel\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
#use Zend\Db\Adapter\Driver\Pdo;
#use Zend\Db\Adapter\Platform\Mysql;

class HotelRoomTable
{

    public $tableGateway;

    public function __construct (AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


      public function fetchAll() { $resultSet = $this->tableGateway->select(); return $resultSet; }

      public function getRooms($id)
      {
      	$id  = (int) $id;
      	$resultset = $this->tableGateway->select(array('room_record_id' => $id));

      	if (!$resultset) {
      	//	throw new \Exception("Could not find row $id");
      		return NULL;
      	}
      	return $resultset;
      }
}