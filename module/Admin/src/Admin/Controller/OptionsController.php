<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\OptionForm;
use Admin\Form\ProviderForm;
use Admin\Form\OptionsActionsForm;
use Admin\Form\StatusSettingForm;
use Admin\Form\ServiceSettingsForm;
use AceLibrary\Controller\AceController;
use Admin\Form\SiteBlogSettingsForm;
use Admin\Form\SeoSettingForm;
use Admin\Form\SiteSettingForm;
use Zend\Config\Writer\Ini as IniWriter;
use AceLibrary\Tool;

/**
 * @author n3ziniuka5
 * @property \Admin\Model\SettingsModel			$settingsModel
 *
 */
class OptionsController extends AceController {
    
    protected $optionsModel;
    protected $destinationModel;

	public function listAction() {
		$optionForm = new OptionForm($this->getServiceLocator());
		$optionsActionsForm = new OptionsActionsForm($this->getServiceLocator());
		$optionFormErrors = array();
		$request = $this->getRequest();
		if($request->isPost()) {
			$postData = $request->getPost();
			if(array_key_exists('submit-optionForm', $postData)) {
				$optionForm->setData($postData);
				if($optionForm->isValid()) {
					$optionFormData = $optionForm->getData();
					$uniqueValidationData = array();
					$uniqueValidationData['optionName'] = $optionFormData['optionName'];
					$uniqueValidationData['optionCategory'] = $optionFormData['optionCategory'];
					$option = $this->getOptionsModel()->findOneBy($uniqueValidationData);
					if(!$option) {
						$this->getOptionsModel()->add($optionFormData);
						$this->redirect()->toRoute('zfcadmin/settings/options');
					}
					else {
						$optionFormErrors[] = $this->getTranslator()->translate("Such Name/Category pair already exists");
					}
				}
			}
			else {
				$optionsActionsForm->setData($postData);
				if($optionsActionsForm->isValid()) {
					if($postData['action'] == OptionsActionsForm::ACTION_DELETE && array_key_exists('options', $postData) && is_array($postData['options'])) {
						$this->getOptionsModel()->bulkDelete($postData['options']);
					}
				}
			}
		}
		$optionList = $this->getOptionsModel()->getList();
		
		$this->layout()->heading = "Options";
		$this->layout()->subHeading = "Here you can edit database table \"options\" rows";
		return array(
			'optionList'			=> $optionList,
			'optionForm'			=> $optionForm,
			'optionFormErrors'		=> $optionFormErrors,
			'optionsActionsForm'	=> $optionsActionsForm,
		);
	}
	
	public function deleteAction() {
		$id = (int)$this->params()->fromRoute('id');
		$this->getOptionsModel()->delete($id);
		$this->redirect()->toRoute('zfcadmin/settings');
	}
	
	public function editAction() {
		$id = (int)$this->params()->fromRoute('id');
		$option = $this->getOptionsModel()->findOneBy(array('optionId' => $id));
		
		if(!$option) {
			$this->redirect()->toRoute('zfcadmin/settings/options');
		}
		$optionForm = new OptionForm($this->getServiceLocator());
		$optionFormErrors = array();
		$request = $this->getRequest();
		if($request->isPost()) {
			$postData = $request->getPost();
			$optionForm->setData($postData);
			if($optionForm->isValid()) {
				$optionFormData = $optionForm->getData();
				$uniqueValidationData = array();
				$uniqueValidationData['optionName'] = $optionFormData['optionName'];
				$uniqueValidationData['optionCategory'] = $optionFormData['optionCategory'];
				
				$option = $this->getOptionsModel()->findOneBy($uniqueValidationData);
				
				if($option && $option->getOptionId() != $id) {
					$optionFormErrors[] = $this->getTranslator()->translate("Such Name/Category pair already exists");
				}
				else {
					$this->getOptionsModel()->edit($id, $optionFormData);
					$this->redirect()->toRoute('zfcadmin/settings/options');
				}
			}
		}
		else {
			$optionFormData = array();
			$optionFormData['optionName'] = $option->getOptionName();
			$optionFormData['optionValue'] = $option->getOptionValue();
			$optionFormData['optionCategory'] = $option->getOptionCategory();
			$optionForm->setData($optionFormData);
		}
		
		$this->layout()->heading = $this->getTranslator()->translate('Options');
		$this->layout()->subHeading = sprintf($this->getTranslator()->translate('Editing option id %s'), $id);				
		return array(
			'optionId'			=> $id,
			'optionForm'		=> $optionForm,
			'optionFormErrors'	=> $optionFormErrors,
		);
	}

