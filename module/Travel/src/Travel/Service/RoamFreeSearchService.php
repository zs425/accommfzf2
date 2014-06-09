<?php
namespace Travel\Service;

use Doctrine\ORM\AbstractQuery;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Model\DestinationModel          $destinationModel
 * @property \AceLibrary\Service\RoamfreeService     $aceRoamfreeService
 * @property \Travel\Model\ProductModel              $productModel
 */
class RoamFreeSearchService extends AbstractService
{

    protected $destinationModel;
    protected $aceRoamfreeService;
    protected $productModel;

    public function getResults($area, $date, $nights, $guests, $destinationIds, $dest)
    {
        $config = $this->getConfig();
        if (isset($config['providers']['roamfree']['enable']) && !$config['providers']['roamfree']['enable']) {
            return;
        }
        if ($area) {
            if ($dest['baodestinationSource'] == 'roamfree') {
                $roamfreeAreas = array($destinationIds['roamfree']);
            }
        }
        else {
            $roamfreeAreas = $this->getDestinationModel()->getRoamfreeAreasArray();
        }

        if (isset($roamfreeAreas) && $roamfreeAreas) {
            $dates = $this->getAceRoamfreeService()->getDates($date, $nights);
            try {
                $rates = $this->getAceRoamfreeService()->getHotelRates($dates['checkIn'], $dates['checkOut'], $guests, 0, $roamfreeAreas);
            }
            catch (Exception $e) {
                /*
                 * @todo this needs to be logged
                 */
                return array();
            }
            $products = $this->getProductModel()->getBySourceIds(array_keys($rates));
            foreach ($products as $i => &$p) {
                if (array_key_exists($p['productSourceId'], $rates)) {
                    $p['rates']     = $rates[$p['productSourceId']]["rates"];
                    $p['GrossRate'] = $rates[$p['productSourceId']]["GrossRate"];
                    $p['bookUrl']   = $this->getAceRoamfreeService()->getBookUrl($p['productSourceId'], str_replace(' ', '-', $date), $nights, $guests);
                    $p['nights']    = $nights;
                }
                else {
                    unset($products[$i]);
                }
            }
            return $products;
        }
    }

    public function getProductResults(\Travel\Entity\Product $product, $date, $nights, $adults, $children)
    {
        $config = $this->getConfig();
        // check In (from 4pm default)
        $checkinDate = date('Y-m-d\TH:i:s', strtotime($date) + 3600 * 16);
        // check In (from 10am default)
        $checkoutDate = date('Y-m-d\TH:i:s', strtotime($date) + 3600 * 24 * $nights + 3600 * 10);

        $rates = $this->getAceRoamfreeService()->getHotelRoomRates($product->getProductSourceId(), $checkinDate, $checkoutDate, $adults, $children);

        // if single row returned
        if (isset($rates->Grid)) {
            $rates = array($rates);
        }

        $dates    = array();
        $maxDates = $config['roamfree']['max-dates'];
        for ($i = 0; $i < $maxDates; $i++) {
            $j         = (strtotime($date) + 3600 * 24 * $i);
            $dates[$i] = date('D', $j) . '<br/>' . date('d', $j) . '<br/>' . date('M', $j);
        }
        foreach ($rates as $rate) {
            $rate->Grid->Day = array_slice($rate->Grid->Day, 0, $maxDates);
        }

        $results              = array();
        $results['rates']     = $rates;
        $results['rawParams'] = urlencode("date={$date}&nights={$nights}&adults={$adults}&children={$children}&product={$product->getProductId()}&source_id={$product->getProductSourceId()}");
        $results['dates']     = $dates;
        return $results;
    }

    protected function getProductModel()
    {
        if (!$this->productModel) {
            $this->productModel = $this->getServiceManager()->get('Travel\Model\ProductModel');
        }
        return $this->productModel;
    }

    protected function getAceRoamfreeService()
    {
        if (!$this->aceRoamfreeService) {
            $this->aceRoamfreeService = $this->getServiceManager()->get('AceLibrary\Service\RoamfreeService');
        }
        return $this->aceRoamfreeService;
    }

    protected function getDestinationModel()
    {
        if (!$this->destinationModel) {
            $this->destinationModel = $this->getServiceManager()->get('Travel\Model\DestinationModel');
        }
        return $this->destinationModel;
    }

}