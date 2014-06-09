<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\RoamfreeDestinations;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class RoamfreeDestinationsModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\RoamfreeDestinations';
    protected $primaryColumn = 'id';
	
	public function findByRoamfreeId($roamfreeId) {
		$dql = 'SELECT d FROM CentralDB\Entity\RoamfreeDestinations d WHERE d.roamfreeId = :roamfreeId';;
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('roamfreeId', $roamfreeId);
        $query->setMaxResults(1);
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
	}

	public function getList($roamfreeName, $roamfreeId, $searchOption, $perPage = 30, $current_page = 1) {
		$dql = 'SELECT d FROM CentralDB\Entity\RoamfreeDestinations d WHERE 1=1 ';
		
		if($roamfreeName) {
			$dql .= " AND LOWER(d.roamfreeName) LIKE :roamfreeName";
		}
		
		if($roamfreeId) {
			$dql .= " AND d.roamfreeId LIKE :roamfreeId";
		}
		
		switch($searchOption) {
			case "0": // only Unmatched with Geonames Destinations
				$dql .= " AND d.destinationId IS NULL";
				break;
			case "1": // only matched with Geonames Destinations
				$dql .= " AND d.destinationId IS NOT NULL";
				break;
			default:
				break;
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		if($roamfreeName) {
			$query->setParameter('roamfreeName', "%" . strtolower($roamfreeName) . "%");
		}
		
		if($roamfreeId) {
			$query->setParameter('roamfreeId', "%" . $roamfreeId . "%");
		}
		
		$d2_paginator = new DoctrinePaginator($query);
		$d2_paginator_iter = $d2_paginator->getIterator(); // returns \ArrayIterator object
		$adapter =  new paginatorIterator($d2_paginator_iter);
		
		$zend_paginator = new Paginator($adapter);          
		
		$zend_paginator->setItemCountPerPage($perPage)
		            ->setCurrentPageNumber($current_page);
		return $zend_paginator; 
		//return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function getByName($name, $parent = NULL)
    {
    	$dql = 'SELECT d FROM CentralDB\Entity\RoamfreeDestinations d WHERE d.roamfreeName = :name ';
		if($parent) {
			$dql .= " AND d.roamfreeParent = :parent";
		}		
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('name', $name);
		if($parent) {
			$query->setParameter('parent', $parent);
		}
		$query->setMaxResults(1);		
		
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function getChildren($parent)
	{
		$dql = 'SELECT d FROM CentralDB\Entity\RoamfreeDestinations d WHERE d.roamfreeParent = :parent';
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('parent', $parent);
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function save($data, $variables)
	{
		$dql = 'SELECT d FROM CentralDB\Entity\RoamfreeDestinations d WHERE 1 = 1';
        
        foreach($variables as $key){
            $dql .= " AND d." . $key . "= :" . $key;
        }
        
        $query = $this->getCentralEntityManager()->createQuery($dql);
        
        foreach($variables as $key){
            $query->setParameter($key, $data[$key]);
        }
                                    
        if(!$destination = $query->getOneOrNullResult()) {
            $destination = new RoamfreeDestinations();            
        }            
        
        $destination->setByArray($data);
        $this->getCentralEntityManager()->persist($destination);        
        $this->getCentralEntityManager()->flush();
        return $destination->getByArray();     
	}
}