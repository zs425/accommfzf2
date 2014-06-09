<?php
namespace Admin\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\ResultSet\ResultSet;
use Travel\Model\AbstractModel;
use Admin\Model\ProductRoomModel;
use Admin\Model\ProductInfoModel;
use Admin\Model\ProductAttrModel;
use Admin\Model\ProductMultimedaiModel; 
use CentralDB\Model\HotelRoomModel;
use CentralDB\Model\RecordInfoModel;
use CentralDB\Model\RecordAttrModel;
use CentralDB\Model\RecordMultimediaModel;

/**
 * @author kirill
 * @property \Zend\ServiceManager\ServiceManager    $sm 
 * @property \Doctrine\ORM\EntityManager            $entityManager
 */
class ProductModel extends AbstractModel {
    
    protected $entityClass = 'Travel\Entity\Product';
    protected $primaryColumn = 'productId';
	
	public $centralDBHotelRoomModel;
	public $centralDBRecordInfoModel;
	public $centralDBRecordAttrModel;
	public $centralDBRecordMultimediaModel;
	
	public $productAttrModel;
	public $productInfoModel;
	public $productMultimedaiModel;
	public $productRoomModel;
    
    public function add($data) {
        $product = new \Travel\Entity\Product();
        $this->getEntityManager()->persist($data);      
    }                        
    
    public function search($search){
        if (isset($search['baodestination_id']) && !empty($search['baodestination_id'])){
            // Get Bao Destination Id
        }
        $where = new Where();
        $select = $this->getSql()->select();
        $select->columns(array('product_id', 'product_name', 'product_source', 'product_category', 'product_state', 'product_region', 'product_city', 'product_deleted'))
                ->from(array('p' => 'products'))
                ->where($where);
        if (isset($search['bao_id']) && !empty($search['bao_id']))
        {
            $select->where('p.product_id = '. $search['bao_id']);
        }else{
            if (isset($search['category']) && ($search['category'] != 'ALL'))
                $select->where('p.product_category = "'. $search['category']. '"');
            if (isset($search['source']) && ($search['source'] != 'ALL'))
                $select->where('p.product_source = "'. $search['source']. '"');
            if (isset($search['keyword']) && strlen($search['keyword']) >= 3)
                $select->where('p.product_name LIKE "%'. $search['keyword'] . '%"');
            if (isset($search['deleted']) && $search['deleted'] != 'ALL' && $search['deleted'] != '')
                $select->where('p.product_deleted = ' . $search['deleted']);
            if (isset($search['order']) && !empty($search['order']))
                $select->order('p.' . $search['order']);
            $select->order('p.product_name');      
        }
        
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
    }
    
    public function edit($id, $data) {
        $product = $this->get($id);
        if($product) {
            foreach ($data as $key=>$value){
                $product->set($key, $value);
            }
            $this->getEntityManager()->persist($product);
        }
    }
    
    public function save($product) {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }
    
    public function deleteBy($where){
        $delete = $this->getSql()->delete();
        $delete->from('products')->where($where);
        
        $statement = $this->getSql()->prepareStatementForSqlObject($delete);
        $results = $statement->execute();
    }
    
    public function getProductsBy($term = null){
        if ($term == null){
            $products = $this->getEntityManager()->getRepository('Travel\Entity\Product')->findAll();
        }else{
            $products = $this->getEntityManager()->getRepository('Travel\Entity\Product')->findBy($term);
        }
        return $products;
    }
    
    public function getProduct($id) {
        $product = $this->getEntityManager()->getRepository('Travel\Entity\Product')->findOneBy(array('productId'=>$id));
        return $product;
    }
    
