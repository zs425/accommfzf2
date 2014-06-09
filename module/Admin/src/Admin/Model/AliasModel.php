<?php
namespace Admin\Model;

use Travel\Model\AbstractModel;
/**
 * @author n3ziniuka5
 * @property \Zend\ServiceManager\ServiceManager    $sm 
 * @property \Doctrine\ORM\EntityManager			$entityManager
 */
class AliasModel extends AbstractModel {
    
	protected $entityClass = 'Travel\Entity\Alias';
	protected $primaryColumn = 'aliasId';
    
    public function add($data) {
    	$alias = new \Travel\Entity\Alias();
    	$alias->setAliasSystem($data['alias_system']);
    	$alias->setAliasRoute($data['alias_route']);
        $this->getEntityManager()->persist($alias);
    }
    
    public function edit($id, $data) {
    	$alias = $this->get($id);
    	if($alias) {
    		$alias->setAliasSystem($data['alias_system']);
    		$alias->setAliasRoute($data['alias_route']);
    		$this->getEntityManager()->persist($alias);
    	}
    }

}