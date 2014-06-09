<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use CentralDB\Entity\QueueProgress;

class QueueProgressModel extends AbstractModel
{   
    protected $entityClass = 'CentralDB\Entity\QueueProgress';
    protected $primaryColumn = 'Id';
    
    public function getByQueueName($queue_name)
    {
        $dql = 'SELECT p FROM CentralDB\Entity\QueueProgress p WHERE p.queueName = :queue_name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
    
        return $query->getOneOrNullResult(Query::HYDRATE_ARRAY);
    }
    
    public function setQueueProgress($queue_name = NULL, $status = NULL, $total = NULL, $progress = NULL)
    {
        $data = array();
        if (!$queue_name){
            throw new \Exception('Need to have a queue name specified');
        }
        
        $dql = 'SELECT p FROM CentralDB\Entity\QueueProgress p WHERE p.queueName = :queue_name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
                                    
        if(!$queue = $query->getOneOrNullResult()) {
            $queue = new QueueProgress();
            $queue->setQueueName($queue_name);
        }    
        
        if($status) {
            $queue->setStatus($status);
        }
        if($total) {
            $queue->setTotal($total);
        }
        if(isset($progress)) {
            $queue->setProgress($progress);
        }
        
        $this->getCentralEntityManager()->persist($queue);        
        $this->getCentralEntityManager()->flush();
        return $queue->getByArray();
    }
    
    public function save($array) {
    	$queueProgress = $this->getCentralEntityManager()->getRepository('CentralDB\Entity\QueueProgress')->findOneBy(array('id' => $array['id']));
		if(!$queueProgress) {
			$queueProgress = new QueueProgress();	
		}
        
        $queueProgress->setByArray($array);
        $this->getCentralEntityManager()->persist($queueProgress);
		$this->getCentralEntityManager()->flush();
    }

}