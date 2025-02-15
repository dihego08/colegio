<?php
	class ciclos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function ciclos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_ciclos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Ciclos Academicos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Ciclos Academicos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Ciclos Academicos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Ciclos Academicos";
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
	    public function loadciclos() {
	    	$sql = "SELECT c.*, u.universidad FROM ciclos as c, universidades as u WHERE c.id_universidad = u.id";

	        echo $this->modelo3->run_query($sql, false);
	    }
	    public function by_universidad()
	    {
	    	echo $this->modelo3->select_all_where("ciclos", array("id_universidad" => $_POST['id_universidad']));
	    }
	    function save(){
	        echo $this->modelo3->insert_data("ciclos", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("ciclos", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("ciclos", array('id' => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("ciclos", $_POST);
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