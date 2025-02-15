<?php
	class biblioteca extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function biblioteca() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_biblioteca");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Biblioteca";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Biblioteca";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Biblioteca";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Biblioteca";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function crear_carpeta()
	    {
	    	if (isset($_POST['id_padre'])) {
		        $padre = json_decode($this->modelo2->select_one("biblioteca", array("id" => $_POST['id_padre'])));

		        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $padre->nombre_carpeta . "/" . $_POST["nombre_carpeta"])) {
		            echo json_encode(array("Result" => "ERROR", "Message" => "La carpeta ya existe"));
		        } else {
		            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $padre->nombre_carpeta . "/" . $_POST["nombre_carpeta"];
		            mkdir($ruta, 0777);

		            $this->modelo2->insert_data("biblioteca", $_POST, false);

		            echo json_encode(array("Result" => "OK", "Message" => "OK"));
		        }
		    } else {
		        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $_POST["nombre_carpeta"])) {
		            echo json_encode(array("Result" => "ERROR", "Message" => "La carpeta ya existe"));
		        } else {
		            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $_POST["nombre_carpeta"];
		            mkdir($ruta, 0777);

		            $this->modelo2->insert_data("biblioteca", $_POST, false);

		            echo json_encode(array("Result" => "OK", "Message" => "OK"));
		        }
		    }
	    }
	    public function lista_carpetas()
	    {
	    	$sql = "SELECT * FROM biblioteca WHERE id_padre is null or id_padre = 0 or id_padre = ''";
    		echo $this->modelo2->run_query($sql, false);
	    }
	    public function loadareas() {
	        echo $this->modelo2->select_all("areas", true);
	    }
	    function save(){
		    echo $this->modelo2->insert_data("areas", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo2->delete_data("areas", array("id" => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo2->select_one("areas", array("id" => $_POST['id']));
	    }
	    function editarBD(){
	        echo $this->modelo2->update_data("areas", $_POST);
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