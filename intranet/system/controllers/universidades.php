<?php
	class universidades extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function universidades() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_universidades");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Universidades";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Universidades";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Universidades";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Universidades";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loaduniversidades() {
	        echo $this->modelo3->select_all("universidades", true);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("universidades", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("universidades", array("id" => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("universidades", array("id" => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("universidades", $_POST);
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