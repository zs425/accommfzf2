<?php
namespace Travel\View\Helper;

use AceLibrary\View\Helper\AbstractViewHelper;

class DisplayProductArea extends AbstractViewHelper
{
    public function __invoke($product)
    {
       if ($product instanceof \Travel\Model\Product) {
           if ($product->product_city){return $product->product_city;}
           elseif ($product->product_area){
               return $product->product_area;
           }
           echo "model";
        }
        else if ($product instanceof \Travel\Entity\Product) {
            echo "entity";
            if ($product->getProductCity()){return $product->getProductCity();}
            elseif ($product->getProductArea()){
               return $product->getProductArea();
            }
        }
        else {
            throw new \Exception('Unknown argument passed');
        }


    }
}