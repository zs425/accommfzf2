<?php
namespace CentralDB\Model;

use Travel\Model\AbstractModel;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;

class WebsiteCategoriesModel extends AbstractModel
{   
    public function getWebsiteCategories()
    {
        $dql = 'SELECT c FROM CentralDB\Entity\Websitecategory c';
        $query = $this->getCentralEntityManager()->createQuery($dql);
        return $query->getResult(Query::HYDRATE_ARRAY);
    }
	
}