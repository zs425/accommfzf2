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
use Zend\View\Model\ViewModel;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * @author Kirill
 * @property \Zend\I18n\Translator\Translator    $translator
 *
 */
class OrphanproductController extends AceController {
    
    protected $productModel;
    protected $destinationModel;
    protected $authService;
    
    // Products search form & search result
    public function indexAction() {
        
        $productModel = $this->getProductModel();
        $destModel = $this->getDestinationModel();
        $ids = $destModel->getAreas();
        
        $productSearchForm = new ProductSearchForm($this->getServiceLocator());
        $productActionsForm = new ProductActionsForm($this->getServiceLocator());
        
        $multiact = $this->params()->fromPost("multiact");
        
        if ($this->request->isPost() && isset($multiact)){
            $actIds = $this->params()->fromPost("id");

            if ($multiact == 'export'){
                
                $resultset = $productModel->getProducts($actIds)->toArray();
                
                $filename = "product.csv";
                $view = new ViewModel();
                $view->setTemplate('orphanproduct-download-csv')
                     ->setVariable('results', $resultset)
                     ->setTerminal(true);
                
                $columnHeaders = array("ID", "Name", "Source", "Category", "State", "Region", "City");

                $view->setVariable(
                    'columnHeaders', $columnHeaders
                );

                $output = $this->getServiceLocator()
                               ->get('viewrenderer')
                               ->render($view);

                $response = $this->getResponse();

                $headers = $response->getHeaders();
                $headers->addHeaderLine('Content-Type', 'text/csv')
                        ->addHeaderLine(

                            'Content-Disposition', 
                            sprintf("attachment; filename=\"%s\"", $filename)
                        )
                        ->addHeaderLine('Accept-Ranges', 'bytes')
                        ->addHeaderLine('Content-Length', strlen($output));

                $response->setContent($output);

                return $response;
            }else if ($multiact == 'delete'){
                foreach($actIds as $id){
                    $productModel->delete($id);
                }
            }
        }
        
        if ($this->request->isPost())
        {
            $values = $this->request->getPost()->toArray();
            
            $orphanProds = $productModel->getOrphans($ids, $values);
                                
            $productSearchForm->setData($values); 
            $productActionsForm->setData($values);
            
        }else{
            $orphanProds = $productModel->getOrphans($ids, null);
        }
        
        $page = $this->params()->fromRoute('page')?(int)$this->params()->fromRoute('page'):1;
        
        $this->layout()->heading = $this->getTranslator()->translate('Products');
        
        $itemsPerPage = 30;
        $orphanProds->buffer();
        $current = $orphanProds->current();
        
        $paginator = new Paginator(new paginatorIterator($orphanProds));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(90);
        
        return array(
            'searchForm'  => $productSearchForm,
            'actionsForm' => $productActionsForm,
            'page' => $page,
            'items' => $paginator,
        );
    }
    
    protected function getProductModel() {
        if(!$this->productModel) {
            $this->productModel = $this->getServiceLocator()->get('Admin\Model\ProductModel');
        }
        return $this->productModel;
    }
    
    protected function getDestinationModel() {
        if(!$this->destinationModel) {
            $this->destinationModel = $this->getServiceLocator()->get('Admin\Model\DestinationModel');
        }
        return $this->destinationModel;
    }
    
    protected function getAuthService() {
        if(!$this->authService) {
            $this->authService = $this->getServiceLocator()->get('Admin\Service\AuthService');
        }
        return $this->authService;
    }
    
}