    public function providersAction() {
        $optionForm = new ProviderForm($this->getServiceLocator());
        $optionsActionsForm = new OptionsActionsForm($this->getServiceLocator());
        $optionFormErrors = array();
        $request = $this->getRequest();
        $option = $this->getOptionsModel();
        
        $this->layout()->heading = $this->getTranslator()->translate('Provider Settings');
        if ($request->isPost()){
            $values = $this->getRequest()->getPost();
            $optionForm->setData($values);
            unset($values['save']);
            
            $cfg = $this->getServiceLocator()->get('config');
            $fname = ROOT_PATH . $cfg['config_path'];
            
            $reader = new \Zend\Config\Reader\Ini();
            $config   = $reader->fromFile($fname);
            
            foreach ($values as $key => $val) {
                if (isset($config["providers"][$key])){
                    $config["providers"][$key] = $val;
                }
                else {
                    $option->save($key, $val, 'settings');
                }
            }
            
            $writer = new IniWriter();
            $writer->toFile($fname, $config);
            $this->redirect()->toRoute('zfcadmin/settings/providers');
        }else{
            $values = array();
        
            $cfg = $this->getServiceLocator()->get('config');
            $fname = ROOT_PATH . $cfg['config_path'];
                    
            $reader = new \Zend\Config\Reader\Ini();
            $data   = $reader->fromFile($fname);
            
            $values = array_merge($data['providers'], $option->getCategory('providers'));

            if (!($values['expedia']['id']) && !($values['roamfree']['id']) && !($values['v3']['id']) && !($values['hotelscombined']['id']) && !($values['viator']['id']) && !($values['atdw']['id'])) {
                $destination = $this->getDestinationModel();
                $destIds = $destination->getSearchDestIds();
                
                $destIds['roamfree'][0] ? $values['roamfree']['id'] = $destIds['roamfree'][0] : $values['roamfree']['id'] = '';
                $destIds['v3'] ? $values['v3']['id'] = $destIds['v3'] : $values['v3']['id'] = '';
                $destIds['expedia'] ? $values['expedia']['id'] = $destIds['expedia'] : $values['expedia']['id'] = '';
                $destIds['viator'] ? $values['viator']['id'] = $destIds['viator'] : $values['viator']['id'] = '';
                $destIds['atdw'] ? $values['atdw']['id'] = $destIds['atdw'] : $values['atdw']['id'] = '';
                $destIds['hotelscombined'] ? $values['hotelscombined']['id'] = $destIds['hotelscombined'] : $values['hotelscombined']['id'] = '';
                
                if (!$values['hotelscombined']['id']) {
                    
                    $rawmodel = new CentralRawDestinationModel();

                    $destination_id = $options->get('baodestination_id');
                    if (!($destination_id)) {
                        $centralrf = $destination->getIdsFromSourceId($destIds['roamfree'][0], 'roamfree');
                        $addoption = $options->save('baodestination_id', $centralrf->baodestination_id);
                        $destination_id = $centralrf->baodestination_id;

                    }
                    else { echo "already have id " . $destination_id . "<br/>";}

                    if ($destination_id) {
                        $getrawids = $rawmodel->getListFromBaoId($destination_id);
                        foreach ($getrawids as $raw) {

                            if ($raw['rawdest_source'] = 'hc') {
                                $values['hotelscombined']['id'] = $raw['rawdest_source_id'];
                            }

                        }
                    }
                }
                
                if (!$values['expedia']['id']) {
                    
                    $rawmodel = new Model_CentralRawDestination();

                    $destination_id = $options->get('baodestination_id');
                    if (!($destination_id)) {
                        $desmodel = new Model_CentralDestination();
                        $centralrf = $desmodel->getIdsFromSourceId($destIds['roamfree'][0], 'roamfree');
                        $addoption = $options->save('baodestination_id', $centralrf->baodestination_id);
                        $destination_id = $centralrf->baodestination_id;

                    }
                    else { echo "already have id " . $destination_id . "<br/>";}

                    if ($destination_id) {
                        $getrawids = $rawmodel->getListFromBaoId($destination_id);
                        foreach ($getrawids as $raw) {

                            if ($raw['rawdest_source'] = 'expedia') {
                                $values['expedia']['id'] = $raw['rawdest_source_id'];
                            }

                        }
                    }
                }
            }
            $optionForm->populateValues($values);
        }
        
        return array(
            'form' => $optionForm,
        );
    }


