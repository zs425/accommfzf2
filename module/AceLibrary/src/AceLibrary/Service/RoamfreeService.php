<?php
namespace AceLibrary\Service;

use Zend\ServiceManager\ServiceManager;

class RoamfreeService extends AceService
{
    protected $inventoryClient = null;
    protected $contentClient = null;
    protected $auth = null;
    protected $webId = null;

    public function __construct()
    {
        $this->inventoryClient = new \SoapClient("http://api.roamfree.com/affiliate/1.0/services/InventoryService.svc?wsdl");
        $this->contentClient   = new \SoapClient("http://api.roamfree.com/affiliate/1.0/services/ContentService.svc?wsdl");
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager    = $serviceManager;
        $config                  = $this->getConfig();
        $this->auth              = new \stdClass();
        $this->webId             = $config['providers']['roamfree']['web_id'];
        $this->auth->AffiliateId = $config['roamfree']['web_id'];
        $this->auth->Username    = $config['roamfree']['username'];
        $this->auth->Password    = $config['roamfree']['pass'];
        if (!$this->webId) {
            $this->webId = $this->auth->AffiliateId;
        }
    }

    public function getHotelRates($checkIn, $checkOut, $adults = 2, $children = 0, $localities = array(), $currency = 'AUD')
    {
        // rates
        $request                 = new \stdClass();
        $request->Authentication = $this->auth;
        $request->CheckIn        = $checkIn;
        $request->CheckOut       = $checkOut;
        $request->Adults         = $adults;
        $request->Children       = $children;
        $request->CurrencyIso    = $currency;
        $request->PriceGrid      = true;
        $request->Sorting        = "Rating";
        $request->Localities     = $localities;
        $response                = $this->inventoryClient->GetHotelRates(array("request" => $request));

        // dates
        $current = strtotime($checkIn);
        $dates   = array();
        for ($i = 0; $i < 14; $i++) {
            $j         = ($current + 3600 * 24 * $i);
            $dates[$i] = date('D', $j) . '<br/>' . date('d', $j) . '<br/>' . date('M', $j);
        }
        // combine rates & dates
        $rates = array();
        if (count($response->GetHotelRatesResult->Hotels->HotelRates) > 1) {
            foreach ($response->GetHotelRatesResult->Hotels->HotelRates as $h) {
                if (count($h->Grid->Day) == count($dates)) {
                    $rates[$h->HotelId]['rates'] = array_combine($dates, $h->Grid->Day);
                }
                else {
                    $rates[$h->HotelId]['rates'] = false;
                }
                $rates[$h->HotelId]['GrossRate']    = $h->GrossRate;
                $rates[$h->HotelId]['ContainsDeal'] = $h->ContainsDeal;

            }
        }
        else {
            $rates[$response->GetHotelRatesResult->Hotels->HotelRates->HotelId]['rates']        = array_combine($dates, $response->GetHotelRatesResult->Hotels->HotelRates->Grid->Day);
            $rates[$response->GetHotelRatesResult->Hotels->HotelRates->HotelId]['GrossRate']    = $response->GetHotelRatesResult->Hotels->HotelRates->GrossRate;
            $rates[$response->GetHotelRatesResult->Hotels->HotelRates->HotelId]['ContainsDeal'] = $response->GetHotelRatesResult->Hotels->HotelRates->ContainsDeal;


        }

        return $rates;
    }

    public function getBookUrl($providerId, $date, $nights, $adults)
    {
        // http://www.roamfree.com/AccommodationProviderDetails.aspx?apID=278513&sDate=28-Oct-2011&Duration=2&adu=2&WebID=26115
        $url = 'http://www.roamfree.com/AccommodationProviderDetails.aspx?';
        $url .= 'apID=' . $providerId;
        $url .= '&sDate=' . $date;
        $url .= '&Duration=' . $nights;
        $url .= '&adu=' . $adults;
        $url .= '&WebID=' . $this->webId;
        return $url;
    }

    /**
     * @return array $roomRates
     */
    public function getHotelRoomRates($hotelId, $checkIn, $checkOut, $adults = 2, $children = 0, $currency = 'AUD')
    {
        $request                 = new \stdClass();
        $request->Authentication = $this->auth;
        $request->CheckIn        = $checkIn;
        $request->CheckOut       = $checkOut;
        $request->Adults         = $adults;
        $request->Children       = $children;
        $request->CurrencyIso    = $currency;
        $request->Hotels         = array($hotelId);
        $request->PriceGrid      = true;
        $response                = $this->inventoryClient->GetHotelRoomRates(array("request" => $request));

        $rates = $response->GetHotelRoomRatesResult->HotelRates->HotelRoomRates->RoomRates->RoomRates;
        return $rates;
    }

