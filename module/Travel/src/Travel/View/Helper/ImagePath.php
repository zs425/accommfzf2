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
class ImagePath extends AbstractViewHelper
{

    public function __invoke($product)
    {
        if (is_array($product)) {
            $productId       = $product['productId'];
            $productSource   = $product['productSource'];
            $productSourceId = $product['productSourceId'];
        }
        else if ($product instanceof \Travel\Model\Product) {
            $productId       = $product->product_id;
            $productSource   = $product->product_source;
            $productSourceId = $product->product_source_id;
        }
        else if ($product instanceof \Travel\Entity\Product) {
            $productId       = $product->getProductId();
            $productSource   = $product->getProductSource();
            $productSourceId = $product->getProductSourceId();
        }
        else {
            throw new \Exception('Unknown argument passed');
        }
        switch ($productSource) { // work out id used for image path
            case 'v3':
                $imagepathid    = $productId;
                $imagepathdelim = "/";
                break;
            case 'roamfree':
                $imagepathid    = $productSourceId;
                $imagepathdelim = "/";
                break;
            case 'hc':
                $imagepathid    = '';
                $imagepathdelim = "";
                break;
            case 'atdw':
                $imagepathdelim = '';
                $productSource  = '';
                break;

        }
        $productimagepath = "http://images.bookaccommodationonline.com.au/" . $productSource . $imagepathdelim . $imagepathid . $imagepathdelim;
        return $productimagepath;
    }
}

