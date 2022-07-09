<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$base_url = 'https://realrussia.co.uk/';

require_once ("controllers/Aurora.php");
require_once ("controllers/DBController.php");
require_once ("controllers/Language.php");
require_once ("controllers/Theme.php");
require_once ("controllers/Tour.php");
require_once ("controllers/TourDetail.php");
require_once ("controllers/TourCost.php");
require_once ("controllers/Countries.php");
require_once ("controllers/TourLink.php");
require_once ("controllers/CustomeHeader.php");
require_once ("controllers/TourPreProcess.php");
require_once ("controllers/TourFilter.php");
require_once ("controllers/mailController.php");
require_once ("controllers/TourFilterPluginController.php");
require_once ("controllers/FeaturedPluginController.php");
require_once ("controllers/TourYearlyCost.php");
require_once "core/Request.php";

$db_handle = new DBController();

$tourPreProcess = new TourPreProcess($base_url);
$tourFilter     = new TourFilter($base_url);
$language       = new Language();
$theme          = new Theme();
$tour           = new Tour($base_url);
$country        = new Countries();
$tourDetail     = new TourDetail();
$tourCost       = new TourCost();
$tourLink       = new TourLink($base_url);
$customeHeader  = new CustomeHeader();
$mailController = new mailController();
$tourFilterPluginController = new TourFilterPluginController();
$featuredPluginController = new FeaturedPluginController();
$tourYearlyCost = new TourYearlyCost();
$request        = new Request();

$action = "";
if (!empty($_GET["action"])) {
    $action = $_GET["action"];
}
switch ($action) {
	case "language":
        $result = $language->getAllLanguage();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "getLanguageById":
    	$language_id = $_GET["id"];
        if (!empty($language_id)) {
	        $result = $language->getLanguageById($language_id);
            echo json_encode(array('status'=>1,'data'=>$result));
        }
        break;
    case "theme":
        $result = $theme->getAllTheme();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "getthemeById":
    	$theme_id = $_GET["id"];
        if (!empty($theme_id)) {
	        $result = $theme->getThemeById($theme_id);
	        echo json_encode(array('status'=>1,'data'=>$result));
        }
        break;
    case "tourTags":
        $result = $tour->getAllTourTags();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "physicalRating":
        $result = $tour->getPhysicalRating();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "tourType":
        $result = $tour->getTourType();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "getTourById":
    	$tour_id = $_GET["id"];
        if (!empty($tour_id)) {
	        $result = $tour->getTourById($tour_id);
	        echo json_encode(array('status'=>1,'data'=>$result));
        }
        break;
    case "countries":
        $result = $country->getAllCountry();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
    case "getCitiesByCountryId":
    	$country_id = $_GET["id"];
        if (!empty($country_id)) {
	        $result = $country->getCitiesByCountryId($country_id);
	        echo json_encode(array('status'=>1,'data'=>$result));
        }
        break;
    case "getTourDetail":
        echo $tourDetail->get();
        break;
    case "getTourCost":
        echo $tourCost->get();
        break;
    case "getChannel":
        echo $tourCost->getChannelID($request->get('tourId', null));
        break;
    case "getTourLink":
        echo $tourLink->getTourLinkByTourId();   
        break;
    case "getAllTourIdPageId":
        $result = $tour->getAllTourIdPageId();
        echo json_encode(array('status'=>1,'data'=>$result));
        break; 
    case "getFavPageDataByTourId":
        $tour_id = $_GET["id"];
        if (!empty($tour_id)) {
	        $result = $tour->getFavPageDataByTourId($tour_id);
	        echo json_encode(array('status'=>1,'data'=>$result));
        }
        break; 
    case "getTourLinkByPageId":
        echo $tourLink->getTourLinkByPageId();   
        break; 
    case "getCustomeHeaderFilterOption":
        $id = $_GET["id"];
        $result = $customeHeader->getCustomeHeaderFilterOption($id);  
        echo json_encode(array('status'=>1,'data'=>$result)); 
        break;
    case "getPreProcess":
        $result = $tourPreProcess->get();  
        echo json_encode(array('status'=>1,'data'=>$result)); 
        break;  
    case "getTourFilter":
        echo json_encode($tourFilter->get()); 
        break; 
    case "getTourCountFilter":
        echo json_encode($tourFilter->getTourCountByFitler()); 
        break;
    case "getLowestPrice":
        $result = $tour->getLowestPrice();
        echo json_encode(array('status'=>1,'data'=>$result));
        break; 
    case "callMeBackForm":
        echo json_encode($mailController->callMeBackForm());
        break;
    case "tourEnquiry":
        echo json_encode($mailController->tourEnquiry());
        break; 
    case "getTourFilterPluginOption":
        echo json_encode($tourFilterPluginController->getDataById());
        break;
    case "getFeaturedPluginData":
        echo json_encode($featuredPluginController->getDataById());
        break;
    case "getThemePluginData":
        echo json_encode($theme->getThemePluginData());
        break;  
    case "getTourYearlyCost":        
        echo $tourYearlyCost->get();      
        break;                  
    default:
        $result = $language->getAllLanguage();
        echo json_encode(array('status'=>1,'data'=>$result));
        break;
}
?>