    /* public function getQuote($hotelId, $roomId, $checkIn, $checkOut, $adults = 2, $children = 0, $infants = 0)
      {
      $request = new stdClass();
      $request->Authentication = $this->auth;
      $request->HotelId = $hotelId;
      $request->RoomId = $roomId;
      $request->CheckIn = $checkIn;
      $request->CheckOut = $checkOut;
      $request->Adults = $adults;
      $request->Children = $children;
      $request->Infants = $infants;
      $response = $this->inventoryClient->GetQuote(array("request" => $request));
      return $response;
      } */

    /**
     * Get checkIn & checkOut dates
     * @return array - checkIn & checkOut
     */
    public function getDates($date, $nights)
    {
        $checkIn  = date('Y-m-d\TH:i:s', strtotime($date) + 3600 * 14); // +14 hours
        $checkOut = date('Y-m-d\TH:i:s', strtotime($checkIn) + $nights * 3600 * 24); // checkin + nights
        return array('checkIn' => $checkIn, 'checkOut' => $checkOut);
    }

    /* function webSearch()
      {
      $client = new Zend_Http_Client();
      $client->setUri('http://www.roamfree.com.au/json/prices/roomprices');
      $client->setConfig(array(
      'maxredirects' => 0,
      'timeout'      => 90));
      $client->setParameterGet(array(
      'hotels'  => $params['source_id'],
      'adults'  => $params['adults'],
      'children'=> $params['children'],
      'infants' => 0,
      'checkIn' => $params['checkIn'],
      'checkOut'=> $params['checkOut'],
      'currencyid' => 1
      ));

      if ($this->mode != 'test') {
      $response = $client->request();
      $json = $response->getBody();
      }

      if ($this->mode == 'cache')
      file_put_contents(ROOT_PATH .'/data/roamfreeresult.php', $json);
      if ($this->mode == 'test')
      $json = file_get_contents(ROOT_PATH .'/data/roamfreeresult.php');

      return Zend_Json::decode($json);
      } */

    /*
     * Get Country List
     * Returns information about countries with RoamFree
     * 
     */

    public function getCountries()
    {
        $response                        = "";
        $request                         = new \stdClass();
        $request->Authentication         = $this->auth;
        $request->IncludeonRequestHotels = true;
        $response                        = $this->contentClient->GetCountries(array("Request" => $request));
        $countries                       = $response->GetCountriesResult->Countries->Country;
        return $countries;
    }

    public function getLocalities($parent)
    {
        $response                = "";
        $request                 = new \stdClass();
        $request->Authentication = $this->auth;

        $request->IncludeonRequestHotels = true;
        $request->LocalityId             = $parent;
        $response                        = $this->contentClient->GetLocalities(array("Request" => $request));
		
        $countries                       = $response->GetLocalitiesResult->Localities;
        // Zend_Debug::dump($countries);

        /* foreach($countries as $c)
          {
          foreach($c as $a)
          {
          echo $a->Name . "<br/>";
          echo "Live Hotels" . $a->LiveHotels. "<br/>";
          echo $a->IsoCode. "<br/>";
          echo "Id" . $a->LocalityId. "<br/>"  . "<br/>";
          }

          } */
        return $countries;
    }


    public function getHotelDetails($hotels)
    {
        $response                = "";
        $request                 = new \stdClass();
        
        try {
            $request->Authentication = $this->auth;
            $request->Hotels         = $hotels;
            $response                = $this->contentClient->GetHotelDetails(array("request" => $request));
            return $response->GetHotelDetailsResult->HotelDetails->HotelDetails;
        }
        catch (Exception $e) {
            array_push($this->messages, 'Exception: ' . $e->getMessage());
            array_push($this->messages, 'Switch to single request (per hotel)');
            $result = array();
            foreach ($hotels as $id) {
                try {
                    $request->Authentication = $this->auth;
                    $request->Hotels         = array($id);
                    $response                = $this->contentClient->GetHotelDetails(array("request" => $request));
                    $result[]                = $response->GetHotelDetailsResult->HotelDetails->HotelDetails;
                }
                catch (Exception $ee) {
                    array_push($this->messages, 'NOTICE: data for ' . $id . ' can not be received. Message:' . $e->getMessage());
                }
            }
            return $result;
        }
    }


    /*
  * Get Subscribers function
  * Returns list of emails, last name, and first names in the array
  * To print in a table
  *  echo "<table>";
  * foreach ($aux as $a) {
  * ?><tr><td><?= $a[1] ?></td><td><?= $a[2] ?></td><td><?= $a[3] ?></td></tr><?
  *   }
  *  echo "</table>";
  *
  */

