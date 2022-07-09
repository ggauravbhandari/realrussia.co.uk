<?php 
require_once ("controllers/DBController.php");
require_once ("controllers/TourPreCost.php");
class TourPreProcess
{

    private $db;
    private $tourCost;
    private $base_url;
    private $currencyList;
    private $languageList;
    private $tourList;
    private $finalResult = [];
    
    function __construct($base_url) {
        $this->db = new DBController();
        $this->tourCost = new TourPreCost();
        $this->base_url = $base_url;

    }
    
    function get(){ 
    
        ini_set('max_execution_time', '0'); 
        ini_set('memory_limit', '-1');      
        $this->currencyList  = $this->getCurrencyList();
        $this->tourList      = $this->getTourList();
        
        $sql                 = '';

        foreach ($this->tourList as $key => $tour) {
            $tourId             = $tour['tourId'];
            //$this->languageList = !empty($tour['tLanguages']) ?  explode(";",$tour['tLanguages']) : [];
            $this->languageList = [1];
            

            foreach ($this->currencyList as $key => $curr) {
                if(!empty($this->languageList)){
                    foreach ($this->languageList as $key => $lng) { 
                 
                        for ($person=1; $person < 13; $person++) {
                            $curId  = $curr['currencyId'];
                            $lngId  = $lng;
                            $price  = $this->fetchResult($tourId,$curId,$lngId,$person);

                            if($price > 0){
                                $price   =  round($price/$person,0);
                            }
                            $sql    .= "($tourId,$person,$curId,$price,$lngId),";
                            echo "($tourId,$person,$curId,$price,$lngId) <br>";

                        }
                        

                    }
                    //die;
                }
                
            }
            


            
        }
        
        echo $this->replaceAndInsert($sql);


       
    }
    

    function getCurrencyList(){

        $sql      = 'SELECT CurrencyID_Admin as currencyId FROM tblCurrencies where CurrencyID_Admin is not null ';
        $result   = $this->db->query($sql);
        $data     = [];
        
        while ($row = $result->fetch_assoc()){
            array_push($data,$row);
        }
        return $data;

    }
    function getLanguageList(){

        $sql      = 'SELECT languageID_Admin as languageId FROM tbllanguages where languageID_Admin is not null and languageID_Admin = 1';
        $result   = $this->db->query($sql);
        $data     = [];
        
        while ($row = $result->fetch_assoc()){
            array_push($data,$row);
        }
        return $data;

    }
    function getTourList(){

        $sql      = "SELECT tourID_Admin as tourId,tLanguages from tblTours INNER JOIN tblTourData on tblTours.tourID_Admin = tblTourData.tourID  where tourID_Admin is not null and tourID_Admin != 0 and tStatus in (1,62) ";
        
        $result   = $this->db->query($sql);
        $data     = [];
        
        while ($row = $result->fetch_assoc()){
            array_push($data,$row);
        }
        return $data;

    }
    function fetchResult($tourId,$curId,$lngId,$person){
        $_GET['tourId']     = $tourId;
        $_GET['person']     = $person;
        $_GET['lng']        = $lngId;
        $_GET['currency']   = $curId;
        $_GET['lowest']     = true;

        //echo "<pre>";print_r($res);
        //$res = file_get_contents($this->base_url.'custom-code/api/index.php?tourId='.$tourId.'&person='.$person.'&lng='.$lngId.'&currency='.$curId.'&action=getTourCost&lowest=true');
        // $res = file_get_contents(__DIR__.'\TouCost.php?tourId='.$tourId.'&person='.$person.'&lng='.$lngId.'&currency='.$curId.'&action=getTourCost&lowest=true');
        
        //$tourCost       = new TourCost();
        
        $res = $this->tourCost->get(); 

        
        if(!empty($res)){
            $res = json_decode($res);
            if(!empty($res->status)){
                return $res->data->groupOneArray[0];
            }else{
                return  0;
            }
            
        }else{
           return  0; 
        }   

    }

    function replaceAndInsert($sql){
        if(!empty($sql)){
            $sql= "INSERT INTO tblPreProcessTour
                            (tourId,passenger,currency_id,price,language_id) 
                            VALUES ".rtrim($sql,',');
            
            if($this->db->query('TRUNCATE TABLE tblPreProcessTour')){
                if($this->db->query($sql) === TRUE) {
                  return  "New records created successfully";
                } else {
                  return  "Error: <br>" . $sql . "<br>" ;
                }                
            }
        }
    }
   

}
?>