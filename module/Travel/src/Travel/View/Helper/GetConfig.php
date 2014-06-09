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
class GetConfig extends AbstractViewHelper
{

    public function __invoke()
    {
        return $this->getServiceManager()->get('config');
    }
}
