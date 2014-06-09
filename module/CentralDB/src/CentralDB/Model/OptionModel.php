<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use CentralDB\Entity\Option;

class OptionModel extends AbstractModel
{
    protected $entityClass = 'CentralDB\Entity\Option';
    protected $primaryColumn = 'optionId';
        
    public function save($key, $value, $category = null)
    {
        $dql = 'SELECT o FROM CentralDB\Entity\Option o WHERE o.optionName = :key';
        
        if ($category) {
            $dql .= ' AND o.optionCategory = :category';
        }
        
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('key', $key);
        
        if ($category) {
            $query->setParameter('category', $category);
        }
                                    
        if(!$option = $query->getOneOrNullResult()) {
            $option = new Option();
            $option->setOptionName($key);
        }    
        
        $option->setOptionValue($value);
        
        if($category) {
            $option->setOptionCategory($category);
        }
        
        $this->getCentralEntityManager()->persist($option);        
        $this->getCentralEntityManager()->flush();
        return;        
    }
    
    public function get($key, $category = null, $default = false)
    {
        $dql = 'SELECT o FROM CentralDB\Entity\Option o WHERE o.optionName = :key';
        
        if ($category) {
            $dql .= ' AND o.optionCategory = :category';
        }
        
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('key', $key);
        
        if ($category) {
            $query->setParameter('category', $category);
        }
        $result = $query->getOneOrNullResult(Query::HYDRATE_ARRAY);
        if($result){
            return $result['optionValue'];
        } else {
            return null;
        }
    }
    
    public function remove($key, $category = null)
    {
        $qb = $this->getCentralEntityManager()->createQueryBuilder();
        $qb->delete('CentralDB\Entity\Option', 'o');
        $qb->add('where', 'o.optionName = :key');
        if($category) {
            $qb->andWhere('o.optionCategory = :category');
        }
        $qb->setParameter('key', $key);
        if($category) {
            $qb->setParameter('category', $category);
        }
        $query = $qb->getQuery();
        $query->execute();        
    }

    public function getCategory($category = null)
    {
        $dql = 'SELECT o FROM CentralDB\Entity\Option o';
        
        if ($category) {
            $dql .= ' WHERE o.optionCategory = :category';
        }
        
        $query = $this->getCentralEntityManager()->createQuery($dql);
        
        if ($category) {
            $query->setParameter('category', $category);
        }
        return $query->getResult(Query::HYDRATE_ARRAY);  
    }
}