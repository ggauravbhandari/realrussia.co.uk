<?php 
require_once ("controllers/DBController.php");
class TourLink
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
        $this->db = new DBController();
        $this->base_url = $base_url;
    }

    
    function getTourLinkByTourId(){
        if(!empty($_GET['tourId'])){
            $tour_id    = $_GET['tourId'];
          
            $sql        = "SELECT pageId from tblTours where tourID_Admin=$tour_id";
           
            $result     = $this->db->query($sql);

            if($result->num_rows > 0) {

                while ($row = $result->fetch_row()) {
                
                    $res = file_get_contents($this->base_url.'/wp-json/wp/v2/tour/'.$row[0], false, stream_context_create($this->arrContextOptions));
                   
                    if(!empty($res)){
                      return  $res;
                    }else{
                       return  false; 
                    }   
                }
            }else{
              return  false;
            }
        }
    }

    function getTourLinkByPageId(){
        if(!empty($_GET['pageId'])){
            $page_id    = $_GET['pageId'];
        
            $res = file_get_contents( $this->base_url.'/wp-json/wp/v2/pages/'.$page_id, false, stream_context_create($this->arrContextOptions));
            if(!empty($res)){
              return  $res;
            }else{
               return  false; 
            }          
        }else{
           return  false; 
        }
    }

}
?>