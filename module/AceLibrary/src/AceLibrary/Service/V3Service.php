<?php
namespace AceLibrary\Service;

use Zend\Http\Client;
use Zend\Json\Json;

class V3Service extends AceService
{

    //const COOKIE_FILE        = '/tmp/my_cookies.txt';
    const COOKIE_FILE = 'c:/server/workspace/accomodationcms/source/my_cookies.txt';

    const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";

    const V3_BOOKINGS_URL    = "http://www.au.v3travel.com/VCubed/Page/Distributor/DistributorBookings.aspx?mainindex=4&subindex=1";
    const V3_LOGIN_URL       = 'http://www.au.v3travel.com/VCubed/Page/User/Login.aspx';
    const V3_REFERRER        = "http://www.au.v3travel.com";
    const V3_STATS_URL       = "http://www.au.v3travel.com/VCubed/Page/Distributor/DistributorBookings.aspx?mainindex=4&subindex=1";
    const V3_RESERVATION_URL = "http://www.au.v3travel.com/VCubed/Page/Distributor/DistributorBookings.aspx?ReservationId=%value%&mainindex=5&subindex=1&UQry=a478afc5-a541-4f50-b218-7a6b73e6a6ee";
    const V3_TRANSACTION_URL = "http://www.au.v3travel.com/VCubed/Page/Distributor/DistributorBookings.aspx?ReservationId=%value%&mainindex=5&subindex=1&UQry=a478afc5-a541-4f50-b218-7a6b73e6a6ee";


    /*
     * cache - put results to file
     * test  - get from file, don't do any requests
     * null  - production
     */
    protected $_requestUrl = 'http://www.au.v3travel.com/CABS.WebServices/SearchService.asmx?WSDL';
    //protected $_requestUrl = 'http://www.au.v3travel.com/CABS.WebServices/SearchServiceAdapters.asmx?';
    protected $_v3Id = '';
    protected $_v3Key = '';
    public $_v3login;
    public $_v3pass;
    protected $_errors = array();
    protected $mode = null;

    protected $registryService;

    public function __construct()
    {
        $this->_v3login = 'ace_web_design_web_Paul';
        $this->_v3pass  = "Talisha2!";
    }

