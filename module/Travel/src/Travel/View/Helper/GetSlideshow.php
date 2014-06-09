<?php

/**
 * TravelViewHelper
 *
 * @author
 *
 * @version
 *
 */
namespace Travel\View\Helper;
use AceLibrary\View\Helper\AbstractViewHelper;

/**
 * View Helper
 */
class GetSlideshow extends AbstractViewHelper
{
	public $_slideshowModel;
	public $_slideshowImagesModel;
	
    public function __invoke($function = "getSlideshow", $val = '')
    {
        try {
            switch ($function) {
                case 'getSlideshow':
                    return $this->getSlideshow($val);;
                    break;                
				case 'getSlideshowImages':
					return $this->getSlideshowImages($val);;
                    break;
				default:                    	
                    break;
            }
        }
        catch (\Exception $e) {
        }
    }

    public function getSlideshow($slideshow_uri = '')
    {
    	$this->_slideshowModel = $this->getServiceManager()->get('Travel\Model\SlideshowModel');
		$result = $this->_slideshowModel->getSlideshowByUri($slideshow_uri);
        return $result;
    }
	
	public function getSlideshowImages($slideshow_id = '')
    {
    	$this->_slideshowImagesModel = $this->getServiceManager()->get('Travel\Model\SlideshowImagesModel');
		$result = $this->_slideshowImagesModel->getImagesBySlideshowId($slideshow_id);
        return $result;
    }   
}
