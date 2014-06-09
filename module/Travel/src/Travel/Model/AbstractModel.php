<?php
namespace Travel\Model;

use AceLibrary\Model\AceModel;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Doctrine\ORM\EntityManager                 $centralEntityManager
 * @property \Zend\Db\Adapter\Adapter                    $dbAdapter
 * @property \Zend\Db\Sql\Sql                            $sql
 */
abstract class AbstractModel extends AceModel
{

    protected $centralEntityManager;
    protected $dbAdapter;
    protected $sql;

    protected function getCentralEntityManager()
    {
        if (!$this->centralEntityManager) {
            $this->centralEntityManager = $this->getServiceManager()->get('doctrine.entitymanager.central');
        }
        return $this->centralEntityManager;
    }

    protected function getDbAdapter()
    {
        if (!$this->dbAdapter) {
            $this->dbAdapter = $this->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        }
        return $this->dbAdapter;
    }

    protected function getSql()
    {
        if (!$this->sql) {
            $this->sql = $this->getServiceManager()->get('AceLibrary\Sql');
        }
        return $this->sql;
    }
}