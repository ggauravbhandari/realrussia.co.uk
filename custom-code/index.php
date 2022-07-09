<?php
require('config.php');

$pageId             = !empty($_GET['pageId']) ? $_GET['pageId']: null;
$tourId             = !empty($_GET['tourId']) ? $_GET['tourId']: null;
$availDepartureDate = [];

if(empty($tourId) && !empty($pageId)){
  $tourSql = "SELECT tourID_Admin from tblTours where pageId=$pageId";
  $tourRes = $conn->query("SELECT tourID_Admin from tblTours where pageId=$pageId");
     
  if($tourRes->num_rows > 0) {
    while ($row = $tourRes->fetch_row()) {
      $tourId = $row[0];
    }
  }
}else{
  $tourId   = !empty($_GET['tourId']) ? $_GET['tourId']: 14;
}


if(!empty($tourId)){

  $person               = !empty($_GET['person']) ? $_GET['person']: 1;
  $paxValue             = ($person < 10) ? 'PAX0'.$person:'PAX'.$person;
  $room                 = !empty($_GET['room']) ? $_GET['room']: 1;;
  $month                = !empty($_GET['month']) ? $_GET['month']:date('m');
  $lng                  = !empty($_GET['lng']) ? $_GET['lng']: 1;
  $srooms               = ($person % 2);
  $drooms               = (int)($person / 2);
  $currency             = !empty($_GET['currency']) ? $_GET['currency']: 2;
  $currencyPrefix       = trim(getPrefix($currency,$conn));
  //$today                = !empty($_GET['today']) ? $_GET['today']: date("Y-m-d") ;
  $today                =  date("Y-m-d") ;
  $dayWiseTourCost      = [];
  $allDiffCostArray     = [];
  $totalTourDays        = getTotalTourDays($tourId,$conn);
  $availDepartureDate   = getDepartureDates($tourId,$month,$conn);
  $tourLastDay          = getTourLastDay($tourId,$conn);;

  //$availDepartureDate   = ['2021-11-07 00:00:00.000'];
  if(count($availDepartureDate) > 0){

    foreach ($availDepartureDate as $key => $departureDate) {
      if(strtotime($departureDate) > strtotime($today)){


        $dateIndex        = (int)date('d', strtotime($departureDate));
        $cost             = [];

        /*
          1.  For each service item associated with the tour, obtain total services cost adding each individual service cost based on service start date, PAX and guide language
        */
        
        $sqlA12 = "select tourCostingID,tourDayStart From tblTourCostingList where tourID = $tourId";
        $resultA12 = $conn->query($sqlA12);

        /*============================= Extra Facilities  ==========================================*/

        while ($rowA12 = $resultA12->fetch_assoc()) {
         
          $date = date('Y-m-d', strtotime($departureDate."+ ".$rowA12['tourDayStart']." days"));
          $date = date('Y-m-d', strtotime($date.' -1 days'));
          
         
          /*================   Costing for rangeType=52   =======================*/
          
          $sqlA13 = 'SELECT '.$paxValue.',MAX(rangePriority) as rangePriority,rangeType,rangeCostType,tourCostingID,rangeLanguage,tblTourCostings.costCurrency,tblTourCostings.supplierRates,tblTourCostings.costingName
          FROM tblCostRanges 
            INNER JOIN tblTourCostings on tblTourCostings.tourCostingsID_Admin = tblCostRanges.tourCostingID  
          WHERE 
            tblCostRanges.tourCostingID = '.$rowA12['tourCostingID'].'  
            and (case 
              WHEN rangeType = 53  THEN  rangeLanguage = '.$lng.'
              ELSE 1=1
              end)
            and dateFrom <= "'.$date.'" and dateTo >= "'.$date.'" 
            group by rangeType ';
          // echo $sqlA13;
          // echo "<br>---------------------------------------------<br>";
          $sqlA13Result = $conn->query($sqlA13);

          /*
            53  Guide Range Type | 52  Service Range Type
            55  Per Group Cost Type | 54  Per PAX Cost Type
          */

          while ($rowA13 = $sqlA13Result->fetch_assoc()) {

            if($rowA13['rangeType']==52){
              array_push($cost,["cost"=>$rowA13[$paxValue]*$person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
            }

            if($rowA13['rangeType']==53){
              if($rowA13['rangeLanguage'] != 1){
                if($rowA13['rangeCostType'] == 55){  
                  // array_push($cost,["cost"=>($rowA13[$paxValue]/$person),"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                  array_push($cost,["cost"=>($rowA13[$paxValue]*$person),"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
                }
                if($rowA13['rangeCostType'] == 54){  
                  array_push($cost,["cost"=>$rowA13[$paxValue]*$person,"isConversion"=>$rowA13['supplierRates'],"currencyId"=>$rowA13['costCurrency']]);
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
          
          
        // $sqlA21 = "select tourDayStart,trainTicketID From  tblTourTrainCostingList  where tourID = 24";
        $sqlA21 = "select tourTrainCostingID_Admin,trainID,trainTicketID, tourDayStart,trainTicketID From  tblTourTrainCostingList  where tourID =  $tourId";
        $resutlA21 = $conn->query($sqlA21);
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
          
          $resultA22 = $conn->query($sql22);
          
          while ($rowA22 = $resultA22->fetch_assoc()) { 
           
            if($rowA22['rCost'] > 0){            
              array_push($cost,["cost"=>$rowA22['rCost']*$person,"isConversion"=>0,"currencyId"=>$rowA22['currencyID']]);
            }
            if($rowA22['costCoefficient']>0){
              array_push($cost,["cost"=>($rowA22['rCost'] * $rowA22['costCoefficient']*$person),"isConversion"=>0,"currencyId"=>$rowA22['currencyID']]);
            }
            if($rowA22['railTicketServiceFee']>0){
              array_push($cost,["cost"=>$rowA22['railTicketServiceFee']*$person,"isConversion"=>0,"currencyId"=>$rowA22['supplierCurrencyID']]);
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
        
        $sqlA31 = "SELECT  tourID, hotelID, roomID, tourDayStart, tourDayEnd, earlyCheckin, lateCheckout  FROM tblTourRoomCostings where tourID =  $tourId";
        $resutlA31 = $conn->query($sqlA31);

        while ($rowA31 = $resutlA31->fetch_assoc()) {
         
          $startDate    = date('Y-m-d', strtotime($departureDate." + ".$rowA31['tourDayStart']." days"));
          $endDate      = date('Y-m-d', strtotime($departureDate." + ".$rowA31['tourDayEnd']." days"));
          $checkInDay   = date('Y-m-d', strtotime($startDate.' -1 days'));
          $checkOutDay  = date('Y-m-d', strtotime($endDate.' -1 days'));
          $dayList      = getDatesFromRange($checkInDay, $checkOutDay);        
          //echo "<br><br><br> <b>Check In = ".$checkInDay." & Check Out= ".$checkOutDay."</b><br>";
          for ($i=0; $i < count($dayList) ; $i++) { 
            $weekDay    = date('w', strtotime($dayList[$i]));
            $weekDay    = ($weekDay == 0 ) ? 7 : $weekDay;
           
            /*============================= tblRoomCostRanges  ==============================*/
            $sqlA41 = 'SELECT ('.$srooms.' * d'.$weekDay.'_1pax + d'.$weekDay.'_2pax * '.$drooms.') as total, tblSuppliers.currencyID, earlyCheckIn as earlyCheckInPer,lateCheckOut as lateCheckOutPer,tblRooms.rName,tblRooms.hotelID as accomodationID
            From tblRoomCostRanges 
              INNER JOIN tblRooms ON tblRooms.roomID_Admin = tblRoomCostRanges.roomID
              LEFT JOIN tblAccomodation ON tblAccomodation.accomodationID_Admin=tblRooms.hotelID
              LEFT JOIN tblSuppliers  ON tblSuppliers.supplierID_Admin = tblAccomodation.supplierID 
            WHERE 
              tblRoomCostRanges.roomID = '.$rowA31['roomID'].' and tblRoomCostRanges.dateFrom <= "'.$dayList[$i].'" and "'.$dayList[$i].'"<= tblRoomCostRanges.dateTo limit 1';
            //echo $sqlA41."<br><br><br>";
            $resutlA41 = $conn->query($sqlA41);
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
        $price = 0 ;
        //ading price individually
        foreach ($totalCost as $k => $val) {
          $price = $price + getPricing($k,$currency,$val,$conn,false);
        }
        //ading price individually
        foreach ($nonChangableCost as $k => $val) {
          $price = $price + getPricing($k,$currency,$val,$conn,true);
        }

        //$dayWiseTourCost[$dateIndex] = $price;
        $dayWiseTourCost[$dateIndex] = ['date'=>($dateIndex),'price'=>$price,'color'=>''];
        if(!in_array($price,$allDiffCostArray)){
          array_push($allDiffCostArray,$price);
        }
        //end adding all currency seprately
        //echo "============== date=================<br>";
      }
    }/*foreach ($availDepartureDate as $key => $departureDate)*/
   
    
    // sort($allDiffCostArray);
    //echo "<pre>";print_r($allDiffCostArray);die;
    if(count($allDiffCostArray)==0){
      echo json_encode(array('status'=>0,'data'=>[],'prefix'=>$currencyPrefix));exit();
    }
    $finalResult = formatResult($dayWiseTourCost,$allDiffCostArray);
    echo json_encode(
      array(  'status'        => 1,
              'data'          => $finalResult,
              'prefix'        => $currencyPrefix,
              'totalTourDays' => $totalTourDays,
              'endingDate'    => $tourLastDay
      ) 
    );exit();
    //echo "<pre>";print_r($finalResult);die;
  }else{
    echo json_encode(array('status'=>0,'data'=>[],'message'=>'Dates Are Not Available'));
    exit();
  }
  $conn->close();
}else{
  echo json_encode(array('status'=>1,'data'=>[]));exit();
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

function getToursDays($tourId,$tourStart,$conn){
  $sql      = "select max(iDay) as count from tblItineraries where tourID = $tourId ";
  $result   = $conn->query($sql);
  while ($row = $result->fetch_assoc()){
    $days = $row['count']; 
  }
  
  $tourEnd = date('Y-m-d', strtotime($tourStart."+ ".$days." days"));
  $tourEnd = date('Y-m-d', strtotime($tourEnd.' -1 days'));

  return getDatesFromRange($tourStart, $tourEnd);

}

function getDepartureDates($tourId,$month,$conn){

  $sql      = "SELECT departureDates FROM tblTours where tourID_Admin = $tourId";
  $result   = $conn->query($sql);
  $departureDate = [];

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
      switch ($row[0]) {
        case 74:
          /*============================= Fixed Date  ==========================================*/
          $sql  = "SELECT dStartDate FROM tblDepartures where tourID = $tourId and month(dStartDate)=".$month;
          $sql  = $conn->query($sql);
          //creating an array of available departure dates on the basis of departureDate value 74
          while ($row = $sql->fetch_assoc()) {
            array_push($departureDate, $row['dStartDate']);
          }          
          /*============================= /. Fixed Date  ==========================================*/
          break;
        case 75:
          /*============================= Date-From to Date-To ==================================*/ 
          $sql     = "SELECT dStartDate,dEndDate FROM tblDepartures where tourID = $tourId limit 1";
          $result  = $conn->query($sql);
          //creating an array of available departure dates on the basis of departureDate value 75
          while ($row = $result->fetch_assoc()) {
            $departureDate = getDatesFromRange($row['dStartDate'],$row['dEndDate']);
          }      
          /*=============================/. Date-From to Date-To ================================*/ 
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
function getTourLastDay($tourId,$conn){

  $sql      = "SELECT departureDates FROM tblTours where tourID_Admin = $tourId";
  $result   = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
      switch ($row[0]) {
        case 74:
          /*============================= Fixed Date  ==========================================*/
          $sql  = "SELECT max(dStartDate) as dStartDate  FROM tblDepartures where tourID = $tourId";
          $sql  = $conn->query($sql);
          //creating an array of available departure dates on the basis of departureDate value 74
          while ($row = $sql->fetch_assoc()) {
            return $row['dStartDate'];
          }          
          /*============================= /. Fixed Date  ==========================================*/
          break;
        case 75:
          /*============================= Date-From to Date-To ==================================*/ 
          $sql     = "SELECT dStartDate,dEndDate FROM tblDepartures where tourID = $tourId limit 1";
          $result  = $conn->query($sql);
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
  }else{
    return null;
  }

}
function getPricing($fromCurrency,$toCurrency,$cost,$conn,$isNotChangable=false){
  
  $price = 0;
  
  // no need of currency conversion
  if($fromCurrency !== $toCurrency){
    $sql      = "SELECT fxInternalRate as fxRate,fxUpdated,fxPreviousUpdate, channelForexID, forexRateID_Admin 
      FROM tblForexRates 
      Where fxCurrencyFrom = $fromCurrency 
        and  fxCurrencyTo = $toCurrency limit 1";

    $result   = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
      $cost = $cost * $row['fxRate'];
    }
   
  }

  

  if($isNotChangable){
    return round($cost,0);
  }
  //return $cost;
  //applying rounding and pricing algo.
  $sql1 = "SELECT channelID_Admin, pMinMargin, pTargetMargin, pTargetMargin ,pMinMargin, pTargetUplift, pTargetFixed, rNearest, rRoundupThreashold
    FROM tblChannels 
    LEFT JOIN tblPricingOptions on tblPricingOptions.pricingOptionID_Admin = tblChannels.pricingOptionID
    LEFT JOIN tblRoundingOptions on tblRoundingOptions.roundingOptionID_Admin = tblChannels.roundingOptionID
    where channelID  = 1";
  $result1   = $conn->query($sql1);
  while ($row1 = $result1->fetch_assoc()){

    if($row1['pTargetMargin'] != 0){
      $price = $cost / (1-$row1['pTargetMargin']);
    }
     

    if($row1['pTargetUplift'] != 0){
      $price = $price + ($cost + ($cost * $row1['pTargetUplift']));
    }
    
    if($row1['pTargetFixed'] != 0){
      $price = $price + $cost + $row1['pTargetFixed'];
    }
    //echo "calculated actual price =".$price."<br>";
    //$price = round($price,0);
    //echo "Round of  price =".$price."<br>";

    /*very simple, if MOD exceeds THRESHOLD, you round UP, otherwise you round DOWN...
      to the nearest 10, 50, 100, etc */
    If(($price % $row1['rNearest']) >= $row1['rRoundupThreashold']){    
      //$price = ($price - ($price % $row1['rNearest'])) + $row1['rRoundupThreashold'];
      $price =  $price + ($row1['rNearest'] -  ($price % $row1['rNearest']));
    }else{   
      $price = $price - ($price % $row1['rNearest']);
    }
    

    //echo "Last Result of Round algorithm =".(int)$price."<br><br><br><br>";

    

  }
  return (int)$price;



}

function getPrefix($toCurrency,$conn){
  $prefix   = '';
  $sql      = "SELECT cHTMLcode FROM `tblCurrencies` where CurrencyID_Admin = $toCurrency limit 1";
  $result   = $conn->query($sql);
  while ($row = $result->fetch_assoc()){
    $prefix = $row['cHTMLcode'];
  }
  return $prefix;
}

function getTotalTourDays($tourId,$conn){
  $total    = 0;
  $sql      = "SELECT max(iDay) as total FROM tblItineraries where tourID = $tourId limit 1";
  $result   = $conn->query($sql);
  while ($row = $result->fetch_assoc()){
    $total = $row['total'];
  }
  $total--;
  return $total;
}


 
function formatResult($result,$allDiffCostArray){
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


?>