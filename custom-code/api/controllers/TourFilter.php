<?php 
require_once ("controllers/DBController.php");
class TourFilter
{

    private $db;
    private $base_url;
    
    
    function __construct($base_url) {
        $this->db = new DBController();
        $this->base_url = $base_url;

    }
    
    function get(){  
    
        $result     = $this->db->query($this->getTourByFitler());
        $tagsResult = $this->getTourByFitler(true,true);
        $rangeResult= $this->getTourByFitlerRange();

        $tours      = [];
        $tags       = [];
        $tourIdArray= [];
        $priceArray = [];
        $dayArray   = [];
        $minDay     = 0;
        $maxDay     = 0;
        $minPrice   = 0;
        $maxPrice   = 0;



        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $countryAndFlag     = explode(' || ', $row['countries']);
                $row['countries']   = $countryAndFlag[0];
                $row['flags']       = $countryAndFlag[1];
                $tours[]            = $row;
                //array_push($tourIdArray,$row['tourID_Admin']);
               
            }

        }
        
        if(!empty($tagsResult)){
            //$tourIdString = implode(',', $tourIdArray);

            $sql = "SELECT tagID_Admin as id,tTag FROM tbltags where tagID_Admin in (select DISTINCT tagID from tbltourtags where tourID in ({$tagsResult}) and tPrimaryTag = 0) order by tTag asc";
            //echo $sql;die;
            $tags= $this->db->runBaseQuery($sql);
        }

        $priceArray = $rangeResult->priceArray;
        $dayArray   = $rangeResult->dayArray;
        if(!empty($dayArray)){            
            $minDay     = $dayArray[0];
            $maxDay     = $dayArray[count($dayArray)-1];
        }
        if(!empty($priceArray)){ 
            $minPrice   = $priceArray[0];
            $maxPrice   = $priceArray[count($priceArray)-1];
        }
        return array('status'=>1,'data'=>$tours,'tags'=>$tags,'minDay'=>$minDay,'maxDay'=>$maxDay,'minPrice'=>$minPrice,'maxPrice'=>$maxPrice);
        //return array('status'=>1,'data'=>$tours,'tags'=>$tags);
    }

    function getTourByFitler($getCount = false,$getCountSkipFlag = false){

        $data = $_POST;

        $language = !empty($data['language'])  ? $data['language'] : 1;
        $theme    = !empty($data['theme'])     ? $data['theme'] : 0;
        $currency = !empty($data['currency'])  ? $data['currency'] : 2;
        $person   = !empty($data['person'])    ? intval($data['person']) : 1;
        $country  = !empty($data['country'])   ? $data['country'] : [];
        $ranking  = !empty($data['ranking'])   ? implode(',',$data['ranking']) : null;
        $startDate= !empty($data['startDate']) ? $data['startDate'] : null;
        $endDate  = !empty($data['endDate'])   ? $data['endDate'] : null;
        $minDay   = !empty($data['minDay'])    ? $data['minDay'] : 0;
        $maxDay   = !empty($data['maxDay'])    ? $data['maxDay'] : 31;
        $minPrice = !empty($data['minPrice'])  ? $data['minPrice'] : 0;
        $maxPrice = !empty($data['maxPrice'])  ? $data['maxPrice'] : 0;
        $tourType = !empty($data['tourType'])  ? $data['tourType'] : 0;
        $cities   = !empty($data['cities'])    ? implode(',',$_POST['cities']) : null;
        $tourTags = !empty($data['tourTags'])  ? $data['tourTags'] : [];
        $limit    = !empty($data['limit'])     ? $data['limit'] : 10;
        $pageNo   = !empty($data['pageNo'])    ? $data['pageNo'] : 1;
        $sort     = !empty($data['sort'])      ? $data['sort'] : 'asc';
        $offset   = ($pageNo-1)*$limit;
        
        $coloum   = " tourID_Admin,pageId,
            (select concat( GROUP_CONCAT(cName SEPARATOR ' / ') ,' || ', GROUP_CONCAT(cFlagIcon SEPARATOR ' / ')) from tblCountries where countryID_Admin in ( select DISTINCT countryID from tblcities where cityID_Admin in ( 
            select distinct cityID from tblItineraries where tourID = tblTours.tourID_Admin ))) as countries,
            (select  if( max(iDay) >= {$minDay} and max(iDay) <= {$maxDay},true,false) from tblItineraries where tourID = tblTours.tourID_Admin) as dayLimit,tblPreProcessTour.price,tBannerDescription,tName,tBannerImage,tblbanners.bTitle  ,tblbanners.bBackGroundColour ,tblbanners.bForeGroundColour,(select max(iDay) from tblItineraries where tourID = tblTours.tourID_Admin) as totalTourDays  ";

        if($getCount){
            //$coloum   = " tourID_Admin,";
            $coloum   = $getCountSkipFlag ? " tourID_Admin " : " tourID_Admin,";
            if(!empty($maxDay) && $getCountSkipFlag == false)
            $coloum   .= "(select  if( max(iDay) >= {$minDay} and max(iDay) <= {$maxDay},true,false) from tblItineraries where tourID = tblTours.tourID_Admin) as dayLimit ";
        }
        $subjoin  = '';
        if(!empty($maxPrice)){
            $subjoin .= " and price >= {$minPrice} and price <= {$maxPrice} ";
        }
        $joins    = " INNER JOIN tblPreProcessTour on ( tblTours.tourID_Admin = tblPreProcessTour.tourId and passenger = {$person}  and currency_id = {$currency} $subjoin ) 
        LEFT JOIN tblbanners on tblTours.bannerID = tblbanners.bannerID_Admin and tblbanners.bannerID_Admin != 0 ";

        // $joins    = " INNER JOIN tblPreProcessTour on ( tblTours.tourID_Admin = tblPreProcessTour.tourId and passenger = {$person}  and price >= {$minPrice} and price <= {$maxPrice} and currency_id = {$currency}) 
        // LEFT JOIN tblbanners on tblTours.bannerID = tblbanners.bannerID_Admin";

        $sql      = " select $coloum from tblTours $joins";

        $sqlParts = [];

        if(!empty($ranking)){
            array_push( $sqlParts , " tPhysicalRating in ({$ranking}) ");
        }

        if(!empty($tourType)){
            array_push( $sqlParts , " tGroup = {$tourType} ");
        }
        if(!empty($language)){
            array_push( $sqlParts , " FIND_IN_SET ({$language}, REPLACE(tLanguages, ';', ',')) " );
        }

        if(!empty($country)){
            $sqlSubParts = [];
            foreach ($country as $key => $value) {
                array_push( $sqlSubParts , " FIND_IN_SET ({$value}, REPLACE(tCountriesVisited,';', ',')) ");
            }
            if(!empty($sqlSubParts)){
                array_push( $sqlParts , '('.implode(' and ', $sqlSubParts).')' );
            }
            
        }

        if(empty($startDate['year']) || empty($startDate['month'])|| empty($endDate['year']) || empty($endDate['month'])){

        }else{

            if(!empty($startDate) && !empty($endDate)){
                
                if((int)date('Y') == (int)$startDate['year'] && (int)date('m') == $startDate['month']){
                    $startDate = date('Y-m-d');
                    array_push( $sqlParts , " Exists( SELECT 1 FROM tblDepartures where tourID  = tblTours.tourID_Admin and dStartDate > {$startDate} and YEAR(dStartDate) <= {$endDate['year']} and  Month(dStartDate) <= {$endDate['month']} ) ");
                }else{

                    array_push( $sqlParts , " Exists( SELECT 1 FROM tblDepartures where tourID  = tblTours.tourID_Admin and YEAR(dStartDate) >= {$startDate['year']} and Month(dStartDate) >= {$startDate['month']}  and YEAR(dStartDate) <= {$endDate['year']} and  Month(dStartDate) <= {$endDate['month']}) ");
                }

            }
        }


        

        
        if(!empty($tourTags)){
            $sqlTagSubParts = [];
            foreach ($tourTags as $key => $value) {
                array_push( $sqlTagSubParts , " Exists( SELECT 1 FROM tbltourtags where tourID  = tblTours.tourID_Admin and tagID ={$value} and tPrimaryTag = 0 ) ");
            }
            if(!empty($sqlTagSubParts)){
                if(count($sqlTagSubParts)==1){
                    array_push( $sqlParts , $sqlTagSubParts[0]);
                }else{
                    array_push( $sqlParts , '('.implode(' and ', $sqlTagSubParts).')' );
                }
            }
            //echo "<pre>";print_r($sqlParts);die;

            //array_push( $sqlParts , " Exists( SELECT 1 FROM tbltourtags where tourID  = tblTours.tourID_Admin and tagID in ({$tourTags}) and tPrimaryTag = 0 ) ");
        }

        if(!empty($cities)){
            array_push( $sqlParts , " Exists( SELECT 1 FROM tblItineraries where tourID  = tblTours.tourID_Admin and cityID in ({$cities}) ) ");
        }
            
        // $sql = $sql." where  ".implode(' and ', $sqlParts);
        $sql = $sql." where tStatus in (1,62) and  ".implode(' and ', $sqlParts);

        if(!empty($theme)){
            $tour_ids = $this->getTourBelongsToTheme($theme);
            if(!empty($tour_ids))
            $sql .= " and tblTours.tourID_Admin in ({$tour_ids}) ";
           
        }

        if(!empty($maxDay)){
            if($getCountSkipFlag){
                $sql = $sql." GROUP by tourID_Admin ";
            }else{
                $sql = $sql." GROUP by tourID_Admin having  dayLimit = 1";
            }
        }
        if(!$getCount){
            $sql = $sql." order by price $sort limit $offset,$limit"  ;
        }
        
        //echo $sql;die;
        return $sql;

    }

    function getTourCountByFitler(){

        $sql = $this->getTourByFitler(true);

        //echo $sql;die;
        return array('status'=>1,'data'=>$this->db->query($sql)->num_rows);


    }

    function getTourBelongsToTheme($theme){

        $sql = "
          SELECT 
            themeID_Admin, 
            tToursWithPrimaryTags, 
            tToursFromList, 
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
                          themeID = {$theme}
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
                          themeID = {$theme}
                      )
                  )as temp
              ) , 
            (SELECT GROUP_CONCAT(tourID) FROM tblThemeTours WHERE themeID = {$theme})
            ) as tourID
          FROM 
            tblThemes 
          where 
            themeID_Admin = {$theme} limit 1
        ";
        
        $result = $this->db->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                return $row['tourID'];               
            }
        }
        
    }




    function getTourByFitlerRange(){
        $person   = !empty($_POST['person'])    ? $_POST['person'] : null;
        $country  = !empty($_POST['country'])   ? $_POST['country'] : [];
        $language = !empty($_POST['language'])  ? $_POST['language'] : null;
        $theme    = !empty($_POST['theme'])     ? $_POST['theme'] : null;
        $currency = !empty($_POST['currency'])  ? $_POST['currency'] : null;
        $startDate= !empty($_POST['startDate']) ? $_POST['startDate'] : null;
        $endDate  = !empty($_POST['endDate'])   ? $_POST['endDate'] : null;

        $coloum   = " tourID_Admin,tblPreProcessTour.price,
            (select max(iDay) from tblItineraries where tourID = tblTours.tourID_Admin) as totalTourDays  ";

        $joins    = " INNER JOIN tblPreProcessTour on ( tblTours.tourID_Admin = tblPreProcessTour.tourId and passenger = {$person}  and currency_id = {$currency} and language_id = {$language}) 
        LEFT JOIN tblbanners on tblTours.bannerID = tblbanners.bannerID_Admin and tblbanners.bannerID_Admin != 0";

        $sql      = " select $coloum from tblTours $joins";

        $sqlParts = [];

        if(!empty($country)){
            $sqlSubParts = [];
            foreach ($country as $key => $value) {
                array_push( $sqlSubParts , " FIND_IN_SET ({$value}, REPLACE(tCountriesVisited,';', ',')) ");
            }
            if(!empty($sqlSubParts)){
                array_push( $sqlParts , '('.implode(' and ', $sqlSubParts).')' );
            }
            
        }

        if(!(empty($startDate['year']) || empty($startDate['month'])|| empty($endDate['year']) || empty($endDate['month']))){


            if(!empty($startDate) && !empty($endDate)){
                
                if((int)date('Y') == (int)$startDate['year'] && (int)date('m') == $startDate['month']){
                    $startDate = date('Y-m-d');
                    array_push( $sqlParts , " Exists( SELECT 1 FROM tblDepartures where tourID  = tblTours.tourID_Admin and dStartDate > {$startDate} and YEAR(dStartDate) <= {$endDate['year']} and  Month(dStartDate) <= {$endDate['month']} ) ");
                }else{

                    array_push( $sqlParts , " Exists( SELECT 1 FROM tblDepartures where tourID  = tblTours.tourID_Admin and YEAR(dStartDate) >= {$startDate['year']} and Month(dStartDate) >= {$startDate['month']}  and YEAR(dStartDate) <= {$endDate['year']} and  Month(dStartDate) <= {$endDate['month']}) ");
                }

            }
        }


        // if(!empty($theme)){
        //     array_push( $sqlParts , " Exists( SELECT 1 FROM tblThemetours where tourID  = tblTours.tourID_Admin and themeTourID_Admin = {$theme} ) ");
        // }
        if(!empty($theme)){
            $tour_ids = $this->getTourBelongsToTheme($theme);
            if(!empty($tour_ids))
            $sql .= " and tblTours.tourID_Admin in ({$tour_ids}) ";
           
        }

       
            
        if(!empty($sqlParts)){
            $sql = $sql." where tStatus in (1,62) and  ".implode(' and ', $sqlParts);
        }else{
            $sql = $sql." where tStatus in (1,62) ";
        }

        if(!empty($maxDay)){
            $sql = $sql." GROUP by tourID_Admin having  dayLimit = 1";
        }
        
        $result = $this->db->query($sql);

        $priceArray = [];
        $dayArray   = [];

        if ($result && $result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                array_push($priceArray,$row['price']);
                array_push($dayArray,$row['totalTourDays']);
            }
            sort($priceArray);
            sort($dayArray);

        }
        
        return (object)['priceArray'=>$priceArray,'dayArray'=>$dayArray];
        
        
    }

   

    

    
    
   
    
   

}
?>