<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Entity\SlideshowImages;
use Travel\Model\AbstractModel;

class SlideshowImageModel extends AbstractModel {
	protected $entityClass = 'Travel\Entity\SlideshowImages';
    protected $primaryColumn = 'imageId';
    
	function saveImage($data) {
		$slideshowImages = new SlideshowImages();
		
		$slideshowImages->setSlideshowId($data['slideshow_id']);
		$slideshowImages->setImageDesc($data['image_desc']);
		$slideshowImages->setImagePath($data['image_path']);
		$slideshowImages->setThumbPath($data['thumb_path']);
		$slideshowImages->setTitle($data['image_title']);
		$slideshowImages->setCreatedDate($data['created_date']);
		$slideshowImages->setModifiedDate($data['modified_date']);
		
		
		$this->getEntityManager()->persist($slideshowImages);
		$this->getEntityManager()->flush();
		return $slideshowImages->getImageId();	
	}
	
	public function updateImage($id, $data) {
    	$slideshowImages = $this->getEntityManager()->find($this->entityClass, $id);
		
		if($slideshowImages) {
    		$slideshowImages->setTitle($data['title']);
			$slideshowImages->setDiscription($data['discription']);
			$slideshowImages->setLink($data['link']);
			$slideshowImages->setLinktext($data['linktext']);
			
			$this->getEntityManager()->persist($slideshowImages);
			$this->getEntityManager()->flush();
    	}
    }
	
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

	public function deleteImageByName($img_name) {
		$qb = $this->getEntityManager()->createQueryBuilder();
    	$qb->delete('Travel\Entity\SlideshowImages', 'i');
    	$qb->add('where', 'i.imagePath = ?1')
			->setParameter(1, $img_name);
		$query = $qb->getQuery();
    	$query->execute();
    }
    
}