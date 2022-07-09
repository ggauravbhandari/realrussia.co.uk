<?php

class DBController {


    private $host       = "localhost";

    private $user       = "rr_wp_user";

    private $password   = "m%dA3sEj?:D=";

    private $database   = "rr_wp";


    private $conn;

    

    function __construct() {

        $this->conn = $this->connectDB();

    }   

    

    function connectDB() {

        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);

        return $conn;

    }

    function query($query){

        return mysqli_query($this->conn,$query);

    }
    
    function multi_query($query){

        return $this->conn->multi_query($query);

    }

    

    function runBaseQuery($query) {

        $result = $this->conn->query($query);   
        $resultset = [];
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {

                $resultset[] = $row;

            }

        }

        return $resultset;

    }

    

    

    

    function runQuery($query, $param_type, $param_value_array) {

        $sql = $this->conn->prepare($query);

        $this->bindQueryParams($sql, $param_type, $param_value_array);

        $sql->execute();

        $result = $sql->get_result();

        

        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {

                $resultset[] = $row;

            }

        }

        

        if(!empty($resultset)) {

            return $resultset;

        }

    }

    

    function bindQueryParams($sql, $param_type, $param_value_array) {

        $param_value_reference[] = & $param_type;

        for($i=0; $i<count($param_value_array); $i++) {

            $param_value_reference[] = & $param_value_array[$i];

        }

        call_user_func_array(array(

            $sql,

            'bind_param'

        ), $param_value_reference);

    }

    

    function insert($query, $param_type, $param_value_array) {

        $sql = $this->conn->prepare($query);

        $this->bindQueryParams($sql, $param_type, $param_value_array);

        $sql->execute();

        $insertId = $sql->insert_id;

        return $insertId;

    }
    

    function update($query, $param_type, $param_value_array) {

        $sql = $this->conn->prepare($query);

        $this->bindQueryParams($sql, $param_type, $param_value_array);

        $sql->execute();

    }

}

?>