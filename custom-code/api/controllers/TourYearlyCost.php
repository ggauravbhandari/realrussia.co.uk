<?php 

require_once ("controllers/DBController.php");
require_once ("controllers/Aurora.php");

class TourYearlyCost

{

  private $db;

  public $pageId;

  public $tourId;

  public $tourType;

  public $person;

  public $paxValue;

  public $room;

  public $month;

  public $year;

  public $lng;

  public $srooms;

  public $drooms;

  public $currency;

  public $currencyPrefix;

  public $today;

  public $dayWiseTourCost;

  public $allDiffCostArray;

  public $totalTourDays;

  public $availDepartureDate;

  public $tourLastDay;

  public $lowestPrice;

  public $isGroupPriceApply;

  public $groupPAX;

  /* channelID will be read from Aurora database */
  private $channelID = 0;    

  private $auroraService;
    

  function __construct() {

    $this->db = new DBController(); 
    $this->isGroupPriceApply = false;

    $this->auroraService = new AuroraService();

  }



  function get(){

    $this->pageId    = !empty($_GET['pageId']) ? $_GET['pageId']: null;

    $this->tourId    = !empty($_GET['tourId']) ? $_GET['tourId']: null;

    $this->lowestPrice    = !empty($_GET['lowest']) ? $_GET['lowest']: false;

    if(empty($this->tourId) && !empty($this->pageId)){

      $this->tourId = $this->getTourIdByPageId($this->pageId);

    }

    $this->initializiation();

  }



  function getTourIdByPageId($pageId){

    $sql    = "SELECT tourID_Admin from tblTours where pageId=$pageId";

    $result = $this->db->query("SELECT tourID_Admin from tblTours where pageId=$pageId");

    if($result->num_rows > 0) {

      while ($row = $result->fetch_row()) {

        return $row[0];

      }

    }

  }



