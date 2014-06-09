<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Travel\Entity\ProductInfo;

class ProductInfoModel extends AbstractModel
{
	protected $entityClass = 'Travel\Entity\ProductInfo';
    protected $primaryColumn = 'infoId';

	public function updInfo($info)
    {
    	$dql = "SELECT r from Travel\Entity\ProductInfo r WHERE r.infoRecordId = :recordinfoRecordId AND r.infoCode = :recordinfoCode";
		$query = $this->getEntityManager()->createQuery($dql);
		
		$query->setParameter("recordinfoRecordId", $info['recordinfoRecordId']);
		$query->setParameter("infoCode", $info['recordinfoCode']);	
		
		
		$record = $query->getResult();
        
        if (!$record) {
        	$record =  new ProductInfo();
        }
		
		$record->setByArray(array(
								'infoCode' => $info['recordinfoCode'],
				                'infoTitle' => $info['recordinfoTitle'],
				                'infoBody' => $info['recordinfoBody'],
				                'infoRecordId' => $info['recordinfoRecordId']
							));
        $this->getEntityManager()->persist($record);
		$this->getEntityManager()->flush();
    }
}