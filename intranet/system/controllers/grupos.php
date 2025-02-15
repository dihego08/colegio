<?php
	class grupos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function grupos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_grupos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Grupos Academicos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Grupos Academicos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Grupos Academicos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Grupos Academicos";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function Login() {
	        $h["title"]   = "Iniciar Sesi&oacute;n";
	        $c["title"]   = "Iniciar Sesi&oacute;n";
	        $c["content"] = $this->html_basico->FormLogin();
	        $this->View($h, $c);
	    }
	    public function loadgrupos() {
            $result = array();
            if(isset($_POST['id_ciclo'])){
                $grupos = json_decode($this->modelo3->select_all_where("grupos", array("id_ciclo" => $_POST['id_ciclo'])));
                $result = $grupos->Records;
            }else{
                $grupos = json_decode($this->modelo3->select_all("grupos", true));
            
                foreach($grupos as $key => $value){
                    $ciclo = json_decode($this->modelo3->select_one("ciclos", array("id" => $value->id_ciclo)));
                    $value->ciclo = $ciclo->ciclo;
                    $result[] = $value;
                }
            }
            

            echo json_encode($result);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("grupos", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("grupos", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("grupos", array('id' => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("grupos", $_POST);
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