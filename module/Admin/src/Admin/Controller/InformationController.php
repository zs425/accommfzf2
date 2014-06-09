<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use AceLibrary\Controller\AceController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * @author Kirill
 * @property \Zend\I18n\Translator\Translator    $translator
 *
 */
class InformationController extends AceController {
    
    protected $destinationModel;
    protected $productModel;
     
    // Products search form & search result
    public function indexAction() {
        
        $this->layout()->heading = $this->getTranslator()->translate('Database Information');
        
        $model = $this->getDestinationModel();
        $product = $this->getProductModel();
        
        $result = array();
        $result['totalDestinationCnt'] = count($model->getListAll());
        $result['totalDestinationStateCnt'] = count($model->getListBy(array('baodestinationType' => 'STATE')));
        $result['totalDestinationRegionCnt'] = count($model->getListBy(array('baodestinationType' => 'REGION')));
        $result['totalDestinationAreaCnt'] = count($model->getListBy(array('baodestinationType' => 'AREA')));
        $result['totalDestinationCityCnt'] = count($model->getListBy(array('baodestinationType' => 'CITY')));
        
        $result['totalProductCnt'] = count($product->getProductsBy());
        $result['totalAccomProductCnt'] = count($product->getProductsBy(array('productCategory' => 'ACCOMM')));
        $result['totalAttrProductCnt'] = count($product->getProductsBy(array('productCategory' => 'ATTRACTION')));
        $result['totalEventProductCnt'] = count($product->getProductsBy(array('productCategory' => 'EVENT')));
        $result['totalTourProductCnt'] = count($product->getProductsBy(array('productCategory' => 'TOUR')));
        $result['totalAtdwProductCnt'] = count($product->getProductsBy(array('productSource' => 'atdw')));
        $result['totalRoamProductCnt'] = count($product->getProductsBy(array('productSource' => 'roamfree')));
        $result['totalV3ProductCnt'] = count($product->getProductsBy(array('productSource' => 'v3')));
        $result['totalHcProductCnt'] = count($product->getProductsBy(array('productSource' => 'hc')));
        $result['totalViatorProductCnt'] = count($product->getProductsBy(array('productSource' => 'viator')));
        $result['totalExpdProductCnt'] = count($product->getProductsBy(array('productSource' => 'expedia')));
        
        return array(
            'result' => $result,
        );
    }
    
    protected function getDestinationModel() {
        if(!$this->destinationModel) {
            $this->destinationModel = $this->getServiceLocator()->get('Admin\Model\DestinationModel');
        }
        return $this->destinationModel;
    }
    
    protected function getProductModel(){
        if (!$this->productModel) {
            $this->productModel = $this->getServiceLocator()->get('Admin\Model\ProductModel');
        }
        return $this->productModel;
    }
}
