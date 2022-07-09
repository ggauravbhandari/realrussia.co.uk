<?php 

require_once ("controllers/DBController.php");

class Theme

{

    private $db_handle;

    

    function __construct() {

        $this->db_handle = new DBController();

    }

    

    function deleteTheme($theme_id) {

        $query = "DELETE FROM tblThemes WHERE themeID = ?";

        $paramType = "i";

        $paramValue = array(

            $theme_id

        );

        $this->db_handle->update($query, $paramType, $paramValue);

        return true;

    }

    

    function getThemeById($theme_id) {

        $query = "SELECT * FROM tblThemes WHERE themeID = ?";

        $paramType = "i";

        $paramValue = array(

            $theme_id

        );

        

        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);

        return $result;

    }

    function getAllTheme() {

        $sql = "SELECT * FROM tblThemes where tName IS NOT NULL ORDER BY tName asc ";

        $result = $this->db_handle->runBaseQuery($sql);

        return $result; 

    }

    function getThemePluginData() {
        $id = $_POST['id'];

        $sql = "SELECT tName,themeID_Admin FROM tblThemes where tName IS NOT NULL and themeID_Admin in (SELECT theme_id FROM tblthemecardplugin WHERE id = ". $id.")";

        // print_r($sql);
        // die();

        $result2 = $this->db_handle->query($sql);

        if ($result2->num_rows > 0) {

            $resultset = $result2->fetch_assoc();
            return array('status'=>1,'data'=>$resultset);
        }else{
          return array('status'=>0,'data'=>$resultset);
        }  

    }

}

?>