    public function siteAction()
    {
        $siteSettingForm = new SiteSettingForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $siteSettingForm->setData($post);
            $this->_updateSettings($siteSettingForm, $post);
        } else {
            $values = $this->_getCurrentSettings();
            $siteSettingForm->setData($values);
        }
        $this->layout()->heading = 'Site Settings';
        return array(
            'form'  => $siteSettingForm,
        );
    }

    public function blogAction()
    {
        $siteBlogSettingsForm = new SiteBlogSettingsForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $post = $request->getPost();
            $siteBlogSettingsForm->setData($post);
            if($siteBlogSettingsForm->isValid()) {
                //$slideshowId = $this->getSlideshowModel()->addSlideshow($slideshowForm->getData());
                $this->_updateSettings($siteBlogSettingsForm, $post);                
            }
        } else {
            $values = $this->_getCurrentSettings();
            $siteBlogSettingsForm->setData($values);
        }
        $this->layout()->heading = 'Site Blog Settings';
        return array(
            'siteBlogSettingsForm'  => $siteBlogSettingsForm,
        );
    }

    public function themesAction()
    {
        $this->layout()->heading = 'Themes';
        if ($this->getRequest()->isPost()){
            $values = $this->getRequest()->getPost();
            
            $cfg = $this->getServiceLocator()->get('config');
            $fname = ROOT_PATH . $cfg['config_path'];
            
            $reader = new \Zend\Config\Reader\Ini();
            $config   = $reader->fromFile($fname);
            
            if (isset($config["site"]["theme"])){
                $config["site"]["theme"] = $values["theme"];
            }
            
            $writer = new IniWriter();
            $writer->toFile($fname, $config);
            $this->redirect()->toRoute('zfcadmin/settings/themes');
            
        } else {
            $themesPath = ROOT_PATH.'/public/themes';
            $themes = array();
            
            $cfg = $this->getServiceLocator()->get('config');
            $fname = ROOT_PATH . $cfg['config_path'];
                    
            $reader = new \Zend\Config\Reader\Ini();
            $data   = $reader->fromFile($fname);
            
            $currentTheme = $data["site"]["theme"];
            
            // scan themes directory add other themes
            $dirs = Tool::searchdir($themesPath);
            foreach ($dirs as $themeName) {
                $themeDir = $themesPath.'/'.$themeName.'/';
                $themes[$themeName]['dirname'] = $themeName;
                $themes[$themeName]['name'] = $themeName;
                $themes[$themeName]['selected'] = ($currentTheme == $themeName)?1:0;
                if (file_exists($themeDir.$themeName.'.png'))
                    $themes[$themeName]['thumb'] = '/themes/'.$themeName.'/'.$themeName.'.png';
                else
                    $themes[$themeName]['thumb'] = '/admin-assets/images/no-image-theme.png';
            }
            
            return array(
                'themes' => $themes,
            );
        }
        
    }

    public function statusAction()
    { 
        $statusSettingForm = new StatusSettingForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        $status = "";
        
        if($request->isPost()) {
            $post = $request->getPost();
            $statusSettingForm->setData($post);
            $this->_updateSettings($statusSettingForm, $post);
            $status = "saved";
        } else {
            $values = $this->_getCurrentSettings();
            $statusSettingForm->setData($values);
        }
        $this->layout()->heading = 'Status';
        
        return array(
            'form'  => $statusSettingForm,
            'status' => $status,
        );
    }
    public function seoAction()
    {
        $seoSettingForm = new SeoSettingForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $post = $request->getPost();
            $seoSettingForm->setData($post);
            $this->_updateSettings($seoSettingForm, $post);
        } else {
            $values = $this->_getCurrentSettings();
            $seoSettingForm->setData($values);
        }
        $this->layout()->heading = 'Seo Settings';
        return array(
            'form'  => $seoSettingForm,
        );
    }
    public function servicesAction()
    {
        $serviceSettingsForm = new ServiceSettingsForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $post = $request->getPost();
            $serviceSettingsForm->setData($post);
            $this->_updateSettings($serviceSettingsForm, $post);
        } else {
            $values = $this->_getCurrentSettings();
            $serviceSettingsForm->setData($values);
        }
        $this->layout()->heading = 'Site Service Settings';
        return array(
            'form'  => $serviceSettingsForm,
        );
    }
    
    private function _getCurrentSettings()
    {
        $values = array();
        
        $cfg = $this->getServiceLocator()->get('config');
        $fname = ROOT_PATH . $cfg['config_path'];
                
        $reader = new \Zend\Config\Reader\Ini();
        $data   = $reader->fromFile($fname);

        $setttings = $this->getOptionsModel()->getCategory('settings');
        $settingArray = array();

        foreach($setttings as $val) {          
            $settingArray[$val['optionName']] = $val['optionValue'];
        }
        //Start Added on 2012 April 04 By GN
        $values = array_merge($data['site'], $settingArray);
        
        if(isset($data['debug'])){
            $values = array_merge($values, $data['debug']); 
        }

        if(array_key_exists('category', $values) && !empty($values['category']))
            $values['category'] = unserialize($values['category']);    

        return $values;
    }
    
    private function _updateSettings($form, $values)
    {
        $frm_type = $values['frm_type'];
        unset($values['frm_type']);
        unset($values['submit']);
        
        $cfg = $this->getServiceLocator()->get('config');
        $fname = ROOT_PATH . $cfg['config_path'];
        
        $reader = new \Zend\Config\Reader\Ini();
        $data   = $reader->fromFile($fname);
                
        $config = new \Zend\Config\Config($data, true);
        
        /*// upload logo
        if ($form->get('logo')->getValue()) {
            $values['logo'] = $form->get('logo')->getValue()['name'];
        }*/
		
		if(isset($values['logo']['name'])) {
			$values['logo'] = $values['logo']['name'];
		}
        
        foreach ($values as $key => $val) {
            if (isset($config->site->$key)) {
                $config->site->$key = str_replace('"', '&quot;', $val);
            } else if(isset($config->debug->$key)) {
                $config->debug->$key = str_replace('"', '&quot;', $val);
            } else {
                if($key == 'category')
                    $val = serialize($val);
                 
                $this->getOptionsModel()->save($key, $val, 'settings');
            }              
        }
        
        $writer = new \Zend\Config\Writer\Ini();
        
        try{
            $writer->toFile($fname, $config);
        }
        catch (Exception $e)
        {
            die($e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>');
        }
    }
    
    protected function getOptionsModel() {
        if(!$this->optionsModel) {
            $this->optionsModel = $this->getServiceLocator()->get('Admin\Model\OptionsModel');
        }
        return $this->optionsModel;
    }
    
    protected function getDestinationModel() {
        if(!$this->destinationModel) {
            $this->destinationModel = $this->getServiceLocator()->get('Admin\Model\DestinationModel');
        }
        return $this->destinationModel;
    }
}
