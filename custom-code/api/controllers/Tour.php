<?php 
require_once ("controllers/DBController.php");
class Tour
{
    private $db_handle;
    private $base_url;
	private $arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	);
    
    function __construct($base_url) {
        $this->db_handle = new DBController();
        $this->base_url = $base_url;
    }
    
    function deleteTour($tour_id) {
        $query = "DELETE FROM tblTours WHERE tourID = ?";
        $paramType = "i";
        $paramValue = array(
            $tour_ids
        );
        $this->db_handle->update($query, $paramType, $paramValue);
        return true;
    }
    
    function getTourById($tour_ids) {
        $query = "SELECT * FROM tblTours WHERE tourID = ?";
        $paramType = "i";
        $paramValue = array(
            $tour_ids
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    function getAllTour() {
        $sql = "SELECT * FROM tblTours";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getPhysicalRating() {
        $sql = "SELECT sName,statusID_Admin,'0' as is_check FROM tblstatuses where sCategory = 'fitness'";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getTourType() {
        $sql = "SELECT sName,statusID_Admin FROM tblstatuses where sCategory = 'Group Type'";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllTourIdPageId() {
        $sql = "SELECT tourID_Admin as tourId,pageId,(SELECT calendarType from tblTourData where tourID = tblTours.tourID_Admin) as isAnnualCalendar FROM tblTours where tourID_Admin is not null and tourID_Admin != 0 and pageId !=0 and pageId is not null";
        $result = $this->db_handle->query($sql);
        $data   = [];       

        while($row = $result->fetch_assoc()) {

            $res = file_get_contents($this->base_url.'/wp-json/wp/v2/tour/'.$row['pageId'], false, stream_context_create($this->arrContextOptions));
            if(!empty($res)){
                $res                    = json_decode($res);
                $row['slug']            = !empty($res->link) ?  $res->link : '';
                $row['isAnnualCalendar']= ($row['isAnnualCalendar']== 81) ?  1 : 0;
                $data[] = $row;
            }
            
        }
        
        
        $fp = fopen('././tourIdAccordingToPageId.json', 'w');
       
        fwrite($fp, json_encode($data));
        fclose($fp);
        return true;
    }

    function getFavPageDataByTourId($tour_ids){
        $query = "SELECT * FROM tblTours WHERE tourID_Admin in ( ".$tour_ids." )";
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getLowestPrice(){

        $tour_id      = !empty($_GET['tour_id'])     ? $_GET['tour_id']     : 0;
        $person       = !empty($_GET['person'])      ? $_GET['person']      : 0;
        $currency_id  = !empty($_GET['currency_id']) ? $_GET['currency_id'] : 0;
        $language_id  = !empty($_GET['language_id']) ? $_GET['language_id'] : 0;

        $query = "SELECT price FROM tblpreprocesstour WHERE tourID =  ".$tour_id." and passenger = ".$person." and currency_id = ".$currency_id." and language_id = ".$language_id." ";
      
        $result = $this->db_handle->query($query);
        while ($row = $result->fetch_assoc()){
            return $total = $row['price'];
        }
        return 0;
    }

}
?>