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
class GetDestinations extends AbstractViewHelper
{

    public $destinationTable;

    public function __invoke($function = "getDestinationBlock", $productType = null, $classification = null, $count = false, $parent = null, $config = false)
    {
        try {

            switch ($function) {
                case 'getDestinationBlock':
                    return $this->getDestinationBlock($productType, $classification, $count, $parent, $config);;
                    break;

                default:
                    ;
                    break;
            }
        }
        catch (\Exception $e) {
        }
    }

    public function getDestinationBlock($productType = null, $classification = null, $count = false, $parent = null, $config = false)
    {
        $this->destinationTable = $this->getServiceManager()->get('Travel\Model\DestinationTable');
        $result                 = array($this->destinationTable->getDestinationBlock($productType, $classification, $count, $parent, $config));
        return $result;
    }

    public function getAreas()
    {
        $this->destinationTable = $this->getServiceManager()->get('Travel\Model\DestinationTable');
        return $this->destinationTable->fetchAll();
    }
}
