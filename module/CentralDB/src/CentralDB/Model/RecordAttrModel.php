<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\RecordAttribute;

class RecordAttrModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\RecordAttribute';
    protected $primaryColumn = 'baorecordattrId';

	public function addIfNotExists($data)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\RecordAttribute r WHERE 1 = 1 ';
		
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
			return $record->getBaorecordattrId();
		}
		
		$record = new RecordAttribute();
		$record->setByArray($data);
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
		return $record->getBaorecordattrId(); 
	}
	
	public function getAttributes($productId, $type = null, $attrType = null)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\RecordAttribute r WHERE r.baorecordattrRecordId = :productId';
		if($type) {
			$dql .= ' AND r.baorecordattrRecordType = :type';
		}
		if($attrType) {
			$dql .= ' AND r.baorecordattrType = :attrType';
		}
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('productId', $productId);
		if($type) {
			$query->setParameter('type', $type);
		}
		if($attrType) {
			$query->setParameter('attrType', $attrType);
		}	
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);		
	}	
	
}