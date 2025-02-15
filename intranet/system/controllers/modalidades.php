<?php
	class modalidades extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function modalidades() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_modalidades");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Modalidades";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Modalidades";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Modalidades";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Modalidades";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadmodalidades() {
	        echo $this->modelo2->select_all("modalidades", true);
	    }
	    function save(){
		    echo $this->modelo2->insert_data("modalidades", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo2->delete_data("modalidades", array("id" => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo2->select_one("modalidades", array("id" => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo2->update_data("modalidades", $_POST);
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