<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Content for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Content\Controller;

use AceLibrary\Controller\AceController;
use Travel\Form\SearchForm;

/**
 * @author n3ziniuka5
 * @property \Content\Model\ContentModel	$contentModel
 */
class ContentController extends AceController
{
    
    protected $contentModel;
    
    public function indexAction()
    {
        $searchForm = new SearchForm($this->getServiceLocator());
        $id = (int) $this->params()->fromRoute('id');
        $page = $this->getContentModel()->get($id);
        if(!$page) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $meta = array(
            array(
                'name'  => 'description',
                'value' => $page->getContentMetaDescription(),                
            ),
            array(
                'name'  => 'keywords',
                'value' => $page->getContentMetaKeywords(),
            )
        );
        $this->layout()->meta = $meta;
        $this->layout()->title = $page->getContentMetaTitle();
        return array(
            'id'            => $id,
            'page'          => $page,
            'searchForm'    => $searchForm,
        );
    }
    
    protected function getContentModel() {
        if(!$this->contentModel) {
            $this->contentModel = $this->getServiceLocator()->get('Content\Model\ContentModel');
        }
        return $this->contentModel;
    }
}
