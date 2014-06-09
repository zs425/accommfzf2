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
use CentralDB\Model\WebsitesModel;
use CentralDB\Model\WebsiteCategoriesModel;
use Admin\Form\WebsiteForm;
use AceLibrary\Service\S3ImageUploadService;

class SiteController extends AceController {
	public $websitesModel;
	public $websiteCategoriesModel;
	
    public function listWebsitesAction() {    	
    	
        if(!isset($websiteList)) {
            $websiteList = $this->getWebsitesModel()->getWebsiteList();
			
			$s3ImageUploadService = new S3ImageUploadService();
			
			foreach($websiteList as $key => $website) {
				
				$fileExist = $s3ImageUploadService->checkFileExist($website['websitePreviewsmall'], "website/" . $website['websiteSlug']. "/");
				if ($fileExist){
	            	$websiteList[$key]['image_url'] = $s3ImageUploadService->getFileUrl($website['websitePreviewsmall'], "website/" . $website['websiteSlug']. "/");	                
	            }else{
	                $websiteList[$key]['image_url'] = "/admin-assets/images/noimage.jpg";
	            }				
			}			
        }
		
		$this->layout()->heading = $this->getTranslator()->translate('Web Sites');
        return array(
            'websiteList' => $websiteList,
        );        
    }
	
	public function addWebsiteAction() {
		$websiteForm = new WebsiteForm($this->getServiceLocator(), $this->getWebsiteCategoriesModel());
		$request = $this->getRequest();
        
        if($request->isPost()) {
            $post = $request->getPost()->toArray();
            $files   = $request->getFiles()->toArray();
            
            //$post = array_merge_recursive($data, $files);
            if($files['websitePreviewsmall_file']['error'] == 0 && in_array($files['websitePreviewsmall_file']['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
                $post['websitePreviewsmall'] = $files['websitePreviewsmall_file']['name'];
                $post['websitePreviewlarge'] = $post['websitePreviewsmall'];
            }
            
            if($post['websitePreviewsmall']){
            
                $websiteForm->setData($post);                           
                
                if($websiteForm->isValid()) { 
                    $post['websiteCategories'] = implode(",", $post['websiteCategories']);
                    if($files['websitePreviewsmall_file']['error'] == 0){
                        $s3ImageUploadService = new S3ImageUploadService();
                        $s3ImageUploadService->imageUpload($files['websitePreviewsmall_file'], 'website/' . $post['websiteSlug'] . '/');
                    }
                      
                    $post['websiteAdded'] = new \DateTime();
                    $post['websiteExpecteddate'] = new \DateTime();
                    $post['websitePath'] = "";
                    $post['websiteAutoupdate'] = "1";
                    
                    $this->getWebsitesModel()->addWebsite($post);                
                    
                    return $this->redirect()->toRoute('zfcadmin/centraldb/site/default', array('action'=>'listWebsites'));
                }
            } else {
            	$websiteForm->get('websitePreviewsmall_file')->setMessages(array('File is required and should be image.'));
            }            
		}
        //$websiteForm->get('websitePreviewsmall')->setMessages('File has an incorrect extension');
		return array(
			'websiteForm' => $websiteForm,
		);
	}
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id');
        if($id != 0) {
            $this->getWebsitesModel()->deleteWebsite($id);
        }
        return $this->redirect()->toRoute('zfcadmin/centraldb/site/default', array('action'=>'listWebsites'));
    }
    
    public function editWebsiteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if($id == 0) {
            return $this->redirect()->toRoute('zfcadmin/centraldb/site/default', array('action'=>'listWebsites'));
        }
        $website = $this->getWebsitesModel()->getWebsite($id);
        
        $website['websiteCategories'] = explode(",", $website['websiteCategories']);
        
        if(!$website) {
            return $this->redirect()->toRoute('zfcadmin/centraldb/site/default', array('action'=>'listWebsites'));
        }
        $websiteForm = new WebsiteForm($this->getServiceLocator(), $this->getWebsiteCategoriesModel());
        
		$s3ImageUploadService = new S3ImageUploadService();
		
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost()->toArray();
            $files = $request->getFiles()->toArray();
            
            //$post = array_merge_recursive($data, $files);  
            
            if($files['websitePreviewsmall_file']['error'] == 0 && in_array($files['websitePreviewsmall_file']['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
                $post['websitePreviewsmall'] = $files['websitePreviewsmall_file']['name'];
                $post['websitePreviewlarge'] = $post['websitePreviewsmall'];
            }
            
            if($post['websitePreviewsmall']){
            
                $websiteForm->setData($post);                           
                
                if($websiteForm->isValid()) {                           
                    if($files['websitePreviewsmall_file']['error'] == 0){
                        $s3ImageUploadService->imageUpload($files['websitePreviewsmall_file'], 'website/' . $post['websiteSlug'] . '/');
                    }
                    $post['websiteCategories'] = implode(",", $post['websiteCategories']);
                    $this->getWebsitesModel()->editWebsite($id, $post);                
                    return $this->redirect()->toRoute('zfcadmin/centraldb/site/default', array('action'=>'listWebsites'));
                }
            } else {
                $websiteForm->get('websitePreviewsmall_file')->setMessages(array('File is required and should be image.'));
            }            
        } else {            
            $websiteForm->setData($website);
        }
		$fileExist = $s3ImageUploadService->checkFileExist($website['websitePreviewsmall'], "website/" . $website['websiteSlug']. "/");
		if ($fileExist){
        	$image_url = $s3ImageUploadService->getFileUrl($website['websitePreviewsmall'], "website/" . $website['websiteSlug']. "/");	                
        }else{
            $image_url = "/admin-assets/images/noimage.jpg";
        }	
        return array(
            'websiteForm'   => $websiteForm,
            'id'            => $id,
            'image_url'		=> $image_url,
        );
    }
	
	public function getWebsitesModel() {
		if(!$this->websitesModel) {
    		$this->websitesModel = $this->getServiceLocator()->get('CentralDB\Model\WebsitesModel');
    	}
        
        return $this->websitesModel;
	}
	
	public function getWebsiteCategoriesModel() {
		if(!$this->websiteCategoriesModel) {
    		$this->websiteCategoriesModel = $this->getServiceLocator()->get('CentralDB\Model\WebsiteCategoriesModel');
    	}
		return $this->websiteCategoriesModel;
	}	
}
