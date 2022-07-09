<?php 
require_once ("controllers/DBController.php");
class CustomeHeader
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function getCustomeHeaderFilterOption($id) {
        $query = "SELECT * FROM tblsearch_option WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );        
        $data = $this->db_handle->runQuery($query, $paramType, $paramValue);
        $data = $data[0];
        /*$country_id = explode(',',$data['filterOption'][0]['country_id']);
        //country data
        $contryQuery = "SELECT cName,countryID FROM tblCountries WHERE countryID IN (".$data['filterOption'][0]['country_id'].")";        
        $data['contryResult'] = $this->db_handle->runBaseQuery($contryQuery);
        //theme data
        $themeQuery = "SELECT tName,themeID FROM tblThemes WHERE themeID IN (".$data['filterOption'][0]['theme_id'].")";        
        $data['themeResult'] = $this->db_handle->runBaseQuery($themeQuery);*/
        return $data;
    }
    
}
?>