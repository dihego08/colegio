<?php
	/*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

	class notas extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function notas() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_notas");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Reporte de Notas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Notas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Reporte de Notas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Notas";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadnotas() {

	    	$result = array();

            // $notas = json_decode($this->modelo3->select_all_where("tbl_notas", array("date(fecha)" => $_GET['fecha'])));
			$sql_2 = "SELECT * FROM tbl_notas WHERE date(fecha) = '".$_GET['fecha']."'";

        	$notas = json_decode($this->modelo3->run_query($sql_2, false));

            foreach ($notas as $key => $value) {
            	$alumno = json_decode($this->modelo3->select_one("usuarios", array("id" => $value->id_alumno)));

            	$result[] = array(
            		"nombres" => $alumno->nombres . " " . $alumno->apellidos,
            		'examen' => $value->examen,
            		'id' => $value->id,
            	);
            }

            echo json_encode($result);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("niveles", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("tbl_notas", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("niveles", array('id' => $_POST['id_nivel']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("tbl_notas", $_POST);
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