<?php
namespace Travel\View\Helper;

use AceLibrary\View\Helper\AbstractViewHelper;

class ThumbPath extends AbstractViewHelper
{
    public function __invoke($product, $image=NULL, $base = "http://www.bookaccommodationonline.com.au/images/multimedia/", $thumbsize = NULL)
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
/*        switch ($productSource) { // work out id used for image path
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
        $thumbPath = "http://images.bookaccommodationonline.com.au/" . $width . '/' . $productSource . $imagepathdelim . $imagepathid . $imagepathdelim;

		switch ($productSource) {
			case 'v3':
				$thumbPath = $width . '/' . $productSource . '/' . $imagepathid . '/';
				break;
			case 'roamfree':
				$thumbPath = $width . '/' . $productSource . '/' . $imagepathid . '/';
				break;
		}
		
        return $thumbPath;
*/


		$html = '';
        $thumbhtml = ($thumbsize) ? $thumbsize . "/" : '';
        $image = trim($image, "/");
        		
        if ($image) {            
            switch ($productSource)
            {
                case 'v3':
                    $html .= "http://images.bookaccommodationonline.com.au/" . $thumbhtml . "v3/";
					$imagepath = $productId;
                    break;
                case 'atdw':
                    $html .= $base;
                    $html .= $thumbhtml;
					$imagepath = $productId;
                    break;
                case 'hc':
                    $html .= "http://images.bookaccommodationonline.com.au/" . $thumbhtml . "hc/";
					$imagepath = $productSourceId;
                    break;
            	case 'roamfree':
					$html .= $base . $thumbhtml . $productSource;
                    $html .="/";
					$imagepath = $productSourceId;
                    break;
                default:
					$html .= $base . $thumbhtml . $productSource;
                    $html .="/";
					$imagepath = $productId;
                    break;
            }

            if (($imagepath && $productSource == 'roamfree') || ($imagepath && $productSource == 'v3'))
            {
                $html .= $imagepath . "/";
            }
            
            $html .= $image;
            
        } else {
            $html = "http://images.bookaccommodationonline.com.au/noimage.png";
        }

        return $html;
    }
}