<?php

namespace Travel\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
// se Zend\Db\Adapter\Driver\Pdo;
// se Zend\Db\Adapter\Platform\Mysql;
class MultimediaTable {
	public $tableGateway;
	public function __construct(AbstractTableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function getMultimedia($id) {
		$id = ( int ) $id;
		$resultset = $this->tableGateway->select ( array (
				'multimedia_record_id' => $id
		) );

		if (! $resultset) {
			// throw new \Exception("Could not find row $id");
			return NULL;
		}
		return $resultset;
	}
	public function getProductPhotos($id, $type, $source_id, $limit = NULL) {
		$select = new \Zend\Db\Sql\Select ();
		$select->from ( 'product_multimedia' );
		$select->where ( "multimedia_record_id = '$id'" );
		$select->where ( "multimedia_record_type = '$type'" );
		if ($limit) {
			$select->limit ( $limit );
		}
		$resultSet = $this->tableGateway->selectWith ( $select );
		//echo $select->getSqlString();
		$results = array ($resultSet);
/*
		foreach ( $results[0] as $key => $r ) {
			var_dump($r);
		//	$results [$key] ['fullpath'] = $this->getImagePath ( $r, $source_id );
		//	$results [$key] ['40thumb'] = $this->getImagePath ( $r, $source_id, '40/' );
		//	$results [$key] ['100thumb'] = $this->getImagePath ( $r, $source_id, '100/' );
		}*/
		return $resultSet;
	}

	public function getImagePath($image, $source_id = NULL, $thumbsize = NULL) {
		$path = "";
		$thumb40 = ($thumbsize) ? $thumbsize : '';

		$base = "http://www.bookaccommodationonline.com.au/images/multimedia/" . $thumbsize;
		$s3domain = "http://images.bookaccommodationonline.com.au/" . $thumbsize;
		if ($image[0]['multimedia_s3bucket']) {
			$path .= $s3domain;
		} else {
			$path .= $base;
		}

		$path .= $image ['multimedia_source'] . "/";
		if ($image ['multimedia_source'] == 'roamfree' && $source_id) {
			$path .= $source_id . "/";
		}
		$path .= $image ['multimedia_path'];
		return $path;
	}
	public function toArray() {
		return ( array ) $this;
	}
}