<?php
namespace AceLibrary\Service;

use Zend\Http\Client;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Json\Json;

/**
 * Class ViatorService
 * @package AceLibrary\Service
 * @author  Kirill Morozov
 * @property \AceLibrary\Service\CacheService $cacheService
 */
class ViatorService extends AceService
{
    protected $cacheService;

    const API_URL         = 'http://prelive.viatorapi.viator.com/service';
    const CACHE_NAMESPACE = 'viator';

    //const API_URL = 'http://viatorapi.viator.com/service';

    public function getProductsByDestination($destinationId, $catId = 0, $subCatId = 0, $startDate = "", $endDate = "")
    {
        $config   = $this->getConfig();
        $cacheKey = 'productList_' . $destinationId . '_' . $catId . '_' . $subCatId . '_' . $startDate . '_' . $endDate;
        $cache    = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $products = $cache->getItem($cacheKey, $success);
        if (!$success) {
            
            $params   = array(
                'sortOrder'    => 'TOP_SELLERS',
                'destId'       => $destinationId,
                'currencyCode' => $config['viator']['currency_code'],
                'catId'        => $catId,
                'subCatId'     => $subCatId,
            );
            if ($startDate != "")
                $params["startDate"] = $startDate;
            if ($endDate != "")
                $params["endDate"] = $endDate;
            $products = $this->makePostRequest('/search/products', $params);
            if ($products !== false) {
                $cache->setItem($cacheKey, $products);
            }
        }
        return $products;
    }

