<?php
namespace AceLibrary\Service;

use AceLibrary\Service\HttpRestJsonClientService;

class GeonamesService
{

    const API_URI = 'http://api.geonames.org';

    /**
     * Supported methods
     * Describe prefered output type and root property/node
     * to format the result in a user-friendly manner
     *
     * @var array
     */
    protected static $_supportedMethods = array(
        'astergdem' => array(
            'output' => 'json',
        ),
        'children' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'cities' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'countryCode' => array(
            'output' => 'json',
        ),
        'countryInfo' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'countrySubdivision' => array(
            'output' => 'json',
        ),
        'earthquakes' => array(
            'output' => 'json',
            'root'   => 'earthquakes',
        ),
        'extendedFindNearby' => array(
            'output' => 'xml',
        ),
        'findNearby' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'findNearbyPlaceName' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'findNearbyPostalCodes' => array(
            'output' => 'json',
            'root'   => 'postalCodes',
        ),
        'findNearbyStreets' => array(
            'output' => 'json',
            'root'   => 'streetSegment',
        ),
        'findNearbyStreetsOSM' => array(
            'output' => 'json',
            'root'   => 'streetSegment',
        ),
        'findNearByWeather' => array(
            'output' => 'json',
            'root'   => 'weatherObservation',
        ),
        'findNearByWikipedia' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'findNearestAddress' => array(
            'output' => 'json',
            'root'   => 'address',
        ),
        'findNearestIntersection' => array(
            'output' => 'json',
            'root'   => 'intersection',
        ),
        'findNearestIntersectionOSM' => array(
            'output' => 'json',
            'root'   => 'intersection',
        ),
        'get' => array(
            'output' => 'json',
        ),
        'gtopo30' => array(
            'output' => 'json',
        ),
        'hierarchy' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'neighbourhoud' => array(
            'output' => 'json',
            'root'   => 'neighbourhood',
        ),
        'neighbours' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'postalCodeCountryInfo' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'postalCodeLookup' => array(
            'output' => 'json',
            'root'   => 'postalcodes',
        ),
        'postalCodeSearch' => array(
            'output' => 'json',
            'root'   => 'postalCodes',
        ),
        'search' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'siblings' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'srtm3' => array(
            'output' => 'json',
        ),
        'timezone' => array(
            'output' => 'json',
        ),
        'weather' => array(
            'output' => 'json',
            'root'   => 'weatherObservations',
        ),
        'weatherIcao' => array(
            'output' => 'json',
            'root'   => 'weatherObservation',
        ),
        'wikipediaBoundingBox' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
        'wikipediaSearch' => array(
            'output' => 'json',
            'root'   => 'geonames',
        ),
    );

    /**
     * Username
     *
     * @var string
     */
    protected $_username;

    /**
     * Token
     *
     * @var string
     */
    protected $_token;

    /**
     * Zend_Rest_Client instance
     *
     * @var Zend_Rest_Client
     */
    protected $_rest = null;

    /**
     * Options passed to constructor
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Construct a new Geonames.org web service
     *
     * @param array $options
     * @return void
     */
    public function __construct($httpClient)
    {
        $this->_rest = $httpClient;
    }

    /**
     * Set username
     *
     * @param  string $username
     * @return Ace_Service_Geonames Provides a fluent interface
     */
    public function setUsername($username)
    {
        $this->_username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }


    /**
     * Set token
     *
     * @param  string $token
     * @return Ace_Service_Geonames Provides a fluent interface
     */
    public function setToken($token)
    {
        $this->_token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Retrieve all the supported methods
     *
     * @deprecated Proxy to getSupportedMethods
     * @return array Supported methods
     */
    public static function getAvailableMethods()
    {
        return self::getSupportedMethods();
    }

    /**
     * Retrieve all the supported methods
     *
     * @return array Supported methods
     */
    public static function getSupportedMethods()
    {
        return array_keys(self::$_supportedMethods);
    }

    /**
     * Method overloading which checks for supported methods
     *
     * @param string $method The webservice method
     * @param array $params The parameters
     * @throws Ace_Service_Geonames_Exception
     * @return array
     */
    public function __call($method, $params = array())
    {
        if (!in_array($method, $this->getSupportedMethods())) {
            throw new \Exception(
                'Invalid method "' . $method . '"'
            );
        }

        if (isset($params[0])) {
            if (!is_array($params[0])) {
                throw new \Exception(
                    '$params must be an Array, "'.gettype($params[0]).'" given'
                );
            }

            $params = $params[0];
        }

        $result = $this->makeRequest($method, $params);
        return $result;
    }

    /**
     * Handles all GET requests to a web service
     *
     * @param   string $method Requested API method
     * @param   array  $params Array of GET parameters
     * @return  mixed  decoded response from web service
     * @throws  Ace_Service_Geonames_Exception
     */

    public function makeRequest($method, $params = array())
    {
        $url = self::API_URI . "/";
        
        $path = $method;
        $type = self::$_supportedMethods[$path]['output'];

        // Construct the path accordingly to the output type
        switch ($type) {
            case 'json':
                $path = $path . 'JSON';
                break;
            case 'xml':
                $params += array('type' => 'xml');
                break;
            default:
                throw new \Exception(
                    'Unknown request type'
                );
        }
        
        if (null !== $this->getUsername()) {
            $params['username'] = $this->getUsername();
        }

        if (null !== $this->getToken()) {
            $params['token'] = $this->getToken();
        }
        
        $url .= $path . "?";
        foreach($params as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }
        
        $response = $this->_rest->get($url);
                                
        if(isset($response['geonames']) && is_array($response['geonames'])) {
            return $response['geonames'];
        } else if(is_array($response)) {
            return $response;            
        } else {
            return false;
        }
    }
}