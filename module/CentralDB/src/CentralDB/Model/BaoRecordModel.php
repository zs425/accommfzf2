<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\BaoRecord;

class BaoRecordModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\BaoRecord';
    protected $primaryColumn = 'baorecordId';

	public function addIfNotExists($data)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\BaoRecord r WHERE 1 = 1 ';
		
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
			return $record->getBaorecordId();
		}
		
		$record = new BaoRecord();
		$record->setByArray($data);
		
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
		return $record->getBaorecordId(); 
	}
	
	public function save($data)
	{
		if(isset($data['baorecordId'])) {
			$record = $this->getCentralEntityManager()->find($this->entityClass, $data['baorecordId']);	
		}
		if(!isset($data['baorecordId']) || !$record) {
			$record = new CentralDB\Entity\BaoRecord();
		}
		
		$record->setByArray($data);
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
	}
	
	public function getProductIdsByDestinations($destinations, $source = NULL) {
		$dql = 'SELECT r.baorecordId FROM CentralDB\Entity\BaoRecord r WHERE 1 = 1 ';
		
		if($source) {
			$dql .= ' AND r.baorecordSource = :source';
		}
		
		$whereRegArea = array();
        $whereCity = array();
		$valueArray = array();
		$index = 0;
		
		foreach ($destinations as $dest) {
			if (in_array($dest['baodestinationType'], array('REGION', 'AREA'))) {
				$index++;
                $fieldname = 'r.baorecord' . ucfirst(strtolower($dest['baodestinationType']));
                $whereRegArea[] = $fieldname . ' = ?' . $index;
				$valueArray[$index] = $dest['baodestinationName'];    
			} elseif ($dest['baodestinationType'] == 'CITY') {
            
            	$index++;
				$where1 = '(r.baorecordCity = ?' . $index;
				$valueArray[$index] = $dest['baodestinationName'];
				
				$index++;
				$where2 =  ' AND r.baorecordState = ?' . $index . ')';
				$valueArray[$index] = $dest['baodestinationState'];
				
				$whereCity[] = $where1 . $where2;                
            }
        }
		
		$dql .= ' AND (' . implode(' OR ', array_merge($whereRegArea, $whereCity)) . ')';
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		if($source) {
			$query->setParameter('source', $source);
		}
						
		foreach($valueArray as $key => $val) {
			$query->setParameter($key, $val);
		}
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);		
    }

	public function getProducts($ids){
        $idsimplode = "'" . implode("','", $ids) . "'";
		
		$dql = "SELECT r FROM CentralDB\Entity\BaoRecord r WHERE r.baorecordId IN (" . $idsimplode . ")";
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
}