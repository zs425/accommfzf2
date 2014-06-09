<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use CentralDB\Entity\Queue;

class QueueModel extends AbstractModel
{   
    protected $entityClass = 'CentralDB\Entity\Queue';
    protected $primaryColumn = 'id';
    
    public function getByQueueName($queue_name, $count = 1)
    {
        $dql = 'SELECT q FROM CentralDB\Entity\Queue q WHERE q.queueName = :queue_name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
    
        $query->setMaxResults($count);
        $query->setFirstResult(0);
        return $query->getResult(Query::HYDRATE_ARRAY);        
    }
	
    public function getAllByQueueName($queue_name)
    {
        $dql = 'SELECT q FROM CentralDB\Entity\Queue q WHERE q.queueName = :queue_name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
        
        return $query->getResult(Query::HYDRATE_ARRAY);        
    }

    public function getTask($queue_name){
        $dql = 'SELECT q FROM CentralDB\Entity\Queue q WHERE q.queueName = :queue_name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
        $query->setMaxResults(1);
        $query->setFirstResult(0);
        
        $result = $query->getOneOrNullResult(Query::HYDRATE_ARRAY);
        if($result) {
            return $result;
        } else {
            return false;
        }        
    }

    public function setTasks(array $messages = NULL, $queue = NULL)
    {
        $outputArray = array();
        if (!(is_array($messages))) {
            throw new \Exception('$messages must be array. You could try function setTask');
        }
        foreach ($messages as $m) {
            $outputArray[$this->setTask($m, $queue)] = $m;
        }
        return $outputArray;

    }

    /**
     * @param null $message
     * @param null $queue
     *
     * @return mixed
     * @throws Exception
     */
    public function setTask($message = NULL, $queue_name = NULL)
    {
        if (!$message) {
            throw new \Exception("Need to include message in setTask request");
        }
        
        $dql = 'SELECT q FROM CentralDB\Entity\Queue q WHERE q.queueName = :queue_name AND q.message = :message';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('queue_name', $queue_name);
        $query->setParameter('message', $message);
        $result = $query->getOneOrNullResult(Query::HYDRATE_ARRAY);
        
        if(!$result) {
            $queue = new Queue();
            $queue->setQueueName($queue_name);
            $queue->setMessage($message);
            $queue->setAdded(new \DateTime());
            
            $this->getCentralEntityManager()->persist($queue);
            $this->getCentralEntityManager()->flush();
            
            return $queue->getId();    
        } else {
            return false;
        }
    }

    public function deleteQueue($id) {
        $queue = $this->getCentralEntityManager()->find($this->entityClass, $id);
        $this->getCentralEntityManager()->remove($queue);
        $this->getCentralEntityManager()->flush();
    }                              
}