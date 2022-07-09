<?php 

require_once ("controllers/DBController.php");

class Language

{

    private $db_handle;

    

    function __construct() {

        $this->db_handle = new DBController();

    }

    

    function deleteLanguage($language_id) {

        $query = "DELETE FROM tblLanguages WHERE languageID = ?";

        $paramType = "i";

        $paramValue = array(

            $language_id

        );

        $this->db_handle->update($query, $paramType, $paramValue);

        return true;

    }

    

    function getLanguageById($language_id) {

        $query = "SELECT * FROM tblLanguages WHERE languageID = ?";

        $paramType = "i";

        $paramValue = array(

            $language_id

        );

        

        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);

        return $result;

    }

    

    function getAllLanguage() {

        $sql = "SELECT * FROM tblLanguages where lName IS NOT NULL ORDER BY lName asc";

        $result = $this->db_handle->runBaseQuery($sql);

    

        return $result;

    }

}

?>