  function initializiation(){

    if(!empty($this->tourId)){

      $this->channelID = $this->auroraService->getChannelID($this->tourId);

      $this->person               = !empty($_GET['person']) ? $_GET['person']: 1;

      $this->groupPAX             = $this->getGroupPriceCondition($this->tourId,$this->person);

      $this->groupPAX             = 'PAX'.(($this->groupPAX < 10)? '0':'').$this->groupPAX;

      $this->paxValue             = 'PAX'.(($this->person < 10)? '0':'').$this->person;
      //echo $this->paxValue;die;

      $this->room                 = !empty($_GET['room']) ? $_GET['room']: 1;;

      $this->month                = !empty($_GET['month']) ? $_GET['month']:date('m');
      
      $this->year                 = !empty($_GET['year']) ? $_GET['year']:date("Y");

      $this->lng                  = !empty($_GET['lng']) ? $_GET['lng']: 1;

      $this->srooms               = ($this->person % 2);

      $this->drooms               = (int)($this->person / 2);

      $this->currency             = !empty($_GET['currency']) ? $_GET['currency']: 2;

      $this->currencyPrefix       = trim($this->getPrefix($this->currency));

      $this->today                =  date("Y-m-d") ;

      $this->dayWiseTourCost      = [];

      $this->allDiffCostArray     = [];

      $this->totalTourDays        = $this->getTotalTourDays($this->tourId);

      $this->availDepartureDate   = $this->getDepartureDates();

      $this->tourLastDay          = $this->getTourLastDay($this->tourId);



      //$availDepartureDate   = ['2021-12-29 00:00:00.000'];

      //echo "<pre>";print_r($this->availDepartureDate);die;
      if(count($this->availDepartureDate) > 0){


        foreach ($this->availDepartureDate as $key => $departureDate) {
          // if(strtotime($departureDate) > strtotime($this->today) || $this->lowestPrice){
          if(strtotime($departureDate) >= strtotime($this->today)){





            //$dateIndex        = (int)date('d', strtotime($departureDate));
            $dateIndex        =   date('Y-m-d', strtotime($departureDate));

            $cost             = [];



            /*

              1.  For each service item associated with the tour, obtain total services cost adding each individual service cost based on service start date, PAX and guide language

            */

            

            $sqlA12 = "select tourCostingID,tourDayStart From tblTourCostingList where tourID = $this->tourId";

            $resultA12 = $this->db->query($sqlA12);



            /*============================= Extra Facilities  ==========================================*/



            while ($rowA12 = $resultA12->fetch_assoc()) {

             

              $date = date('Y-m-d', strtotime($departureDate."+ ".$rowA12['tourDayStart']." days"));

              $date = date('Y-m-d', strtotime($date.' -1 days'));

              

             

              /*================   Costing for rangeType=52   =======================*/
              $tempColoum = '';
              if($this->isGroupPriceApply){
                $tempColoum = $this->groupPAX.',';
              }
              

              $sqlA13 = 'SELECT '.$tempColoum.$this->paxValue.',MAX(rangePriority) as rangePriority,rangeType,rangeCostType,tourCostingID,rangeLanguage,tblTourCostings.costCurrency,tblTourCostings.supplierRates,tblTourCostings.costingName

              FROM tblCostRanges 

                INNER JOIN tblTourCostings on tblTourCostings.tourCostingsID_Admin = tblCostRanges.tourCostingID  

              WHERE 

                tblCostRanges.tourCostingID = '.$rowA12['tourCostingID'].'  

                and (case 

                  WHEN rangeType = 53  THEN  rangeLanguage = '.$this->lng.'

                  ELSE 1=1

                  end)

                and dateFrom <= "'.$date.'" and dateTo >= "'.$date.'" 

                group by rangeType ';

              // echo $sqlA13;

              // echo "<br>---------------------------------------------<br>";

              $sqlA13Result = $this->db->query($sqlA13);



              /*

                53  Guide Range Type | 52  Service Range Type

                55  Per Group Cost Type | 54  Per PAX Cost Type

              */



              while ($rowA13 = $sqlA13Result->fetch_assoc()) {



                if($rowA13['rangeType']==52){
                  if($this->isGroupPriceApply){
                    array_push($cost,["cost"=>$rowA13[$this->groupPAX]*$this->person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                  }else{

                    array_push($cost,["cost"=>$rowA13[$this->paxValue]*$this->person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                  }


                }



                if($rowA13['rangeType']==53){

                  if($rowA13['rangeLanguage'] != 1){

                    if($rowA13['rangeCostType'] == 55){  

                      if($this->isGroupPriceApply){

                        array_push($cost,["cost"=>($rowA13[$this->groupPAX]*$this->person),"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);

                      }else{

                        array_push($cost,["cost"=>($rowA13[$this->paxValue]*$this->person),"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                      }


                    }

                    if($rowA13['rangeCostType'] == 54){  
                      //check for exceptionif 0 divide by number.
                      if($this->isGroupPriceApply){
                        if($rowA13[$this->groupPAX] > 0){
                          array_push($cost,["cost"=>$rowA13[$this->groupPAX]/$this->person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                        }else{
                          array_push($cost,["cost"=>0,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);

                        }

                      }else{

                        if($rowA13[$this->paxValue] > 0){
                          array_push($cost,["cost"=>$rowA13[$this->paxValue]/$this->person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                        }else{
                          array_push($cost,["cost"=>0,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);

                        }
                      }
                      // array_push($cost,["cost"=>$rowA13[$this->paxValue]*$this->person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);

                    }

                  }

                }

                // echo $rowA13['costingName'];

                // echo "<pre>";print_r(end($cost));

              }



              //echo "<pre>";print_r(end($cost));



              /*==========  /. Costing for rangeType=52   =============================*/

            }

            //die;

          

            /*

              2.  For each train ticket associated with the tour, obtain total ticket costs adding each train ticket cost based on train departure date, PAX and applying any cost coefficient

            */



            /*============tblTourTrainCostingList  ================*/

              

              

            

            $sqlA21 = "select tourTrainCostingID_Admin,trainID,trainTicketID, tourDayStart,trainTicketID From  tblTourTrainCostingList  where tourID =  $this->tourId";

            $resutlA21 = $this->db->query($sqlA21);

            while ($rowA21 = $resutlA21->fetch_assoc()) {

              $dateA21 = date('Y-m-d', strtotime($departureDate." + ".$rowA21['tourDayStart']." days"));

              $dateA21 = date('Y-m-d', strtotime($dateA21.' -1 days'));

              $sql22 = 'SELECT 

                tblTrainCostRanges.trainTicketID,MAX(tblTrainCostRanges.rangePriority) as rangePriority,tblTrainCostRanges.dateFrom,tblTrainCostRanges.rCost,

                t1.currencyID,t1.costCoefficient,

                tblSuppliers.railTicketServiceFee,tblSuppliers.currencyID as supplierCurrencyID,t1.trainNumber

                From tblTrainCostRanges 

                LEFT JOIN tblTrainTickets ON tblTrainTickets.trainTicketID_Admin = tblTrainCostRanges.trainTicketID

                LEFT JOIN tblTrains as t1 ON t1.trainID_Admin = tblTrainTickets.trainID

                LEFT JOIN tblSuppliers  ON tblSuppliers.supplierID_Admin = t1.tSupplier 

                WHERE tblTrainCostRanges.trainTicketID= '.$rowA21['trainTicketID'].' and  dateFrom < "'.$dateA21.'" and dateTo > "'.$dateA21.'" group by  tblTrainCostRanges.trainTicketID';

              

              $resultA22 = $this->db->query($sql22);

              

              while ($rowA22 = $resultA22->fetch_assoc()) { 

               

                if($rowA22['rCost'] > 0){            

                  array_push($cost,["cost"=>$rowA22['rCost']*$this->person,"isConversion"=>0,"currencyId"=>$rowA22['currencyID']]);

                }

                if($rowA22['costCoefficient']>0){

                  array_push($cost,["cost"=>($rowA22['rCost'] * $rowA22['costCoefficient']*$this->person),"isConversion"=>0,"currencyId"=>$rowA22['currencyID']]);

                }

                if($rowA22['railTicketServiceFee']>0){

                  array_push($cost,["cost"=>$rowA22['railTicketServiceFee']*$this->person,"isConversion"=>0,"currencyId"=>$rowA22['supplierCurrencyID']]);

                }



                //echo "<pre>";print_r(end($cost));

              }

            }

            

            



            //die;

              

            /*=================      /.tblTourTrainCostingList       =====================*/



            /*

              3.  Obtain total accommodation cost adding each individual room night from the tour based on room type(s), number of rooms, check-in and check-out dates, take into account any early check-in and early-check-out options

            */



            /*================       tblTourRoomCostings              ======================*/

            

            $sqlA31 = "SELECT  tourID, hotelID, roomID, tourDayStart, tourDayEnd, earlyCheckin, lateCheckout  FROM tblTourRoomCostings where tourID =  $this->tourId";

            $resutlA31 = $this->db->query($sqlA31);



            while ($rowA31 = $resutlA31->fetch_assoc()) {

             

              $startDate    = date('Y-m-d', strtotime($departureDate." + ".$rowA31['tourDayStart']." days"));

              $endDate      = date('Y-m-d', strtotime($departureDate." + ".$rowA31['tourDayEnd']." days"));

              $checkInDay   = date('Y-m-d', strtotime($startDate.' -1 days'));

              $checkOutDay  = date('Y-m-d', strtotime($endDate.' -1 days'));

              $dayList      = $this->getDatesFromRange($checkInDay, $checkOutDay);        

              //echo "<br><br><br> <b>Check In = ".$checkInDay." & Check Out= ".$checkOutDay."</b><br>";

              for ($i=0; $i < count($dayList) ; $i++) { 

                $weekDay    = date('w', strtotime($dayList[$i]));

                $weekDay    = ($weekDay == 0 ) ? 7 : $weekDay;

               

                /*======== tblRoomCostRanges  =============*/

                $sqlA41 = 'SELECT ('.$this->srooms.' * d'.$weekDay.'_1pax + d'.$weekDay.'_2pax * '.$this->drooms.') as total, tblSuppliers.currencyID, earlyCheckIn as earlyCheckInPer,lateCheckOut as lateCheckOutPer,tblRooms.rName,tblRooms.hotelID as accomodationID

                From tblRoomCostRanges 

                  INNER JOIN tblRooms ON tblRooms.roomID_Admin = tblRoomCostRanges.roomID

                  LEFT JOIN tblAccomodation ON tblAccomodation.accomodationID_Admin=tblRooms.hotelID

                  LEFT JOIN tblSuppliers  ON tblSuppliers.supplierID_Admin = tblAccomodation.supplierID 

                WHERE 

                  tblRoomCostRanges.roomID = '.$rowA31['roomID'].' and tblRoomCostRanges.dateFrom <= "'.$dayList[$i].'" and "'.$dayList[$i].'"<= tblRoomCostRanges.dateTo limit 1';

                //echo $sqlA41."<br><br><br>";

                $resutlA41 = $this->db->query($sqlA41);

                //Note : replace this after demo :LEFT JOIN tblSuppliers  ON tblSuppliers.supplierID_Admin = tblAccomodation.supplierID 

                while ($rowA41 = $resutlA41->fetch_assoc()) {

                  $cost41 = 0;

                  if($rowA31['earlyCheckin'] == 1 && $dayList[$i] == $checkInDay){

                    $cost41 = $rowA41['total'] * $rowA41['earlyCheckInPer']; 

                  }

                  if($rowA31['lateCheckout'] == 1 && $dayList[$i] == $checkOutDay){

                    $cost41 = $rowA41['total'] * $rowA41['lateCheckOutPer'];

                  }

                  if($checkOutDay !== $dayList[$i] || ($checkInDay == $checkOutDay) ){

                    $cost41 = $cost41 + $rowA41['total'];

                  }

                  if($cost41 > 0){

                    array_push($cost,["cost"=>$cost41,"isConversion"=>0,"currencyId"=>$rowA41['currencyID']]);

                  }



                  //echo $dayList[$i]." ".$rowA41['rName']." = ".$cost41. "<br>" ;

                  //echo "<pre>";print_r($rowA41);

                }

                /*============================= /.tblRoomCostRanges  ==========================================*/

              }

            }



            //die;

            

            $totalCost        = [];

            $nonChangableCost = [];

           
            //echo "<pre>";print_r($cost);die;
            //adding all currency seprately

            foreach ($cost as $key => $value) {

              if(!empty($value['currencyId'])){

                $index = $value['currencyId'] ;

              }else{

                $index =  end($cost)['currencyId'];

              }

              if(!empty($value['isConversion'])){

                //direct price    

                $nonChangableCost[$index] = (!empty($nonChangableCost[$index])) ? ($nonChangableCost[$index] + $value['cost']) : $value['cost'] ;          

              }else{

                //need price algorithm          

                $totalCost[$index] = (!empty($totalCost[$index])) ? ($totalCost[$index] + $value['cost']) : $value['cost'] ;

              }        

            }



            //cost to price conversion

            $price = 0;

            //ading price individually

            foreach ($totalCost as $k => $val) {

              $price = $price + $this->getPricing($k,$this->currency,$val,false);

            }

            //ading price individually

            foreach ($nonChangableCost as $k => $val) {

              $price = $price + $this->getPricing($k,$this->currency,$val,true);

            }

            $pricePerPerson = $price / $this->person;
            $pricePerPerson = $this->roundByRule($pricePerPerson);
            $price = $pricePerPerson * $this->person;
            

            $dayWiseTourCost[$dateIndex] = ['date'=>($dateIndex),'price'=>$price,'color'=>''];

            

            if(!in_array($price,$this->allDiffCostArray)){

              array_push($this->allDiffCostArray,$price);

            }

            //end adding all currency seprately

            //echo "============== date=================<br>";

          }

        }/*foreach ($availDepartureDate as $key => $departureDate)*/

       

        

        // sort($allDiffCostArray);

        if(count($this->allDiffCostArray)==0){

          echo json_encode(array('status'=>0,'data'=>[],'prefix'=>$this->currencyPrefix));exit();

        }

        $finalResult = $this->formatResult($dayWiseTourCost,$this->allDiffCostArray);

        //echo "<pre>";print_r($finalResult);die;

        echo json_encode(

          array(  'status'        => 1,

                  'data'          => $finalResult,

                  'prefix'        => $this->currencyPrefix,

                  'totalTourDays' => $this->totalTourDays,

                  'endingDate'    => $this->tourLastDay

          ) 

        );exit();

        //echo "<pre>";print_r($finalResult);die;

      }else{

        echo json_encode(
          array(
            'status'        => 0,
            'data'          => [],
            'message'       =>'Dates Are Not Available',
            'endingDate'    => $this->tourLastDay


          )
        );

        exit();

      }

      

    }else{

      echo json_encode(array('status'=>1,'data'=>[]));exit();

    }

  }

    

  // Function to get all the dates in given range

  function getDatesFromRange($start, $end, $format = 'Y-m-d') {

    // Declare an empty array

    $array = array();

      

    // Variable that store the date interval

    // of period 1 day

    $interval = new DateInterval('P1D');



    $realEnd = new DateTime($end);

    $realEnd->add($interval);



    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);



    // Use loop to store date into array

    foreach($period as $date) {                 

        $array[] = $date->format($format); 

    }



    // Return the array elements

    return $array;

        

  }



  function getToursDays($tourId,$tourStart){

    $sql      = "select max(iDay) as count from tblItineraries where tourID = $tourId ";

    $result   = $this->db->query($sql);

    while ($row = $result->fetch_assoc()){

      $days = $row['count']; 

    }

    

    $tourEnd = date('Y-m-d', strtotime($tourStart."+ ".$days." days"));

    $tourEnd = date('Y-m-d', strtotime($tourEnd.' -1 days'));



    return getDatesFromRange($tourStart, $tourEnd);



  }



  function getDepartureDates(){

    $departureDate = [];

    $sql      = "SELECT departureDates FROM tblTours where tourID_Admin = $this->tourId ";

    $result   = $this->db->query($sql);



    if ($result->num_rows > 0) {

      while ($row = $result->fetch_row()) {
        $this->tourType = $row[0];
        // echo "<pre>";print_r($row);die;
        switch ($row[0]) {

          case 74:

            /*========================= Fixed Date  ============================*/

            $sql  = "SELECT dStartDate FROM tblDepartures where tourID = $this->tourId and year(dStartDate) = {$this->year} ";
            // echo "<pre>";print_r($sql);die;
            $sql  = $this->db->query($sql);
            
            //creating an array of available departure dates on the basis of departureDate value 74

            while ($row = $sql->fetch_assoc()) {

              array_push($departureDate, $row['dStartDate']);

            }          

            /*======================= /. Fixed Date  =============================*/

            break;

          case 75:

            /*========================= Date-From to Date-To =======================*/ 
            $tempDate = $this->year.'-01-01';
            

            if(strtotime($this->today) > strtotime($tempDate)){
              $tempDate = $this->today;
            }


            $sql     = "SELECT dStartDate,dEndDate FROM tblDepartures where tourID = {$this->tourId} and dStartDate <= '{$tempDate}' and dEndDate >= '{$tempDate}'  limit 1";
            
            $result  = $this->db->query($sql);


            //creating an array of available departure dates on the basis of departureDate value 75

            while ($row = $result->fetch_assoc()) {

            

              $row['dStartDate']  = $tempDate;
              $row['dEndDate']    = date("Y-m-d", strtotime($row['dEndDate']));
                            
              $departureDate = $this->getDatesFromRange($row['dStartDate'],$row['dEndDate']);              

            }      

            /*====================/. Date-From to Date-To ==========================*/ 

            break;

          

          default:

            return [];

            break;

        }
        
        return $departureDate;
      }

    }else{

      return [];

    }



  }
 

  function getTourLastDay($tourId){
    if(empty($this->tourType)){
      return null;
    }

    //echo $this->tourType;die;
    switch ($this->tourType) {

      case 74:

        /*============================= Fixed Date  ==========================================*/

        $sql  = "SELECT max(dStartDate) as dStartDate  FROM tblDepartures where tourID = $tourId";

        $sql  = $this->db->query($sql);

        //creating an array of available departure dates on the basis of departureDate value 74

        while ($row = $sql->fetch_assoc()) {

          return $row['dStartDate'];

        }          

        /*============================= /. Fixed Date  ==========================================*/

        break;

      case 75:

        /*============================= Date-From to Date-To ==================================*/ 

        $year = date("Y");
        $month = date('m');
        $today = date("Y-m-d");
        $tempDate = $year . '-' . $month . '-01';

        if (strtotime($today) > strtotime($tempDate)) {
            $tempDate = $today;
        }

        $sql = "SELECT dStartDate,dEndDate FROM tblDepartures where tourID = $tourId and dStartDate <= '{$tempDate}' and dEndDate >= '{$tempDate}' limit 1";


        $result  = $this->db->query($sql);

        //creating an array of available departure dates on the basis of departureDate value 75

        while ($row = $result->fetch_assoc()) {

          return $row['dEndDate'];

        }      

        /*=============================/. Date-From to Date-To ================================*/ 

        break;

      

      default:

        return null;

        break;

    }
    





  }

  function getPricing($fromCurrency, $toCurrency, $cost, $isNotChangable = false)
  {        
      $cost = $this->currencyConvertCost($fromCurrency, $toCurrency, $cost);           
   
      if ($isNotChangable) {                 
          $price = $cost;            
          return $price;
      }       
     
      //add margins        
      $price = $this->applyMargins($cost);        

      return $price;
  }

  function currencyConvertCost($fromCurrency, $toCurrency, $cost)
  {
      $channelID = $this->channelID;        

      if ($fromCurrency !== $toCurrency) {

          $sql = "SELECT fxInternalRate as fxRate,fxUpdated,fxPreviousUpdate, channelForexID, forexRateID_Admin 

      FROM tblForexRates 

      Where fxCurrencyFrom = $fromCurrency 

      AND fxCurrencyTo = $toCurrency
          
      AND channelForexID IN (SELECT channelForexID FROM tblForexGroup WHERE channelID = $channelID) limit 1";


          $result = $this->db->query($sql);

          while ($row = $result->fetch_assoc()) {

              $cost = $cost * $row['fxRate'];

          }


      }      

     
      return $cost;
  }

  function applyMargins($cost)
  {
      $channelID = $this->channelID;    

        $sql1 = "SELECT channelID_Admin, pMinMargin, pTargetMargin, pMinMargin, pTargetUplift, pTargetFixed, rNearest, rRoundupThreashold

    FROM tblChannels 

    LEFT JOIN tblPricingOptions on tblPricingOptions.pricingOptionID_Admin = tblChannels.pricingOptionID

    LEFT JOIN tblRoundingOptions on tblRoundingOptions.roundingOptionID_Admin = tblChannels.roundingOptionID

    where channelID_Admin  = $channelID";

      $result1 = $this->db->query($sql1);
      
        if ($result1)
        {            
      while ($row1 = $result1->fetch_assoc()) {
          

                if ($row1['pTargetMargin'] != 0) 
                {    

              $price = $cost / (1 - $row1['pTargetMargin']);

          }
                else
                {
                    $price = $cost;
            }


          if ($row1['pTargetUplift'] != 0) {

              $price = $price + ($cost + ($cost * $row1['pTargetUplift']));

          }


          if ($row1['pTargetFixed'] != 0) {

              $price = $price + $cost + $row1['pTargetFixed'];

          }

      }

      return $price;
  }

        return $cost;
    }
  function roundByRule($price)
  {
      $channelID = $this->channelID;    

      $sql1 = "SELECT channelID_Admin, pMinMargin, pTargetMargin, pTargetMargin ,pMinMargin, pTargetUplift, pTargetFixed, rNearest, rRoundupThreashold

    FROM tblChannels 

    LEFT JOIN tblPricingOptions on tblPricingOptions.pricingOptionID_Admin = tblChannels.pricingOptionID

    LEFT JOIN tblRoundingOptions on tblRoundingOptions.roundingOptionID_Admin = tblChannels.roundingOptionID

    where channelID_Admin  = $channelID";

      $result1 = $this->db->query($sql1);
          
      while ($row1 = $result1->fetch_assoc()) {

          /*very simple, if MOD exceeds THRESHOLD, you round UP, otherwise you round DOWN...

            to the nearest 10, 50, 100, etc */

          if (($price % $row1['rNearest']) >= $row1['rRoundupThreashold']) {
              

              $price = ($price - ($price % $row1['rNearest'])) + $row1['rNearest'];

          } else {
              
              $price = $price - ($price % $row1['rNearest']);

          }            
      }

      return (int)$price;
  }


  function getPrefix($toCurrency){

    $prefix   = '';

    $sql      = "SELECT cHTMLcode FROM `tblCurrencies` where CurrencyID_Admin = $toCurrency limit 1";

    $result   = $this->db->query($sql);

    while ($row = $result->fetch_assoc()){

      $prefix = $row['cHTMLcode'];

    }

    return $prefix;

  }



  function getTotalTourDays($tourId){

    $total    = 0;

    $sql      = "SELECT max(iDay) as total FROM tblItineraries where tourID = $tourId limit 1";

    $result   = $this->db->query($sql);

    while ($row = $result->fetch_assoc()){

      $total = $row['total'];

    }

    $total--;

    return $total;

  }





   

  function formatResult($result,$allDiffCostArray){

    // echo "<pre>";print_r($result);
    // echo "<pre>";print_r($allDiffCostArray);die;

    //array_multisort(array_column($result, 'price'), SORT_ASC, $result);

    sort($allDiffCostArray);

    $divisor = (count($allDiffCostArray) >= 3) ? 3 : count($allDiffCostArray);

    $remaining            = count($allDiffCostArray) % $divisor;

    $IndividualGroupCount = (int)(count($allDiffCostArray) / $divisor);

    

    // echo "allDiffCostArray = ".count($allDiffCostArray)." <br>";

    // echo "divisor = $divisor <br>";

    // echo "remaining = $remaining <br>";

    // echo "IndividualGroupCount = $IndividualGroupCount <br>";

    

    

    $groupOneCount    = $IndividualGroupCount;

    $groupTwoCount    = $IndividualGroupCount;

    // echo "groupOneCount = $groupOneCount <br>";

    // echo "groupTwoCount = $groupTwoCount <br>";

    if($remaining == 1 || $remaining == 2) {

      $groupOneCount  = $groupOneCount + 1 ;

    }

    

    if($remaining == 2) {

      $groupTwoCount  = $groupTwoCount + 1 ;

    }

    // echo "groupOneCount = $groupOneCount <br>";

    // echo "groupTwoCount = $groupTwoCount <br>";

    

    

    if($divisor == 1){

      $groupOneCount    = 100;

    }



    if($divisor == 2){

      $groupTwoCount    = 100;

    }



    $groupOneArray    = [];

    $groupTwoArray    = [];

    $groupThreeArray  = [];

    $finalArray       = [];

    $g1Counter        = 0;

    $g2Counter        = 0;

    foreach ($allDiffCostArray as $key => $value) {

      if($g1Counter < $groupOneCount){

        $g1Counter++;

        if(!in_array($value,$groupOneArray)){

          array_push($groupOneArray,$value);

        }      

      }else if($g2Counter < $groupTwoCount ){

        $g2Counter++;

        if(!in_array($value,$groupTwoArray)){

          array_push($groupTwoArray,$value);

        }      

      }else{

        if(!in_array($value,$groupThreeArray)){

          array_push($groupThreeArray,$value);

        }

      }

    }

    // echo "<pre>";print_r($groupOneArray);
    // echo "<pre>";print_r($result);

    foreach ($result as $key => $value) {

      if(in_array($value['price'],$groupOneArray)){
        $finalArray[$value['date']] = ['price'=>$value['price'],'class'=>'green-border'];   

      }

      if(in_array($value['price'],$groupTwoArray)){

        $finalArray[$value['date']] = ['price'=>$value['price'],'class'=>'yellow-border'];   

      }

      if(in_array($value['price'],$groupThreeArray)){

        $finalArray[$value['date']] = ['price'=>$value['price'],'class'=>'red-border'];   

      }

    }

    sort($groupOneArray);

    sort($groupTwoArray);

    sort($groupThreeArray);



    return ['result'=> $finalArray,'groupOneArray'=>$groupOneArray,'groupTwoArray'=>$groupTwoArray,'groupThreeArray'=>$groupThreeArray];



    

  }

  function getGroupPriceCondition($tourId){
    
    $sql      = "SELECT tMinPAX  FROM tblTours where tourID_Admin = $tourId and tGroup = 4 limit 1";
    
    $result   = $this->db->query($sql);
    if($result->num_rows > 0){
      $this->isGroupPriceApply = true;
      while ($row = $result->fetch_assoc()){
        return $row['tMinPAX'];
      }
      
    }
  }
}

?>