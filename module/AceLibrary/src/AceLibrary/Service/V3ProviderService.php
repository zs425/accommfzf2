<?php
namespace AceLibrary\Service;

use Zend\ServiceManager\ServiceManager;

class V3ProviderService extends AceService
{
    protected $v3AdapterClient = null;
    protected $v3Client = null;
    protected $auth = null;
    
    public function __construct()
    {
        $this->v3AdapterClient = new \SoapClient("http://www.au.v3travel.com/CABS.WebServices/SearchServiceAdapters.asmx?WSDL");
        $this->v3Client = new \SoapClient("http://www.au.v3travel.com/CABS.WebServices/SearchService.asmx?WSDL");
    }
	
	public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
		$this->auth = new \stdClass();
        $config = $this->getConfig();
        $this->auth->channelid = $config['v3']['channelid'];
        $this->auth->channelkey = $config['v3']['channelkey'];
    }
    
    public function isValidService()
    {
        $request = '<?xml version="1.0"?>
                <CABS_ProviderOptIn_RQ xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderOptIn_RQ.xsd">
                    <Channels>
                        <DistributionChannel id="'.$this->auth->channelid.'" key="'.$this->auth->channelkey.'" xmlns="http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd" />
                </Channels>
                </CABS_ProviderOptIn_RQ>';
      
        try {
            $res = $this->v3AdapterClient->ProviderOptInTextAdapter($request);
            
            $res = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $res);  

            $result = json_decode(json_encode((array) simplexml_load_string($res)),1);

            if ($result["Status"]["Success"] == "success") 
                return true;

        } catch (SoapFault $exception) {
            echo $exception;
        }

        return false;
    }
    
    public function getProviderOptIns($values = NULL)
    {
        $request = new \stdClass();
        $request->Channels = new \stdClass();
        $request->Query = new \stdClass();
        $request->Channels->DistributionChannel = array("id"=>$this->auth->channelid, "key"=>$this->auth->channelkey);
        $request->Providers = "";
        
        if ($values["searchquery"] == "TodayQuery") {
            $request->Query->TodayQuery = array("status"=>$values["status"]);
        } else if ($values["searchquery"] == "DateRangeQuery") {
            $request->Query->DateRangeQuery = array("start_date"=>$values["startdate"]."T00:00:00", "status"=>$values["status"]);
        
            if ($enddate != "")
                $request->Query->DateRangeQuery["finish_date"] = $values["finishdate"]."T00:00:00";
        } else {
            $request->Query->CompleteQuery = "";
        }
        
        try {
            $res = $this->v3Client->ProviderOptIn($request);
            
            if($res->Status->Success) {
                return $res->Channels->Channel->Providers->Provider;
            }
            
        } catch (SoapFault $exception) {
            echo $exception;
        }
        
        return null;
    }
    
   public function getProviderSearchs($array) {
        // print_r($values);
        $values = array(
            'chkContact' => 'on',
            'chkDescription' => 'on',
            'chkShortDescription' => 'on',
            'chkDetail' => 'on',
            'chkBooking' => 'on',
            'chkImage' => 'on',
            'chkOptIn' => 'on',
            'chkRAG' => 'on',
            'chkInclude' => 'on',
            'chkMarketing' => 'on',
            'chkEcommerce' => 'on',
            'chkPickup' => 'on',
            'chkRate' => 'on',
        );
        //  print_r($values);
        //   print_r($array);
        $values = array_merge($values, $array);

        //$this->_auth->channelid = "ace_web_design_web";
        //$this->_auth->channelkey = "EB5F7B01-64F5-4457-9146-6F4D24C66D82";
        $request = new \stdClass();
        $request->Channels = new \stdClass();
        $request->Query = new \stdClass();
		$request->Response = new \stdClass();
        $request->Query->SearchGroup = new \stdClass();
        $request->Response->IncludeContactDetails  = new \stdClass();
        $request->Channels->CO_DistributionChannelRQType = array("id" => $this->auth->channelid, "key" => $this->auth->channelkey);
        $request->Providers = "";
        //$request->Query->SearchGroup = "";
        //$request->Response = "";

        //Search Criteria
        if (@$values["chkITB"] == "on") //check "Include Test Businesses"
            $request->Query->SearchCriteriaIncludeTestProviders = array("value" => "false");

        if (@$values["chkIC"] == "on") //check "Industry Category"
            $request->Query->SearchCriteriaIndustryCategory = array("category" => $values["selIC"]);

        if (@$values["chkState"] == "on") //check "State"
            $request->Query->SearchGroup->SearchCriteriaState = array("id" => $values["selState"]);

        if (@$values["txtBusiness"] != "") //input Business Name
            $request->Query->SearchGroup->SearchCriteriaFullName = array($values["selBusiness"] => $values["txtBusiness"]);

        if (@$values["shortName"] != "") //input Business Name
            $request->Query->SearchGroup->SearchCriteriaShortName = array("exact" => $values["shortName"]);

        if (@$values["txtLocation"] != "") //input Location
            $request->Query->SearchGroup->SearchCriteriaCity = array($values["selLocation"] => $values["txtLocation"]);

        if (@$values["txtKeyword"] != "") //input Keywords
            $request->Query->SearchGroup->SearchCriteriaKeyword = array($values["selKeyword"] => $values["txtKeyword"]);

        //Output Options
        //- Business Information
        if (@$values["chkContact"] == "on") //check "Contact Details"
            $request->Response->IncludeContactDetails = array("include" => true);

        if (@$values["chkDescription"] == "on") //check "Description"
            $request->Response->IncludeDescription = array("include" => true);

        if (@$values["chkShortDescription"] == "on") //check "Short Description"
            $request->Response->IncludeShortDescription = array("include" => true);

        if (@$values["chkDetail"] == "on") //check "Details"
            $request->Response->IncludeBusinessDetails = array("include" => true);

        if (@$values["chkBooking"] == "on") //check "Booking Information"
            $request->Response->IncludeBookingDetails = array("include" => true);

        if (@$values["chkImage"] == "on") //check "Images"
            $request->Response->IncludeImages = array("include" => true);

        if (@$values["chkOptIn"] == "on") //check "Opt In"
            $request->Response->IncludeOptInDetails = array("include" => true);

        if (@$values["chkMarketing"] == "on") //check "Marketing"
            $request->Response->IncludeMarketingDetails = array("include" => true);

        if (@$values["chkRAG"] == "on") //check "Region and Geocode"
            $request->Response->IncludeRegionGeocodeDetails = array("include" => true);

        if (@$values["chkECommerce"] == "on") //check "ECommerce"
            $request->Response->IncludeECommerceDetails = array("include" => true);

        if (@$values["chkMerchant"] == "on") //check "MerchantDetails"
            $request->Response->IncludeMerchantDetails = array("include" => true);

        //- Production Information

        if (@$values["chkInclude"] == "on") //check "Include"
            $request->Response->IncludeProducts = array("include" => true);

        if (@$values["chkDesc"] == "on") //check "Descriptions"
            $request->Response->IncludeProductDescription = array("include" => true);

        if (@$values["chkImg"] == "on") //check "Images"
            $request->Response->IncludeProductImages = array("include" => true);

        if (@$values["chkMarket"] == "on") //check "Marketing"
            $request->Response->IncludeProductMarketing = array("include" => true);

        if (@$values["chkPickup"] == "on") //check "Pickup Locations"
            $request->Response->IncludeProductPickupLocations = array("include" => true);

        if (@$values["chkRate"] == "on") //check "Rates"
            $request->Response->IncludeProductRates = array("include" => true);

        try {
            $res = $this->v3Client->ProviderSearch($request);
            //  print_r($res);
            if ($res->Status->Success) {
                return $res->Channels->Channel->Providers->Provider;
            }
        } catch (SoapFault $exception) {
            echo $exception;
        }

        return null;
    }

    public function getProviderAvailability($values)
    {
        $request = new \stdClass();
        $request->Channels->DistributionChannelRQ = array("id"=>$this->auth->channelid, "key"=>$this->auth->channelkey);
        $request->Providers->ProviderRQ = array("short_name", $values["txtShortName"]); //checked short name list
        $request->Query->IndustryCategory = array("_"=>$values["selIndustryCategory"]);
        $request->Channels->CO_DistributionChannelRQType = array("id" => $this->auth->channelid, "key" => $this->auth->channelkey);
        if ($values["selIndustryCategory"] == 0 || $values["selIndustryCategory"] == 1) { //Accommondation, Accommondation (Non-Serviced)
            $request->Query->SearchCriteria->LengthNights = array("minimum"=>$values["txtMin"], "maximum"=>$values["txtMax"]);
        } else { //Atraction, Events, Tours
            if ($values["txtDays"] != "") //Number Of Days
                $request->Query->SearchCriteria->LengthDays = array("days"=>$values["txtDays"]);
            
            if ($values["txtStartTime"] != "") //Start Time
                $request->Query->SearchCriteria->LengthDays = array("start_time"=>$values["txtStartTime"]);
                
            if ($values["txtFinishTime"] != "") //End Time
                $request->Query->SearchCriteria->LengthDays = array("finish_time"=>$values["txtFinishTime"]);
        }
        
        //Passengers
        if ($values["txtAdult"] != "") //Adult
            $request->Query->SearchCriteria->Consumers->Consumer = array("adults"=>$values["txtAdult"]);
            
        if ($values["txtChildren"] != "") //Children
            $request->Query->SearchCriteria->Consumers->Consumer = array("children"=>$values["txtChildren"]);
            
        if ($values["txtConcession"] != "") //Concessions
            $request->Query->SearchCriteria->Consumers->Consumer = array("concessions"=>$values["txtConcession"]);
            
        //click Specific Date Raido Button
        if ($values["rdoSpecific"] == "on")
            $request->Query->SearchCriteria->CommencingSpecific = array("date"=>$values["txtSpecificDate"]);
            
        //click Date Range Radio Button
        if ($valus["rdoDate"] == "on")
        {
            $request->Query->SearchCriteria->CommencingWindow = array("start_date"=>$values["txtStartDate"]);
            $request->Query->SearchCriteria->CommencingWindow = array("finish_date"=>$values["txtFinishDate"]);
            
            if ($values["chkCommerceAny"] != "on") { //checked CommerceAny
                $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = "";
                
                if ($values["chkCommerceMon"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("monday"=>true);
                
                if ($values["chkCommerceTue"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("tuesday"=>true);
                    
                if ($values["chkCommerceWed"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("wednesday"=>true);
                    
                if ($values["chkCommerceThu"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("thursday"=>true);
                    
                if ($values["chkCommerceFri"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("friday"=>true);
                    
                if ($values["chkCommerceSat"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("saturday"=>true);
                    
                if ($values["chkCommerceSun"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("sunday"=>true);
            }
            
            if ($values["chkConcludeAny"] != "on") { //checked ConcludeAny
                $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = "";
            
                if ($values["chkConcludeMon"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("monday"=>true);
                    
                if ($values["chkConcludeTue"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("tuesday"=>true);
                    
                if ($values["chkConcludeWed"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("wednesday"=>true);
                    
                if ($values["chkConcludeThu"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("thursday"=>true);
                    
                if ($values["chkConcludeFri"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("friday"=>true);
                    
                if ($values["chkConcludeSat"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("saturday"=>true);
                    
                if ($values["chkConcludeSun"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("sunday"=>true);
            }
        }
        
        try {
            $res = $this->v3Client->ProviderAvailability($request);
            
            if($res->Status->Success) {
                return $res->Channels->Channel->Providers->Provider;
            }
            
        } catch (SoapFault $exception) {
            echo $exception;
        }
        
        return null;
    }
    
    public function getProductAvailability($values)
    {
        $request = new \stdClass();
        
        $request->Channels->DistributionChannelRQ = array("id"=>$this->auth->channelid, "key"=>$this->auth->channelkey);
        $request->Providers->ProviderRQ = array("short_name", $values["txtShortName"]); //checked short name list
        $request->Query->IndustryCategory = array("_"=>$values["selIndustryCategory"]);
        
        if ($values["selIndustryCategory"] == 0) { //Accommondation
            $request->Query->SearchCriteria->LengthNights = array("minimum"=>$values["txtMin"], "maximum"=>$values["txtMax"]);
        } else { //Accommondation (Non-Serviced), Atraction, Events, Tours
            if ($values["txtDays"] != "") //Number Of Days
                $request->Query->SearchCriteria->LengthDays = array("days"=>$values["txtDays"]);
            
            if ($values["txtStartTime"] != "") //Start Time
                $request->Query->SearchCriteria->LengthDays = array("start_time"=>$values["txtStartTime"]);
                
            if ($values["txtFinishTime"] != "") //End Time
                $request->Query->SearchCriteria->LengthDays = array("finish_time"=>$values["txtFinishTime"]);
        }
        
        //Passengers
        if ($values["txtAdult"] != "") //Adult
            $request->Query->SearchCriteria->Consumers->Consumer = array("adults"=>$values["txtAdult"]);
            
        if ($values["txtChildren"] != "") //Children
            $request->Query->SearchCriteria->Consumers->Consumer = array("children"=>$values["txtChildren"]);
            
        if ($values["txtConcession"] != "") //Concessions
            $request->Query->SearchCriteria->Consumers->Consumer = array("concessions"=>$values["txtConcession"]);
            
        //click Specific Date Raido Button
        if ($values["rdoSpecific"] == "on")
            $request->Query->SearchCriteria->CommencingSpecific = array("date"=>$values["txtSpecificDate"]);
            
        //click Date Range Radio Button
        if ($valus["rdoDate"] == "on")
        {
            $request->Query->SearchCriteria->CommencingWindow = array("start_date"=>$values["txtStartDate"]);
            $request->Query->SearchCriteria->CommencingWindow = array("finish_date"=>$values["txtFinishDate"]);
            
            if ($values["chkCommerceAny"] != "on") { //checked CommerceAny
                $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = "";
                
                if ($values["chkCommerceMon"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("monday"=>true);
                
                if ($values["chkCommerceTue"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("tuesday"=>true);
                    
                if ($values["chkCommerceWed"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("wednesday"=>true);
                    
                if ($values["chkCommerceThu"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("thursday"=>true);
                    
                if ($values["chkCommerceFri"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("friday"=>true);
                    
                if ($values["chkCommerceSat"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("saturday"=>true);
                    
                if ($values["chkCommerceSun"] == "on")
                    $request->Query->SearchCriteria->CommencingWindow->CommencingDaysRQ = array("sunday"=>true);
            }
            
            if ($values["chkConcludeAny"] != "on") { //checked ConcludeAny
                $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = "";
            
                if ($values["chkConcludeMon"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("monday"=>true);
                    
                if ($values["chkConcludeTue"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("tuesday"=>true);
                    
                if ($values["chkConcludeWed"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("wednesday"=>true);
                    
                if ($values["chkConcludeThu"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("thursday"=>true);
                    
                if ($values["chkConcludeFri"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("friday"=>true);
                    
                if ($values["chkConcludeSat"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("saturday"=>true);
                    
                if ($values["chkConcludeSun"] == "on")    
                    $request->Query->SearchCriteria->CommencingWindow->ConcludingDaysRQ = array("sunday"=>true);
            }
        }
        
        try {
            $res = $this->v3Client->ProductAvailability($request);
            
            if($res->Status->Success) {
                return $res->Channels->Channel->Providers->Provider;
            }
            
        } catch (SoapFault $exception) {
            echo $exception;
        }
        
        return null;
    }
    
    public function getCalendarSearch($values)
    {
        $request = new \stdClass();
        $request->Channels->DistributionChannel = array("id"=>$this->auth->channelid, "key" => $this->auth->channelkey);
        $request->Providers->Provider =  array_slice($values["txtShortName"], 0, 30, true); //checked short name list
        $request->Query->IndustryCategory = $values["selIndustryCategory"];
        $request->Query->Criteria = array("start_date"=>$values["txtStartDate"], "days"=>$values["txtDays"]);
        //Cache Mode
        if ($values["rdoAuto"] == "on") //Auto
            $request->Query = array("cache"=>"Auto");
            
        if ($values["rdoOn"] == "on") //On
            $request->Query = array("cache"=>"On");
            
        if ($values["rdoOff"] == "on") //Off
            $request->Query = array("cache"=>"Off");
            
        //Show Product Info in results
        if ($values["chkShowProduct"] == "on")
            $request->Response = array("product_calendar"=>true);
        else
            $request->Response = array("product_calendar"=>false);
            
       
        try {
          //  echo "<pre>".print_r($request, true)."</pre>";
            if (count($request->Providers->Provider) > 10) {
                $providers = $request->Providers->Provider;
                $result = array();
                for ($i = 0; $i < count($providers); $i+=10) {
                    $request->Providers->Provider = array_slice($providers, $i, 10);
                    $res = $this->v3Client->CalendarSearch($request);
                    $result = array_merge($result, $res->Channels->Channel->Providers->Provider);
                }
                return $result;
            } else {
                $res = $this->v3Client->CalendarSearch($request);
                //  echo "<pre>".print_r($res, true)."</pre>";
                if($res->Status->Success) {
                    return $res->Channels->Channel->Providers->Provider;
                }
            }
            
        } catch (SoapFault $exception) {
            echo $exception;
        }
        
        return null;
    }
    
     public function getBaoDestinationRegion($id = NULL) {
        switch (strtoupper($id)) {
            // NSW
            case '339F8C8E-594B-4834-B130-319BCFE812A8' : // Blue Mountains
                return '359';
            case 'D6BE5144-EA67-4A08-BB78-2EFA32F298ED' : // Capital Country
                return '431';
            case '4A7DC397-A3F1-45F5-AF60-553B356F2DCC' : // Central Coast
                return '371';
            case '5F22D9FE-7B9D-4175-B949-DA58F6BBC1A1' : // Central New South Wales
                return '31';
            case '66AFA8C3-31E5-4F8F-BAAA-4E461F55EFAF' : // Hunter
                return '48';
            case '53752AFE-2607-460F-95A2-01FD1D3AE589' : // Illawarra
                return '99';
            case '7D983C8E-485E-4660-BACE-7227ECD7F754' : // Lord Howe Island
                return '425';
            case '6655EBD6-1F82-4FC6-AB12-613153A758B3' : // New England North West
                return '113';
            case '22063512-05AE-4388-8F68-FC3BE134C6FF' : // North Coast New South Wales
                return '129';
            case '5FEB642F-19D6-4CC1-9D17-B59FB0B76994' : // Northern Rivers
                return '188';
            case '1C4BBB86-CFCB-4ADE-9068-7C528B957DED' : // Outback New South Wales
                return '427';
            case '679C6EA7-E8B5-4B0E-895C-5D03995757B9' : // Riverina
                return '393';
            case '905C7766-8CA7-4E59-BF5A-B34FD3A185DD' : // Snowy Mountains
                return '415';
            case '5E05259A-05BC-41A4-975A-E93F221F5A9F' : // South Coast
                return '218';
            case '81C6D175-FDF3-4DF8-9B1F-E798766E07DE' : // Sydney
                return '274';
            case 'DEB9D233-8E9A-4631-BF6C-09A81584E70A' : // The Murray   ****** Missing *********
                return '';
// Northern Territory
            case '66C6EA3B-6EAC-4EEF-9141-4DFE78D38DDC' : // Alice Springs
                return '474';
            case 'CBED7265-58CD-4AAC-8CD7-CC9179CF3CB2' : // Darwin
                return '456';
            case '393FF982-0274-44EF-B893-DFFC5C13928C' : // Kakadu & Arnhem Land       *********** Unsure - outback selected ************
                return '472';
            case 'A54202DE-9B12-48E9-B18A-E0A0D7441031' : // Katherine
                return '484';
            case '8A3B4B71-7DA4-4F7A-BE1E-FA0496044A3A' : // Tennant Creek
                return '479';
            case '0E2BFEB9-BF0B-4E54-9055-12AC0EF6536C' : // Uluru & Kata Tjuta
                return '475';
//Queensland
            case '4CF7B910-74B9-40BC-8782-49E3F0BBFAD6' : // Brisbane
                return '489';
            case '549FEB8D-24E3-4651-970B-0EF92C99EEA8' : // Bundaberg & Coral Isles
                return '544';
            case 'C19194BA-689D-4067-A1B7-B20C3FCAFB53' : // Fraser Coast South Burnett
                return '744';
            case '26C087BC-F912-4064-A471-8871BDE8D30B' : // Gladstone
                return '553';
            case '8990EEE7-B49B-439B-A2DF-13B766738C15' : // Gold Coast
                return '571';
            case 'A29F6156-B762-4F7A-A380-5F2E8168C77B' : // Mackay
                return '622';
            case '924CE8CC-19E4-41B8-9A5E-371361387AE8' : // Outback Queensland
                return '762';
            case 'C99EEA23-6FC4-41F2-AB4A-58D86C247BCF' : // Rockhampton & Capricorn
                return '561';
            case 'FD5CF75A-33D4-418A-B1C3-291CCFB05AF7' : // Southern Downs  - *********** No idea on this one *************
                return '';
            case '7229DD33-41C1-4F79-B538-2C103D61DD41' : // Sunshine Coast
                return '632';
            case '0E96926F-CFAE-4676-BD2D-C1D5FD82DEB9' : // The Whitsundays
                return '731';
            case '885CD289-B519-4B3A-980F-1F0389829AC1' : // Toowoomba & Golden West
                return '776';
            case '10E06227-F409-43E1-8B1C-CA240FD75EF6' : // Townsville
                return '626';
            case '10AB0A5D-5F45-4528-8792-6662C38D9F02' : // Tropical North Queensland
                return '688';
            case 'A0C3A5CA-DF30-46C1-86A3-CFCECE57D9CD' : // Western Downs  - ************* No idea ******************
                return '';
//South Australia
            case 'EEECDD61-2DE0-43D6-ACF6-24BC4D6C9761' : // Adelaide
                return '800';
            case '68306EC4-0445-4021-9966-AD3B2FAD97CF' : // Adelaide Hills
                return '843';
            case 'BA2BA015-7DC1-402C-86F1-6C9417F22A3B' : // Barossa
                return '849';
            case 'E5EAAB70-9CA8-4362-914A-834105445FC5' : // Clare Valley
                return '862';
            case '763DC3A2-489D-4C01-BC93-2D4182AB79DF' : // Eyre Peninsula
                return '870';
            case 'C6D6E4F5-2348-4E77-A93B-9D6C77AB608A' : // Fleurieu Peninsula
                return '879';
            case 'E179E33A-F3B9-4ECB-BCF5-2E7DB249C310' : // Flinders Ranges and Outback
                return '928';
            case 'F4E97BA4-B400-4C98-A0EB-86DCE647EF2D' : // Kangaroo Island
                return '892';
            case 'BB534381-9498-4115-B192-7267723D94AA' : // Limestone Coast
                return '905';
            case '7F7BF742-E351-4E9F-9D6C-5AECF1073C3E' : // Murraylands
                return '919';
            case '4DEA93BD-88D9-402D-AFCA-13BD045C9315' : // Riverland
                return '937';
            case '2915BED4-263A-4116-9656-131F29B44A4D' : // Yorke Peninsula
                return '944';
//Tasmania
            case '3BC10ACB-4A05-40E4-9BBE-8ABDEFC9C710' : // Derwent Valley and Central Highlands
                return '950';
            case '75BE5A67-445F-477F-9300-8408749EA9FD' : // Devonport, Cradle Mountain & Great Western
                return '1018';

            case '875CF66E-451B-4D37-872E-B49E9E8960ED' : // Flinders Island
                return '4606';
            case '10109C81-C6EA-4357-A2B8-721CB3AC7258' : // Freycinet and the East Coast
                return '984';
            case 'B91C26D2-E722-4681-80B7-4C1F3398E548' : // Heritage Highway ******************** No idea ******************
                return '';
            case '82418A19-2C5E-4FD0-A821-1E7EC4D660C2' : // Hobart and Surrounds
                return '961';
            case '2DDC3B3B-4B40-4F6E-B7F8-EC599ECBF8BA' : // Huon DEntrecasteaux Bruny
                return '1045';
            case '1666362D-ADAC-4530-884E-255EFC85051F' : // King Island
                return '1039';
            case '5DDF0E1F-1C80-4D53-8B41-C7254548D5E7' : // Launceston and Tamar Valley
                return '987';
            case '8EDD77EB-0F45-4BF0-A229-E8C773B0105E' : // St Helens and the North East
                return '983';
            case '63658C87-1129-4B59-97E3-C1670EC11A84' : // Stanley and the North West
                return '1018';
            case '318AB8D8-2AC2-412E-A613-B666FB52E8C7' : // Strahan and The West Coast
                return '1033';
            case '5FCDCC48-2914-40A1-AB2F-C845BBE8B359' : // Tasman Peninsula and The South East
                return '1053';
//Victoria
            case '944330A4-3EDA-472A-BDAF-CDADDEFF7E7D' : // Gippsland
                return '1219';
            case '15B59C8E-38AB-4931-8D9E-0ECBA0D87A10' : // Goldfields
                return '1350';
            case '0084E941-1E86-4111-BB3D-F3D6742' : // DBABE Grampians
                return '1367';
            case '21FBFE50-25C0-403B-A8BA-E65E04F0A988' : // Great Ocean Road
                return '1069';
            case 'CCE9952B-07BE-4F7D-AB26-94734B6E5043' : // Legends, Wine & High Country
                return '1256';
            case 'BE5E8804-4034-44EE-A64A-F857CE9D7E26' : // Macedon Ranges Spa Country
                return '1284';
            case 'B1C1F111-E5B1-4FE7-9CC2-AD9A4CB0C703' : // Melbourne
                return '1102';
            case '78C646CF-61BB-4674-8E63-39221CC33111' : // Mornington Peninsula
                return '1294';
            case '0ED8FBD6-29FE-4241-9D77-1FB682F253CE' : // Murray
                return '1321';
            case '0460F33B-AD0A-4865-B473-DEC30513E17E' : // Phillip Island
                return '1343';
            case '21FDFDA8-FC94-4627-AA84-D1A3E698B54F' : // Yarra Valley & Dandenongs  ************ Also 1216 for dandenong ****************
                return '1381';
//Western Australia ************************* should be many more really *************** where is perth, broome, karratha etc. **********
            case '3c4e7fce-738e-4455-8a06-726189624194': // Perth ??
                return '1419';
            case 'BDD021C0-19A8-4C3C-B73F-4ACB0940E70E' : // Australia's Coral Coast
                return '1390';
            case '922F64B8-D854-4928-B2E3-290DB22E7DC3' : // Australia's Golden Outback
                return '1522';
            case '134978BD-3FF9-492C-B1C0-E8ED8A95F6FB' : // Australia's North West
                return '1407';
            case '97B4D628-6AC0-44F5-9C30-8803A60DA397' : // Australia's South West
                return '1480';
                break;

            default: return NULL;
                break;
        }
    }
	
	public function getIndustryCategory($id = 1) {
        switch ($id) {
            case '1':
                return "ACCOMM";

                break;
            case '8':
                return "TOUR";

                break;
            default: return "ACCOMM";
                break;
        }
    }
	/*
	public function downloadImage($image, $product_id = NULL, $s3 = FALSE) {
    	$serverpath = pathinfo($image);
        $fname = $serverpath['basename']; // get file name by stripping original path
        //  print_r($serverpath);
        $path = ROOT_PATH . '/public_html/images/multimedia/v3/' . $product_id; // set path to transfer image to
		if (!is_dir($path))
		{
			mkdir($path, 0777, true);
			mkdir($path . '/40', 0777, true);
		 	mkdir($path . '/100', 0777, true);
		}
        $url = "http://v3leisure.com" . $image;
		echo "<a href = '$url' target ='_blank'>fullurl</a>"; 
		$fullpathtoimage = $path . '/' . $fname;
       
        $file = file_get_contents($url);
        file_put_contents($fullpathtoimage, $file);
        $thumbnail40 = $this->resizeImage($fullpathtoimage, $path . "/40/" , 40, 40, 80, 'image_ratio_crop', true);
        $thumbnail100 = $this->resizeImage($fullpathtoimage, $path . "/100/" , 100, 100, 90, 'image_ratio_crop', true);
           
        if ($s3) { // if s3 storage selected then upload
            $s3 = new Ace_Service_S3();
            $bucket = "images.bookaccommodationonline.com.au";
            $folder = "v3";
          //  $put = $s3->sendToS3($path . '/' . $fname, $bucket, $folder . "" . $serverpath['dirname']);
        
        
          
                    
// add the first photo as default accommodation image
                        $s3 = new Ace_Service_S3();
                        $bucket = "images.bookaccommodationonline.com.au";
                        $putoriginal = $s3->sendToS3($fullpathtoimage, $bucket, 'v3' . "/" . $product_id);
                        $put40 = $s3->sendToS3($thumbnail40->file_dst_pathname, $bucket, '40/v3' . "/" . $product_id);
                        $put100 = $s3->sendToS3($thumbnail100->file_dst_pathname, $bucket, '100/v3' . "/" . $product_id);
                        unlink($thumbnail100->file_dst_pathname);
                        unlink($thumbnail40->file_dst_pathname);
                        unlink($fullpathtoimage);
                        rmdir($path . '/40');
                        rmdir($path . '/100');
                        rmdir($path);
                        
        }
        return $fname;
    }
    public function resizeImage($sourcePath, $destPath, $w = null, $h = null, $q = 90, $ratioType = 'image_ratio_no_zoom_in') {
        $thumb = new Ace_Upload();
        $thumb->upload($sourcePath);
        if ($w || $h) {
            $thumb->image_resize = true;
            $thumb->$ratioType = true;
            $thumb->image_y = $h;
            if ($h != '0') {
                $thumb->image_x = $w;
            }
            $thumb->jpeg_quality = $q;
        }
        if ($ratioType == 'image_ratio_fill')
            $thumb->image_background_color = '#FFFFFF';
        
        $thumb->file_safe_name = true;
        $thumb->file_auto_rename = false;
        $thumb->file_overwrite = true;
        $thumb->Process($destPath);
        
        return $thumb;
    }*/
}