    public function getProductDetails($productId)
    {
        $config   = $this->getConfig();
        $cacheKey = 'product_' . $productId;
        $cache    = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $product  = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params  = array(
                'code'         => $productId,
                'currencyCode' => $config['viator']['currency_code'],
            );
            $product = $this->makeGetRequest('/product', $params);
            if ($product !== false) {
                $cache->setItem($cacheKey, $product);
            }
        }
        return $product;
    }

    public function getProductPhotos($productId)
    {
        $cacheKey      = 'productPhotos_' . $productId;
        $cache         = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $productPhotos = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params        = array(
                'code' => $productId,
            );
            $productPhotos = $this->makeGetRequest('/product/photos', $params);
            if ($productPhotos !== false) {
                $cache->setItem($cacheKey, $productPhotos);
            }
        }
        return $productPhotos;
    } 

    public function getCategories($destinationId)
    {
        $cacheKey   = 'categories_' . $destinationId;
        $cache      = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $categories = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params     = array(
                'destiId' => $destinationId,
            );
            $categories = $this->makeGetRequest('/taxonomy/categories', $params);
            if ($categories !== false) {
                $cache->setItem($cacheKey, $categories);
            }
        }
        return $categories;
    }
    
    public function getCategoriesFromResult($categories, $productResult){
        $productCats = array();
        
        $prodRootIds = array();
        foreach ($productResult as $key=>$product){
            if (isset($product->catIds)){
                foreach($product->catIds as $inx=>$catId){
                    if (isset($product->subCatIds)){
                        $productCats[] = array($catId, $product->subCatIds[$inx]);
                    }else{
                        $productCats[] = array($catId, "0");
                    }
                }
            }
        }
		
        $result = array_map("unserialize", array_unique(array_map("serialize", $productCats)));
		
        foreach($result as $key=>$categoryPair){
            $prodRootIds[$key] = $categoryPair[0];
        }
        
        foreach($categories->data as $key=>$category){
            if (!in_array($category->id, $prodRootIds)){
                unset($categories->data[$key]);
            }else{
				if (isset($category->subcategories)){
	                foreach ($category->subcategories as $subKey=>$subCat){
	                    $subCategory = $subCat->subcategoryId;
						$isSameFlg = false;
						$inxs = $this->recursive_array_search($category->id, $prodRootIds);
						foreach($inxs as $inx){
							if ($subCategory == $result[$inx][1])
								$isSameFlg = true;
						}
						
						if (!$isSameFlg){
							unset($categories->data[$key]->subcategories[$subKey]);
						}
	                }
	            }
            }
        }
		
		return $categories->data;
    }
    
    public function removeEmptyCategories($categories, $destId){
        ini_set('max_execution_time', 30000);
        foreach ($categories as $key=>$category){
            if (isset($category->subcategories)){
                $rootCat = $category->id;
                foreach ($category->subcategories as $subKey=>$subCat){
                    $subCategory = $subCat->subcategoryId;
                    $products = $this->getProductsByDestination($destId, $rootCat, $subCategory);
                    if (!isset($products->data) || (count($products->data) < 1)){
                        unset($category->subcategories[$subKey]);
                    }
                }
            }
            if (count($category->subcategories) < 1){
                unset($categories[$key]);
            }
        }

        return $categories;
    }

    public function getAustralianDestinations()
    {
        $australia = $this->getAustraliaDestinationObject();
        return $this->getRecursiveDestinationsByParent(array($australia));
    }
    
    public function getAustralianAreas(){
        $destinations = $this->getAustralianDestinations();
        foreach($destinations as $key => $dest){
            if ($dest->destinationType == "COUNTRY"){
                unset($destinations[$key]);
            }
        }
        return $destinations;
    }
    
    public function getAustralianCategories(){
        $austDestObj = $this->getAustraliaDestinationObject();
        $austDest = $austDestObj->destinationId;
        $categories = $this->getCategories($austDest);
        return $categories;
    }
    
    public function getProductsByIds($ids)
    {
        $config   = $this->getConfig();
        $params   = array(
            'currencyCode' => $config['viator']['currency_code'],
            'productCodes' => $ids,
        );
        $products = $this->makePostRequest('/search/products/codes', $params);
        
        return $products;
    }
    
    public function getProductsByKeyword($keyword, $destId = NULL)
    {
        $config   = $this->getConfig();
        $cacheKey = 'productListByKeyword_' . $keyword. '_'.$destId;
        $cache    = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $products = $cache->getItem($cacheKey, $success);
        if (!$success) {
            if ($destId != NULL){
                $params   = array(
                    'destId'       => $destId,
                    'currencyCode' => $config['viator']['currency_code'],
                    'text'         => $keyword,
                    "searchTypes"  => array("PRODUCT"), 
                );
            }else{
                $params   = array(
                    'currencyCode' => $config['viator']['currency_code'],
                    'text'        => $keyword,
                    "searchTypes"  => array("PRODUCT"),
                );
            } 
            
            $products = $this->makePostRequest('/search/freetext', $params);
            if ($products !== false) {
                $cache->setItem($cacheKey, $products);
            }
        }
        return $products;
    }
    
    // Utility weather api
    public function getWeatherViatorDest($destId, $tempUnit="C"){
        $cacheKey   = 'weather_' . $destId."_".$tempUnit;
        $cache      = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $weather = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params     = array(
                'destId' => $destId,
                'tempUnit' => "C"
            );
            $weather = $this->makePostRequest('/util/weather', $params);
            if ($weather !== false) {
                $cache->setItem($cacheKey, $weather);
            }
        }
        return $weather; 
    }
    
    // Utility ip2Country api
    public function ip2country($ip){
        $params     = array(
            'ip' => $ip
        );
        $country = $this->makePostRequest('/util/ip2country', $params);
        return $country;
    }
    
    // Utility version api
    public function getApiVersion(){
        $version = $this->makePostRequest('/util/version', array());
        return $version;
    }
    
    // Get product reviews api
    public function getProductReviews($code, $topX, $sortOrder){
        $cacheKey   = 'weather_' . $destId."_".$tempUnit;
        $cache      = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $reviews = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params     = array(
                'code' => $code,
                'topX' => $topX,
                'sortOrder' => $sortOrder,
            );
            $reviews = $this->makeGetRequest('/product/reviews', $params);
            if ($reviews !== false) {
                $cache->setItem($cacheKey, $reviews);
            }
        }
        return $reviews; 
    }
    
    // Get product booking availability dates api
    public function getAvailabilityDates($productCode){
        $cacheKey   = 'avdate_' . $productCode;
        $cache      = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $avdate = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params     = array(
                'productCode' => $productCode,
            );
            $avdate = $this->makeGetRequest('/booking/availability/dates', $params);
            if ($avdate !== false) {
                $cache->setItem($cacheKey, $avdate);
            }
        }
        return $avdate; 
    }
    
    // Get product booking availability within a month
    public function getAvailability($productCode, $month, $year, $currencyCode, $ageBands){
        $cacheKey   = 'availability_' . $productCode."_".$month."_".$year;
        $cache      = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $availability = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $params     = array(
                'productCode' => $productCode,
                'month' => $month,
                'year' => $year,
                'currencyCode' => $currencyCode,
                'ageBands' => $ageBands,
            );
            $availability = $this->makePostRequest('/booking/availability', $params);
            if ($availability !== false) {
                $cache->setItem($cacheKey, $availability);
            }
        }
        return $availability; 
    }
    
    // Get list all available tour grades for a specific day
    public function getTourgrades($productCode, $bookingDate,  $ageBands){
        $config   = $this->getConfig();
        
        $currencyCode = $config['viator']['currency_code'];

        $params     = array(
            'productCode' => $productCode,
            'bookingDate' => $bookingDate,
            'currencyCode' => $currencyCode,
            'ageBands' => $ageBands,
        );
        $tourgrades = $this->makePostRequest('/booking/availability/tourgrades', $params);
        return $tourgrades; 
    }
    
    public function getAustraliaDestinationObject()
    {
        $allDestinations = $this->getDestinations();
        foreach ($allDestinations->data as $destination) {
            if ($destination->destinationType == 'COUNTRY' && $destination->destinationName == 'Australia') {
                return $destination;
            }
        } 
    }

    protected function getDestinations()
    {
        $cacheKey     = 'destinations';
        $cache        = $this->getCacheService()->getCache(self::CACHE_NAMESPACE, CacheService::SIX_HOURS);
        $destinations = $cache->getItem($cacheKey, $success);
        if (!$success) {
            $destinations = $this->makeGetRequest('/taxonomy/locations');
            if ($destinations !== false) {
                $cache->setItem($cacheKey, $destinations);
            }
        }
        return $destinations;
    }

    protected function getRecursiveDestinationsByParent(array $parentDestinations)
    {
        $idMap = array();
        foreach ($parentDestinations as $destination) {
            $idMap[] = $destination->destinationId;
        }

        $madeProgress = false;

        $allDestinations = $this->getDestinations();
        foreach ($allDestinations->data as $destination) {
            if (in_array($destination->parentId, $idMap) && !in_array($destination, $parentDestinations)) {
                $parentDestinations[] = $destination;
                $madeProgress         = true;
            }
        }
        if ($madeProgress) {
            return $this->getRecursiveDestinationsByParent($parentDestinations);
        }
        return $parentDestinations;
    }

    protected function makePostRequest($url, $parameters = array())
    {
        $config  = $this->getConfig();
        $url     = self::API_URL . $url . '?apiKey=' . $config['viator']['api_key'];
        $request = new Request();
        $headers = new Headers();
        $headers->addHeaderLine('content-type', 'application/json');
        $request->setUri($url);
        $request->setMethod(Request::METHOD_POST);
        $request->setHeaders($headers);
        $jsonParameters = Json::encode($parameters);
        $request->setContent($jsonParameters);

        $httpClient = new Client();
        $response   = $httpClient->dispatch($request);

        if ($response->isSuccess()) {
            $jsonData = $response->getBody();
            $data     = Json::decode($jsonData);
            if ($data && $data->success === true) {
                return $data;
            } 
        }
        return false;
    }

    protected function makeGetRequest($url, $parameters = array())
    {
        $config               = $this->getConfig();
        $parameters['apiKey'] = $config['viator']['api_key'];// . 'a';
        $url                  = self::API_URL . $url;
        $url                  = $url . '?' . http_build_query($parameters);
        $jsonData             = file_get_contents($url);

        if (!$jsonData) {
            return false;
        }
        
        $data = Json::decode($jsonData);
        if ($data && $data->success === true) {
            return $data;
        }
        return false;
    }
	
	protected function recursive_array_search($needle,$haystack) {
		$result;
	    foreach($haystack as $key=>$value) {
	        $current_key=$key;
	        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
	            $result[] = $current_key;
	        }
	    }
	    return $result;
	}

    protected function getCacheService()
    {
        if (!$this->cacheService) {
            $this->cacheService = $this->getServiceManager()->get('AceLibrary\Service\CacheService');
        }
        return $this->cacheService;
    } 

}