    public function make_xml_request($request, $use_https = false)
    {
        $dom               = dom_import_simplexml(simplexml_load_string($request))->ownerDocument;
        $dom->formatOutput = true;
        echo '<PRE style="color:#006600;padding:10px;text-align:left">', htmlspecialchars($dom->saveXML()), '</PRE>';
        if ($use_https) {
            $request = urlencode($request);
        }
        $curl_attempts = 0;
        do {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL,
                ($use_https ? 'https' : 'http') .
                '://www.au.v3travel.com/CABS.WebServices/SearchService.asmx?WSDL');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'xml=' . $request);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array('Content-type:application/x-www-form-urlencoded'));
            $response = trim(curl_exec($curl));
            curl_close($curl);
        }
        while (strlen($response) == 0 &&
            ++$curl_attempts < MAXIMUM_CURL_ATTEMPTS);
        if (strlen($response) == 0) {
            $response = '<response><error>Error reaching XML gateway</error></response>';
        }
        $dom               = dom_import_simplexml(simplexml_load_string($response))->ownerDocument;
        $dom->formatOutput = true;
        echo '<PRE style="color:#000066;padding:10px;text-align:left">', htmlspecialchars($dom->saveXML()), '</PRE>';
        return $response;
    }


    public function getHotelRates($v3AreaCode, $date, $nights = 2, $adults = 2, $children = 0)
    {
        $config = $this->getConfig();
        $url    = 'http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderSearch.aspx';
        $client = new Zend_Http_Client();
        $client->setCookieJar();
        $client->setUri($url);
        $client->setConfig(array(
                'maxredirects' => 3,
                'timeout'      => 30)
        );
        $dayMonth = $this->getDate($date, 'dd MMM y');
        $params   = array(
            'commencingDayAccomm'   => $dayMonth['day'],
            'commencingMonthAccomm' => $dayMonth['month'],
            'nightsAccomm'          => $nights,
            'adultsAccomm'          => $adults,
            'childrenAccomm'        => $children,
            'concessionsAccomm'     => 0,
            'exl_dn'                => $config['keys']['v3'],
            'exl_bs'                => $config['keys']['v3'],
            'exl_siz'               => 'lge',
            'tabscategory'          => 'accomm',
            'categoryGrouping'      => 'accomm',
            // @todo destination
            'exl_ist'               => 'sa',
            'exl_expanded'          => true,
            'regionAccomm'          => $v3AreaCode,
        );
        $client->setParameterGet($params);
        //$client->setRawData('__EVENTTARGET', 'ctl00$PageContent$ucDiscoveryBodySection$ucSearchResults$lnkPagingTop_2');

        /* $urlTest = '';
          foreach ($params as $k=>$v) {
          $urlTest .= '&'.$k.'='.$v;
          }
          $urlTest = $url.'?'.substr($urlTest, 1);
          Zend_Debug::dump($urlTest); */

        if ($this->mode != 'test') {
            $response = $client->request();
            $htmlPage = $response->getBody();
        }
        if ($this->mode == 'cache') {
            file_put_contents(ROOT_PATH . '/data/v3hotels.php', $htmlPage);
        }
        if ($this->mode == 'test') {
            $htmlPage = file_get_contents(ROOT_PATH . '/data/v3hotels.php');
        }

        // check pagination
        /* if(preg_match('/discovery_results_paging_value_selected.*?\>(\d*)\<\/span\>/si', $htmlPage, $m)) {
          $currentPage = $m[1];
          // is there next page?
          preg_match('/_ucSearchResults_lnkPagingBottom_2.*?\>(\d*)\</si', $htmlPage, $m);
          if(isset($m[1]) && !empty($m[1]) && $currentPage < $m[1]) {
          $nextPage = $m[1];
          echo "<h1>Next Page $m[1]</h1>";
          }
          echo '<h1>Pagination</h1>';
          } */

        $data = $this->getCleanHotelRates($htmlPage, $date, 'dd MMM y');

        return $data;
    }

    public function getBookUrl($psn, $date, $nights = 2, $adults = 2, $children = 0)
    {
        $config = $this->getConfig();
        // http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?
        // exl_dn=ace_web_design_web&exl_psn=Barossa_Country_Cottages&date=2011-06-27&nights=1
        // &category=1&adults=1&children=0&concessions=0 
        $url = 'http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?';
        $url .= 'exl_dn=' . $config['keys']['v3'];
        $url .= '&exl_psn=' . $psn;
        // format date
        $date = date('Y-m-d', strtotime($date));
        $url .= '&date=' . $date;
        $url .= '&nights=' . $nights;
        $url .= '&category=1';
        $url .= '&adults=' . $adults;
        $url .= '&cildren=' . $children;
        $url .= '&concessions=0';
        return $url;
    }

    public function getRoomRates($psn, $date, $nights = 2, $adults = 2, $children = 0, &$minNights = false, $calendar = false)
    {
        $config = $this->getConfig();
        // format dates
        $dateHotel = date('Y-m-d', strtotime($date));
        $dateRoom  = date('Y/m/d', strtotime($date));

        // get rooms (html page)
        // http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?exl_dn=ace_web_design_web&exl_psn=Barossa_Country_Cottages&date=2011-06-27&nights=1&category=1&adults=1&children=0&concessions=0 
        // http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?exl_dn=ace_web_design_web&exl_psn=gulfvista&exl_bs=ace_web_design_web&date=2011-11-16&nights=2&category=1&adults=2&children=0&concessions=0
        $client = new Client();
        $client->setUri('http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx');
        $client->setParameterGet(array(
            'exl_dn'      => $config['keys']['v3'],
            'exl_psn'     => $psn,
            'date'        => $dateHotel,
            'nights'      => $nights,
            'category'    => 1,
            'adults'      => $adults,
            'children'    => $children,
            'concessions' => 0
        ));

        if ($this->mode != 'test') {
            $response = $client->send();
            $htmlPage = $response->getBody();
        }
        if ($this->mode == 'cache') {
            file_put_contents(ROOT_PATH . '/data/v3-' . $psn . '.php', $htmlPage);
        }
        if ($this->mode == 'test') {
            $htmlPage = file_get_contents(ROOT_PATH . '/data/v3-' . $psn . '.php');
        }

        $rooms = $this->getCleanRooms($htmlPage);
        // get rates (following AJAX requests)
        $client = new Client();
        $client->setUri('http://www.au.v3travel.com/CABS2/DiscoveryServices/AsyncProviderAvailability.aspx/GetAvailability');
        $client->setHeaders(array(
            'Content-Type'     => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ));

        // get rates for one night (for grid) and get for requested amount of nights also
        $rates = array();
        $iter  = array(1);
        if ($nights > 1) {
            $iter[] = $nights;
        }
        foreach ($iter as $i) {
            $request                             = new \stdClass();
            $request->numNights                  = $i;
            $request->criteria                   = new \stdClass();
            $request->criteria->ChannelShortname = $config['keys']['v3'];
            $request->criteria->Shortnames       = array($psn);
            $request->criteria->InstanceId       = 1; // ???

            //
            if ($calendar) {
                $request->criteria->NumberOfDays = 13;
            } else {
                $request->criteria->NumberOfDays = $nights;
            }


            $request->criteria->IndustryCategoryGroup = 'ACCOMM';
            $request->criteria->StartDate             = $dateRoom;
            $request->criteria->Adults                = $adults;
            $request->criteria->Child                 = $children;
            $request->criteria->Concession            = 0;
            $requestPayload                           = Json::encode($request);
            $client->setRawBody($requestPayload);
            $client->setMethod('POST');
            $result = $client->send();
            $result = Json::decode($result->getBody(), Json::TYPE_ARRAY);
            // check if there is "min 2 nights stay" limitation
            if ($i == 1 && !count($result["d"]["Results"])) {
                $minNights = true;
            }

            foreach ($result["d"]["Results"][$psn] as $roomId => $r) {
                $rooms[$roomId]->rates[$i] = $r;
            }

        }
        // "min 2 nights stay" limitation - add rates to the grid anyway
        if ($minNights) {
            foreach ($rooms as $roomId => &$info) {
                $info->rates[1] = $info->rates[$nights];
                $last           = 0;
                foreach ($info->rates[1] as $date => &$i) {
                    if (!isset($i['StartTimes'][0]["TP"]) && $last) {
                        $i['StartTimes'][0]["TP"] = $last;
                    } else {
                        $last = $i['StartTimes'][0]["TP"] = round($i['StartTimes'][0]["TP"] / $nights);
                    }
                }
            }
        }
        return $rooms;
    }


    public function getProviderRates($psn, $date, $nights = 2, $adults = 2, $children = 0, &$minNights = false)
    {
        $config = $this->getConfig();
        // format dates
        $dateHotel = date('Y-m-d', strtotime($date));
        $dateRoom  = date('Y/m/d', strtotime($date));

        // get rooms (html page)
        // http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?exl_dn=ace_web_design_web&exl_psn=Barossa_Country_Cottages&date=2011-06-27&nights=1&category=1&adults=1&children=0&concessions=0 
        // http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx?exl_dn=ace_web_design_web&exl_psn=gulfvista&exl_bs=ace_web_design_web&date=2011-11-16&nights=2&category=1&adults=2&children=0&concessions=0
        $client = new Zend_Http_Client();
        $client->setUri('http://www.au.v3travel.com/CABS2/DiscoveryServices/ProviderAvailability.aspx');
        $client->setParameterGet(array(
            'exl_dn'      => $config['keys']['v3'],
            'exl_psn'     => $psn,
            'date'        => $dateHotel,
            'nights'      => $nights,
            'category'    => 1,
            'adults'      => $adults,
            'children'    => $children,
            'concessions' => 0
        ));
        if ($this->mode != 'test') {
            $response = $client->request();
            $htmlPage = $response->getBody();
        }
        if ($this->mode == 'cache') {
            file_put_contents(ROOT_PATH . '/data/v3-' . $psn . '.php', $htmlPage);
        }
        if ($this->mode == 'test') {
            $htmlPage = file_get_contents(ROOT_PATH . '/data/v3-' . $psn . '.php');
        }

        $rooms = $this->getCleanRooms($htmlPage);


        return $rooms;
    }


    protected function getDate($date, $inputFormat)
    {
        $result  = array();
        $curDate = new Zend_Date(null, null, 'en_AU');
        $selDate = new Zend_Date();
        $selDate->set($date, $inputFormat, 'en_AU');
        // day
        $result['day'] = $selDate->get(Zend_Date::DAY_SHORT);
        // month - strange V3 format year+month+lastDayInMonth(+currentDay if current month selected) i.e 2011+07+31 or 2011+06+30+24
        $time = mktime(0, 0, 0, $selDate->get('MM'), $curDate->get('MM'), $curDate->get('y'));
        $time = mktime(0, 0, 0, $selDate->get('MM'), date("t", $time), $curDate->get('y'));
        $val  = date('Y m d', $time);
        $val .= ($selDate->get('MM') == $curDate->get('MM')) ? ' ' . $curDate->get('dd') : '';
        $result['month'] = $val;
        return $result;
    }

