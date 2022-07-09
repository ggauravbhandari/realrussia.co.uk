<?php 

require_once ("controllers/DBController.php");

class FeaturedPluginController

{

    private $db_handle;

    function __construct() {

        $this->db_handle = new DBController();

    }    

    function getDataById() {
      $id = $_POST['id'];
      $person = $_POST['person'];
        
        $query2 = "SELECT 
                  tblTours.tourID,
                  tblTours.tourID_Admin,
                  (
                    select 
                      concat(
                        GROUP_CONCAT(cName SEPARATOR ' / '), 
                        ' || ', 
                        GROUP_CONCAT(cFlagIcon SEPARATOR ' / ')
                      ) 
                    from 
                      tblCountries 
                    where 
                      countryID_Admin in (
                        select 
                          DISTINCT countryID 
                        from 
                          tblcities 
                        where 
                          cityID_Admin in (
                            select 
                              distinct cityID 
                            from 
                              tblItineraries 
                            where 
                              tourID = tblTours.tourID_Admin
                          )
                      )
                  ) as countries,
                  tblTours.tName,
                  tblTours.tBannerImage,
                  tblTours.tBannerDescription,
                  (SELECT is_display_banner FROM tblfeaturetourplugin WHERE id = ". $id.")as is_display_banner,
                  (select price from tblPreProcessTour where tourID = tblTours.tourID_Admin and language_id = 1 and passenger = ". $person." and currency_id = 2 ) as price,
                  tblbanners.bTitle,
                  tblbanners.bBackGroundColour,
                  tblbanners.bForeGroundColour
                FROM 
                  tblTours LEFT JOIN tblbanners on tblTours.bannerID = tblbanners.bannerID_Admin and tblbanners.bannerID_Admin != 0 
                WHERE 
                  tblTours.tourID_Admin in(SELECT tour_id FROM tblfeaturetourplugin WHERE id = ". $id.") and tblTours.tStatus in (1,62)";

                  // echo $query2;
                  // die();

        $result2 = $this->db_handle->query($query2);

        if ($result2->num_rows > 0) {

            $resultset = $result2->fetch_assoc();
            return array('status'=>1,'data'=>$resultset);
        }else{
          return array('status'=>0,'data'=>$resultset);
        }      
        
    }

    
    function getAll() {
        $sql = "SELECT * FROM tblfeaturetourplugin";

        $result = $this->db_handle->runBaseQuery($sql);

        return $result;
    }

}

?>