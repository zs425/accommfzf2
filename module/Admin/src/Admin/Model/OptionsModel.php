<?php
namespace Admin\Model;

use Travel\Entity\Option;
use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
/**
 * @author n3ziniuka5
 * 
 */
class OptionsModel extends AbstractModel{
	
	protected $entityClass = 'Travel\Entity\Option';
	protected $primaryColumn = 'optionId';
	
	public function add($data) {
		$option = new Option();
		$option->setOptionName($data['optionName']);
		$option->setOptionValue($data['optionValue']);
		$option->setOptionCategory($data['optionCategory']);
		$this->getEntityManager()->persist($option);
		$this->getEntityManager()->flush();
	}
	
	public function findOneBy($data) {
		return $this->getEntityManager()->getRepository('Travel\Entity\Option')->findOneBy($data);
	}	
	
	public function edit($id, array $data) {
		$option = $this->getEntityManager()->find($this->entityClass, $id);
		
		if($option) {
			$option->setOptionName($data['optionName']);
			$option->setOptionValue($data['optionValue']);
			$option->setOptionCategory($data['optionCategory']);
			$this->getEntityManager()->persist($option);	
			$this->getEntityManager()->flush();
		}
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