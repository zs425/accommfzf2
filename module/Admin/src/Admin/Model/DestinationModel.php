<?php
namespace Admin\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Model\AbstractModel;
use Admin\Model\OptionsModel;
use Travel\Entity\BaoDestination;
use Doctrine\ORM\AbstractQuery;

/**
 * @author kirill
 * @property \Zend\ServiceManager\ServiceManager    $sm 
 * @property \Doctrine\ORM\EntityManager            $entityManager
 */
class DestinationModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\BaoDestination';
    protected $primaryColumn = 'baodestinationId';
    
    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->serviceLocator = $sl;
        return $this;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }
    
    public function getList($search){
        $where = new Where();
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_id', 'baodestination_name', 'baodestination_type', 'baodestination_region', 'baodestination_state', 'baodestination_source', 'baodestination_disabled', 'baodestination_searchdisabled'))
                ->from(array('d' => 'bao_destinations'))
                ->where($where);
                
        if (isset($search['bao_id']) && !empty($search['bao_id']))
        {
            $select->where('d.baodestination_id = '.$search['bao_id']);
        } else
        {
            $select->order('d.baodestination_disabled ASC')
                    ->order('d.baodestination_name');
        }
                    
        $searchareas = "areas only";// Get from registry
        if ($searchareas == "areas only"){
            $select->where('d.baodestination_type = "AREA"');
        }else if ($searchareas == "areas and selected cities"){
            $select->where("d.baodestination_type = 'AREA'");
            $select->where("d.baodestination_id in (".$searchareaids.")");
        }
                
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
     
    }
    
    public function getListAll()
    {
        $where = new Where();
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_id', 'baodestination_name', 'baodestination_type', 'baodestination_region', 'baodestination_state', 'baodestination_source', 'baodestination_disabled', 'baodestination_searchdisabled'))
                ->from(array('d' => 'bao_destinations'))
                ->where($where);
        $select->order('d.baodestination_disabled ASC')
            ->order('d.baodestination_name');

        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
    }
    
    public function edit($id, $data) {
        $destination = $this->get($id);
        if($destination) {
            foreach ($data as $key=>$value){
                $destination->set($key, $value);
            }
            $this->getEntityManager()->persist($destination);
        }
    }
    
    public function disableEnableChilds($parentId, array $allDestinations, $newStatus)
    {
        if (isset($allDestinations[$parentId])) {
            foreach ($allDestinations[$parentId] as $dest) {
                $dest->setBaodestinationDisabled($newStatus);
                $this->getEntityManager()->persist($destination);
                $this->disableEnableChilds($dest->getBaodestinationId(), $allDestinations, $newStatus);
            }
        }
    }
    
    public function getDestination($id) {
        $destination = $this->getEntityManager()->getRepository('Travel\Entity\BaoDestination')->findOneBy(array('baodestinationId'=>$id));
        return $destination;
    }
    
    public function getListBy(array $term){
        $destinations = $this->getEntityManager()->getRepository('Travel\Entity\BaoDestination')->findBy($term);
        return $destinations;
    }
    
    public function getDestinations($ids){
        $where = new Where();
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_id', 'baodestination_name', 'baodestination_type', 'baodestination_region', 'baodestination_state', 'baodestination_source', 'baodestination_disabled', 'baodestination_searchdisabled'))
                ->from(array('d' => 'bao_destinations'))
                ->where($where);
        
        $idLists = implode(',', $ids);
        $select->where('d.baodestination_id in ('.$idLists.')');
                        
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
    }
    
    public function getAreas($provider = 'ALL'){
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_id', 'baodestination_name'))
                ->from(array('d' => 'bao_destinations'))
                ->where('d.baodestination_searchdisabled <> 1')
                ->order('d.baodestination_disabled ASC')
                ->order('d.baodestination_name');
                        
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
    }
    
    public function getSearchDestIds(){
        $optionsModel = $this->getServiceLocator()->get('Admin\Model\OptionsModel');
        $result = array('roamfree' => array(), 'atdw' => '', 'expedia' => '', 'hotelscombined' => '', 'v3' => '', 'viator' => '');
        $data = $this->getServiceLocator()->get('config');
        if (in_array($data["site"]["type"], array('single_area', 'area'))){
            $select = $this->getSql()->select();
            $select->columns(array('baodestination_id', 'baodestination_name'))
                   ->from(array('d'=>'bao_destinations'))
                   ->where("d.baodestination_type = 'AREA' or d.baodestination_type = 'REGION' ")
                   ->where("d.baodestination_source = 'roamfree'")
                   ->limit(1);
            $sql = $this->getSql()->getSqlStringForSqlObject($select);
            $result['roamfree'] = $this->getDbAdapter()->query($sql, array())->toArray();
            $result['hotelscombined'] = $optionsModel->get('hc_destination_id', 'search');
            $result['v3'] = $optionsModel->get('v3_destination_id', 'search');
        }
        if ($data["site"]["type"] == 'region'){
            $select = $this->getSql()->select();
            $select->columns(array('baodestination_id', 'baodestination_name'))
                   ->from("d => bao_destination")
                   ->where("d.baodestination_type = 'REGION' ")
                   ->where("d.baodestination_source = 'roamfree'")
                   ->limit(1);
            $sql = $this->getSql()->getSqlStringForSqlObject($select);
            $result['roamfree'] = $this->getDbAdapter()->query($sql, array())->toArray();
            $result['hotelscombined'] = $optionsModel->get('hc_destination_id', 'search');
            $result['v3'] = $optionsModel->get('v3_destination_id', 'search');
        }
        return $result;
    }
    
    public function getIdsFromSourceId($baodestination_source_id, $source)
    {
        $select = $this->getSql()->select();
        $select->columns(array('baodestination_id'))
             ->from("d => bao_destination")
             ->where('d.baodestination_source_id = '.$baodestination_source_id)
             ->where('baodestination_source = '.$source);
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array())->toArray();
        return $result;
     
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
	
	public function fetchAll() {
		$dql = 'SELECT d FROM Travel\Entity\BaoDestination d WHERE 1 = 1 ';
		$query = $this->getEntityManager()->createQuery($dql);
		
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function getArrayOfAreaIds($provider = 'ALL') {
		
		$dql = 'SELECT d FROM Travel\Entity\BaoDestination d WHERE 1 = 1 ';
		$query = $this->getEntityManager()->createQuery($dql);
		$result = $query->getResult(AbstractQuery::HYDRATE_ARRAY);
		$array = array();
		foreach($result as $r) {
			$array[] = $r['baodestinationId'];
		}
		return $array;		
    }
}