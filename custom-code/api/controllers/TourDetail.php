<?php 
require_once ("controllers/DBController.php");
class TourDetail
{
    private $db;
    
    function __construct() {
        // $DB = new DBController();
        $this->db = new DBController();
        
    }

    function get(){
        
        if(!empty($_GET['pageId'])){
          return $this->getTourDetail($_GET['pageId']);
        }

        if(!empty($_GET['tourId'])){
          return $this->getTourCities($_GET['tourId']);
        }

    }
    
    

    function getTourCities($tourId){
      
      $sql = "SELECT cName,cLatitude,cLongitude from tblCities where cityID_Admin in (SELECT DISTINCT cityID FROM tblItineraries where tourID=$tourId order by iDay asc)";
      

      $result                 = $this->db->query($sql);
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
      
      return json_encode(array('status'=>1,'data'=>$data));
      
    }

    function getTourDetail($pageId){
      
      $sql    = "SELECT tourID_Admin,tName from tblTours where pageId=$pageId limit 1";  
      $result = $this->db->query($sql);
      $data   = [];

      if($result->num_rows){
        while ($row = $result->fetch_assoc()) { 
          $data['tourId']    = $row['tourID_Admin'];
          $data['tourName']  = $row['tName'];
        }
      }    
      return json_encode(array('status'=>1,'data'=>$data));
    }
    
    
}
?>