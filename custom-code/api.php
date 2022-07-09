<?php
require('config.php');

if(!empty($_GET['all']) && !empty($_GET['tourId']) ){
  getAll($conn,$_GET['tourId']);
}
if(!empty($_GET['pageId'])){
  getTourDetail($conn,$_GET['pageId']);
}

if(!empty($_GET['tourId']) && empty($_GET['all'])){
  getTourCities($conn,$_GET['tourId']);
}
function getAll($conn,$tourId){
  $data['language'] = getLanguage($conn,$tourId);
  $data['currency'] = getCurrency($conn,$tourId);
  echo json_encode(array('status'=>1,'data'=>$data));
  return;
}
function getCurrency($conn,$tourId){
  
  $sql = "SELECT CurrencyID_Admin as id ,cShortName as name,cHTMLcode  FROM tblCurrencies";
  $result = $conn->query($sql);
  $data = [];
  while ($row = $result->fetch_assoc()) { 
    array_push($data,$row);
  }
  return $data;
  
}
function getLanguage($conn,$tourId){
  if(!empty($tourId)){
    $res = $conn->query("SELECT REPLACE(tLanguages, ';', ',') as tLanguages from tblTours where tourID_Admin = $tourId");
    if($res->num_rows){
      while ($row = $res->fetch_assoc()) { 
        $sql = "SELECT languageID_Admin as id ,lName as name  FROM tblLanguages where languageID_Admin in (".$row['tLanguages']." ) ORDER BY lName asc";
      }
    }    
  }
  else{
    $sql = "SELECT languageID_Admin as id ,lName as name  FROM tblLanguages ORDER BY lName asc;";
  }
  $result = $conn->query($sql);
  $data = [];
  while ($row = $result->fetch_assoc()) { 
    array_push($data,$row);
  }
  
  return $data;
  
}



function getTourCities($conn,$tourId){
  
  // $sql = "SELECT cName,cLatitude,cLongitude from tblCities 
  // INNER JOIN tblItineraries on tblCities.cityID = tblItineraries.cityID_Admin
  // where cityID_Admin in (SELECT DISTINCT cityID FROM tblItineraries where tourID=$tourId order by iDay asc)";

  $sql = "SELECT tblCities.cName,tblCities.cLatitude,tblCities.cLongitude,tblItineraries.iDay
    from tblItineraries 
    INNER JOIN tblCities on tblItineraries.cityID = tblCities.cityID_Admin 
    where tblItineraries.tourID=$tourId order by iDay asc";
  
  $result = $conn->query($sql);
  $data['waypoint']       = [];
  $data['origin']         = [];
  $data['destination']    = [];
  $data['center']         = [];
  $centerIndex            = 0;
  $counter                = 0;
  if($result->num_rows > 0){
   
    if(($result->num_rows) % 2 == 0) {
      $centerIndex = ($result->num_rows) / 2 ;
    } else {
      $centerIndex = floor(($result->num_rows) / 2) ;
    }

    while ($row = $result->fetch_assoc()) { 
     
      if($counter===0) {
        //$data['origin'] = $row['cName'];
        $data['origin'] = array('cName'=>$row['cName'],'lat'=>(float)$row['cLatitude'],'lng'=>(float)$row['cLongitude']);        
      }
      if($centerIndex == $counter){
        //$data['center'] = array('cName'=>$row['cName'],"lat"=> 56.0153 ,"lng"=>92.8932);
        $data['center'] = array('cName'=>$row['cName'],'lat'=>(float)$row['cLatitude'],'lng'=>(float)$row['cLongitude']);
      }
      //array_push($data['waypoint'],array("location"=> $row['cName'],"stopover"=> true));
      array_push($data['waypoint'],array("location"=> $row['cName'],'lat'=>(float)$row['cLatitude'],'lng'=>(float)$row['cLongitude']));
      $counter++;
    }
  }

  
  $data['destination']      = end($data['waypoint']);
  $data['waypoint']         = array_slice($data['waypoint'], 1, -1);
  
  
  echo json_encode(array('status'=>1,'data'=>$data));
  return false;
  
}

function getTourDetail($conn,$pageId){
  
  $sql    = "SELECT tourID_Admin,tName from tblTours where pageId=$pageId limit 1";  
  $result = $conn->query($sql);
  $data   = [];

  if($result->num_rows){
    while ($row = $result->fetch_assoc()) { 
      $data['tourId']    = $row['tourID_Admin'];
      $data['tourName']  = $row['tName'];
    }
  }    
  echo json_encode(array('status'=>1,'data'=>$data));
  return;
}