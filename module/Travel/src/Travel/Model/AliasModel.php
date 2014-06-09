<?php
namespace Travel\Model;

/**
 * @author n3ziniuka5
 *
 */
class AliasModel extends AbstractModel
{

    public function matchAlias($route)
    {
        $dql   = 'SELECT a.aliasSystem FROM Travel\Entity\Alias a WHERE a.aliasRoute = :aliasRoute';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('aliasRoute', $route);
        $query->setMaxResults(1);
        $result = $query->getOneOrNullResult();
        if ($result) {
            return $result['aliasSystem'];
        }
        return false;
    }

}