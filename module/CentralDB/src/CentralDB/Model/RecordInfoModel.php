<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\RecordInfo;

class RecordInfoModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\RecordInfo';
    protected $primaryColumn = 'recordinfoId';

	public function addIfNotExists($data)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\RecordInfo r WHERE 1 = 1 ';
		
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
			return $record->getRecordinfoId();
		}
		
		$record = new RecordInfo();
		$record->setByArray($data);
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
		return $record->getRecordinfoId(); 
	}
	
	public function getInfo($productId) {
        $dql = 'SELECT r FROM CentralDB\Entity\RecordInfo r WHERE r.recordinfoRecordId = :productId';
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('productId', $productId);
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}