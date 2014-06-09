<?php

namespace Travel\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
// se Zend\Db\Adapter\Driver\Pdo;
// se Zend\Db\Adapter\Platform\Mysql;
use Zend\Db\Sql\Select, Zend\Db\ResultSet\ResultSet, Zend\Db\Sql\Expression;

class AttributeTable {
	public $tableGateway;
	public function __construct(AbstractTableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getAccommodationAttributes($id) {
		$id = ( int ) $id;
		$resultset = $this->tableGateway->select ( array (
				'attr_record_id' => $id,
				'attr_record_type' => "ACCOMM"
		) );

		if (! $resultset) {
			// throw new \Exception("Could not find row $id");
			return NULL;
		}
		return $resultset;
	}
	public function getList($type, $productType, $destination = NULL) {
		$select = new \Zend\Db\Sql\Select ();
		$select->from ( 'product_attributes' );

		$select->join ( 'products', "products.product_id = product_attributes.attr_record_id",
				array ("count" => new Expression ( 'COUNT(products.product_id)' ), "*"), 'right' );
		$select->join ( 'bao_destinations', 'bao_destinations.baodestination_name = products.product_city', array ('*'), 'left' );
		$select->where ( 'bao_destinations.baodestination_disabled <> 1' );
		// ->joinLeft(array('b' => 'bao_destinations'), 'b.baodestination_name = p.product_city', array())
		$select->order ( array (
				'attr_name ASC'
		) );
		$select->group ( 'attr_code' );

		if ($type) {
			if (! is_array ( $type ))
				$type = array (
						$type
				);
			$whereType = '(attr_type = "' . implode ( '" OR attr_type = "', $type ) . '")';
			$select->where ( $whereType );
		}

		if ($productType)
			$select->where ( "attr_record_type = '$productType'"  );

		if ($destination)
			$select->where ( 'p.product_city = ?', $destination );

		$resultSet = $this->tableGateway->selectWith ( $select );

		return $resultSet;
	}
	
	public function getByCode($code) {
		$resultset = $this->tableGateway->select ( array (
				'attr_code' => $code
		) );
		if (! $resultset) {
			// throw new \Exception("Could not find row $id");
			return NULL;
		}
		return $resultset->current();
	}
}