// HTML parsing functions

    /**
     * @param unknown_type $html
     * @param unknown_type $startDate
     * @param unknown_type $inputFormat
     * @return array $hotelRates
     * @example
     * ["Barossa_Shiraz_Estate"] => array(1) {
    ["rates"] => array(14) {
    [1314399600] => string(4) "$275"
    [1315436400] => string(4) "$275"
    [1315522800] => string(4) "$275"
    etc. 14 days
    }
    }
    ["kooringalhomestead"] => array(1) {
    ["rates"] => array(14) {
    [1314399600] => string(4) "$170"
    [1314486000] => string(4) "$170"
    [1314572400] => string(4) "$175"
    etc.
     */
    protected function getCleanHotelRates($html, $startDate, $inputFormat)
    {
        //$this->clearHtml(&$html);
        // calendar header/dates
        preg_match_all('/\<tr class\=\"discovery_provider_grid_header_row\"\>(.*?)\<\/tr\>/si', $html, $rows);
        $thead = $rows[1][0];
        $dates = $this->getMainDates($thead);

        // use own date format
        /* $zd = new Zend_Date();
          $zd->set($startDate, $inputFormat);
          $current = $zd->get(Zend_Date::TIMESTAMP);
          $dates = array();
          for ($i=0; $i<14; $i++) {
          $dates[$i] = date('U', ($current+3600*24*$i));
          } */

        // get rows - each row is provider availability calendar
        preg_match_all('/\<tr class\=\"discovery_provider_grid_provider_row\"\>(.*?\<table.*?\/table\>.*?\/table\>.*?\/table\>.*?\/table\>.*?)\<\/tr\>/si', $html, $rows);
        $products = $rows[1];

        // combine results
        $result = array();
        foreach ($products as $row) {
            $psn = $this->getProviderShortName($row);
            // dates & rates
            $result[$psn]['rates'] = array_combine($dates, $this->getMainRates($row));
        }
        return $result;
    }

    protected function getProviderShortName($html)
    {
        preg_match('/\>.*?<!--(.*?)--><\/td>/si', $html, $psn);
        return $psn[1];
    }

    protected function getMainDates($thead)
    {
        preg_match_all('/discovery_provider_grid_header_date_cell.*?\>(.*?)\<\/td/si', $thead, $cells);
        return $cells[1];
    }

    protected function getMainRates($html)
    {
        preg_match_all('/discovery_provider_grid_price_cell.*?\>\$*(.*?)\</si', $html, $cells);
        return $cells[1];
    }

    protected function getCleanRooms($html)
    {
        $this->clearHtml($html);

        preg_match_all('/productNameCell\"\>\<div class\=\"outerContainer\"\>(.*?)\<\/div\>\<\/td\>/si', $html, $rows);
        $rows  = $rows[1];
        $rooms = array();
        foreach ($rows as $row) {
            preg_match('/<!--(.*?)-->/si', $row, $p);
            $key         = $p[1];
            $rooms[$key] = new \stdClass();
            preg_match("/productName\'>(.*?)\<\/span/si", $row, $p);
            $rooms[$key]->name = $p[1];
            preg_match("/maxpax\'>(.*?)\<\/div/si", $row, $p);
            $rooms[$key]->max = $p[1];
        }
        return $rooms;
    }

    /**
     * delete inline JS, style etc.
     * @param string &$html
     */
    protected function clearHtml(&$html)
    {
        $html = preg_replace('/(onmouseout\=\".*?\")/si', '', $html);
        $html = preg_replace('/(onmouseover\=\".*?\")/si', '', $html);
        $html = preg_replace('/(onclick\=\".*?\")/si', '', $html);
        $html = preg_replace('/\<script.*?\/script\>/si', '', $html);
        $html = preg_replace('/(href\=\"javascript:.*?\")/si', 'href="#"', $html);
    }

    /**
     * get opted in via xml
     */
    public function getoptins()
    {
        //	 $configArray = Zend_Registry::get('config');
        //			$config = new Zend_Config($configArray);
        // $host = "http://www.au.v3travel.com/CABS.WebServices/SearchServiceAdapters.svc?swdl";
        // $host = "http://web02.au.v3travel.com/CABS.WebServices/SearchService.asmx?op=ProviderOptIn";
        $host = "http://www.au.v3travel.com/CABS.WebServices/SearchServiceAdapters.asmx";
        /*  $xml = "<?xml version='1.0'?>
  <CABS_ProviderOptIn_RQ xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns='http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderOptIn_RQ.xsd'>
    <Channels>
      <DistributionChannel id='ace_web_design_web' key='EB5F7B01-64F5-4457-9146-6F4D24C66D82' xmlns='http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd' />
    </Channels>
    <Providers />
    <Query>
      <CompleteQuery xmlns='http://www.v3leisure.com/Schemas/CABS/2.0/CABS_Common.xsd' />
    </Query>
  </CABS_ProviderOptIn_RQ>";
  */

        /*     $xml = '<?xml version="1.0" encoding="utf-8"?>

     <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">

       <soap:Body>

         <CABS_ProviderSearch_RQ xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderSearch_RQ.xsd">

           <Channels>

             <CO_DistributionChannelRQType id="ace_web_design_web" key="EB5F7B01-64F5-4457-9146-6F4D24C66D82" />

           </Channels>

           <Query>

             <SearchGroup xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd">

               <SearchCriteriaState id="514DD3B2-4EF2-494E-A9C4-2DD92C48738D" />

             </SearchGroup>

             <SearchCriteriaIndustryCategory category="Tours" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

           </Query>

           <Response>

             <IncludeContactDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeMarketingDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeDescription include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeImages include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeProducts include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeProductRates include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeOptInDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeBusinessDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeBookingDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeShortDescription include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeRegionGeocodeDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

            <IncludeECommerceDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

             <IncludeMerchantDetails include="true" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />

           </Response>

         </CABS_ProviderSearch_RQ>

       </soap:Body>

     </soap:Envelope>';*/
        //   echo var_dump($xml);
        $xml = '
<?xml version="1.0"?>
<CABS_ProviderOptIn_RQ xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderOptIn_RQ.xsd">
  <Channels>
    <DistributionChannel id="ace_web_design_web" key="EB5F7B01-64F5-4457-9146-6F4D24C66D82" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />
  </Channels>
  <Providers />
  <Query>
    <CompleteQuery xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />
  </Query>
</CABS_ProviderOptIn_RQ>    
';

        $client = new Zend_Http_Client($host);
        $client->setRawData($xml, 'text/xml')->request('GET');

        //    $response = $client->request();


        if ($client->getLastResponse()->isSuccessful()) {
            $response = $client->getLastResponse()->getBody();
        }
        $response = $client->request('GET');
        //     Zend_debug::dump($response);


        return $response->getBody();
    }

    public function getoptinssoap()
    {
        $client = new SoapClient("http://www.au.v3travel.com/CABS.WebServices/SearchService.asmx?WSDL");
        $test   = $client->ProviderOptIn;
        echo $client;
    }

    public function providerSearch()
    {
        $xmlRequest =
            '<?xml version="1.0"?>
            <CABS_ProviderOptIn_RQ xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderOptIn_RQ.xsd">
              <Channels>
                <DistributionChannel id="ace_web_design_web" key="EB5F7B01-64F5-4457-9146-6F4D24C66D82" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />
              </Channels>
              <Providers />
              <Query>
                <CompleteQuery xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />
              </Query>
            </CABS_ProviderOptIn_RQ>';

        $result = simplexml_load_string($this->make_xml_request($xmlRequest));
        //   Zend_Debug::dump($result);
        /*  $client = new SoapClient($this->_requestUrl);
        $ch = curl_init($this->_requestUrl);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // print_r($client->ProviderOptIn);
         $xmlResponse = curl_exec($ch);

         if(curl_errno( $ch ) == CURLE_OK)
             print_r($xmlResponse);*/
    }

    /**
     * $startdate dd/mm/yyyy
     */
    public function getBookings($startdate = "01/01/2010", $enddate = "01/01/2015")
    {
        set_time_limit(100);

        $postfields = array(
            'loginController:displayLogin:txtUserName' => $this->_v3login,
            'loginController:displayLogin:txtPassword' => $this->_v3pass,
            'loginController:displayLogin:btnLogin'    => "Login"
        );
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::V3_LOGIN_URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, self::COOKIE_FILE);
        curl_setopt($ch, CURLOPT_COOKIEFILE, self::COOKIE_FILE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_REFERER, self::V3_REFERRER);
        $page = curl_exec($ch);

        preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $page, $values);
        preg_match_all('/<input.*?name\\s*=\\s*"?([^\\s>"]*)/i', $page, $names);

        $postfields = array($names[1][0] => $values[1][0], $names[1][1] => $values[1][1],
                            $names[1][2] => $values[1][2], $names[1][3] => $values[1][3], $names[1][6] => $values[1][4],
                            $names[1][5] => $this->_v3pass, $names[1][4] => $this->_v3login);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        $page = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, self::V3_STATS_URL);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        $page = curl_exec($ch);

        preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $page, $values);
        preg_match_all('/<input.*?name\\s*=\\s*"?([^\\s>"]*)/i', $page, $names);
        $postfields = array(
            $names[1][0]                                                                        => $values[1][0],
            $names[1][1]                                                                        => $values[1][1],
            $names[1][2]                                                                        => $values[1][2],
            $names[1][3]                                                                        => $values[1][3],
            "internetDistributorBookingsController:searchBookings:dateRangeSearch:txtStartDate" => $startdate,
            "internetDistributorBookingsController:searchBookings:dateRangeSearch:txtEndDate"   => $enddate,
            $names[1][8]                                                                        => 'rbTransaction',
            $names[1][9]                                                                        => 'Search'
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        $page = curl_exec($ch);

        preg_match_all('%(?<=vertical-align:top;"><a href="/VCubed/Page/Distributor/DistributorBookings\.aspx\?ReservationId=)(.*?)(?=&)%m', $page, $bookingurls);
        preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $page, $values);
        preg_match_all('/<input.*?name\\s*=\\s*"?([^\\s>"]*)/i', $page, $names);

        // get input values to go through more pages
        $postfields = array(
            $names[1][0] => 'internetDistributorBookingsController$displayBookingSearchResults$reportWebViewer',
            $names[1][1] => 'arvPageNext',
            $names[1][2] => $values[1][2],
            $names[1][3] => $values[1][3],
            $names[1][4] => $values[1][4],
            $names[1][5] => $values[1][5],
            $names[1][6] => $values[1][6],
            $names[1][7] => $values[1][7],
            $names[1][8] => $values[1][8]
        );


        $bookingdata = array();
        $arraykey    = 0;
        foreach ($bookingurls[0] as $b => $value) {
            $url = str_replace('%value%', $value, self::V3_TRANSACTION_URL);


            // curl individual transaction pages and mine customer information.
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 0);
            $page2 = curl_exec($ch);
            preg_match('%(?<=lblBookingCost">)(.*?)(?=<)%m', $page2, $bookingtotal);
            preg_match('%(?<=lblReservationDate">)(.*?)(?=<)%m', $page2, $reservationdate);
            preg_match('%(?<=ReservationVoucher_lblProvider">)(.*?)(?=<)%m', $page2, $provider);
            preg_match('%(?<=Voucher_lblCustomer">)(.*?)(?=<)%m', $page2, $customername);
            preg_match('%(?<=lblCustomerAddress">)(.*?)(?=</)%m', $page2, $address);
            preg_match('%(?<=lblCustomerEmail">)(.*?)(?=<)%m', $page2, $email);
            preg_match('%(?<=lblTransactionDate">)(.*?)(?=<)%m', $page2, $transactiondate);
            preg_match('%(?<=lblBookingRefNumber">)(.*?)(?=<)%m', $page2, $transactionid);


            // set all matches to variables
            $bookingdata[$arraykey]['total']           = str_replace('&#36;', '', $bookingtotal[0]);
            $bookingdata[$arraykey]['reservationdate'] = $reservationdate[0];
            $bookingdata[$arraykey]['provider']        = $provider[0];
            $bookingdata[$arraykey]['customername']    = str_replace('&#160;', ' ', str_replace('None&#160;', '', $customername[0]));
            $bookingdata[$arraykey]['address']         = $address[0];
            $bookingdata[$arraykey]['email']           = $email[0];
            $bookingdata[$arraykey]['transactiondate'] = $transactiondate[0];
            $bookingdata[$arraykey]['reference']       = $transactionid[0];
            $bookingdata[$arraykey]['commission']      = ($bookingdata[$arraykey]['total'] * 0.09);
            $arraykey++;
        }

        // set page numbers
        $totalpages = $values[1][7];
        $pageno     = $values[1][6];

        // If there is more than one page of results
        if ($postfields["internetDistributorBookingsController:displayBookingSearchResults:reportWebViewerPageCount"] > 1) {


            while ($pageno < $totalpages) {
                // echo "page " . $pageno . " of " . $totalpages;

                curl_setopt($ch, CURLOPT_URL, self::V3_STATS_URL);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
                curl_setopt($ch, CURLOPT_POST, 1);
                $followuppages = curl_exec($ch);

                preg_match_all('%(?<=vertical-align:top;"><a href="/VCubed/Page/Distributor/DistributorBookings\.aspx\?ReservationId=)(.*?)(?=&)%m', $followuppages, $bookingurls);
                foreach ($bookingurls[0] as $b => $value) {
                    $url = str_replace('%value%', $value, self::V3_RESERVATION_URL);

                    // curl individual transaction pages and mine customer information.
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    $page2 = curl_exec($ch);
                    preg_match('%(?<=lblBookingCost">)(.*?)(?=<)%m', $page2, $bookingtotal);
                    preg_match('%(?<=lblReservationDate">)(.*?)(?=<)%m', $page2, $reservationdate);
                    preg_match('%(?<=ReservationVoucher_lblProvider">)(.*?)(?=<)%m', $page2, $provider);
                    preg_match('%(?<=Voucher_lblCustomer">)(.*?)(?=<)%m', $page2, $customername);
                    preg_match('%(?<=lblCustomerAddress">)(.*?)(?=</)%m', $page2, $address);
                    preg_match('%(?<=lblCustomerEmail">)(.*?)(?=<)%m', $page2, $email);
                    preg_match('%(?<=lblTransactionDate">)(.*?)(?=<)%m', $page2, $transactiondate);
                    preg_match('%(?<=lblBookingRefNumber">)(.*?)(?=<)%m', $page2, $transactionid);

                    // set all matches to variables
                    $bookingdata[$arraykey]['total']           = str_replace('&#36;', '', $bookingtotal[0]);
                    $bookingdata[$arraykey]['reservationdate'] = $reservationdate[0];
                    $bookingdata[$arraykey]['provider']        = $provider[0];
                    $bookingdata[$arraykey]['customername']    = str_replace('&#160;', ' ', str_replace('None&#160;', '', $customername[0]));
                    $bookingdata[$arraykey]['address']         = $address[0];
                    $bookingdata[$arraykey]['email']           = $email[0];
                    $bookingdata[$arraykey]['transactiondate'] = $transactiondate[0];
                    $bookingdata[$arraykey]['reference']       = $transactionid[0];
                    $bookingdata[$arraykey]['commission']      = ($bookingdata[$arraykey]['total'] * 0.9);
                    $arraykey++;
                }

                preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $followuppages, $values);
                preg_match_all('/<input.*?name\\s*=\\s*"?([^\\s>"]*)/i', $followuppages, $names);
                $postfields = array(
                    $names[1][0] => 'internetDistributorBookingsController$displayBookingSearchResults$reportWebViewer',
                    $names[1][1] => 'arvPageNext',
                    $names[1][2] => $values[1][2],
                    $names[1][3] => $values[1][3],
                    $names[1][4] => $values[1][4],
                    $names[1][5] => $values[1][5],
                    $names[1][6] => $values[1][6],
                    $names[1][7] => $values[1][7],
                    $names[1][8] => $values[1][8]
                );

                $pageno++;
            }
        }


        return $bookingdata;
    }

    /** moved from marketing project
     *
     */
    public function getV3Subscribers()
    {
        /** Check V3 for new sales and subscribers * */
        // $this->_helper->layout->disableLayout();
        $v3         = $this;
        $options    = new Model_CentralOptions();
        $log        = new Model_CentralChanges();
        $product    = new Model_Centraldb();
        $lastdate   = (false && $options->get('subscribercheck', 'v3')) ? $options->get('subscribercheck', 'v3') : '01/01/2012'; // check when last checked
        $today      = date('Y/m/d');
        $lastdatezd = new Zend_Date($lastdate, 'dd/MM/yyyy');
        // get bookings from last checked date with 7 day buffer.
        $stats = $v3->getBookings($lastdatezd->sub(7, Zend_Date::DAY)->toString(Zend_Date::DATE_MEDIUM));
        $options->save('subscribercheck', $today, 'v3'); // save date of this check
        $sale      = new Model_Sales();
        $mailchimp = new Ace_MailChimpAPI('552f1ac25010443b3d1f7bf2845d5def-us2');
        foreach ($stats as $s) {
            $property                    = $product->getProductBySourceId($s['provider']);
            $resstart                    = explode("/", substr($s["reservationdate"], 0, 10));
            $s['reservation_date_start'] = $this->_dateToMysql($resstart[2], $resstart[1], $resstart[0]);
            $resend                      = explode("/", substr($s["reservationdate"], 13, 10));
            $s['reservation_date_end']   = $this->_dateToMysql($resend[2], $resend[1], $resend[0]);
            $transdate                   = explode("/", $s["transactiondate"]);
            $s['transactiondate']        = $this->_dateToMysql($transdate[2], $transdate[1], $transdate[0]);
            $splitname                   = preg_split('/\s/', $s['customername'], 2);
            $s['first_name']             = $splitname[0];
            $s['last_name']              = trim($splitname[1]);
            $s['property']               = $s['provider'];
            $s['provider']               = "V3";
            $email_address               = $s['email'];
            $s['property_id']            = $property['baorecord_id'];
            if (!($sale->rowExists('email', $email_address))) { // if the email doesn't exist in sales table then find out if subscribed
                echo $email_address . " email is already added<br/>";
                $retval = $mailchimp->listMemberInfo('0705f36954', $email_address); // check to see if this member is subscribed.
                if ($mailchimp->errorCode) {
                    echo "Unable to load!";
                    echo "\n\tCode=" . $mailchimp->errorCode;
                    echo "\n\tMsg=" . $mailchimp->errorMessage . "\n";
                } else {
                    //  Zend_Debug::dump($retval);
                    if (isset($retval['data']['0']['status'])) {
                        echo $s['customername'] . " : " . $retval['data']['0']['status'] . "<br/>";
                        ($retval['data']['0']['status'] == "subscribed") ? $subscribed++ : '';
                        ($retval['data']['0']['status'] == "unsubscribed") ? $unsubscribed++ : '';
                        $s['subscribe_status'] = $retval['data']['0']['status'];
                    } else {
                        echo $email_address . " email will be subscribed and transaction added<br/>";
                        $subscribedata = array('FNAME' => $s['first_name'], 'LNAME' => $s['last_name'], 'SITE' => 'V3');

                        $subscribe = $mailchimp->listSubscribe('0705f36954', $email_address, $subscribedata);
                        if ($subscribe) {
                            $s['subscribe_status'] = "Sent";
                        }
                    }
                }

                $id = $sale->save($s);
                $log->save(array('other_id' => $id, 'record_type' => 'Subscriber', 'newvalue' => $s['email']));
            }
        }

        return array('subscribed' => $subscribed, 'not subscribed' => $notsubscribed, 'unsubscribed' => $unsubscribed);
    }


    private function _dateToMysql($year, $month, $day)
    {
        $date = strtotime($year . ' ' . $month . ' ' . $day);
        return date('Y-m-d', $date);
    }

    protected function getRegistryService()
    {
        if (!$this->registryService) {
            $this->registryService = $this->getServiceManager()->get('AceLibrary\Service\RegistryService');
        }
        return $this->registryService;
    }

}