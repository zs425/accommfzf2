<?php

/**
 * TravelViewHelper
 *
 * @author
 * @version
 */
namespace Travel\View\Helper;

use AceLibrary\View\Helper\AbstractViewHelper;

/**
 * View Helper
 */
class ThemeElement extends AbstractViewHelper
{


    public function __invoke($element = null, $template, $options = null, $partialLoop = false)
    {
        try {
            if (!$partialLoop) {
                $this->getView()->el         = $options;
                $this->getView()->elTemplate = $template;
                $this->getView()->selfPath   = "public/shared/$element/$template";
                // css inside
                //		return $this->getView()->partial(PUBLIC_PATH . "/shared/$element/$template/$template.php");
                //	return $this->render(PUBLIC_PATH . "/shared/$element/$template/$template.php");
            }
            else {
                $this->getView()->headLink()->appendStylesheet($this->view->cmsUrl() . "/shared/$element/$template/$template.css");
                return $this->getView()->partialLoop("$element/$template/$template.php", $options);
            }
        }
        catch (Zend_View_Exception $e) {
            $msg = (APPLICATION_ENV == 'development') ? '<span style="font-size:12px">' . $e->getMessage() . '</span>' : '';
            return '<div style="background:#f00;color:white;font-size:1.5em;width:500px;height:75px;text-align:center;margin:auto">Element ' . $element . ':' . $template . ' error <br />' . $msg . '</div>';
        }
    }
}
