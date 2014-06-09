<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use CentralDB\Entity\Website;

class WebsitesModel extends AbstractModel
{
	protected $entityClass = 'CentralDB\Entity\Website';
    protected $primaryColumn = 'websiteId';
	
	public function getWebsiteList()
    {
        $dql = 'SELECT w FROM CentralDB\Entity\Website w';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        return $query->getResult(Query::HYDRATE_ARRAY);
    }
	
	public function addWebsite($data) {
        $website = new Website();
        $website->setByArray($data);
        $this->getCentralEntityManager()->persist($website);
		//$this->getCentralEntityManager()->flush();
		//return $website->getWebsiteId();				        
    }
    
    public function editWebsite($id, $data) {
        $website = $this->getCentralEntityManager()->find($this->entityClass, $id);
        if($website) {
            $website->setByArray($data); 
            $this->getCentralEntityManager()->persist($website);    
        }                
    }
	
    public function getWebsite($id) {
        $website = $this->getCentralEntityManager()->find($this->entityClass, $id);
        return $website->getByArray();
    }
    
    public function deleteWebsite($id) {
        $website = $this->getCentralEntityManager()->find($this->entityClass, $id);
        $this->getCentralEntityManager()->remove($website);        
    }
}