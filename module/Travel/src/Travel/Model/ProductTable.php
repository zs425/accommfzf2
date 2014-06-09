<?php
namespace Travel\Model;

#use Zend\Db\Adapter\Driver\Pdo;
#use Zend\Db\Adapter\Platform\Mysql;

use Zend\Db\TableGateway\AbstractTableGateway;

class ProductTable
{

    public $tableGateway;

    public function __construct(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProduct($id)
    {
        $id     = (int)$id;
        $rowset = $this->tableGateway->select(array('product_id' => $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getList($type, $productType, $destination = null)
    {
        $select = new \Zend\Db\Sql\Select ();
        $select->from('product_attributes');

        $select->join('products', "products.product_id = product_attributes.attr_record_id",
            array("count" => new Expression ('COUNT(products.product_id)'), "*"), 'right');
        $select->join('bao_destinations', 'bao_destinations.baodestination_name = products.product_city', array('*'), 'left');
        $select->where('bao_destinations.baodestination_disabled <> 1');
        // ->joinLeft(array('b' => 'bao_destinations'), 'b.baodestination_name = p.product_city', array())
        $select->order(array(
            'attr_name ASC'
        ));
        $select->group('attr_code');

        if ($type) {
            if (!is_array($type)) {
                $type = array(
                    $type
                );
            }
            $whereType = '(attr_type = "' . implode('" OR attr_type = "', $type) . '")';
            $select->where($whereType);
        }

        if ($productType) {
            $select->where("attr_record_type = '$productType'");
        }

        if ($destination) {
            $select->where('p.product_city = ?', $destination);
        }

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet;
    }


    public function getNewList($category, $page = 1, $destination = null, $classification = null, $enabledProviders = null)
    {
        /* not sure what this does yet */
        $org_category = $category;
        $category     = ($category == 'ARCHIVES') ? 'EVENT' : $category;
        $select       = new \Zend\Db\Sql\Select ();
        $select->from('products');
        //browse by destination
        // if destination selected
        if (isset($destination)) { // if destination given
            if ($destination[0]['baodestination_type'] == 'AREA') { // destination given and = area
                $select->join('bao_destinations', "bao_destinations.baodestination_id = products.product_area_id", "*", 'left');
                $select->where("products.product_region_id = '" . $destination[0]['baodestination_id'] . "' OR products.product_area_id = '" . $destination[0]['baodestination_id'] . "'");
                $select->where('bao_destinations.baodestination_disabled <> 1');
                //->orWhere('p.product_area_id = ?', $destination->baodestination_id);
            }
            else { // destination given and = city
                $select->join('bao_destinations', "bao_destinations.baodestination_name = products.product_city", "*", 'left');
                $select->where("products.product_" . strtolower($destination[0]["baodestination_type"]) . " = '" . $destination[0]["baodestination_name"] . "'");
                $select->where('bao_destinations.baodestination_disabled <> 1');
            }
        }
        else { // if no destination given
            $select->join('bao_destinations', "bao_destinations.baodestination_name = products.product_city", "*", 'left');
        }

        // standard terms
        $select->where("products.product_category =  '$category'");
        $select->where->notEqualTo("products.product_deleted", '1');

        $select->order('products.product_bookable DESC')
            ->order('products.product_name ASC')
            ->order('products.product_source DESC');

        // if enabled providers
        if (null !== $enabledProviders) {
            $select->where->in('products.product_source', $enabledProviders);
        }

        // browse by category
        if (isset($classification)) {
        	$classification = (is_string($classification)) ? $classification : $classification->attr_code;
			$select->join(array('a' => 'product_attributes'), "products.product_id = a.attr_record_id", array('classification' => 'attr_name'), 'right')
                ->where("a.attr_type = 'Vertical Classification'")
                ->where("a.attr_code = '$classification'");
                //->group('p.product_id');
			
			
			
        }
		

// TODO readd this part.
        //Start Added on 2012 April 02 By GN
        /*  	if ($category == 'EVENT')
              {
                  $select->joinLeft(array('a' => 'product_attributes'), 'p.product_id = a.attr_record_id', array('a.attr_code', 'a.attr_name'))
                  ->where('a.attr_type = ?', "Frequency")
                  ->where('p.product_category = a.attr_record_type');

                  if ($org_category == 'ARCHIVES')
                      $select->where('a.attr_name < ?', date("Y-m-d"));
                  else
                      $select->where('a.attr_name > ?', date("Y-m-d"));

                  $select->order('p.product_id ASC');*/
        /*
         $r = $this->fetchAll($select);
        print '<pre>';
        echo count($r);
        //print_r($r->toArray());
        exit;
        */
        //	}


//echo $select->getSqlString();

		//$select->limit(10)
		//		->offset(($page - 1) * 10);
		$resultSet = $this->tableGateway->selectWith($select);
		
        return $resultSet->buffer();  
    }


    /**
     * This is the old one
     * @param string            $category - product_category (ACCOMM/ATTRACTION)
     * @param int               $page
     * @param array             $destination - array of state, area, city (can be NULL)
     * @param Zend_Db_Table_Row $classification - product vertical classification
     */
    public function getOldList($category, $page = 1, $destination = null, $classification = null, $enabledProviders = null)
    {
        //Added on 2012 April 02 By GN
        $org_category = $category;
        $category     = ($category == 'ARCHIVES') ? 'EVENT' : $category;
        //End added on 2012 April 02 By GN

        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('p' => $this->_name));

        //browse by destination
        // if destination selected
        if (isset($destination)) { // if destination given
            if ($destination->baodestination_type == 'AREA') { // destination given and = area
                $select->joinLeft(array('b' => 'bao_destinations'), 'b.baodestination_id = p.product_area_id', array());
                $select->where('p.product_region_id = ? OR p.product_area_id = ?', $destination->baodestination_id);
                $select->where('b.baodestination_disabled <> 1');
                //->orWhere('p.product_area_id = ?', $destination->baodestination_id);
            }
            else { // destination given and = city
                $select->joinLeft(array('b' => 'bao_destinations'), 'b.baodestination_name = p.product_city', array());
                $select->where('p.product_' . strtolower($destination->baodestination_type) . ' = ?', $destination->baodestination_name);
                $select->where('b.baodestination_disabled <> 1');
            }
        }
        else { // if no destination given
            $select->joinLeft(array('b' => 'bao_destinations'), 'b.baodestination_name = p.product_city', array());
        }

        // standard terms
        $select->where('p.product_category = ?', $category)
            ->where('p.product_deleted <> 1')
            ->order('p.product_bookable DESC')
            ->order('p.product_name ASC')->order('p.product_source DESC');

        if (null !== $enabledProviders) {
            $select->where('p.product_source IN (?)', $enabledProviders);
        }

        // browse by category
        if (isset($classification)) {
            $classification = (is_string($classification)) ? $classification : $classification->attr_code;
            $select->joinRight(array('a' => 'product_attributes'), 'p.product_id = a.attr_record_id', array('classification' => 'a.attr_name'))
                ->where('a.attr_type = ?', "Vertical Classification")
                ->where('a.attr_code = ?', $classification)
                ->group('p.product_id');
        }


        //Start Added on 2012 April 02 By GN
        if ($category == 'EVENT') {
            $select->joinLeft(array('a' => 'product_attributes'), 'p.product_id = a.attr_record_id', array('a.attr_code', 'a.attr_name'))
                ->where('a.attr_type = ?', "Frequency")
                ->where('p.product_category = a.attr_record_type');

            if ($org_category == 'ARCHIVES') {
                $select->where('a.attr_name < ?', date("Y-m-d"));
            }
            else {
                $select->where('a.attr_name > ?', date("Y-m-d"));
            }

            $select->order('p.product_id ASC');
            /*
             $r = $this->fetchAll($select);
            print '<pre>';
            echo count($r);
            //print_r($r->toArray());
            exit;
            */
        }
        //End Added on 2012 April 02 By GN


        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbTableSelect($select));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(10);

        return $paginator;
    }
}