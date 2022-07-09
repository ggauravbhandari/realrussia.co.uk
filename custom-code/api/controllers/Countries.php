<?php 
require_once ("controllers/DBController.php");
class Countries
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function deleteCountry($country_id) {
        $query = "DELETE FROM tblCountries WHERE countryID = ?";
        $paramType = "i";
        $paramValue = array(
            $country_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
        return true;
    }
    
    function getCountryById($country_id) {
        $query = "SELECT * FROM tblCountries WHERE countryID = ?";
        $paramType = "i";
        $paramValue = array(
            $country_id
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }
    
    function getAllCountry() {
        $sql = "SELECT * FROM tblCountries where cName IS NOT NULL ORDER BY cName asc";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getCitiesByCountryId($country_id) {
        $query = "SELECT *,'0' as is_check FROM tblCities WHERE countryID IN (".$country_id.")";
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }
}
?>