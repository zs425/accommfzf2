<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Travel\Entity\ProductMultimedia;

class ProductMultimediaModel extends AbstractModel
{
	protected $entityClass = 'Travel\Entity\ProductMultimedia';
    protected $primaryColumn = 'multimediaId';
	
	public function remove($multimediaRecordId)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('Travel\Entity\RecordMultimedia', 'r');
        $qb->add('where', 'r.multimedia_record_id = :key');
        $qb->setParameter('key', $multimediaRecordId);
        $query = $qb->getQuery();
        $query->execute();   
	}
	
	public function add($mm) {
        foreach ($mm as $m) {
        	$productMultimedia = new ProductMultimedia();
			$productMultimedia->setByArray(
						array(
			                'multimediaId' => $m['recordmultimediaId'],
			                'multimediaType' => $m['recordmultimediaType'],
			                'multimediaPath' => $m['recordmultimediaPath'],
			                'multimediaDescription' => $m['recordmultimediaDescription'],
			                'multimediaWidth' => $m['recordmultimediaWidth'],
			                'multimediaHeight' => $m['recordmultimediaHeight'],
			                'multimediaSource' => $m['recordmultimediaSource'],
			                'multimediaRecordType' => $m['recordmultimediaRecordType'],
			                'multimediaRecordId' => $m['recordmultimediaRecordId'],
			                'multimediaS3bucket' => $m['recordmultimediaS3bucket']
			            ));
       		$this->getEntityManager()->persist($productMultimedia);
			$this->getEntityManager()->flush();
        }
	}
}