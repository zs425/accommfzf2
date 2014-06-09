<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\HotelRoom;

class HotelRoomModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\HotelRoom';
    protected $primaryColumn = 'hotelroomId';

	public function addIfNotExists($data)
	{
		$dql = 'SELECT r FROM CentralDB\Entity\HotelRoom r WHERE 1 = 1 ';
		
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
			return $record->getHotelroomId();
		}
		
		$record = new HotelRoom();
		$record->setByArray($data);
		$this->getCentralEntityManager()->persist($record);
		$this->getCentralEntityManager()->flush();
		return $record->getHotelroomId(); 
	}
	
	public function getRooms($recordId) {
		$dql = 'SELECT r FROM CentralDB\Entity\HotelRoom r WHERE r.hotelroomRecordId = :recordId';
		$query = $this->getCentralEntityManager()->createQuery($dql);
		$query->setParameter('hotelroomRecordId', $recordId);	
		return $query->getResult(AbstractQuery::HYDRATE_ARRAY);		
	}
}