    public function getOrphans($destids, $search, $provider = 'all'){
        $where = new Where();
        $select = $this->getSql()->select();
        $select->columns(array('product_id', 'product_name', 'product_source', 'product_category', 'product_state', 'product_region', 'product_city', 'product_deleted'))
                ->from(array('p' => 'products'))
                ->where($where);
        if ($provider != 'all'){
            $select->where('product_source = '.$provider);
        }
        
        if ($search){
            if (isset($search['bao_id']) && !empty($search['bao_id']))
            {
                $select->where('p.product_id = '. $search['bao_id']);
            }else{
                if (isset($search['category']) && !empty($search['category']) && ($search['category'] != 'ALL'))
                    $select->where('p.product_category = "'. $search['category']. '"');
                if (isset($search['source']) && !empty($search['source']) && ($search['source'] != 'ALL'))
                    $select->where('p.product_source = "'. $search['source']. '"');
                if (isset($search['keyword']) && strlen($search['keyword']) >= 3)
                    $select->where('p.product_name LIKE "%'. $search['keyword'] . '%"');
                if (isset($search['deleted']) && $search['deleted'] != 'ALL' && $search['deleted'] != '')
                    $select->where('p.product_deleted = ' . $search['deleted']);
                if (isset($search['order']) && !empty($search['order']))
                    $select->order('p.' . $search['order']);
            }
        }
        
        $select->order('p.product_name');
        
        $names = array();
        $areaids = array();
        
        foreach ($destids as $detail){
            $names[] = $detail->baodestination_name;
            $areaids[] = $detail->baodestination_id;
        }
        
        $namesimplode = "'".implode("','", $names)."'";
        $idsimplode = "'".implode("','", $areaids)."'";
        
        $select->where("product_city NOT IN (".$namesimplode.") AND product_area_id NOT IN (".$idsimplode. ")");
                                
        $sql = $this->getSql()->getSqlStringForSqlObject($select);
        $result = $this->getDbAdapter()->query($sql, array());
        
        return $result;
    }

 	public function updateProducts($products)
    {
        foreach ($products as $product)
        {
            // record
            $row = array(
             	'productId' => $product['baorecord_id'],
                'productName' => $product['baorecordName'],
                'productShortdesc' => $product['baorecordShortdesc'],
                'productDescription' => $product['baorecordDescription'],
                'productCategory' => $product['baorecordCategory'],
                'productSource' => $product['baorecordSource'],
                'productSourceId' => $product['baorecordSourceId'],
                'productCountry' => $product['baorecordCountry'],
                'productState' => $product['baorecordState'],
                'productRegion' => $product['baorecordRegion'],
                'productRegionId' => $product['baorecordRegionId'],
                'productArea' => $product['baorecordArea'],
                'productAreaId' => $product['baorecordAreaId'],
                'productCity' => $product['baorecordCity'],
                'productPostcode' => $product['baorecordPostcode'],
                'productAddress' => $product['baorecordAddress'],
                'productPhone' => $product['baorecordPhone'],
                'productEmail' => $product['baorecordEmail'],
                'productWebsite' => $product['baorecordWebsite'],
                'productLat' => $product['baorecordLat'],
                'productLon' => $product['baorecordLon'],
                'productPhoto' => $product['baorecordPhoto'],
                'productStarRating' => $product['baorecordStarRating'],
                'productLowrate' => $product['baorecordLowrate'],
                'productHighrate' => $product['baorecordHighrate'],
                'productRateBasis' => $product['baorecordRateBasis'],
                'productCheckin' => $product['baorecordCheckin'],
                'productCheckout' => $product['baorecordCheckout'],
                'productFrequency' => $product['baorecordFrequency'],
                'productStart' => $product['baorecordStart'],
                'productEnd' => $product['baorecordEnd'],
                'productBookable' => ($product['baorecordSource'] == 'atdw') ? 0 : 1
            );
            $this->updProduct($row);

            /// @todo : do not delete attributes photos etc. every update
            // Will need somehow to check updated/deleted records
            // rooms
            $rooms = $this->getCentralDBHotelRoomModel()->getRooms($row['productId']);
            $attributes = array();
            $mm = array();
            foreach ($rooms as $room)
            {
                $this->getProductRoomModel()->updRoom(array(
                    'roomId' => $room['hotelroomId'],
                    'roomName' => $room['hotelroomName'],
                    'roomShortdesc' => $room['hotelroomShortdesc'],
                    'roomDescription' => $room['hotelroomDescription'],
                    'roomLowrate' => $room['hotelroomLowrate'],
                    'roomHighrate' => $room['hotelroomHighrate'],
                    'roomRateBasis' => $room['hotelroomRateBasis'],
                    'roomExtraperson' => $room['hotelroomExtraperson'],
                    'roomGuestmax' => $room['hotelroomGuestmax'],
                    'roomSource' => $room['hotelroomSource'],
                    'roomSourceId' => $room['hotelroomSourceId'],
                    'roomRecordId' => $room['hotelroomRecordId'],
                ));
                // rooms attr
                $attributes = array_merge($attributes, $this->getCentralDBRecordAttrModel()->getAttributes($room['hotelroomId'], 'ROOM'));
                $this->getProductAttrModel()->remove($room['hotelroom_id']);
                // rooms multimedia
                $mm = array_merge($mm, $this->getCentralDBRecordMultimediaModel()->getMultimedia($room['hotelroom_id'], 'ROOM'));
                $this->getProductMultimediaModel()->remove($room['hotelroom_id']);
            }

            // attr
            $attributes = array_merge($attributes, $this->getCentralDBRecordAttrModel()->getAttributes($row['product_id']));
            $this->getProductAttrModel()->remove($row['product_id']);
            $this->getProductAttrModel()->add($attributes);
            // multimedia
            $mm = array_merge($mm, $this->getCentralDBRecordMultimediaModel()->getMultimedia($row['product_id']));
            $this->getProductMultimediaModel()->remove('multimedia_record_id ="' . $row['product_id'] . '"');
            $this->getProductMultimediaModel()->add($mm);
            // info
            $info = $this->getCentralDBRecordInfoModel()->getInfo($row['product_id']);
            foreach ($info as $i)
            {
                $this->getProductInfoModel()->updInfo($i);
            }
        }
    }   

