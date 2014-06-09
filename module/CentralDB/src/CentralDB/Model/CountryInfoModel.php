<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use CentralDB\Entity\Countryinfo;

class CountryInfoModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\Countryinfo';
    protected $primaryColumn = 'id';

	public function getAllCountries()
	{
		$dql = 'SELECT c FROM CentralDB\Entity\Countryinfo c';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        return $query->getResult(AbstractQuery::HYDRATE_ARRAY);
	}   
	
	public function getByName($name)
	{
		$dql = 'SELECT c FROM CentralDB\Entity\Countryinfo c WHERE c.name = :name';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('name', $name);
        $query->setMaxResults(1);
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
	}
	
	public function save($data)
	{
		if(isset($data['id'])) {
			$countryinfo = $this->getCentralEntityManager()->find($this->entityClass, $data['id']);	
		}
		if(!isset($data['id']) || !$countryinfo) {
			$countryinfo = new CentralDB\Entity\Countryinfo();
		}
		
		$countryinfo->setByArray($data);
		$this->getCentralEntityManager()->persist($countryinfo);
		$this->getCentralEntityManager()->flush();
	}
	
	public function getCountryName($id)
	{
		$countryinfo = $this->getCentralEntityManager()->find($this->entityClass, $id);
		return $countryinfo->getName();
	}
	
	public function findByIsoCode($isoCode)
	{
		$dql = 'SELECT c FROM CentralDB\Entity\Countryinfo c WHERE c.isoAlpha3 = :isoCode';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        $query->setParameter('isoCode', $isoCode);
        $query->setMaxResults(1);
        return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);		
	}
	
	public function find($id)
	{
		$countryinfo = $this->getCentralEntityManager()->find($this->entityClass, $id);
		return $countryinfo->getByArray();
	}
}