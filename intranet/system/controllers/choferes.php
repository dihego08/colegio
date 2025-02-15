<?php
	class choferes extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function choferes() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_choferes");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Conductores";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Conductores";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Conductores";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Conductores";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadconductores() {
	        $result = $this->modelo2->select_all("conductores", true);
	        echo $result;
	    }
	    public function get_chofer(){
            $sql = "SELECT * FROM conductores WHERE apellidos LIKE '%".$_GET['term']."%' OR nombres like '%".$_GET['term']."%'";
            $result = json_decode($this->modelo2->run_query($sql));
            $values = array();
            foreach ($result as $key) {
                $values[] = array(
                    'id' => $key->id,
                    'value' => $key->apellidos.", ".$key->nombres
                );
            }
            echo json_encode($values);
        }
        public function get_one(){
            $result = $this->modelo2->select_one("conductores", array('id' => $_GET['id_conductor']));
            echo $result;
        }
	    function save(){
	    	echo $this->modelo2->insert_data("conductores", $_POST, false);
	    }
	    function eliminar(){
	        $this->modelo2->delete_data("conductores", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo2->select_one("conductores", array('id' => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo2->update_data("conductores", $_POST);
	    }
	    private function valida($level) {
	        if (isset($_SESSION["user_level"])) {
	            if ($_SESSION["user_level"] == $level) {
	                return true;
	            } else
	                return false;
	        } else
	            return false;
	    }
	    private function View($header, $content) {
	        $h = $this->load()->view('header');
	        $h->PrintHeader($header);
	        $c = $this->load()->view('content');
	        $c->PrintContent($content);
	        $f = $this->load()->view('footer');
	        $f->PrintFooter();
	    }
	}
?>