	public function updProduct($data) {
		$product = $this->getEntityManager()->getRepository('Travel\Entity\Product')->findBy($data['productId']);	
		
		if(!$product) {
			$product = new \Travel\Entity\Product();
			$row['productCreated'] = time();
		} else {
			$data['productModified'] = time();
		}
		$product->setByArray($data);
		$this->getEntityManager()->persist($product);
		$this->getEntityManager()->flush();	
	} 
	
	protected function getProductInfoModel()
    {
        if (!$this->productInfoModel) {
            $this->productInfoModel = $this->getServiceManager()->get('Admin\Model\ProductInfoModel');
        }
        return $this->productInfoModel;
    }
	
	protected function getProductAttrModel()
    {
        if (!$this->productAttrModel) {
            $this->productAttrModel = $this->getServiceManager()->get('Admin\Model\ProductAttrModel');
        }
        return $this->productAttrModel;
    }
	
	protected function getProductMultimediaModel()
    {
        if (!$this->productMultimediaModel) {
            $this->productMultimediaModel = $this->getServiceManager()->get('Admin\Model\ProductMultimediaModel');
        }
        return $this->productMultimediaModel;
    }
    
	protected function getProductRoomModel()
    {
        if (!$this->productRoomModel) {
            $this->productRoomModel = $this->getServiceManager()->get('Admin\Model\ProductRoomModel');
        }
        return $this->productRoomModel;
    }
	
	protected function getCentralDBHotelRoomModel()
    {
        if (!$this->centralDBHotelRoomModel) {
            $this->centralDBHotelRoomModel = $this->getServiceManager()->get('CentralDB\Model\HotelRoomModel');
        }
        return $this->centralDBHotelRoomModel;
    }
	
	protected function getCentralDBRecordInfoModel()
    {
        if (!$this->centralDBRecordInfoModel) {
            $this->centralDBRecordInfoModel = $this->getServiceManager()->get('CentralDB\Model\RecordInfoModel');
        }
        return $this->centralDBRecordInfoModel;
    }
	
	protected function getCentralDBRecordAttrModel()
    {
        if (!$this->centralDBRecordAttrModel) {
            $this->centralDBRecordAttrModel = $this->getServiceManager()->get('CentralDB\Model\RecordAttrModel');
        }
        return $this->centralDBRecordAttrModel;
    }
	
	protected function getCentralDBRecordMultimediaModel()
    {
        if (!$this->centralDBRecordMultimediaModel) {
            $this->centralDBRecordMultimediaModel = $this->getServiceManager()->get('CentralDB\Model\RecordMultimediaModel');
        }
        return $this->centralDBRecordMultimediaModel;
    }
}