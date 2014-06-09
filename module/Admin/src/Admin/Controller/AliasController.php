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
use Admin\Validator\UniqueValueValidator;
use AceLibrary\Controller\AceController;

/**
 * @author n3ziniuka5
 * @property \Zend\I18n\Translator\Translator	$translator
 * @property \Admin\Model\AliasModel			$aliasModel;
 */
class AliasController extends AceController {
    
    protected $aliasModel;
    
    public function listAction() {
        $aliasActionsForm = new AliasActionsForm($this->getServiceLocator());        
        $aliasForm = new AliasForm($this->getServiceLocator());
        $aliasForm->addUniqueValidator('alias_route', 'Travel\Entity\Alias', 'aliasRoute', 'aliasId', $this->getTranslator()->translate('Route name already in use'));
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            if(array_key_exists('submit-aliasForm', $post)) {
                $aliasForm->setData($post);
                if($aliasForm->isValid()) {
                    $result = $this->getAliasModel()->add($aliasForm->getData());
                    return $this->redirect()->toRoute('zfcadmin/content/alias');
                }
            }
            else {
                $aliasActionsForm->setData($post);
                if($aliasActionsForm->isValid()) {
                    if($post['action'] == AliasActionsForm::ACTION_DELETE && array_key_exists('aliases', $post) && is_array($post['aliases'])) {
                        $this->getAliasModel()->bulkDelete($post['aliases']);
                    }
                }
            }
        }
        $aliasList = $this->getAliasModel()->getList();
        $this->layout()->heading = $this->getTranslator()->translate('Aliases');
        return array(
            'aliasList'         => $aliasList,
            'aliasActionsForm'  => $aliasActionsForm,
            'aliasForm'         => $aliasForm,
        );
    }
    
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $alias = $this->getAliasModel()->get($id);
        if(!$alias) {
            return $this->redirect()->toRoute('zfcadmin/content/alias');
        }
        $aliasForm = new AliasForm($this->getServiceLocator());
        $aliasForm->addUniqueValidator('alias_route', 'Travel\Entity\Alias', 'aliasRoute', 'aliasId', $this->getTranslator()->translate('Route name already in use'), $id);
        $request = $this->getRequest();
        if($request->isPost()) {
            $aliasForm->setData($request->getPost());
            if($aliasForm->isValid()) {
                $result = $this->getAliasModel()->edit($id, $aliasForm->getData());
                return $this->redirect()->toRoute('zfcadmin/content/alias');
            }
        }
        else {
        	$data = array();
        	$data['alias_system'] = $alias->getAliasSystem();
        	$data['alias_route'] = $alias->getAliasRoute();
            $aliasForm->setData($data);
        }
        
        $this->layout()->heading = $this->getTranslator()->translate('Aliases');
        $this->layout()->subHeading = sprintf($this->getTranslator()->translate('Editing Alias id %d'), $id);
        return array(
            'aliasId'   => $id,
            'aliasForm' => $aliasForm,
        );
    }
    
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id');
        $this->getAliasModel()->delete($id);
        return $this->redirect()->toRoute('zfcadmin/content/alias');
    }
    
    protected function getAliasModel() {
    	if(!$this->aliasModel) {
    		$this->aliasModel = $this->getServiceLocator()->get('Admin\Model\AliasModel');
    	}
    	return $this->aliasModel;
    }
    
}
