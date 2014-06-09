<?php
namespace Admin\Model;

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
    
    public function getSlideshowList() {
        $adapter = $this->getDbAdapter();
        $select = $this->getSql()->select();
        $select->from('slideshows');
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $result;
    }
    
	public function addSlideshow($data) {
    	$slideshow = new Slideshow();
        $slideshow->setSlideshowName($data['slideshow_name']);
		$slideshow->setSlideshowScript($data['slideshow_script']);
		$slideshow->setSlideshowEffect($data['slideshow_effect']);
		$slideshow->setSlideshowWidth($data['slideshow_width']);
		$slideshow->setSlideshowHeight($data['slideshow_height']);		
		$slideshow->setSlideshowDelay($data['slideshow_delay']);
		$slideshow->setSlideshowNavigation($data['slideshow_navigation']);
		$slideshow->setSlideshowSlug($data['slideshow_slug']);
		$slideshow->setSlideshowUri($data['slideshow_uri']);		
		
		$this->getEntityManager()->persist($slideshow);
		$this->getEntityManager()->flush();
		return $slideshow->getSlideshowId();				        
    }
	
	public function getSlideshow($id) {
        $where = new Where();
        $select = $this->getSql()->select();
        $select->from(array('s' => 'slideshows'))              
               ->where($where);
        $where->equalTo('s.slideshow_id', $id);
        $statement = $this->getSql()->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result->current();
    }
	
	public function editSlideshow($id, $data) {
    	$slideshow = $this->getEntityManager()->find($this->entityClass, $id);
    	if($slideshow) {
    		$slideshow->setSlideshowName($data['slideshow_name']);
			$slideshow->setSlideshowScript($data['slideshow_script']);
			$slideshow->setSlideshowEffect($data['slideshow_effect']);
			$slideshow->setSlideshowWidth($data['slideshow_width']);
			$slideshow->setSlideshowHeight($data['slideshow_height']);		
			$slideshow->setSlideshowDelay($data['slideshow_delay']);
			$slideshow->setSlideshowNavigation($data['slideshow_navigation']);
			$slideshow->setSlideshowSlug($data['slideshow_slug']);
			$slideshow->setSlideshowUri($data['slideshow_uri']);
    		
			$this->getEntityManager()->persist($slideshow);			
    	}
    }
	
	public function bulkDelete($ids) {
    	$qb = $this->getEntityManager()->createQueryBuilder();
    	$qb->delete('Travel\Entity\Slideshow', 's');
    	$qb->where($qb->expr()->in('s.slideshowId', $ids));
    	$query = $qb->getQuery();
    	$query->execute();
    }
}