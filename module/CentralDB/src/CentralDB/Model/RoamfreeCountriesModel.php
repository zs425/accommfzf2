<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\RoamfreeCountries;

class RoamfreeCountriesModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\RoamfreeCountries';
    protected $primaryColumn = 'id';
	
	public function findByRoamfreeId($roamfreeId) {
		$dql = 'SELECT c FROM CentralDB\Entity\RoamfreeCountries c WHERE c.roamfreeid = :roamfreeId';;
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('roamfreeId', $roamfreeId);
        $query->setMaxResults(1);
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
	}

	public function getList($pageNumber = 1, $limit = 50, $country = NULL) {
		$dql = 'SELECT c FROM CentralDB\Entity\RoamfreeCountries c';
		
		/*if($country) {
			$dql .= " WHERE c.level = :country";
		}*/
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		//$query->setParameter('country', $country);
		$query->setFirstResult(($pageNumber -1) * $limit)
        	  ->setMaxResults($limit);
		
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function getByName($name)
    {
    	$dql = 'SELECT c FROM CentralDB\Entity\RoamfreeCountries c WHERE c.roamfreename = :name';		
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setMaxResults(1);
		$query->setParameter('name', $name);
		
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function getByIso($isoCode)
    {
        $dql = 'SELECT c FROM CentralDB\Entity\RoamfreeCountries c WHERE c.isocode = :isoCode';		
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setMaxResults(1);
		$query->setParameter('isoCode', $isoCode);
		
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function save($data, $variables)
	{
		$dql = 'SELECT c FROM CentralDB\Entity\RoamfreeCountries c WHERE 1 = 1';
        
        foreach($variables as $key){
            $dql .= " AND c." . $key . "= :" . $key;
        }
        
        $query = $this->getCentralEntityManager()->createQuery($dql);
        
        foreach($variables as $key){
            $query->setParameter($key, $data[$key]);
        }
                                    
        if(!$country = $query->getOneOrNullResult()) {
            $country = new RoamfreeCountries();            
        }            
        
        $country->setByArray($data);
        $this->getCentralEntityManager()->persist($country);        
        $this->getCentralEntityManager()->flush();
        return;     
	}	
}