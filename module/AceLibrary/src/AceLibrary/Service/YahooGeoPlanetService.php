<?php
namespace AceLibrary\Service;

use ZendOAuth\Consumer;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\Escaper\Escaper;

class YahooGeoPlanetService
{
    public $consumer;
    public $siteurl;
    public $appid;
    public $url;
    public $args = array();

    function __construct()
    {
        $this->appId = "PGaKTPXV34EPCfyGAPKbEjvvuKWEiaqplnJwr5MR0T00zE6MqUNRfRTs.VMq9k.Aiw--";
        $this->yahooConfig['consumerKey'] = "dj0yJmk9RzZhRVZGYklnUXR6JmQ9WVdrOU5EVTRURkIzTXpZbWNHbzlNVEk1Tnprd01UVTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD05ZQ--";
        $this->yahooConfig['consumerSecret'] = "3c60a2c6d1fe10f3ebc0005ba648c0da2c5841a3";
        $this->args['appid'] = $this->appId;
        $this->args['count'] = '0';
    }

    public function limitedWeb($query = 'test', $format = 'json')
    {
        $this->args['format'] = $format;
        $this->args['q'] = $query;
        $this->url = "http://yboss.yahooapis.com/ysearch/limitedweb";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function images($query, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->args['q'] = $query;
        $this->url = "http://yboss.yahooapis.com/ysearch/images";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function news($location, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->args['q'] = $query;
        $this->url = "http://yboss.yahooapis.com/ysearch/news";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function placeFinder($location, $flags = 'J')
    {
        $this->args['flags'] = $flags;
        $this->args['location'] = urlencode($location);
        $this->url = "http://yboss.yahooapis.com/geo/placefinder";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function concordance($id, $namespace = 'woeid', $format = 'json')
    {
        http: //where.yahooapis.com/v1/concordance/iso/US-CA;appid=[yourappidhere];
        $this->args['format'] = $format;
        var_dump($this->args);
        $this->url = "http://where.yahooapis.com/v1/concordance/{$namespace}/{$id}";

        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByGeonamesId($geonamesId, $format = 'json')
    {
    	$this->args['q'] = 'select * from geo.concordance where namespace="geonames" and text="' . $geonamesId . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
		return json_decode($response);
    }

    public function findByLatLon($lat, $lon, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.placefinder where text="' . $lat . ',' . $lon . '" and gflags="R"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByWoeId($woeId, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="woeid" and text="' . $woeId . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByLocode($locode, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="locode" and text="' . $locode . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByOsm($osmId, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="osm" and text="' . $osmId . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByWikipediaId($wikipediaId, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="siki" and text="' . $wikipediaId . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByIata($iata, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="iata" and text="' . $iata . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function findByIso($iso, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="iso" and text="' . $iso . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }


    public function findByIana($iana, $format = 'json')
    {
        $this->args['q'] = 'select * from geo.concordance where namespace="ccltd" and text="' . $iana . '"'; // search for WOE code WORKS

        $this->url = "http://query.yahooapis.com/v1/public/yql";
        $this->args['format'] = $format;
        $response = $this->curlRequest();
        return json_decode($response);
    }

    /**
     * @param string $format
     * NOT WORKING - invalid appid
     *
     * @return mixed
     */
    public function getContinents($format = 'json')
    {
        $this->args['format'] = $format;
        var_dump($this->args);
        $this->url = "http://where.yahooapis.com/v1/continents";
        $response = $this->curlRequest();
        return json_decode($response);

    }

    public function getDescendants($woeId, $type = NULL, $format = 'json')
    {
        $this->args['format'] = $format;
        var_dump($this->args);
        $this->url = "http://where.yahooapis.com/v1/place/{$woeId}/descendants";
        if ($type) {
            $this->url .= ".type($type)";
        }
        $response = $this->curlRequest();
        return json_decode($response);

    }

    public function getAncestors($woeId, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/place/{$woeId}/ancestors";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getChildren($woeId, $type = NULL, $degree = NULL, $count = '0', $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/place/{$woeId}/children";
        if ($type) {
            $this->url .= ".type($type)";
        }
        if ($degree) {
            $this->url .= ".type($degree)";
        }
        if ($count) {
            $this->url .= ";count={$count}";
        } else {
            $this->url .= ";count=0";
        }

        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getOceans($format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/oceans";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getCountries($format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/countries";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getStates($country = "AU", $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/states/{$country}";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getCounties($state = "SA", $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/counties/{$state}";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getDistricts($county, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/districts/{$county}";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getSeas($format = 'json')
    {
        $this->args['format'] = $format;

        $this->url = "http://where.yahooapis.com/v1/seas";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getPlaceTypes($country = NULL, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->args['select'] = 'long';
        $this->url = "http://where.yahooapis.com/v1/placetypes";
        if ($country) {
            $this->url .= "/{$country}";
        }
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function place($woeid, $format = 'json')
    {
        $this->args['format'] = $format;
        $this->url = "http://where.yahooapis.com/v1/place/{$woeid}";
        $response = $this->curlRequest();
        return json_decode($response);
    }

    public function getTimeZones($woeid)
    {
        return $this->getChildren($woeid, '31');
    }

    public function getAreas($woeid)
    {
        return $this->getChildren($woeid, '9');
    }

    public function getAreaInfo($location)
    {
        $array = array();
        $information = $this->place($location);
        $concordance = $this->concordance($location);
        //   $concordance2 = $this->findByGeonamesId($location);
        $towns = $this->getChildren($location, "Town");
        $states = $this->getChildren($location, "State");
        $governmentAreas = $this->getChildren($location, "9"); //Local+Government+Area
        $administrativeAreas = $this->getChildren($location, "10"); //Local+Administrative+Area
        $postCodes = $this->getChildren($location, "Postal+Code");
        $islands = $this->getChildren($location, "Island");
        $airports = $this->getChildren($location, "Airport");
        $supername = $this->getChildren($location, "Supername");
        $pointOfInterest = $this->getChildren($location, "20"); //Point of interest
        $suburb = $this->getChildren($location, "Suburb");
        $ancestors = $this->getAncestors($location);

        if (!$information->error) $array['information'] = $information;
        if (!$concordance->error) $array['concordance'] = $concordance;
        if (!$ancestors->error) $array['ancestors'] = $ancestors;
        if (!$towns->error) $array['towns'] = $towns;
        if (!$governmentAreas->error) $array['governmentAreas'] = $governmentAreas;
        if (!$administrativeAreas->error) $array['administrativeAreas'] = $administrativeAreas;
        if (!$postCodes->error) $array['postCodes'] = $postCodes;
        if (!$islands->error) $array['islands'] = $islands;
        if (!$airports->error) $array['airports'] = $airports;
        if (!$supername->error) $array['supername'] = $supername;
        if (!$pointOfInterest->error) $array['pointOfInterest'] = $pointOfInterest;
        if (!$suburb->error) $array['suburb'] = $suburb;
        if (!$states->error) $array['states'] = $states;
        return $array;
    }

    public function curlRequest()
    {
    	$request = new Request();
        /*$request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));*/
        
        $escaper = new \Zend\Escaper\Escaper('utf-8');
		
        $url = $this->url;
		$url .= "?consumerKey=" . $escaper->escapeUrl($this->yahooConfig['consumerKey']);;
		$url .= "&consumerSecret=" . $escaper->escapeUrl($this->yahooConfig['consumerSecret']);
		foreach($this->args as $key => $val) {
			$url .= "&" . $key . "=" . $escaper->escapeUrl($val);
		}
		
        $request->setUri($url);
        $request->setMethod('GET');

        $client = new HttpClient();

		try {
            $response = $client->dispatch($request);
			return $response->getBody();
        } catch (\Exception $e) {
        }
        
        return false;
		
		/*
		
    	$config = array(
		    'consumerKey' 		=> $this->yahooConfig['consumerKey'],
		    'consumerSecret' 	=> $this->yahooConfig['consumerSecret'],
		    'siteUrl'			=> $this->url,	    
		);
		$consumer = new \ZendOAuth\Consumer($config);
		//$token = $consumer->getRequestToken($this->args, "GET", null);
        $token = $consumer->getRequestToken(null, "GET", null);
        
		$client = $token->getHttpClient(array(
										    'adapter'   => 'Zend\Http\Client\Adapter\Curl',
										    'curloptions' => array(CURLOPT_FOLLOWLOCATION => true),
										));
		$client->setUri($this->url);
		$client->setMethod(\Zend\Http\Client::GET);
		
		try {
            // This call will result in a Zend_Http_Client_Adapter_Exception
            $response = $client->request();
        } catch (\Exception $e) {
        }
        return $response->getBody();*/
    }
}
