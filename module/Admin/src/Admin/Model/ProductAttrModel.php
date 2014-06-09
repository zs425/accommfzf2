<?php
namespace Travel\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Travel\Entity\ProductAttribute;

class ProductAttrModel extends AbstractModel
{
	protected $entityClass = 'Travel\Entity\ProductAttribute';
    protected $primaryColumn = 'attrId';

	public function remove($attrRecordId)
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('Travel\Entity\RecordAttribute', 'r');
        $qb->add('where', 'r.attrRecordId = :key');
        $qb->setParameter('key', $attrRecordId);
        $query = $qb->getQuery();
        $query->execute();   
	}
	
	public function add($attributes)
    {
        foreach ($attributes as $attr) {
        	$productAttr = new ProductAttribute();
			$productAttr->setByArray(
							            array(
							                'attrType' => $attr['baorecordattrType'],
							                'attrCode' => $attr['baorecordattrCode'],
							                'attrName' => $attr['baorecordattrName'],
							                'attrRecordType' => $attr['baorecordattrRecordType'],
							                'attrRecordId' => $attr['baorecordattrRecordId']
							            ));
										
			$this->getEntityManager()->persist($productAttr);
			$this->getEntityManager()->flush();
		}
    }
}