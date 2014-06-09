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
class GetMenuItems extends AbstractViewHelper
{

    public $menuItemTable;
    public $destinationTable;

    public function __invoke($function = "getItems", $id = '1')
    {
        try {

            switch ($function) {
                case 'getItems':
                    return $this->getItems($id);;
                    break;
                case 'getAreas':
                    return $this->getAreas();;
                    break;
                default:
                    ;
                    break;
            }
        }
        catch (\Exception $e) {
        }
    }

    public function getItems($menuId = 1)
    {
        $this->menuItemTable = $this->getServiceManager()->get('Travel\Model\MenuItemTable');
        $result              = array($this->menuItemTable->getItems('1'));
        return $result;
    }

    public function getAreas()
    {
        $this->destinationTable = $this->getServiceManager()->get('Travel\Model\DestinationTable');
        return $this->destinationTable->fetchAll();
    }
}
