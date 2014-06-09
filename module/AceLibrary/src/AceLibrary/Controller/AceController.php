<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/AceLibrary for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AceLibrary\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * @author n3ziniuka5
 * @property Zend\I18n\Translator\Translator	$translator
 */
abstract class AceController extends AbstractActionController
{
	protected $translator;
	
	protected function getTranslator() {
		if(!$this->translator) {
			$this->translator = $this->getServiceLocator()->get('translator');
		}
		return $this->translator;
	}
}