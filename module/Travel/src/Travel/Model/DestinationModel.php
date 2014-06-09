<?php
namespace Travel\Model;

use Doctrine\ORM\AbstractQuery;
use Travel\View\Helper\AtdwClassifications;
use Travel\Entity\BaoDestination;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Model\OptionsModel          $optionsModel
 * @property \CentralDB\Model\DestinationModel   $centralDestinationModel
 * @property \Travel\Model\ProductModel          $productModel;
 */
class DestinationModel extends AbstractModel
{
	protected $entityClass = 'Travel\Entity\BaoDestination';
    protected $primaryColumn = 'baodestinationId';
	
    protected $optionsModel;
    protected $centralDestinationModel;
    protected $productModel;

    public function getSearchAreasOptionValues()
    {
        $dql          = 'SELECT a FROM Travel\Entity\BaoDestination a WHERE a.baodestinationSearchdisabled != 1 ORDER BY a.baodestinationName';
        $query        = $this->getEntityManager()->createQuery($dql);
        $results      = $query->getResult();
        $areas        = array();
        $areas['all'] = $this->getTranslator()->translate('All');
        foreach ($results as $result) {
            $areas[$result->getBaodestinationId()] = $result->getBaodestinationName();
        }
        return $areas;
    }

    public function getSearchAreas()
    {
        $dql   = 'SELECT a FROM Travel\Entity\BaoDestination a WHERE a.baodestinationSearchdisabled != 1 ORDER BY a.baodestinationName';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function getRoamfreeAreasArray()
    {
        $dql   = 'SELECT b FROM Travel\Entity\Baodestination b WHERE b.baodestinationSource = :source AND b.baodestinationSearchdisabled != 1';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(':source', 'roamfree');
        $areas  = $query->getResult();
        $result = array();
        foreach ($areas as $area) {
            $result[] = $area->getBaodestinationSourceId();
        }
        return $result;
    }

    public function getSearchDestinationIds($area, &$dest)
    {
        if ($area) {
            $dest = $this->getCentralDestinationModel()->getBaoDestinationById($area, AbstractQuery::HYDRATE_ARRAY);

            $idArray = array('roamfree' => array());
            $dest['baodestinationSource'] == 'roamfree' ? $idArray['roamfree'][0] = $dest['baodestinationSourceId'] : '';
            $rawIds = $this->getCentralDestinationModel()->getRawDestinationsByBaoId($area);
            if ($rawIds) {
                foreach ($rawIds as $rawId) {
                    $idArray[$rawId->getRawdestSource()] = $rawId->getRawdestSourceId();
                }
            }
            $result = $idArray;
        }
        else {
            $result = array('roamfree' => array(), 'atdw' => '', 'expedia' => '', 'v3' => '', 'viator' => '');
            $config = $this->getConfig();
            if (in_array($config['site']['type'], array('single_area', 'area'))) {
                $destination        = $this->getCentralDestinationModel()->getAreaBaoDestinations();
                $result['roamfree'] = array($destination['baodestinationSourceId']);

                // @todo destination for multiple area sites
                $result['v3'] = $this->getOptionsModel()->getOptionValue('v3_destination_id', 'search');
            }
            else if ($config['site']['type'] == 'region') {
                $destination        = $this->getCentralDestinationModel()->getRegionBaoDestinations();
                $result['roamfree'] = array($destination['baodestinationSourceId']);

                // @todo destination for multiple area sites
                $result['v3'] = $this->getOptionsModel()->getOptionValue('v3_destination_id', 'search');
            }
        }
        return $result;
    }

    public function getAccommodationCountsInAreas($category, $classification)
    {
        $category       = ($category == 'ARCHIVES') ? 'EVENT' : $category;
        $destinations   = $this->getSearchAreas();
        $areaTypes      = array(
            'AREA',
            'CITY',
        );
        $destinationMap = array();
        $productCounts  = array();
        foreach ($areaTypes as $type) {
            $idMap[$type]         = array();
            $productCounts[$type] = array();
        }

        $destinationReferences = array();

        foreach ($destinations as $row) {
            if (in_array($row->getBaodestinationType(), $areaTypes)) {
                $destinationMap[$row->getBaodestinationType()][] = $row;

                $destinationReferences[$row->getBaodestinationId()]   = $row;
                $destinationReferences[$row->getBaodestinationName()] = $row;
            }
        }

        foreach ($areaTypes as $type) {
            $productCounts[$type] = $this->getAccommodationCountInDestinationType($category, $destinationMap[$type], $type, $classification);
        }

        $result = array();
        foreach ($productCounts as $typeCount) {
            foreach ($typeCount as $destinationCount) {
                $destinationCountNormalized = array_values($destinationCount);
                $result[]                   = array(
                    'baodestination' => $destinationReferences[$destinationCountNormalized[0]],
                    'count'          => $destinationCountNormalized[1],
                );
            }
        }
        usort($result, function ($a, $b) {
            if ($a['baodestination']->getBaodestinationUrl() == $b['baodestination']->getBaodestinationUrl()) {
                return 0;
            }
            return ($a['baodestination']->getBaodestinationUrl() < $b['baodestination']->getBaodestinationUrl()) ? -1 : 1;
        });
        return $result;
    }

    protected function getAccommodationCountInDestinationType($category, $destinationArray, $baodestinationType, $classification)
    {
        if ($baodestinationType == 'AREA') {
            $field = 'productAreaId';
            $ids   = array();
            foreach ($destinationArray as $destination) {
                $ids[] = $destination->getBaodestinationId();
            }
        }
        else if ($baodestinationType == 'CITY') {
            $field = 'productCity';
            $ids   = array();
            foreach ($destinationArray as $destination) {
                $ids[] = $destination->getBaodestinationName();
            }
        }
        else {
            throw new \Exception('Unexpected baodestination type: ' . $baodestinationType);
        }
        $enabledProviders = $this->getProductModel()->getEnabledProviders();
        $dql              = "SELECT p.$field, count(p.productId) FROM Travel\Entity\Product p ";
		if($classification){
			$dql .= "JOIN Travel\Entity\ProductAttribute a WITH p.productId = a.attrRecordId ";
		}
		$dql .= "WHERE p.$field IN (?1) AND p.productDeleted != 1 AND p.productSource IN (?2) AND p.productCategory = ?3 ";
		if($classification){
			$dql .= "AND a.attrType = ?4 AND a.attrCode = ?5 ";
		}
		$dql .= " GROUP BY p.$field";
        $query            = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $ids);
        $query->setParameter(2, $enabledProviders);
        $query->setParameter(3, $category);
		if($classification){
			$query->setParameter(4, "Vertical Classification");
			$query->setParameter(5, $classification->attr_code);
		}
        return $query->getResult();
    }

