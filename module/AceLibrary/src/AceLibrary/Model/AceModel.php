<?php
namespace AceLibrary\Model;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * @author n3ziniuka5
 * @property \Zend\ServiceManager\ServiceManager      $serviceManager
 * @property \Doctrine\ORM\EntityManager              $entityManager
 * @property Array                                    $config
 * @property \Zend\I18n\Translator\Translator         $translator
 */
abstract class AceModel implements ServiceManagerAwareInterface
{

    protected $serviceManager;
    protected $entityManager;
    protected $config;
    protected $translator;

    protected $entityClass = null;
    protected $primaryColumn = null;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function get($id)
    {
        if (!$this->entityClass || !$this->primaryColumn) {
            throw new \Exception('Entity class or primary column name is not specified');
        }
        $dql   = "SELECT a FROM {$this->entityClass} a WHERE a.{$this->primaryColumn} = ?1";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $id);
        return $query->getOneOrNullResult();
    }

    public function findOneBy($data)
    {
        return $this->getEntityManager()->getRepository($this->entityClass)->findOneBy($data);
    }

    public function getList()
    {
        $dql   = "SELECT a FROM {$this->entityClass} a ORDER BY a.{$this->primaryColumn} DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function delete($id)
    {
        $this->bulkDelete(array($id));
    }

    public function bulkDelete($ids)
    {
        if (!$this->entityClass || !$this->primaryColumn) {
            throw new \Exception('Entity class or primary column name is not specified');
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete($this->entityClass, 'a');
        $qb->where($qb->expr()->in("a.{$this->primaryColumn}", $ids));
        $query = $qb->getQuery();
        $query->execute();
    }

    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = $this->getServiceManager()->get('config');
        }
        return $this->config;
    }

    protected function getTranslator()
    {
        if (!$this->translator) {
            $this->translator = $this->getServiceManager()->get('translator');
        }
        return $this->translator;
    }

}