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
class GetCategory extends AbstractViewHelper
{

    public function __invoke($function = "category", $categoryCode = null, $plural = null)
    {
        try {

            switch ($function) {
                case 'category':
                    return $this->category($categoryCode, $plural);
                    break;

                default:
                    ;
                    break;
            }
        }
        catch (\Exception $e) {
        }
    }

    public function category($categoryCode, $plural = true)
    {
        switch ($categoryCode) {
            case 'ACCOMM':
                return 'Accommodation';
                
            case 'ATTRACTION':
                return ($plural)?'Attractions':'Attraction';
                
            case 'EVENT':
                return ($plural)?'Events':'Event';
                
            case 'ARCHIVES':
            	return ($plural)?'Archives':'Archive';
        }
        return $categoryCode;
    }
}
