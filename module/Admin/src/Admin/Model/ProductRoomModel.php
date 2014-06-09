<?php
namespace Admin\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Travel\Entity\ProductRoom;

class ProductRoomModel extends AbstractModel
{
	protected $entityClass = 'Travel\Entity\ProductRoom';
    protected $primaryColumn = 'roomId';
	
	public function updRoom($data) {
		$room = $this->getEntityManager()->getRepository('Travel\Entity\ProductRoom')->findBy($data['roomId']);	
		
		if(!$room) {
			$room = new \Travel\Entity\ProductRoom();			
		}
		$room->setByArray($data);		
		$this->getEntityManager()->persist($room);
		$this->getEntityManager()->flush();	
	}
	
}