    public function getAccommodationBreadcrumbs($category, $destination, $classification)
    {
        $breadcrumbs   = array();
        $config        = $this->getConfig();
        $breadcrumbs[] = array(
            'label'      => $config['accomm']['sitename'],
            'route'      => 'home',
            'parameters' => array(),
        );
        $route         = null;
        if ($category == 'ACCOMM') {
            $breadcrumbs[] = array(
                'label'      => $this->getTranslator()->translate('Accommodation'),
                'route'      => 'accommodationhome',
                'parameters' => array(),
            );
        }
        else if ($category == 'ATTRACTION') {
            $breadcrumbs[] = array(
                'label'      => $this->getTranslator()->translate('Attractions'),
                'route'      => 'attractionshome',
                'parameters' => array(),
            );
        }
		if ($classification != null){
			if ($category == 'ACCOMM') {
				$breadcrumbs[] = array(
	                'label' => 'Category: ' . $classification->attr_name,
	                'route' => 'accommcategory',
	                'parameters' => array('classification' => AtdwClassifications::$aliases[$classification->attr_code]),                
	            );
			} else if ($category == 'ATTRACTION') {
				$breadcrumbs[] = array(
	                'label' => 'Category: ' . $classification->attr_name,
	                'route' => 'attractioncategory',
	                'parameters' => array('classification' => AtdwClassifications::$aliases[$classification->attr_code]),                
	            );
			} else {
				$breadcrumbs[] = array(
	                'label' => 'Category: ' . $classification->attr_name,	                              
	            );
			}
		}
        if ($destination != null) {
            $breadcrumbs[] = array(
                'label' => $destination[0]['baodestination_name'],
            );
        }
		
        return $breadcrumbs;
    }

	public function addIfNotExists($data)
	{
		$dql = 'SELECT d FROM Travel\Entity\BaoDestination d WHERE 1 = 1 ';
		
		foreach($data as $key => $val) {
			$dql .= ' AND d.' . $key . ' = :' . $key;  
		}
		
		$query = $this->getEntityManager()->createQuery($dql);
		
		foreach($data as $key => $val) {
			$data[$key] = $val = str_replace("\r\n",' ', $val);
			$query->setParameter($key, $val);	
		}
		
		$record = $query->getOneOrNullResult();
		
		if($record) {
			return $record->getBaodestinationId();
		}
		
		$record = new BaoDestination();
		$record->setByArray($data);
		$this->getEntityManager()->persist($record);
		$this->getEntityManager()->flush();
		
		return $record->getBaodestinationId(); 
	}

	public function getDestinationsOfAreaByArray()
    {
        $dql   = 'SELECT a FROM Travel\Entity\BaoDestination a WHERE a.baodestinationSearchdisabled != 1 ORDER BY a.baodestinationName';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    protected function getCentralDestinationModel()
    {
        if (!$this->centralDestinationModel) {
            $this->centralDestinationModel = $this->getServiceManager()->get('CentralDb\Model\DestinationModel');
        }
        return $this->centralDestinationModel;
    }

    protected function getOptionsModel()
    {
        if (!$this->optionsModel) {
            $this->optionsModel = $this->getServiceManager()->get('Travel\Model\OptionsModel');
        }
        return $this->optionsModel;
    }

    protected function getProductModel()
    {
        if (!$this->productModel) {
            $this->productModel = $this->getServiceManager()->get('Travel\Model\ProductModel');
        }
        return $this->productModel;
    }

}