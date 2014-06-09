<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\AmadeusCities;

class AmadeusCitiesModel extends AbstractModel
{   
    public function getList($pageNumber = 1, $limit = 50, $country = null)
	{
		$dql = 'SELECT a FROM CentralDB\Entity\AmadeusCities a';
		
		if($country) {
			$dql .= " WHERE a.countryCode = :country";
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('country', $country)
			  ->setFirstResult(($pageNumber -1) * $limit)
        	  ->setMaxResults($limit);
		
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function getCitiesByCountry($countryCode, $from = 1, $limit = 500)
	{    	
		$dql = 'SELECT a FROM CentralDB\Entity\AmadeusCities a WHERE a.countryCode = :country';
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('country', $countryCode);
		
		if(is_int($from)) {
			$query->setFirstResult($from)
        		  ->setMaxResults($limit);
		}
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}