    public function getSubscribers()
    {
        // Set up initial variables
        $userName   = 'sales@acewebdesign.com.au';
        $pass       = 'awd123!@#';
        $postfields = array('pass' => $pass, 'name' => $userName, 'submit' => 'Log in');
        $url        = 'http://finance.roamfree.com/SingleSignon?AffiliateID=129562';
        $referrer   = "http://www.roamfree.com/Admin/Default.aspx";
        // curl login page to get token
        set_time_limit(100);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_REFERER, $referrer);
        $page = curl_exec($ch);
        preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $page, $token); // match tokens
// Login to Roamfree using tokens and logins


        curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=' . $userName . '&pass=' . $pass . '&submit=' . $token[1][1] . '&form_build_id=' . $token[1][2] . '&form_id=' . $token[1][3]);
        $postfields = array('pass' => $pass, 'name' => $userName, 'submit' => $token[1][1], 'form_build_id' => $token[1][2], 'form_id' => $token[1][3]);
        $page2      = curl_exec($ch);
        $postfields = array('MODE' => 'TABLE', 'submit' => 'Run Report');
        $referrer   = $url; // change referring url to previous url for authentic look
        $url        = 'http://finance.roamfree.com/Suppliers/Affiliates/Reports/MailingList'; // set mailing list page
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        $page3 = curl_exec($ch);

        preg_match_all('/<tr.*?\\s*=\\s*"?([^\\s>"]*)/i', $page3, $tr);
        preg_match_all("/<td class=\'email_address-row\'>(.*?)<\/td><td class=\'last_name-row\'>(.*?)<\/td><td class=\'first_name-row\'>(.*?)<\/td><td class=\'country-row\'>(.*?)<\/td><td class=\'street_address-row\'>(.*?)<\/td><td class=\'suburb-row\'>(.*?)<\/td><td class=\'postcode-row\'>(.*?)<\/td><td class=\'state-row\'>(.*?)<\/td><td class=\'phone-row\'>(.*?)<\/td><td class=\'mobile-row\'>(.*?)<\/td><td class=\'website-url-row\'>(.*?)<\/td>/i", $page3, $auxdata, PREG_SET_ORDER);
        $index     = 0;
        $dataarray = array();
        foreach ($auxdata as $aux) {
            $data              = array(
                'email'        => $aux[1],
                'first_name'   => $aux[2],
                'last_name'    => $aux[3],
                'customername' => $aux[2] . " " . $aux[3],
                'address'      => $aux[5],
                'state'        => $aux[8],
                'provider'     => 'Roamfree'
            );
            $dataarray[$index] = $data;
            $index++;
        }


        return $dataarray;
        //$aux has the list of emails, last name, and first names in the array
        /*
         * To print in a table
         *  echo "<table>";
          foreach ($aux as $a) {
          ?><tr><td><?= $a[1] ?></td><td><?= $a[2] ?></td><td><?= $a[3] ?></td></tr><?
          }
          echo "</table>";
         */
    }

	function GetHotels($inLocalityId) {
		// find the children localities for this locality
		$response = "";
        $request = new \stdClass();
		try {      
			$request->Authentication = $this->auth;
			$request->LocalityId = $inLocalityId;
			$response = $this->contentClient->GetHotels(array("request"=>$request)); // request -> this is case sensitive, our messages sometimes have it set to Request, so check the wsdl.
			
            if(isset($response->GetHotelsResult->Hotels->HotelId)){
                $hotels = $response->GetHotelsResult->Hotels->HotelId;
                return $hotels;    
            }   			
		} catch (SoapFault $exception) {
			die($exception);
		}
		return null;
	}

    public function getBookings($startdate = "01/01/2012", $enddate = "31/01/2012", $checkoutstartdate = "01/01/2000", $checkoutenddate = "01/01/2109")
    {
        $statsurl = "http://finance.roamfree.com/Suppliers/Affiliates/Reports/Bookings?CheckOutStartDate=$checkoutstartdate&CheckOutEndDate=$checkoutenddate&StartDate=$startdate&EndDate=$enddate&submit=Run+Report&MODE=TABLE";
        // Set up initial variables
        $userName   = 'sales@acewebdesign.com.au';
        $pass       = 'awd123!@#';
        $postfields = array('pass' => $pass, 'name' => $userName, 'submit' => 'Log in');
        $url        = 'http://finance.roamfree.com/SingleSignon?AffiliateID=129562';
        $referrer   = "http://www.roamfree.com/Admin/Default.aspx";
        // curl login page to get token
        set_time_limit(100);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields, '', '&'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/my_cookies.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_REFERER, $referrer);
        $page = curl_exec($ch);
        preg_match_all('/<input.*?value\\s*=\\s*"?([^\\s>"]*)/i', $page, $token); // match tokens
