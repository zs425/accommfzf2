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
class AtdwClassifications extends AbstractViewHelper
{


    static $aliases = array(
        // ATTRACTION Vertical Classification
        'AMUSETHEME'   => 'amusement', // Amusement and Theme Parks
        'CLASSWRKSP'   => 'workshops', // Classes, Lessons and Workshops
        'DINEATOUT'    => 'restaurants', // Dining and Eating Out
        'ENTERTAIN'    => 'entertainment',
        'FRMFOODPRD'   => 'farming', // Farming, Food and Produce
        'GALMUSECOL'   => 'museums', // Galleries, Museums and Collections
        'HISTHERITG'   => 'heritage_locations', // Historical Sites and Heritage Locations
        'LMARKBLD'     => 'landmarks', //Landmarks and Buildings
        'MARKET'       => 'markets',
        'MINDUSTRY'    => 'industry', // Mining and Industry
        'NATATTRACT'   => 'nature', // Natural Attractions
        'NATPARKRES'   => 'national_parks', // National Parks and Reserves
        'OBSVPLANET'   => 'observatories', // Observatories and Planetariums
        'PKGDNCEM'     => 'parks', // Parks and Gardens
        'SCENDRVWLK'   => 'scenic_walks', // Scenic Drives and Walks
        'SHOPPING'     => 'shopping',
        'SPARETREAT'   => 'spa_and_retreats', // Spas and Retreats
        'SPORTREC'     => 'sport', // Sports and Recreation Facilities
        'WINVINBREW'   => 'wineries', // Wineries, Vineyards and Breweries
        'ZOOSNCAQU'    => 'zoo_and_wildlife', // Zoos, Sanctuaries, Aquariums and Wildlife Park

        // ACCOMM Vertical Classification
        'APARTMENT'    => 'apartments',
        'BACKPACKER'   => 'hostels', // Backpackers and Hostels
        'BACKPACKER_H' => 'backpackers', // Backpacker_Hostel
        'BEDBREAKFA'   => 'bed_and_breakfasts', // Bed and Breakfasts
        'BNB'          => 'bed_and_breakfast', // BnB
        'CABCOTTAGE'   => 'cottages', // Cabins and Cottages
        'CABIN'        => 'cabin',
        'CHALET'       => 'chalet',
        'CONDO'        => 'condo',
        'COTTAGE'      => 'cottage',
        'FARMSTAY'     => 'farm_stay', // Farm Stays
        'GUEST_HOUSE'  => 'guest_house',
        'HOLHOUSE'     => 'holiday_houses',
        'HOLIDAY_HOUS' => 'holiday_house',
        'HOLIDAY_PARK' => 'holiday_park',
        'HOTEL'        => 'hotels',
        'HOUSEBOAT'    => 'houseboat',
        'LODGE'        => 'lodge',
        'MOTEL'        => 'motels',
        'PRIVATE_APAR' => 'apartment', // Private Apartments
        'RESORT'       => 'resorts',
        'RETREAT'      => 'retreat', // Retreat & Lodge
        'SAFARI'       => 'safari_retreat', // Wilderness Safari Retreat
        'SELFCONTAI'   => 'self_contained',
        'TOURIST_CARA' => 'tourist_caravan_park',
        'VANCAMP'      => 'camping', // Caravan and Camping
        'VILLA'        => 'villa',
    );


    public function __invoke($code)
    {
        try {
            $code = strtoupper($code);
            return (isset(self::$aliases[$code])) ? self::$aliases[$code] : strtolower($code);
        }
        catch (\Exception $e) {
            // return $e->getMessage();
            // return '<div
            // style="background:#f00;color:white;font-size:1.5em;width:500px;height:75px;text-align:center;margin:auto">Element
            // '.$element.':'.$template.' error <br />'.$msg.'</div>';
        }
    }

}
