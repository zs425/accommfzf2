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
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Admin\Form\CentralDestinationForm;
use Admin\Form\DestinationDeleteForm;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * @author Kirill
 * @property \Zend\I18n\Translator\Translator    $translator
 *
 */
class DestinationController extends AceController {
    
    protected $authService;
    protected $destinationModel;
    protected $productModel;
    
    // Products search form & search result
    public function indexAction() {
        
        $this->layout()->heading = $this->getTranslator()->translate('Destinations (Local Data)');
        
        $model = $this->getDestinationModel();
        
        $search = $this->request->getPost()->toArray();
        if ($this->params()->fromRoute('searchableonly'))
            $result = $model->getList($search);
        else
            $result = $model->getListAll();
        
        $page = $this->params()->fromRoute('page', 1);
        $itemsPerPage = 30;
        $result->buffer();
        $current = $result->current();
        
        $paginator = new Paginator(new paginatorIterator($result));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(90);
        
        return array('items' => $paginator,
            'page' => $page,
        );
    }
    
    public function destactionAction(){
    	if ($this->request->isPost()){
            $act = $this->params()->fromPost("multiact");
            $ids = $this->params()->fromPost("id");
            $model = $this->getDestinationModel();
            if ($act == 'toggle-disable'){
                foreach ($ids as $id){
                    $destination = $model->getDestination($id);
                    $baoDisabled = '0';
                    if ($destination->getBaodestinationDisabled() == 1){
                        $baoDisabled = '0';
                    }else if ($destination->getBaodestinationDisabled() == 0){
                        $baoDisabled = '1';
                    }
                    $model->edit($id, array('baodestinationDisabled' => $baoDisabled));
                }
                
                return $this->redirect()->toRoute('zfcadmin/localdata/destination');
            }else if ($act == 'toggle-disable-children'){
                $res = $model->getListAll();
                $allDestinations = array();
                foreach ($res as $r)
                {
                    $allDestinations[(int)$r->getBaodestinationParentId()][] = $r;
                }
                foreach ($ids as $id) {
                    if (isset($allDestinations[$id])) {
                        $newStatus = !$model->getDestination($id)->getBaodestinationDisabled();
                        $model->disableEnableChilds($id, $allDestinations, $newStatus);
                    }
                }
                return $this->redirect()->toRoute('zfcadmin/localdata/destination');
            }else if ($act == 'delete-local'){
                
                foreach ($ids as $id){
                    $dest = $model->getDestination($id);
                    $model->delete($id);
                    $productModel = $this->getProductModel();
                    switch ($dest->getBaodestinationType())
                    {
                        case "AREA":
                           $where = "product_area_id = '$id' or product_city = '" . $dest->getBaodestinationName() . "'";
                            $productModel->deleteBy($where);
                          
                            break;
                        case "CITY":
                            $where = "product_city = '" . $dest->getBaodestinationName() . "'";
                            $productModel->deleteBy($where);
                     
                            break;
                        default:
                            break;
                    }
                }
                return $this->redirect()->toRoute('zfcadmin/localdata/destination');
                
            }else if ($act == 'toggle-disable-search'){
                foreach ($ids as $id){
                    $destination = $model->getDestination($id);
                    $baoSearchDisabled = '0';
                    if ($destination->getBaodestinationType() == 'CITY'){
                        if ($destination->getBaodestinationSearchdisabled() == 1){
                            $baoSearchDisabled  = '0';
                        }else if ($destination->getBaodestinationSearchdisabled() == 0){
                            $baoSearchDisabled  = '1';
                        }
                        $model->edit($id, array('baodestinationSearchdisabled' => $baoSearchDisabled));
                    }
                }
                return $this->redirect()->toRoute('zfcadmin/localdata/destination');
            }
        }
    }
    
    public function hideAction(){
        $id = $this->params()->fromRoute('id', 0);
        if ($id == 0){
            return $this->redirect()->toRoute('zfcadmin/localdata/destination');
        }
        $model = $this->getDestinationModel();
        $model->edit($id, array('baodestinationSearchdisabled' => '1'));
        return $this->redirect()->toRoute('zfcadmin/localdata/destination');
    }
    
    public function showAction(){
        $id = $this->params()->fromRoute('id', 0);
        if ($id == 0){
            return $this->redirect()->toRoute('zfcadmin/localdata/destination');
        }
        $model = $this->getDestinationModel();
        $model->edit($id, array('baodestinationSearchdisabled' => '0'));
        return $this->redirect()->toRoute('zfcadmin/localdata/destination');
    }
    
    public function editAction(){
        $id = $this->params()->fromRoute('id', 0);
        if ($id == 0){
            return $this->redirect()->toRoute('zfcadmin/localdata/destination');
        }
        
        $centralDestinationForm = new CentralDestinationForm($this->getServiceLocator());
        $model = $this->getDestinationModel();
        
        if ($this->request->isPost()){
            $values = $this->request->getPost()->toArray();
            $model->edit($id, array('baodestinationName' => $values['baodestinationName']));
            return $this->redirect()->toRoute('zfcadmin/localdata/destination');
        }else{
            $destination = $model->getDestination($id);
            $centralDestinationForm->bind($destination);
            return array('centralDestinationForm' => $centralDestinationForm,);
        }        
    }
    
    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id');
        if($id != 0) {
           $this->getDestinationModel()->delete($id);
        }
        return $this->redirect()->toRoute('zfcadmin/localdata/destination');
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
