<?php
namespace Travel\Model;

#use Zend\Db\Adapter\Driver\Pdo;
#use Zend\Db\Adapter\Platform\Mysql;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

class DestinationTable
{

    public $tableGateway;
    public $serviceManager;
    public $table = 'bao_destinations';

    /**
     * @var ServiceLocatorInterface
     */
    public function __construct(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;


    }


    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getDestination($id)
    {
        $id     = (int)$id;
        $rowset = $this->tableGateway->select(array('baodestination_id' => $id));
        $row    = $rowset->current();
        /*if (!$row) {
            throw new \Exception("Could not find row $id");
        }*/
        return $row;
    }


    public function getByUrl($url = null)
    {

        //   	$select = new \Zend\Db\Sql\Select ();

        //	$select->where('baodestination_url', $url);

        $select = new \Zend\Db\Sql\Select ();
        $select->from('bao_destinations');
        $select->where("baodestination_url = '$url'");
        //   echo	$select->getSqlString();


        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet->toArray();
    }


    /* TODO convert to ZF2 - this is still ZF1 */
    public function getDestinationBlock($productType = null, &$route = null, $classification = null, $count = false, $parent = null, $config = false)
    {
        //Added on 2012 April 02 By GN
        $org_productType = $productType;
        $productType     = ($productType == 'ARCHIVES') ? 'EVENT' : $productType;
        //End added on 2012 April 02 By GN
        /*   $serviceManager = Bootstrap::getServiceManager();
           $config = $serviceManager->get('Config');
           $siteType = $config->site->type;
   */
        $siteType = 'single_area';
        // single area || single state
        if ($siteType == 'single_area' || $siteType == 'region' || $siteType == 'area' || $siteType == 'state') {
            /* $select = $this->select()
                     ->setIntegrityCheck(false)
                     ->from(array('d' => $this->_name))
                     ->group('d.baodestination_id')
                     ->where('d.baodestination_disabled < 1')
                     ->where('d.baodestination_deleted < 1')
                     ->order('d.baodestination_name ASC');
 */
            //Deleted on 2012 April 03 By GN
            //$select->where('d.baodestination_type = ?', 'CITY');
            //$select->orWhere('d.baodestination_type = ?', 'AREA' ;
            //End Deleted on 2012 April 03 By GN

            $select = $this->tableGateway->select(array('baodestination_disabled < 1', 'baodestination_deleted < 1'));

            /* TODO make specific routes etc
                        if ($config)
                        {
                            $searchareas = Zend_Registry::get('Custom_Config')->site->searchareas;
                            if ($searchareas == "areas only")
                            {
                                $select->where("d.baodestination_type = 'AREA'");
                            } elseif ($searchareas == "areas and selected cities")
                            {
                                $select->where("d.baodestination_type = 'AREA'");
                                $select->orWhere("d.baodestination_id in (" . Zend_Registry::get('Custom_Config')->site->searchareaids . ")");
                            }
                        } else
                        {
                            $select->where("d.baodestination_type = 'CITY' OR d.baodestination_type = 'AREA'");
                        }*/
            /*
              if ($siteType == 'region')
              {
              }
             */
            /* if ($count)
             {
                 $select->joinRight(array('p' => 'products'), 'd.baodestination_name = p.product_city', array('count' => 'count(p.product_id)'))
                         ->where('p.product_deleted = 0');
             }

             if ($productType)
                 $select->where('p.product_category = ?', $productType);

             if ($classification)
             {
                 $select->joinRight(array('a' => 'product_attributes'), 'p.product_id = a.attr_record_id', array('classification' => 'a.attr_name'))
                         ->where('a.attr_type = ?', "Vertical Classification")
                         ->where('a.attr_code = ?', $classification->attr_code);
                 $route = strtolower($productType) . 'towncateg';
             }
             else
                 $route = strtolower($productType) . 'city';

 */
            //Start Added on 2012 April 03 By GN
            /*    if ($productType == 'EVENT')
                {
                    $select->joinLeft(array('a' => 'product_attributes'), 'p.product_id = a.attr_record_id', array('a.attr_code', 'a.attr_name'))
                            ->where('a.attr_type = ?', "Frequency")
                            ->where('p.product_category = a.attr_record_type');

                    if ($org_productType == 'ARCHIVES')
                        $select->where('a.attr_name < ?', date("Y-m-d"));
                    else
                        $select->where('a.attr_name > ?', date("Y-m-d"));

                    $select->order('p.product_id ASC');
                }*/
            //End Added on 2012 April 03 By GN
        }

        return $select->toArray();
    }
}