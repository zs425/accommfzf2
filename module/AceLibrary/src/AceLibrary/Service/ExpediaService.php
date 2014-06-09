<?php
namespace AceLibrary\Service;

class ExpediaService 
{
	private $cid="55505";
	private static $instance;
	private $apiKey = "v6qnvbcub5sgjgfg8wj46h9r";
	private $DEBUG = "false";
	private $ch = NULL;

	function __construct() {
		$this->ch = curl_init();

		if($this->DEBUG) {
			curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
		}

		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		return;
	}

	function __destruct() {
		curl_close($this->ch);
		return;
	}


	public static function instance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}


	public function setCurlOpt($opt, $val) {
		curl_setopt($this->ch, $opt, $val);
		return;
	}

	private function logMessage($function, $msg) {
		if($this->DEBUG) {
			print(sprintf("%s->%s: %s", __CLASS__, $function, $msg));
		}
		return;
	}

	private function curlExec($url, array $postdata=NULL) {
		if(!empty($postdata) && is_array($postdata)){
			curl_setopt($this->ch,CURLOPT_POST,count($postdata));
			curl_setopt($this->ch,CURLOPT_POSTFIELDS,$postdata);

		}
		$this->setCurlOpt(CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$res = curl_exec($this->ch);
		return($res);
	}

	private function buildURL($url, $args) {
		return(sprintf("%s?%s", $url, http_build_query($args)));
	}

	private function recurseArray($xmlEngine, $array) {
		foreach($array as $k => $v) {
			if(is_array($v)) {
				$xmlEngine->startElement($k);
				$this->recurseArray($xmlEngine, $v);
				$xmlEngine->endElement();
				continue;
			} else {
				$xmlEngine->writeElement($k, $v);
			}
		}
	}

	private function arrayToXML($data, $root) {
		$xml = new \XMLWriter();
		
		if(! $xml->openMemory()) {
			$this->logMessage(__FUNCTION__, "error opening in-memory XMLWriter instance.");
		}
		
		if(! $xml->startElement($root)) {
			$this->logMessage(__FUNCTION__, sprintf("unable to start a document with root element: <%s>", $root));
		}
		
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$xml->startElement($key);

				$this->recurseArray($xml, $value);

				$xml->endElement();
			} else {
				$xml->writeElement($key, $value);
			}
		}

		$xml->endElement();
		
		return($xml->outputMemory());
	}

	function searchHotels($arrival,$departure,$roomGroup,$city,$state,$country,$maxrate="") { //works
		$data = array(
						"arrivalDate"				=> $arrival,
						"departureDate"				=> $departure,
						"RoomGroup"					=> array(
														"Room" => array(
																			"numberOfAdults"	=> $adultsNumber,
																			"numberOfChildren"	=> $childrenNumber)),
						"city"						=> $city,
						"stateProvinceCode"			=> $state,
						"countryCode"				=> $country,
						"supplierCacheTolerance"	=> "MED_ENHANCED",
						"numberOfResults"			=>	20);

		if(! empty($maxrate)) {
			$maxrate = str_replace("$", "", $maxrate);
			$temp = explode(".", $maxrate);
			$maxrate = $temp[0];
			unset($temp);
			$data["maxRate"] = $maxrate;	
		}

		$xml = $this->arrayToXML($data, "HotelList");

		$param = array(
						"cid"				=> $this->cid,
						"minorRev"			=> 13,
						"customerUserAgent"	=> $_SERVER['HTTP_USER_AGENT'],
						"customerIpAddress"	=> $_SERVER['REMOTE_ADDR'],
						"apiKey"			=> $this->apiKey,
						"xml"				=> $xml);

		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/list", $param);

		return json_decode($this->curlExec($request_url),true);
	}


	function checkAvailability($hotelid,$arrival,$departure,$room_group,$sessionId){ // works
		$xml_data=array("hotelId"=>$hotelid,
						"arrivalDate"=>$arrival,
						"departureDate"=>$departure,
						"RoomGroup"=>$room_group
		);
		$xml = $this->arrayToXML($xml_data, "HotelRoomAvailabilityRequest");
		$param = array(
						"cid"				=> 	$this->cid,
						"customerSessionId"	=>	$sessionId,
						"minorRev"			=> 	13,
						"customerUserAgent"	=> 	$_SERVER['HTTP_USER_AGENT'],
						"customerIpAddress"	=> 	$_SERVER['REMOTE_ADDR'],
						"apiKey"			=> 	$this->apiKey,
						"xml"				=> 	$xml);

		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/avail", $param);
		//echo $request_url;
		return json_decode($this->curlExec($request_url),true);

	}

	function bookRoom($arrival,$departure,$hotelId,$supplierType,$rateKey,$roomTypeCode,$rateCode,$chargeableRate,array $RoomGroup,array $ReservationInfo,array $AddressInfo,$sessionId){

		$xml_array=array("arrivalDate"=>$arrival,
						"departureDate"=>$departure,
						"hotelId"=>$hotelId,
						"supplierType"=>$supplierType,
						"rateKey"=>$rateKey,
						"roomTypeCode"=>$roomTypeCode,
						"rateCode"=>$rateCode,
						"chargeableRate"=>$chargeableRate,
						"RoomGroup"=>$RoomGroup,
						"ReservationInfo"=>$ReservationInfo,
						"AddressInfo"=>$AddressInfo);

		$xml=$this->arrayToXML($xml_array, "HotelRoomReservationRequest");

		$param = array(

						"cid"				=> 	$this->cid,
						"customerSessionId"	=>	$sessionId,
						"minorRev"			=> 	13,
						"customerUserAgent"	=> 	$_SERVER['HTTP_USER_AGENT'],
						"customerIpAddress"	=> 	$_SERVER['REMOTE_ADDR'],
						"apiKey"			=> 	$this->apiKey,
						"_type"				=>	"json",
						"locale"			=>	"en_US",
						"currencyCode"		=>	"USD",
						"xml"				=> $xml
					);

		$request_url = $this->buildURL("https://book.api.ean.com/ean-services/rs/hotel/v3/res", $param);

		$post=array("xml"=>$xml);
		//if($this->DEBUG) echo "\nRequest URL:\n $request_url\n\nXML:\n $xml\n\n";
		$this->setCurlOpt(CURLOPT_URL,$request_url);	
		$this->setCurlOpt(CURLOPT_SSL_VERIFYHOST, 0);
		$this->setCurlOpt(CURLOPT_SSL_VERIFYPEER, 0);
		$this->setCurlOpt(CURLOPT_HTTPHEADER,array("Content-Type: text/xml","Accept: application/json"));
		$this->setCurlOpt(CURLOPT_POST,1);
		$this->setCurlOpt(CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($this->ch);
		curl_close($this->ch);
		$this->ch = curl_init();
		return json_decode($output,1);
		//return $this->curlExec($request_url,$post);

	}

	function getItinerary($itinerary_id,$email){
		$xml=$this->arrayToXML(array("itineraryId"=>$itinerary_id,"email"=>$email), "HotelItineraryRequest");
		$param = array(

										"cid"				=> 	$this->cid,
										"customerSessionId"	=>	$sessionId,
										"minorRev"			=> 	13,
										"customerUserAgent"	=> 	$_SERVER['HTTP_USER_AGENT'],
										"customerIpAddress"	=> 	$_SERVER['REMOTE_ADDR'],
										"apiKey"			=> 	$this->apiKey,
										"_type"				=>	"json",
										"locale"			=>	"en_US",
										"currencyCode"		=>	"USD",
										"xml"				=> $xml
		);
		$request_url=$this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/itin", $param);
		if($this->DEBUG) {
			echo "\n\nRequest URL: $request_url \n\n XML: $xml \n\n\n";
		}
		return json_decode($this->curlExec($request_url),1);
	}

	function cancelReservation($itinerary_id,$confirmation_num,$email,$reason=""){
		$xml=$this->arrayToXML(array("itineraryId"=>$itinerary_id,
									"email"=>$email,
									"confirmationNumber"=>$confirmation_num,
									"reason"=>$reason), "HotelRoomCancellationRequest");
		$param = array(

						"cid"				=> 	$this->cid,
						"customerSessionId"	=>	$sessionId,
						"minorRev"			=> 	13,
						"customerUserAgent"	=> 	$_SERVER['HTTP_USER_AGENT'],
						"customerIpAddress"	=> 	$_SERVER['REMOTE_ADDR'],
						"apiKey"			=> 	$this->apiKey,
						"_type"				=>	"json",
						"locale"			=>	"en_US",
						"currencyCode"		=>	"USD",
						"xml"				=> $xml
				);
		$request_url=$this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/cancel",$param);

		if($this->DEBUG) {
			echo "\n\nXML: $xml \n Request URL: $request_url \n\n";
		}
		$response=$this->curlExec($request_url);
		return json_decode($response,1);
	}

	public function getLocationsbyDestinationString($destination) {
		
		$param = array(
					'destinationString' => $destination,
					"cid"				=> 	$this->cid,
					"minorRev"			=> 	13,
					"apiKey"			=> 	$this->apiKey,
				);
		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/geoSearch", $param);
		return json_decode($this->curlExec($request_url), true);
	}
	
	public function getLocations($countryCode, $destinationName) {
		
		$data = array(
						'destinationString' => $destinationName,
						'countryCode'		=> $countryCode,
					);
		$xml = $this->arrayToXML($data, "LocationInfoRequest");		
		
		$param = array(
						"cid"				=> $this->cid,
						"minorRev"			=> 13,
						"apiKey"			=> $this->apiKey,
						"xml"				=> $xml);
			
		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/geoSearch", $param);
		return json_decode($this->curlExec($request_url), true);		
	}
	
	public function GetHotels($destinationId) {
		
		$data = array('destinationId' => $destinationId);
		$xml = $this->arrayToXML($data, "HotelListRequest");		
		
		$param = array(
						"cid"				=> $this->cid,
						"minorRev"			=> 13,
						"apiKey"			=> $this->apiKey,
						"xml"				=> $xml);
			
		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/list", $param);
		return json_decode($this->curlExec($request_url), true);		
	}
	
	public function getHotelDetails($hotelId) {
		$data = array('hotelId' => $hotelId, 'options' => 0);
		$xml = $this->arrayToXML($data, "HotelInformationRequest");		
		
		$param = array(
						"cid"				=> $this->cid,
						"minorRev"			=> 1,
						"apiKey"			=> $this->apiKey,
						"xml"				=> $xml);
			
		$request_url = $this->buildURL("http://api.ean.com/ean-services/rs/hotel/v3/info", $param);
		return json_decode($this->curlExec($request_url), true);
	}

}