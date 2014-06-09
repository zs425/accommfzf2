<?php
namespace Travel\Service;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Travel\Model\ProductModel          $productModel
 * @property \Travel\Service\V3ProviderService   $v3ProviderService
 * @property \AceLibrary\Service\V3Service       $aceV3Service
 */
class V3SearchService extends AbstractService
{

    protected $productModel;
    protected $v3ProviderService;
    protected $aceV3Service;

    public function getResults($area, $date, $nights, $guests, $dest)
    {
        $config = $this->getConfig();
        if (isset($config['providers']['v3']['enable']) && !$config['providers']['v3']['enable']) {
            return array();
        }
        if ($area) {
            $products = $this->getProductModel()->getIdsByProviderAndArea('v3', $dest);
        }
        else {
            $products = $this->getProductModel()->getIdsByProvider('v3');
        }
        $productarray = array();
        foreach ($products as $p) {
            $productarray[] = array('short_name' => $p['productSourceId']);
        }
        $date        = strtotime($date);
        $date        = date('Y-m-d', $date);
        $values      = array('txtShortName' => $productarray, 'selIndustryCategory' => 'Accommodation', 'chkOptIn' => 'on', 'txtStartDate' => $date, 'txtDays' => $nights);
        $result      = $this->getV3ProviderService()->getCalendarSearch($values);
        $resultCount = count($result);
        $c           = 0;
        foreach ($products as &$p) {
            $p['nights']    = $nights;
            $p['GrossRate'] = 0;
            $p['rates']     = array();
            if (isset($result[$c])) {
                if ($resultCount > 1) {
                    foreach ($result[$c]->Availability->AvailabilityDate as $key => $a) {
                        if (isset($a->price)) {
                            $p['rates'][$a->start_date] = $a->price;
                            $p['GrossRate']             = $p['GrossRate'] + $a->price;
                        }
                    }
                }
                else {
                    foreach ($result->Availability->AvailabilityDate as $a) {
                        if (isset($a->price)) {
                            $p['rates'][$a->start_date] = $a->price;
                            $p['GrossRate']             = $p['GrossRate'] + $a->price;
                        }
                    }
                }
                $c++;
            }
            $p['bookUrl'] = $this->getAceV3Service()->getBookUrl($p['productSourceId'], $date, $nights, $guests);
        }
        foreach ($products as $i => $p) {
            if (!$p['rates']) {
                unset($products[$i]);
            }
        }
        return $products;
    }

    public function getProductResults(\Travel\Entity\Product $product, $date, $nights, $adults, $children)
    {
        $config  = $this->getConfig();
        $rates   = $this->getAceV3Service()->getRoomRates($product->getProductSourceId(), $date, $nights, $adults, $children, $minNights, true);
        $results = array();
        if ($minNights) {
            $results['minNightsWarning'] = true;
        }
        else {
            $results['minNightsWarning'] = false;
        }
        $dates    = array();
        $maxDates = $config['roamfree']['max-dates'];
        for ($i = 0; $i < $maxDates; $i++) {
            $j         = (strtotime($date) + 3600 * 24 * $i);
            $dates[$i] = date('D', $j) . '<br/>' . date('d', $j) . '<br/>' . date('M', $j);
        }
        $results['rates']     = $rates;
        $results['dates']     = $dates;
        $results['rawParams'] = urlencode("date={$date}&nights={$nights}&adults={$adults}&children={$children}&provider=v3&product={$product->getProductName()}&source_id={$product->getProductSourceId()}");
        return $results;
    }

    protected function getV3ProviderService()
    {
        if (!$this->v3ProviderService) {
            $this->v3ProviderService = $this->getServiceManager()->get('Travel\Service\V3ProviderService');
        }
        return $this->v3ProviderService;
    }

    protected function getProductModel()
    {
        if (!$this->productModel) {
            $this->productModel = $this->getServiceManager()->get('Travel\Model\ProductModel');
        }
        return $this->productModel;
    }

    protected function getAceV3Service()
    {
        if (!$this->aceV3Service) {
            $this->aceV3Service = $this->getServiceManager()->get('AceLibrary\Service\V3Service');
        }
        return $this->aceV3Service;
    }

}