// Login to Roamfree using tokens and logins


        curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=' . $userName . '&pass=' . $pass . '&submit=' . $token[1][1] . '&form_build_id=' . $token[1][2] . '&form_id=' . $token[1][3]);
        $postfields = array('pass' => $pass, 'name' => $userName, 'submit' => $token[1][1], 'form_build_id' => $token[1][2], 'form_id' => $token[1][3]);
        $page2      = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, $statsurl);
        $statspage = curl_exec($ch);
        //  preg_match_all('/<tr.*?\\s*=\\s*"?([^\\s>"]*)/i', $statspage, $tr);
        preg_match_all("/<td class=\'booking_id-row\'>(.*?)<\/td><td class=\'hotel-row\'>(.*?)<\/td><td class=\'booking_date-row\'>(.*?)<\/td><td class=\'booking_status-row\'>(.*?)<\/td><td class=\'payment_status-row\'>(.*?)<\/td><td class=\'check_in-row\'>(.*?)<\/td><td class=\'check_out-row\'>(.*?)<\/td><td class=\'length_of_stay-row\'>(.*?)<\/td><td class=\'lead_days-row\'>(.*?)<\/td><td class=\'currency-row\'>(.*?)<\/td><td class=\'booking_amt-row\'>(.*?)<\/td><td class=\'commission-row\'>(.*?)<\/td><td class=\'website_url-row\'>(.*?)<\/td>/i", $statspage, $aux, PREG_SET_ORDER);


        return $aux;
    }

    /**
     *
     * @param int $count
     * This has been moved from the marketing project to become a part of central accomm
     */
    public function getRoamFreeSubscribers($count = null)
    {
        set_time_limit(500);
        $rf            = $this;
        $subscribers   = $rf->getSubscribers();
        $log           = new Model_CentralChanges();
        $sale          = new Model_Sales();
        $mailchimp     = new Ace_MailChimpAPI('552f1ac25010443b3d1f7bf2845d5def-us2');
        $unsubscribed  = $subscribed = 0;
        $notsubscribed = 0;
        $email_address = "";
        $count         = 0;

        $emailarray       = array();
        $subscribersAssoc = array();
        foreach ($subscribers as $s) {

            $emailarray[]                  = $s['email'];
            $subscribersAssoc[$s['email']] = $s;
        }

        $rfindb = $sale->getsubscribers('roamfree');


        $diff = array_diff($emailarray, $rfindb);

        foreach ($diff as $email_address) {
            $retval = "";
            if ($count < 50) {

                $s = $subscribersAssoc[$email_address];

                if (!($sale->rowExists('email', $email_address))) {

                    $retval = $mailchimp->listMemberInfo('0705f36954', $email_address);

                    if ($mailchimp->errorCode) {
                        echo "Unable to load!";
                        echo "\n\tCode=" . $mailchimp->errorCode;
                        echo "\n\tMsg=" . $mailchimp->errorMessage . "\n";
                    }
                    else {
                        //  Zend_Debug::dump($retval);
                        if (isset($retval['data']['0']['status'])) {
                            echo $s['customername'] . " : " . $retval['data']['0']['status'] . "<br/>";
                            ($retval['data']['0']['status'] == "subscribed") ? $subscribed++ : '';
                            ($retval['data']['0']['status'] == "unsubscribed") ? $unsubscribed++ : '';
                            $s['subscribe_status'] = $retval['data']['0']['status'];
                            echo $email_address . " email is already added<br/>";
                        }
                        else {
                            echo $email_address . " email will be subscribed and transaction added<br/>";
                            $subscribedata = array('FNAME' => $s['first_name'], 'LNAME' => $s['last_name'], 'SITE' => 'Roamfree');
                            Zend_Debug::dump($subscribedata);
                            $subscribe = $mailchimp->listSubscribe('0705f36954', $email_address, $subscribedata);
                            if ($subscribe) {
                                $s['subscribe_status'] = "Sent";
                            }
                        }
                    }

                    $sale->save($s);
                    $log->save(array('other_id' => $id, 'record_type' => 'Subscriber', 'newvalue' => $s['email']));
                    $count++;
                }
                else {
                    echo $email_address . " skipped <br/>";
                }
            }
        }
    }

}