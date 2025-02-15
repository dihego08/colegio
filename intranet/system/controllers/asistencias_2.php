<?php
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    /*ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

	class asistencias_2 extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function asistencias_2() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_asistencias_2");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Reporte de Asistencias";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Asistencias";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Reporte de Asistencias";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Asistencias";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadasistencias() {
			$id_alumno = $_GET['id_alumno'];
            $fecha_desde = $_GET['fecha_desde'];
            $fecha_hasta = $_GET['fecha_hasta'];
            $sql = "SELECT * FROM asistencias WHERE id_alumno = ".$id_alumno." AND fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'";

            $sql_2 = "SELECT * FROM asistencias_new WHERE id_usuario = ".$id_alumno." AND fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'";

            $asistencias_1 = json_decode($this->modelo3->run_query($sql, false));

            $asistencias_2 = json_decode($this->modelo3->run_query($sql_2, false));

            echo json_encode(
            	array(
            		'asistencias_1' => $asistencias_1,
            		'asistencias_2' => $asistencias_2,
            	)
            );
	    }
	    function save(){
	        echo $this->modelo3->insert_data("niveles", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("niveles", array('id' => $_POST['id']));
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