<?php
namespace Travel\Model;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Model\DestinationModel  $destinationModel
 */
class ProductModel extends AbstractModel
{

    protected $destinationModel;
    protected $entityClass = 'Travel\Entity\Product';
    protected $primaryColumn = 'productId';

    public function getIdsByProvider($provider = 'all')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from($this->entityClass, 'p');
        $qb->leftJoin('p.productMultimedia', 'm');
        $where = $qb->expr()->andX();
        if ($provider != 'all') {
            $where->add($qb->expr()->eq('p.productSource', ':productSource'));
            $qb->setParameter('productSource', $provider);
        }

        $areas   = $this->getDestinationModel()->getSearchAreas();
        $names   = array();
        $areaids = array();
        foreach ($areas as $area) {
            $names[]   = $area->getBaodestinationName();
            $areaIds[] = $area->getBaodestinationId();
        }
        $or = $qb->expr()->orX();
        $or->add($qb->expr()->in('p.productCity', $names));
        $or->add($qb->expr()->in('p.productAreaId', $areaIds));
        $where->add($or);
        $qb->where($where);
        $result = $qb->getQuery()->getArrayResult();
        return $result;
    }

    public function getIdsByProviderAndArea($provider, $area)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p');
        $qb->from($this->entityClass, 'p');
        $qb->leftJoin('p.productMultimedia', 'm');
        $where = $qb->expr()->andX();
        if ($provider != 'all') {
            $where->add($qb->expr()->eq('p.productSource', ':productSource'));
            $qb->setParameter('productSource', $provider);
        }

        $or = $qb->expr()->orX();
        $or->add($qb->expr()->eq('p.productCity', ':baodestinationName'));
        $or->add($qb->expr()->eq('p.productAreaId', ':baodestinationId'));
        $qb->setParameter('baodestinationName', $area['baodestinationName']);
        $qb->setParameter('baodestinationId', $area['baodestinationId']);
        $where->add($or);
        $qb->where($where);
        $result = $qb->getQuery()->getArrayResult();
        return $result;
    }

    public function getEnabledProviders()
    {
        $providers = array();
        $config    = $this->getConfig();
        foreach ($config['providers'] as $providerName => $provider) {
            if ($provider['enable']) {
                $providers[] = $providerName;
            }
        }
        return $providers;
    }

    public function getBySourceIds($ids)
    {
        $dql   = 'SELECT p, m FROM ' . $this->entityClass . ' p LEFT JOIN p.productMultimedia m WHERE p.productSourceId IN(?1) ORDER BY p.productStarRating DESC';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $ids);
        $result = $query->getArrayResult();
        return $result;
    }

    protected function getDestinationModel()
    {
        if (!$this->destinationModel) {
            $this->destinationModel = $this->getServiceManager()->get('Travel\Model\DestinationModel');
        }
        return $this->destinationModel;
    }

}