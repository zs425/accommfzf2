<?php
namespace Travel\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Travel\Entity\Option;

class OptionsModel extends AbstractModel {

	protected $entityClass = 'Travel\Entity\Option';
	protected $primaryColumn = 'option_id';
	
	public function getOptionValue($name, $category) {
		$dql = 'SELECT a.optionValue FROM ' . $this->entityClass . ' a WHERE a.optionName = ?1 AND a.optionCategory = ?2';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter(1, $name);
		$query->setParameter(2, $category);
		$result = $query->getOneOrNullResult();
		return $result['optionValue'];
	}
	
	public function save($key, $value, $category = null)
    {
        $dql = 'SELECT o FROM Travel\Entity\Option o WHERE o.optionName = :key';
        
        if ($category) {
            $dql .= ' AND o.optionCategory = :category';
        }
        
        $query = $this->getEntityManager()->createQuery($dql);
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
        
        $this->getEntityManager()->persist($option);        
        $this->getEntityManager()->flush();
        return;        
    }
    
    public function get($key, $category = null, $default = false)
    {
        $dql = 'SELECT o FROM Travel\Entity\Option o WHERE o.optionName = :key';
        
        if ($category) {
            $dql .= ' AND o.optionCategory = :category';
        }
        
        $query = $this->getEntityManager()->createQuery($dql);
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
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('Travel\Entity\Option', 'o');
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
        $dql = 'SELECT o FROM Travel\Entity\Option o';
        
        if ($category) {
            $dql .= ' WHERE o.optionCategory = :category';
        }
        
        $query = $this->getEntityManager()->createQuery($dql);
        
        if ($category) {
            $query->setParameter('category', $category);
        }
        return $query->getResult(Query::HYDRATE_ARRAY);  
    }

}