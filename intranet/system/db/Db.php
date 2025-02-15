<?php
class Db extends f {
    var $hostname = "";
    var $username = "";
    var $password = "";
    var $database = "";
    var $con = "";
    var $config = "";
    function Db() {
        $this->config   = $this->load()->config("database");
        $this->hostname = $this->config->hostname;
        $this->username = $this->config->user;
        $this->password = $this->config->pass;
        $this->database = $this->config->db;
        $this->con      = $this->Conexion();
        $this->init();
    }
    function query($sql) {
        $r = mysqli_query( $this->con,$sql) or die(mysqli_error($this->con));
        $obj = array();
        while ($v = $this->get_object($r)) {
            $obj[] = $v;
        }
        return $obj;
    }
    function execute($sql) {
        mysqli_query( $this->con,$sql) or die(mysqli_error($this->con));
    }
    function insert($table, $data) {
        $this->execute("insert into " . $table . " " . $this->array_keys_to_values($data) . " values " . $this->array_to_values($data));
    }
    function num_rows($r) {
        $r = mysqli_num_rows($r);
        return $r;
    }
    function get_object($r) {
        return mysqli_fetch_object($r);
    }
    function get_array($r) {
        return mysqli_fetch_array($r);
    }
    private function init() {
        //mysql_select_db($this->database, $this->con);
      
    }
    private function array_keys_to_values($data) {
        $num = count($data);
        $num = $num - 1;
        $inc = 0;
        $tmp = "(";
        foreach (array_keys($data) as $r) {
            $tmp .= $r;
            if ($inc < $num) {
                $tmp .= ",";
                ++$inc;
            }
        }
        $tmp .= ")";
        return $tmp;
    }
    function array_to_set_value($data) {
        $num = count($data);
        $num = $num - 1;
        $inc = 0;
        $tmp = "";
        foreach (array_keys($data) as $r) {
            $tmp .= $r . " = '" . $data[$r] . "'";
            if ($inc < $num) {
                $tmp .= ",";
                ++$inc;
            }
        }
        return $tmp;
    }
    function array_to_where_value($data) {
        $num = count($data);
        $num = $num - 1;
        $inc = 0;
        $tmp = "";
        foreach (array_keys($data) as $r) {
            $tmp .= $r . " = '" . $data[$r] . "'";
            if ($inc < $num) {
                $tmp .= " and ";
                ++$inc;
            }
        }
        return $tmp;
    }
    private function array_to_values($data) {
        $num = count($data);
        $num = $num - 1;
        $inc = 0;
        $tmp = "(";
        foreach ($data as $r) {
            $tmp .= "'" . $r . "'";
            if ($inc < $num) {
                $tmp .= ",";
                ++$inc;
            }
        }
        $tmp .= ")";
        return $tmp;
    }
    private function Conexion() {
      
        $conn = mysqli_connect($this->hostname, $this->username, $this->password,$this->database);
        //mysql_set_charset("UTF8", $conn);
        //$conn->set_charset("utf8");
       return $conn; 
    }
    function _close() {
        mysqli_close($this->con);
    }
}