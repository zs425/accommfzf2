<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Model\AbstractModel;
use Travel\Entity\ProductChanges;

/**
 * @author kirill
 * @property \Zend\ServiceManager\ServiceManager    $sm 
 * @property \Doctrine\ORM\EntityManager            $entityManager
 */
class ProductChangesModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\ProductChanges';
    protected $primaryColumn = 'changeId';
    
    public function add($data) {
        $productChanges = new ProductChanges();
        $productChanges->setProductId($data['productId']);
        $productChanges->setChangeDate($data['changeDate']);
        $productChanges->setChangeBack($data['changeBack']);
        $admin = $this->getEntityManager()->getRepository('Travel\Entity\User')->findOneBy(array('userId'=>$data['adminId']));
        $productChanges->setAdminId($admin);
        $this->getEntityManager()->persist($productChanges);      
        $this->getEntityManager()->flush();
        return $productChanges->getChangeId();
    }                        
    
    public function getChanges($product_id) {
        $changeLog = $this->getEntityManager()->getRepository('Travel\Entity\ProductChanges')->findBy(array('productId'=>$product_id), array('changeDate' => 'DESC'));
        return $changeLog;
    }
    
    public function getChangeById($change_id){
        $changeLog = $this->getEntityManager()->getRepository('Travel\Entity\ProductChanges')->findOneBy(array('changeId'=>$change_id));
        return $changeLog;
    }

}