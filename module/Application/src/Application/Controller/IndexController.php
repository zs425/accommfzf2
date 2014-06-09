<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use AceLibrary\Controller\AceController;
use Travel\Form\SearchForm;
use Zend\View\Model\ViewModel;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Service\AccommodationSearchService    $accommodationSearchService
 * @property \AceLibrary\Service\ViatorService             $viatorService
 */
class IndexController extends AceController
{
    protected $accommodationSearchService;
    protected $viatorService;

    public function indexAction()
    {
    	$viewModel        = new ViewModel();
		$searchForm       = new SearchForm($this->getServiceLocator());
        $loadContentBoxes = true;
        $request          = $this->getRequest();
        if ($request->isPost()) {
            $postData = $request->getPost();
            $searchForm->setData($postData);
            if ($searchForm->isValid()) {
                $searchFormData   = $searchForm->getData();
                $loadContentBoxes = false;
                $searchResults    = $this->getAccommodationSearchService()->getResults(
                    $searchFormData['commencing'],
                    $searchFormData['guests'],
                    $searchFormData['nights'],
                    $searchFormData['area']
                );
                $viewModel->setVariable('searchResults', $searchResults);
                $viewModel->setTemplate('viewpages/results/search-results');
            }
        }
        if ($loadContentBoxes) {
            $contentboxes = $this->getServiceLocator()->get('Travel\Model\ContentBoxTable');
            $boxes        = $contentboxes->fetchAll();
            $viewModel->setVariable('contentboxes', $boxes);
        }
        $viewModel->setVariable('searchForm', $searchForm);
		return $viewModel;
    }

    protected function getAccommodationSearchService()
    {
        if (!$this->accommodationSearchService) {
            $this->accommodationSearchService = $this->getServiceLocator()->get(
                'Travel\Service\AccommodationSearchService'
            );
        }
        return $this->accommodationSearchService;
    }

    protected function getViatorService()
    {
        if (!$this->viatorService) {
            $this->viatorService = $this->getServiceLocator()->get('AceLibrary\Service\ViatorService');
        }
        return $this->viatorService;
    }
}
