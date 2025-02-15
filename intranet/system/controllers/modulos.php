<?php
	class modulos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function modulos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_modulos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Modulos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Modulos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Modulos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Modulos";
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
	    public function loadmodulos() {
	        echo $this->modelo3->select_all("tbl_modulos", true);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("tbl_modulos", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("tbl_modulos", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("tbl_modulos", array('id' => $_POST['id_nivel']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("tbl_modulos", $_POST);
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