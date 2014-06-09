<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\Destinations;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Travel\Model\DestinationModel as TravelDestinationModel;
use CentralDB\Model\CountryInfoModel;
use Travel\View\Helper\UrlFilter as UrlFilter;

class DestinationModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\Destinations';
    protected $primaryColumn = 'id';
	
	public $destinationModel;
	public $centralDBCountryInfoModel;
	   
    public function getBaoDestinationById($id, $hydrator = AbstractQuery::HYDRATE_OBJECT)
    {
        $dql = 'SELECT b FROM CentralDB\Entity\BaoDestination b WHERE b.baodestinationId = :id';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('id', $id);
        return $query->getOneOrNullResult($hydrator);
    }
    
    public function getRawDestinationsByBaoId($baoId)
    {
        $dql = 'SELECT a FROM CentralDB\Entity\RawDestination a WHERE a.rawdestBaoId = :rawdestBaoId';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('rawdestBaoId', $baoId);
        return $query->getResult();
    }
    
    public function getAreaBaoDestinations()
    {
        $dql = 'SELECT a.baodestinationSourceId FROM CentralDB\Entity\BaoDestination a WHERE (a.baodestinationType = ?1 OR a.baodestinationType = ?2) AND a.baodestinationSource = ?3';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter(1, 'AREA');
        $query->setParameter(2, 'REGION');
        $query->setParameter(3, 'roamfree');
        $query->setMaxResults(1);
        return $query->getOneOrNullResult();
    }
    
    public function getRegionBaoDestinations()
    {
        $dql = 'SELECT a.baodestinationSourceId FROM CentralDB\Entity\BaoDestination a WHERE a.baodestinationType = ?1 AND a.baodestinationSource = ?2';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter(1, 'REGION');
        $query->setParameter(2, 'roamfree');
        $query->setMaxResults(1);
        return $query->getOneOrNullResult();
    }
    
    public function saveToDestinationTable($data, $variables = NULL)
    {
    	if($variables == NULL){
    		$destination = new Destinations();
    	} else {
	        $dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE 1 = 1';
	        
	        foreach($variables as $key){
	            $dql .= " AND d." . $key . "= :" . $key;
	        }
	        
	        $query = $this->getCentralEntityManager()->createQuery($dql);
	        
	        foreach($variables as $key){
	            $query->setParameter($key, $data[$key]);
	        }
	                                    
	        if(!$destination = $query->getOneOrNullResult()) {
	            $destination = new Destinations();            
	        }            
		}
		
        $destination->setByArray($data);
        $this->getCentralEntityManager()->persist($destination);        
        $this->getCentralEntityManager()->flush();
        return $destination->getId();        
    } 
    
    public function getDestinationByGeonamesId($id)
    {          
        $dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE d.geonamesId = :id';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('id', $id);
		$query->setMaxResults(1);
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }
	
	public function getNoParent()
    {
        $dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE d.parentId IS NULL';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
		
    public function setParentId($id)
    {
    	$destination = $this->getCentralEntityManager()->getRepository('CentralDB\Entity\Destinations')->findOneBy(array('id' => $id));
        if($parent =  $this->getCentralEntityManager()->getRepository('CentralDB\Entity\Destinations')->findOneBy(array('geonamesId' => $destination->getGeonamesParent()))) {
        	$destination->setParentId($parent->getId());
			$this->getCentralEntityManager()->persist($destination);        
        	$this->getCentralEntityManager()->flush();	
			return array('name' => $destination->getName(), 'parent' => $parent->getName());
        } else {
        	return array('name' => $destination->getName(), 'parent' => false);
        }
    }
	
	public function getRecordsWithChildren()
	{
		$dql = 'SELECT d1 FROM CentralDB\Entity\Destinations d1 JOIN CentralDB\Entity\Destinations d2 WITH d1.id = d2.parentId WHERE d2.parentId IS NOT NULL AND d1.children IS NULL GROUP BY d1 ORDER BY d1.id ASC ';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
    
	public function getChildIds($id)
	{
		$array = array();
		
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE d.parentId = :id';
        $query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
        $rows = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
		
		foreach($rows as $id){
			$array[] = $id['id'];
		}
		return serialize($array);
	}
	
	public function getAllDestinations()
	{
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d';
        $query = $this->getCentralEntityManager()->createQuery($dql);
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function getDestinations($data)
	{
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE 1 = 1 ';
		foreach($data as $key => $val) {
			if(is_null($val)) {
				$dql .= "AND d.$key IS NULL ";	
			} else if ($val == 'IS NOT NULL') {
				$dql .= "AND d.$key IS NOT NULL ";
			} else {
				$dql .= "AND d.$key = :$key ";
			}
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		foreach($data as $key => $val) {
			if(!is_null($val) && $val != 'IS NOT NULL') {
				$query->setParameter($key, $val);
			}
		}
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function find($id)
	{
		$destination = $this->getCentralEntityManager()->find($this->entityClass, $id);
		if($destination) {
			return $destination->getByArray();
		} else {
			return false;
		}
	}
	
	public function matchLocation($array)
    {
    	$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE 1 = 1';
		foreach($array as $key => $val) {
			if(is_null($val)) {
				$dql .= " AND d.$key IS NULL ";	
			} else if ($val == 'IS NOT NULL') {
				$dql .= " AND d.$key IS NOT NULL ";
			} else {
				$dql .= " AND d.$key = :$key ";
			}			
		}
        $query = $this->getCentralEntityManager()->createQuery($dql);
		foreach($array as $key => $val) {
			if(!is_null($val) && $val != 'IS NOT NULL') {
				$query->setParameter($key, $val);
			}		
		}
        
        $result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
		
		/*if(!count($result) && array_key_exists('name', $array)) {
			$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE d.name = :name';
			$query = $this->getCentralEntityManager()->createQuery($dql);
			$query->setParameter("name", $array['name']);
			$result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
			if(count($result) == 1) {
				return $result[0];
			}
		}*/
		
		return $result;
    }
	
	public function matchByNameStateRegion($name = null, $stateName = null, $regionName = null)
	{
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE 1 = 1';
		if($name) {
			$dql .= " AND d.name = :name";
		}
		if($stateName) {
			$dql .= " AND d.stateName = :stateName";
		}
		if($regionName) {
			$dql .= " AND d.regionName = :regionName";
		}
		
        $query = $this->getCentralEntityManager()->createQuery($dql);
		
		if($name) {
			$query->setParameter('name', $name);
		}
		if($stateName) {
			$query->setParameter('stateName', $stateName);			
		}
		if($regionName) {
			$query->setParameter('regionName', $regionName);			
		}
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function getList($name, $id, $searchOption, $perPage = 30, $current_page = 1) {
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE 1=1 ';
		$dql1 = 'SELECT count(d) as destinationCount FROM CentralDB\Entity\Destinations d WHERE 1=1 ';
		 
		if($name) {
			$dql .= " AND LOWER(d.name) LIKE :name";
			$dql1 .= " AND LOWER(d.name) LIKE :name";
		}
		
		if($id) {
			$dql .= " AND d.id LIKE :id";
			$dql1 .= " AND d.id LIKE :id";
		}
		
		switch($searchOption) {
			case "0": // only Unmatched with Geonames Destinations
				$dql .= " AND d.roamfreeId IS NULL";
				$dql1 .= " AND d.roamfreeId IS NULL";
				break;
			case "1": // only matched with Geonames Destinations
				$dql .= " AND d.roamfreeId IS NOT NULL";
				$dql1 .= " AND d.roamfreeId IS NOT NULL";
				break;
			default:
				break;
		}
		
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query1 = $this->getCentralEntityManager()->createQuery($dql1);
		if($name) {
			$query->setParameter('name', "%" . strtolower($name) . "%");
			$query1->setParameter('name', "%" . strtolower($name) . "%");
		}

		if($id) {
			$query->setParameter('id', "%" . $id . "%");
			$query1->setParameter('id', "%" . $id . "%");
		}

		$query->setMaxResults($perPage);
		$query->setFirstResult(($current_page -1) * $perPage);
		/*
		$d2_paginator = new DoctrinePaginator($query);
		$d2_paginator_iter = $d2_paginator->getIterator(); // returns \ArrayIterator object
		$adapter =  new paginatorIterator($d2_paginator_iter);
		
		$zend_paginator = new Paginator($adapter);          
		
		$zend_paginator->setItemCountPerPage($perPage)
		            ->setCurrentPageNumber($current_page);
		return $zend_paginator;*/
		
		$result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
		$count = $query1->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
		 
		return array($result, floor(($count['destinationCount'] - 1) / $perPage) + 1);
    }

	public function importDestinations($type, $ids) {
        $log = '';
        $count = 0;
        
		$dql = 'SELECT d FROM CentralDB\Entity\Destinations d WHERE d.id IN (' . implode(', ', $ids) . ')';
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$dest = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
		
		$urlFilter = new UrlFilter();
		
		if (sizeof($dest) > 0) {
            // children areas/cities
            foreach ($dest as &$d) {
                $count++;
				$country = $this->getCentralDBCountryInfoModel()->find($d['countryId']);
				
                $log .= "Processing {$d['destinationType']} {$d['name']}, {$d['regionName']}, {$d['stateName']}, {$country['name']}" . PHP_EOL;
                $log .= 'Import branch (region/areas/cities)' . PHP_EOL;
				
				$data = array(
								'baodestinationName'		=> $d['name'],
								'baodestinationUrl'			=> $urlFilter->__invoke($d['name']),
								'baodestinationType'		=> $d['destinationType'],
								'baodestinationArea'		=> $d['areaName'],
								'baodestinationRegion'		=> $d['regionName'],
								'baodestinationState'		=> $d['stateName'],
								'baodestinationCountry'		=> $country['isoAlpha2'],
								'baodestinationSource'		=> $d['originalSource'],
								'baodestinationSourceId'	=> $d['id'],
								'baodestinationParentId'	=> $d['parentId'],
								'baodestinationLat'			=> $d['lat'],
								'baodestinationLon'			=> $d['lon']
							);
									
				$this->getDestinationModel()->addIfNotExists($data);
				
                $d['children'] = $this->getDestBranch($d['id']);
                
                foreach ($d['children'] as $child) {
                    $count++;
                    $log .= "Import " . $child['name'] . " - " . $child['destinationType'] . "\n";
					$data = array(
								'baodestinationName'		=> $child['name'],
								'baodestinationUrl'			=> $urlFilter->__invoke($child['name']),
								'baodestinationType'		=> $child['destinationType'],
								'baodestinationArea'		=> $child['areaName'],
								'baodestinationRegion'		=> $child['regionName'],
								'baodestinationState'		=> $child['stateName'],
								'baodestinationCountry'		=> $country['isoAlpha2'],
								'baodestinationSource'		=> $child['originalSource'],
								'baodestinationSourceId'	=> $child['id'],
								'baodestinationParentId'	=> $child['parentId'],
								'baodestinationLat'			=> $child['lat'],
								'baodestinationLon'			=> $child['lon']
							);
                    $this->getDestinationModel()->addIfNotExists($data);
                    if (isset($child['children']) && count($child['children'])) {
                        foreach ($child['children'] as $ch) {
                        	$data = array(
								'baodestinationName'		=> $ch['name'],
								'baodestinationUrl'			=> $urlFilter->__invoke($ch['name']),
								'baodestinationType'		=> $ch['destinationType'],
								'baodestinationArea'		=> $ch['areaName'],
								'baodestinationRegion'		=> $ch['regionName'],
								'baodestinationState'		=> $ch['stateName'],
								'baodestinationCountry'		=> $country['isoAlpha2'],
								'baodestinationSource'		=> $ch['originalSource'],
								'baodestinationSourceId'	=> $ch['id'],
								'baodestinationParentId'	=> $ch['parentId'],
								'baodestinationLat'			=> $ch['lat'],
								'baodestinationLon'			=> $ch['lon']
							);
							
                            $log .= "Import " . $ch['name'] . " - " . $ch['destinationType'] . "\n";
                            $count++;
                            $this->getDestinationModel()->addIfNotExists($data);
                            if ($ch['destinationType'] == 'AREA') {
			                    $e['children'] = $this->getDestBranch($ch['id']);
								
			                    foreach ($e['children'] as $childcity) {
				                    $count++;
									$data = array(
										'baodestinationName'		=> $childcity['name'],
										'baodestinationUrl'			=> $urlFilter->__invoke($childcity['name']),
										'baodestinationType'		=> $childcity['destinationType'],
										'baodestinationArea'		=> $childcity['areaName'],
										'baodestinationRegion'		=> $childcity['regionName'],
										'baodestinationState'		=> $childcity['stateName'],
										'baodestinationCountry'		=> $country['isoAlpha2'],
										'baodestinationSource'		=> $childcity['originalSource'],
										'baodestinationSourceId'	=> $childcity['id'],
										'baodestinationParentId'	=> $childcity['parentId'],
										'baodestinationLat'			=> $childcity['lat'],
										'baodestinationLon'			=> $childcity['lon']
									);
							
				                    $log .= "Import " . $childcity['name'] . " - " . $childcity['destinationType'] . "\n";
				                    $this->getDestinationModel()->addIfNotExists($data);
				                    if (isset($childcity['children']) && count($childcity['children'])) {
				                        foreach ($childcity['children'] as $chc) {
				                            $log .= "Import " . $chc['name'] . " - " . $chc['destinationType'] . "\n";
				                            $count++;
											
											$data = array(
												'baodestinationName'		=> $chc['name'],
												'baodestinationUrl'			=> $urlFilter->__invoke($chc['name']),
												'baodestinationType'		=> $chc['destinationType'],
												'baodestinationArea'		=> $chc['areaName'],
												'baodestinationRegion'		=> $chc['regionName'],
												'baodestinationState'		=> $chc['stateName'],
												'baodestinationCountry'		=> $country['isoAlpha2'],
												'baodestinationSource'		=> $chc['originalSource'],
												'baodestinationSourceId'	=> $chc['id'],
												'baodestinationParentId'	=> $chc['parentId'],
												'baodestinationLat'			=> $chc['lat'],
												'baodestinationLon'			=> $chc['lon']
											);
				                            $this->getDestinationModel()->addIfNotExists($data);
				                        }
									}
								}
							}
                        }
					}
                }
            }
         
            $log .= 'Destination import completed' . PHP_EOL;
        } else {
            throw new Ace_Exception('Please configure site: no destinations to process');
        }
        $array = array('log' => $log, 'records' => $count);
   
        return $array;
    }

	public function getAreaChanges($areaids, $type = NULL, $lastupdateid = NULL) {
    
        $areasimplode = "'" . implode("','", $areaids) . "'";
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('bao_records' => $this->_name))
                ->joinRight(array('changelogs' => 'changelogs'), '  changelogs.record_id = bao_records.baorecord_id')
                ->where('bao_records.baorecord_area_id IN (' . $areasimplode . ')');
        if ($lastupdateid){
            $select->where('changelogs.update_id = ?', $lastupdateid);
        }
        if ($type){
    switch ($type)
    {
        case 'product':
$select->where("changelogs.record_type = 'Product'");
$select->group('changelogs.record_id');

            break;
case 'attribute':
$select->where("changelogs.record_type = 'Product Attribute'");
            break;
        case 'hotelroom':
$select->where("changelogs.record_type = 'Hotel Room'");
            break;
        case 'image':
$select->where("changelogs.record_type = 'Product Image'");
            break;
        
        default:
            break;
    }
            
        }

        return $this->getAdapter()->fetchAll($select);
    }

	public function getDestBranch($id) {
		$destinations = $this->getDestinations(array('parentId' => $id));
        
        foreach ($destinations as &$d) {
            if ($d['destinationType'] != 'CITY') {
                $d['children'] = $this->getDestBranch($d['id']);                
            }
        }
        return $destinations;
    }

	public function getDestinationModel() {
        if(!$this->destinationModel) {
            $this->destinationModel = $this->getServiceManager()->get('Admin\Model\DestinationModel');
        }
        return $this->destinationModel;
    }

	public function getCentralDBCountryInfoModel() {
        if(!$this->centralDBCountryInfoModel) {
            $this->centralDBCountryInfoModel = $this->getServiceManager()->get('CentralDB\Model\CountryInfoModel');
        }
        return $this->centralDBCountryInfoModel;
    }
	
}