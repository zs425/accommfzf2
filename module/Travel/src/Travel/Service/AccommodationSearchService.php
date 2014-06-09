<?php
namespace Travel\Service;

use CentralDB;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Service\V3SearchService                $v3SearchService
 * @property \Travel\Service\RoamFreeSearchService          $roamFreeSearchService
 * @property \Travel\Model\DestinationModel                 $destinationModel
 */
class AccommodationSearchService extends AbstractService
{

    protected $v3SearchService;
    protected $roamFreeSearchService;
    protected $destinationModel;

    public function getResults($date, $guests, $nights, $area = 0)
    {
        $area            = (int)$area;
        $destinationIds  = $this->getDestinationModel()->getSearchDestinationIds($area, $dest); //$dest passed by refference
        $v3Results       = $this->getV3SearchService()->getResults($area, $date, $nights, $guests, $dest);
        $roamFreeResults = $this->getRoamFreeSearchService()->getResults($area, $date, $nights, $guests, $destinationIds, $dest);

        $results             = array();
        $results['v3']       = $v3Results;
        $results['roamfree'] = $roamFreeResults;
        return $results;
    }

    public function getProductResults(\Travel\Entity\Product $product, $date, $nights, $adults, $children)
    {
        if($product->getProductSource() == 'roamfree') {
            return $this->getRoamFreeSearchService()->getProductResults($product, $date, $nights, $adults, $children);
        }
        else if($product->getProductSource() == 'v3') {
            return $this->getV3SearchService()->getProductResults($product, $date, $nights, $adults, $children);
        }
        else {
            throw new \Exception('Unexpected product source');
        }
    }

    protected function getRoamFreeSearchService()
    {
        if (!$this->roamFreeSearchService) {
            $this->roamFreeSearchService = $this->getServiceManager()->get('Travel\Service\RoamFreeSearchService');
        }
        return $this->roamFreeSearchService;
    }

    protected function getV3SearchService()
    {
        if (!$this->v3SearchService) {
            $this->v3SearchService = $this->getServiceManager()->get('Travel\Service\V3SearchService');
        }
        return $this->v3SearchService;
    }

    protected function getDestinationModel()
    {
        if (!$this->destinationModel) {
            $this->destinationModel = $this->getServiceManager()->get('Travel\Model\DestinationModel');
        }
        return $this->destinationModel;
    }

}