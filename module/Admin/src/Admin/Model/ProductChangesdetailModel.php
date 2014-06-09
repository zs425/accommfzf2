<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Model\AbstractModel;
use Travel\Entity\ProductChangesdetail;

/**
 * @author kirill
 * @property \Zend\ServiceManager\ServiceManager    $sm 
 * @property \Doctrine\ORM\EntityManager            $entityManager
 */
class ProductChangesdetailModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\ProductChangesdetail';
    protected $primaryColumn = 'changeId';
    
    public function add($data) {
        $productChangesdetail = new ProductChangesdetail();
        $productChangesdetail->setChangeId($data['changeId']);
        $productChangesdetail->setChangeField($data['changeField']);
        $productChangesdetail->setOldValue($data['oldValue']);
        $productChangesdetail->setNewValue($data['newValue']);
        $this->getEntityManager()->persist($productChangesdetail);
        $this->getEntityManager()->flush();
    }                        
    
    public function getChangedetail($id) {
        $product = $this->getEntityManager()->getRepository('Travel\Entity\ProductChangesdetail')->findBy(array('changeId'=>$id));
        return $product;
    }

}