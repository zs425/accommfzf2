<?php
namespace AceLibrary\Service;

use Zend\Http\Client;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Json\Json;
use AceLibrary\OAuth\OAuthToken;
use AceLibrary\OAuth\OAuthConsumer;
use AceLibrary\OAuth\OAuthSignatureMethodHMACSHA1;
use AceLibrary\OAuth\OAuthRequest;


/**
 * Class YelpService
 * @package AceLibrary\Service
 * @author  Kirill Morozov
 */
class YelpService extends AceService
{
    const CONSUMER_KEY = "YJ11fwEsfvvHfcVVo3vzag";
    const CONSUMER_SECRET = "mUNHYr101L6XCRJcq7ccrT66DZU";
    const TOKEN = "KmBtrVhX7YCDJh2Pz3KY_rKBNT20Q_jI";
    const TOKEN_SECRET = "zD7J4FI_fOeJuDGN9HIrbMQMDc0";
    const YWSID = "BHjvIokpoEwXwgzrdG_8Sg";
	
    public function getData($unsigned_url){
    	
        $token = new OAuthToken(self::TOKEN, self::TOKEN_SECRET);
        
        $consumer = new OAuthConsumer(self::CONSUMER_KEY, self::CONSUMER_SECRET);
        $signature_method = new OAuthSignatureMethodHMACSHA1();

        // Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
        $oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

        // Sign the request
        $oauthrequest->sign_request($signature_method, $consumer, $token); 

        // Get the signed URL
        $signed_url = $oauthrequest->to_url();
		
        // Send Yelp API Call
        $ch = curl_init($signed_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch); // Yelp response
        curl_close($ch);

        // Handle Yelp response data
        $response = json_decode($data);

        // Print it for debugging
        return $response;
    }
    
    public function getYelpBusiness($businessId, $params = array()){
        $baseUrl = "http://api.yelp.com/v2/business/".$businessId;
        $url = "";
        $paramStr = http_build_query($params);
        if ($paramStr != "")
            $url = $baseUrl."?".$paramStr;
        else
            $url = $baseUrl;
            
        $data = $this->getData($url);
		 
		return $data;
    }
    
    public function searchYelp($params = array()){
        $baseUrl = "http://api.yelp.com/v2/search";
        $llStr = "";
        $boundStr = "";
        if (isset($params['ll'])){
            $llStr = "ll=".implode(',', $params['ll']);
            unset($params['ll']);
        }
        if (isset($params['bounds'])){
            $boundStr ="bounds=".$params['bounds']['sw_latitude'].",".$params['bounds']['sw_longitude']."|".$params['bounds']['ne_latitude'].",".$params['bounds']['ne_longitude'];
            unset($params['bounds']);
        }
        $paramStr = http_build_query($params); 
        if ($paramStr != ""){
            $url = $baseUrl."?".$paramStr;
            if ($llStr != "")
                $url = $url."&".$llStr;
            if ($boundStr != "")
                $url = $url."&".$boundStr;
        }else{
            if ($llStr != "")
                $url = $baseUrl."&".$llStr;
            if ($boundStr != "")
                $url = $baseUrl."&".$boundStr;
        }          
        $data = $this->getData($url);
		
		return $data;
    }
    
	public function searchBusinessbyPhone($phone, $cc = ""){
		$baseUrl = "http://api.yelp.com/phone_search?phone=".$phone."&ywsid=".self::YWSID;
        
        $data = $this->getData($baseUrl);		 
		return $data;
	}
		
	public function searchNeighborhood($params = array()){
		$baseUrl = "http://api.yelp.com/neighborhood_search";
		
		$paramStr = http_build_query($params);
		
		$url = $baseUrl."?".$paramStr."&ywsid=".self::YWSID;
		
		$data = $this->getData($url);
		
		return $data;
	}
}
