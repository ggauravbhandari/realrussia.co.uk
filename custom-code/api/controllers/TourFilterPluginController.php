<?php 

require_once ("controllers/DBController.php");

class TourFilterPluginController

{

    private $db_handle;

    function __construct() {

        $this->db_handle = new DBController();

    }    

    function getDataById() {
      $id = $_POST['id'];
      $person = $_POST['person'];

        $query1 = "SELECT 
        if( type='tour',tour_id,
          (
            SELECT 
            if(
              tToursWithPrimaryTags = 1, 
              (
                SELECT 
                  GROUP_CONCAT(tourID) 
                from 
                  (
                    SELECT 
                      tourID, 
                      COUNT(*) AS COUNT 
                    FROM 
                      `tblTourTags` 
                    WHERE 
                      `tagID` IN (
                        SELECT 
                          tagID 
                        FROM 
                          `tblThemeTags` 
                        WHERE 
                          themeID = tbltourcardplugin.theme_id
                      ) 
                    GROUP BY 
                      `tourID` 
                    HAVING 
                      COUNT = (
                        SELECT 
                          count(tagID) 
                        FROM 
                          `tblThemeTags` 
                        WHERE 
                          themeID = tbltourcardplugin.theme_id
                      )
                  )as temp
              ) , 
            (SELECT GROUP_CONCAT(tourID) FROM tblThemeTours WHERE themeID = tbltourcardplugin.theme_id)
            ) 
            FROM 
              tblThemes 
            where 
              themeID_Admin = tbltourcardplugin.theme_id limit 1


          )
        ) as tour_id from tbltourcardplugin WHERE id =".$id;
        
        $result1 = $this->db_handle->runBaseQuery($query1);
        
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
                  ( select CONCAT ('[{',
                          '\"is_heading_visible\":\"',is_heading_visible,'\",',
                          '\"is_flag_visible\":\"',is_flag_visible,'\",',
                        '\"is_country_visible\":\"',is_country_visible,'\",', 
                        '\"is_description_visible\":\"',is_description_visible,'\",', 
                          '\"is_price_visible\":\"',is_price_visible,'\",',
                          '\"is_image_visible\":\"',is_image_visible,'\",',
                          '\"is_share_icon_visible\":\"',is_share_icon_visible,'\",',
                          '\"is_label_visible\":\"',is_label_visible,'\",',
                          '\"is_learn_more_visible\":\"',is_learn_more_visible,'\",',
                          '\"is_wishlist_icon_visible\":\"',is_wishlist_icon_visible,
                          '\"}]') from tbltourcardplugin where id = ".$id."
                      ) as pluginDetails,
                  tblTours.tName,
                  tblTours.tBannerImage,
                  tblTours.tBannerDescription,
                  (select price from tblPreProcessTour where tourID = tblTours.tourID_Admin and language_id = 1 and passenger = ". $person." and currency_id = 2 ) as price,
                  tblbanners.bTitle,
                  tblbanners.bBackGroundColour,
                  tblbanners.bForeGroundColour
                FROM 
                  tblTours LEFT JOIN tblbanners on tblTours.bannerID = tblbanners.bannerID_Admin and tblbanners.bannerID_Admin != 0 
                WHERE 
                  tblTours.tourID_Admin in(".$result1[0]['tour_id'].") and tblTours.tStatus in (1,62)";

                  // echo $query2;
                  // die();

        $result2 = $this->db_handle->query($query2);

        if ($result2->num_rows > 0) {

            while($row = $result2->fetch_assoc()) {

                if(!empty($row['pluginDetails'])){
                    $pluginDetails =json_decode($row['pluginDetails']);
                   
                    foreach ($pluginDetails[0] as $k => $val) {
                        $row[$k] = $val; 
                    }
                }

                $resultset[] = $row;
            }
            return array('status'=>1,'data'=>$resultset);
        }else{
          return array('status'=>0,'data'=>$resultset);
        }      
        
    }

    
    function getAll() {
        $sql = "SELECT * FROM tbltourcardplugin";

        $result = $this->db_handle->runBaseQuery($sql);

        return $result;
    }

}

?>