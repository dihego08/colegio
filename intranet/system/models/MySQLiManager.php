<?php
class MySQLiManager {
    private $link;
    
    public function __construct() {
        $DB_HOST=_DB_HOST;
        $DB_USER=_DB_USER;
        $DB_PASS=_DB_PASS;
        $DB_NAME=_DB_NAME;
        $this->link    = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        $this->link->set_charset("utf8");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }
    function getCon(){
        return $this->link;
    }
    function __destruct() {
        $thread_id = $this->link->thread_id;
        $this->link->kill($thread_id);
        $this->link->close();
    }
    function select($attr, $table, $where = '', $sql = '') {
        $where = ($where != '' || $where != null) ? "WHERE " . $where : '';
        if(empty($sql)){
           $stmt  = "SELECT " . $attr . " FROM " . $table . " " . $where . ";"; 
        }else{
           $stmt =$sql; 
           /*echo '<hr>';
           echo $sql;
           echo '<br>';
           echo '<hr>';*/
        }
        $result = $this->link->query($stmt) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
            return $response;
        }
    }
    function insert($table, $values, $where = '', $sanear = false) {
        $columnas = null;
        $valores  = null;
        foreach ($values as $key => $value) {
            $columnas .= $key . ',';
            if ($sanear == true) {
                $valores .= '"' . ucwords(strtolower($value)) . '",';
            } else {
                $valores .= '"' . $value . '",';
            }
        }
        $columnas = substr($columnas, 0, -1);
        $valores  = substr($valores, 0, -1);
        $stmt     = "INSERT INTO " . $table . " (" . $columnas . ") VALUES(" . $valores . ") " . $where . ";";
        $result = $this->link->query($stmt) or die($this->link->error);
        $response = true;
        
        return $response;
    }
    function update($table, $values, $where) {
        $valores = "";
        foreach ($values as $key => $value) {
            $valores .= $key . '="' . $value . '",';
        }
        $valores = substr($valores, 0, strlen($valores) - 1);
        $stmt    = "UPDATE $table SET $valores WHERE $where";
        $result = $this->link->query($stmt) or die($this->link->error . __LINE__);
        //print_r($result);
        if ($result->num_rows > 0) {
            $response = false;
        } else {
            $response = true;
        }
        /*if ($result > 0) {
            $response = false;
        } else {
            $response = true;
        }*/
        return $response;
    }
    function delete($table, $values, $complex = false) {
        if ($complex) {
            $where = $values;
        } else {
            foreach ($values as $key => $value) {
                $where = $key . '="' . $value . '"';
            }
        }
        $stmt = 'DELETE FROM ' . $table . ' WHERE ' . $where;
        $result = $this->link->query($stmt) or die($this->link->error . __LINE__);
        //if ($result->num_rows > 0) {
          //  $response = false;
        //} else {
            $response = true;
        //}
        return $response;
    }
    function check($what, $table, $values, $complex = false) {
        if ($complex) {
            $where = $values;
        } else {
            foreach ($values as $key => $value) {
                $where = $key . '="' . $value . '"';
            }
        }
        $stmt = "SELECT " . $what . " FROM " . $table . " WHERE " . $where;
        $result = $this->link->query($stmt) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }
    function multiple_action($querys){
        $this->link->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);

        /*for ($i = 0; $i < count($querys); $i++) { 
            echo $querys[$i];
        }*/
        $stm = "";
        foreach ($querys as $query => $value) {
            $stm = $value;
            $this->link->query("SELECT first_name, last_name FROM actor");
        }
        $this->link->commit();
        $this->link->close();

        return true; 
        /*$mysqli->query("SELECT first_name, last_name FROM actor");
        

        $mysqli->close();*/
    }
}


    