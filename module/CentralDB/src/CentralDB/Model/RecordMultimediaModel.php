<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\RecordMultimedia;

class RecordMultimediaModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\RecordMultimedia';
    protected $primaryColumn = 'recordmultimediaId';

	public function addIfNotExists($data)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\RecordMultimedia r WHERE 1 = 1 ';
		
		foreach($data as $key => $val) {
			$dql .= ' AND r.' . $key . ' = :' . $key;  
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		
		foreach($data as $key => $val) {
			$data[$key] = $val = str_replace("\r\n",' ', $val);
			$query->setParameter($key, $val);	
		}
		
		$record = $query->getOneOrNullResult();
		
		if($record) {
			return $record->getRecordmultimediaId();
		}
		
		$record = new RecordMultimedia();
		$record->setByArray($data);
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
		return $record->getRecordmultimediaId(); 
	}
	
	public function getMultimedia($productId, $type = null)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\RecordMultimedia r WHERE r.recordmultimediaRecordId = :productId';
		if($type) {
			$dql .= ' AND r.recordmultimediaRecordType = :type';
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('productId', $productId);
		if($type) {
			$query->setParameter('type', $type);
		}
			
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);		
	}
}