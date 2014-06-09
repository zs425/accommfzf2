<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use CentralDB\Entity\Update;

class UpdatesModel extends AbstractModel
{   
    protected $entityClass = 'CentralDB\Entity\Update';
    protected $primaryColumn = 'updateId';
    
    public function getLatest()
   	{
    	$dql = 'SELECT max(u.update_id) maxId FROM CentralDB\Entity\Update u';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $result = $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
		return ($result)?$result['maxId']:false;
   	}                     
}