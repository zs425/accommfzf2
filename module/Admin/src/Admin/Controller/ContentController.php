<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\AliasForm;
use Admin\Form\AliasActionsForm;
use Admin\Model\ContentModel;
use Admin\Form\PagesActionsForm;
use Admin\Form\SearchForm;
use Admin\Form\PageForm;
use AceLibrary\Controller\AceController;

/**
 * @author n3ziniuka5
 * @property \Zend\I18n\Translator\Translator	$translator
 * @property \Admin\Model\ContentModel			$contentModel;
 *
 */
class ContentController extends AceController {
    
    protected $contentModel;
    
    //Pages
    public function addPageAction() {
        $pageForm = new PageForm($this->getServiceLocator());
        $pageForm->addUniqueValidator('alias_route', 'Travel\Entity\Alias', 'aliasRoute', 'aliasId', $this->getTranslator()->translate('Route already in use'));
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            $pageForm->setData($post);
            if($pageForm->isValid()) {
                $this->getContentModel()->addPage($pageForm->getData());
                return $this->redirect()->toRoute('zfcadmin/content');
            }
        }
        $this->layout()->heading = 'Add Page';
        return array(
            'pageForm'  => $pageForm,
        );
    }
    
    public function editPageAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 0) {
            return $this->redirect()->toRoute('zfcadmin/content');
        }
        $page = $this->getContentModel()->getPage($id);
        if(!$page) {
            return $this->redirect()->toRoute('zfcadmin/content');
        }
        $pageForm = new PageForm($this->getServiceLocator());
        $pageForm->addUniqueValidator('alias_route', 'Travel\Entity\Alias', 'aliasRoute', 'aliasId', $this->getTranslator()->translate('Route already in use'), $page['alias_id']);
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            $pageForm->setData($post);
            if($pageForm->isValid()) {
                $data = $pageForm->getData();
                $data['last_alias'] = $page['alias_route'];
                $data['last_alias_id'] = $page['alias_id'];
                $this->getContentModel()->editPage($id, $data);
                return $this->redirect()->toRoute('zfcadmin/content');
            }
        }
        else {
            $pageForm->setData($page);
        }
        
        return array(
            'pageForm'  => $pageForm,
            'id'        => $id,
        );
    }
    
    public function listPagesAction() {
        $pagesActionsForm = new PagesActionsForm($this->getServiceLocator());
        $searchForm = new SearchForm($this->getServiceLocator());
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            if(array_key_exists("submit-searchForm", $post)) {
                $searchForm->setData($post);
                $searchForm->isValid();
                $pageList = $this->getContentModel()->getPageList($post['search']);
            } else {
                $pagesActionsForm->setData($post);
                if($pagesActionsForm->isValid()) {
                	if($post['action'] == PagesActionsForm::ACTION_DELETE && array_key_exists('pages', $post) && is_array($post['pages']) && count($post['pages']) == count($post['pages'], COUNT_RECURSIVE)) {
                		$this->getContentModel()->bulkDelete($post['pages']);
                	}
                }
            }
        }
        if(!isset($pageList)) {
            $pageList = $this->getContentModel()->getPageList();
        }
        $this->layout()->heading = $this->getTranslator()->translate('Pages');
        return array(
            'pagesActionsForm'      => $pagesActionsForm,
            'pageList'              => $pageList,
            'searchForm'            => $searchForm,
        );
    }
    
    //Content
    public function deleteAction() {
    	$id = (int) $this->params()->fromRoute('id');
    	if($id != 0) {
    	   $this->getContentModel()->delete($id);
    	}
    	return $this->redirect()->toRoute('zfcadmin/content');
    }
    
    protected function getContentModel() {
    	if(!$this->contentModel) {
    		$this->contentModel = $this->getServiceLocator()->get('Admin\Model\ContentModel');
    	}
    	return $this->contentModel;
    }
    
}
