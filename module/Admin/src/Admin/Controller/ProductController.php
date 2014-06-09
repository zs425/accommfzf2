<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\ProductSearchForm;
use Admin\Form\ProductActionsForm;
use Admin\Form\ProductEditForm;
use Admin\Model\ProductModel;
use Admin\Model\ProductChangesModel;
use Admin\Model\ProductChangesdetailModel;
use AceLibrary\Controller\AceController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use AceLibrary\Service\S3ImageUploadService;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * @author Kirill
 * @property \Zend\I18n\Translator\Translator    $translator
 *
 */
class ProductController extends AceController {
    
    protected $productModel;
    protected $productChangesModel;
    protected $productChangesdetailModel;
    protected $authService;
    
    // Products search form & search result
    public function indexAction() {
        
        $productSearchForm = new ProductSearchForm($this->getServiceLocator());
        
        $productActionsForm = new ProductActionsForm($this->getServiceLocator());
        
        $model = $this->getProductModel();
        $page = $this->params()->fromRoute('page')?(int)$this->params()->fromRoute('page'):1;
        
        $this->layout()->heading = $this->getTranslator()->translate('Products');

        if ($this->request->isPost())
        {
            $values = $this->request->getPost()->toArray();
            
            $result = $model->search($values);
            $itemsPerPage = 30;
            $result->buffer();
            $current = $result->current();
            
            $paginator = new Paginator(new paginatorIterator($result));
            $paginator->setCurrentPageNumber($page)
                    ->setItemCountPerPage($itemsPerPage)
                    ->setPageRange(90);
					
			$productSearchForm->setData($values); 
            $productActionsForm->setData($values);
            
            return array( 
                'searchForm'  => $productSearchForm,
                'actionsForm' => $productActionsForm,
                'page' => $page,
                'items' => $paginator,
            );
        }
        
        return array(
            'searchForm'  => $productSearchForm,
            'actionsForm' => $productActionsForm,
        );
    }
    
    
    // Edit product action                                  
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 0) {         
            return $this->redirect()->toRoute('zfcadmin/localdata/product');
        }
        $product = $this->getProductModel()->getProduct($id);
        
        $productChangeModel = $this->getProductChangesModel();
        $productChangesdetailModel = $this->getProductChangesdetailModel();
        
        $s3Service = new S3ImageUploadService();
        
        if(!$product) {
            return $this->redirect()->toRoute('zfcadmin/localdata/product');
        }
        
        $productEditForm = new ProductEditForm($this->getServiceLocator());
        
        $request = $this->getRequest(); 

        if($request->isPost()) {
            $post = $request->getPost()->toArray();
            $files   = $request->getFiles()->toArray();
            
            ini_set('max_execution_time', 30000);
            if($files['productPhotoNew']['error'] == 0 && in_array($files['productPhotoNew']['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
                $post['productPhoto'] = $files['productPhotoNew']['name'];
            }
            
            $productEditForm->setData($post);
            
            if(isset($post['productPhotoNew'])){
                if($files['productPhotoNew']['error'] == 0){
                    $s3Service->imageUpload($files['productPhotoNew'], 'testing/');
                }
            }
            
            if($productEditForm->isValid()) {
                $data = $productEditForm->getData();
                
                unset($data['productPhotoNew']);
                unset($data['submitbtn']);
                
                $productArray = $product->getArrayCopy();
                
                $changes = array_diff_assoc($data, $productArray );
                if (count($changes) != 0){
                    $this->getProductModel()->edit($id, $data);
                    $currentDateTime = time();
                    $adminId = $this->getAuthService()->getUserId();
                    $productChanges = array('productId' => $id, 'changeDate' => $currentDateTime, 'adminId' => $adminId, 'changeBack'=>NULL);
                    
                    $changeId = $productChangeModel->add($productChanges);
                    foreach ($changes as $key=>$value){
                        $productChangesdetail = array('changeId' => $changeId);
                        $productChangesdetail['changeField'] = $key;
                        $productChangesdetail['oldValue'] = $productArray[$key];
                        $productChangesdetail['newValue'] = $value;
                        $productChangesdetailModel->add($productChangesdetail);
                    }
                }
            }
            
            return $this->redirect()->toRoute('zfcadmin/localdata/product', array('action' => 'edit', 'id' => $id));
        }
        else {
            $this->layout()->heading = $this->getTranslator()->translate('Edit Product');
            
            $product_img = $product->getProductPhoto();
            $fileExist = $s3Service->checkFileExist($product_img, "testing/");
            if ($fileExist){
                $productPhoto = $s3Service->getFileUrl($product_img, 'testing/');
            }else{
                $productPhoto = "/admin-assets/images/noimage.jpg";
            }

            $productEditForm->bind($product);
            $productChangeLog = $productChangeModel->getChanges($id);
            $productLogsArray = array();
            foreach ($productChangeLog as $changeLog){
                $changeLogs = $changeLog->getArrayCopy();
                $productChangeLogDetail = $productChangesdetailModel->getChangedetail($changeLogs['changeId']);
                $changeLogs['detail'] = $productChangeLogDetail;
                $productLogsArray[] = $changeLogs;
            }

            return array(
                'productEditForm' => $productEditForm,
                'id' => $id,
                'productChangeLog' => $productLogsArray,
                'productPhoto' => $productPhoto,
            );
        }
                     
        return array(
            'productEditForm'  => $productEditForm,
            'id'        => $id,
        );
    }
    
    // Action for change back button
    public function changebackAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 0) {         
            return $this->redirect()->toRoute('zfcadmin/localdata/product');
        }
        
        $productModel = $this->getProductModel();
        $productChangeModel = $this->getProductChangesModel();
        $productChangesdetailModel = $this->getProductChangesdetailModel();
        
        $changeLog = $productChangeModel->getChangeById($id);
        $changeDetail = $productChangesdetailModel->getChangedetail($id);
        
        $product = $productModel->getProduct($changeLog->getProductId());
        
        foreach($changeDetail as $changes){
            $product->set($changes->getChangeField(), $changes->getOldValue());
        }
        $productModel->save($product);
        
        $currentDateTime = time();
        $adminId = $this->getAuthService()->getUserId();
        $productChanges = array('productId' => $product->getProductId(), 'changeDate' => $currentDateTime, 'adminId' => $adminId, 'changeBack'=>$id);
        
        $changeId = $productChangeModel->add($productChanges);
        foreach ($changeDetail as $changes){
            $productChangesdetail = array('changeId' => $changeId);
            $productChangesdetail['changeField'] = $changes->getChangeField();
            $productChangesdetail['oldValue'] = $changes->getNewValue();
            $productChangesdetail['newValue'] = $changes->getOldValue();
            $productChangesdetailModel->add($productChangesdetail);
        }
        
        return $this->redirect()->toRoute('zfcadmin/localdata/product', array('action' => 'edit', 'id' => $product->getProductId()));
    }
    
    //Delete Product
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id');
        if($id != 0) {
           $this->getProductModel()->delete($id);
        }
        return $this->redirect()->toRoute('zfcadmin/localdata/product');
    }
    
    protected function getProductModel() {
        if(!$this->productModel) {
            $this->productModel = $this->getServiceLocator()->get('Admin\Model\ProductModel');
        }
        return $this->productModel;
    }
    
    protected function getProductChangesModel() {
        if(!$this->productChangesModel) {
            $this->productChangesModel = $this->getServiceLocator()->get('Admin\Model\ProductChangesModel');
        }
        return $this->productChangesModel;
    }
    
    protected function getProductChangesdetailModel() {
        if(!$this->productChangesdetailModel) {
            $this->productChangesdetailModel = $this->getServiceLocator()->get('Admin\Model\ProductChangesdetailModel');
        }
        return $this->productChangesdetailModel;
    }
    
    protected function getAuthService() {
        if(!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('Admin\Service\AuthService');
        }
        return $this->authService;
    }
    
}
