<?php
    Class Connection {
        private  $server = "mysql:host="._DB_HOST.";dbname="._DB_NAME;
        private  $user = _DB_USER;
        private  $pass = _DB_PASS;
        private $options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'UTF8'");
        protected $con;
        public function openConnection(){
            try{
                $this->con = new PDO($this->server, $this->user,$this->pass, $this->options);
                return $this->con;
            }
            catch (PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
            }
        }
        public function closeConnection() {
            $this->con = null;
        }
    }
?>