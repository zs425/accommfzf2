<?php
namespace Travel\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\Slideshow;
use Travel\Model\AbstractModel;

class SlideshowModel extends AbstractModel {
 
    protected $entityClass = 'Travel\Entity\Slideshow';
    protected $primaryColumn = 'slideshowId';
    
    public function getSlideshowBySlug($slideshow_slug) {
    	$where = new Where();
        $select = $this->getSql()->select();
        $select->from(array('s' => 'slideshows'))              
               ->where($where);
        $where->equalTo('s.slideshow_slug', $slideshow_slug);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
		return $result->current();
    }
	
	public function getSlideshowByUri($slideshow_uri) {
    	$where = new Where();
        $select = $this->getSql()->select();
        $select->from(array('s' => 'slideshows'))              
               ->where($where);
        $where->equalTo('s.slideshow_uri', $slideshow_uri);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		return $result->current();
    }	
	
}