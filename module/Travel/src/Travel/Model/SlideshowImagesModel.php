<?php
namespace Travel\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\SlideshowImages;
use Travel\Model\AbstractModel;

class SlideshowImagesModel extends AbstractModel {
 
    protected $entityClass = 'Travel\Entity\SlideshowImages';
    protected $primaryColumn = 'imageId';
    
    function getImagesBySlideshowId($slideshow_id) {
    	$adapter = $this->getDbAdapter();
		$where = new Where();		
        $select = $this->getSql()->select();
        $select->from('slideshow_images')
			   ->where($where);
		
		$where->equalTo('slideshow_id', $slideshow_id);
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
		$result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
		return $result;
	}
	
}