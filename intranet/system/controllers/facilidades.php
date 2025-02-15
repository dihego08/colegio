<?php
class facilidades extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function facilidades()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_facilidades");
		$this->modelo      = $this->load()->model("modelo");
		//$this->gi3         = $this->load()->getid3("getid3");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Configuracion de Facilidades";
			$c["content"] = $this->html->container();
			$c["title"]   = "Configuracion de Facilidades";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Configuracion de Facilidades";
			$c["content"] = $this->html->container();
			$c["title"]   = "Configuracion de Facilidades";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadfacilidades()
	{
        //$query = "SELECT t.tipo_estudiante, p.* FROM tipo_estudiantes as t, precios as p WHERE p.id_tipo_estudiante = t.id";
		echo $this->modelo3->select_all("facilidades", true);
    }
    function llenar_tipos_estudiantes(){
        echo $this->modelo3->select_all("tipo_estudiantes", true);
    }
	function save()
	{
		$ruta = $_SERVER['DOCUMENT_ROOT']."/web/";
    	
    	$cant = json_decode($this->modelo3->run_query("SELECT COUNT(*) AS cant FROM facilidades WHERE id = ".$_POST['id'], false));

    	if($cant[0]->cant == 0){
			$fileName = $_FILES["imagen"]["name"];
			$fileTmpLoc = $_FILES["imagen"]["tmp_name"];
			$fileType = $_FILES["imagen"]["type"];
			$fileSize = $_FILES["imagen"]["size"];
			$fileErrorMsg = $_FILES["imagen"]["error"];
			if (!$fileTmpLoc) {
				//echo "ERRPOR";
			}
			
			if(move_uploaded_file($fileTmpLoc, $ruta."/$fileName")){
				$_POST['imagen'] = $fileName;
				
			} else {
			}
			echo $this->modelo3->insert_data("facilidades", $_POST, false);
    	}else{
    		$facilidad = json_decode($this->modelo3->select_one("facilidades", array("id" => $_POST['id'])));
    		$_POST['imagen'] = $facilidad->imagen;

    		$fileName = $_FILES["imagen"]["name"];
			$fileTmpLoc = $_FILES["imagen"]["tmp_name"];
			$fileType = $_FILES["imagen"]["type"];
			$fileSize = $_FILES["imagen"]["size"];
			$fileErrorMsg = $_FILES["imagen"]["error"];
			if (!$fileTmpLoc) {
				//echo "ERRPOR";
			}
			
			if(move_uploaded_file($fileTmpLoc, $ruta."/$fileName")){
				$_POST['imagen'] = $fileName;
				
			} else {
			}
			echo $this->modelo3->update_data("facilidades", $_POST, false);
    	}

    	
	}
	function eliminar()
	{
		echo $this->modelo3->delete_data("precios", array('id' => $_POST['id']));
	}
	function editar()
	{
		echo $this->modelo3->select_one("facilidades", array('id' => $_POST['id']));
	}
	function editarBD()
	{
		echo $this->modelo3->update_data("precios", $_POST);
	}
	private function valida($level)
	{
		if (isset($_SESSION["user_level"])) {
			if ($_SESSION["user_level"] == $level) {
				return true;
			} else
				return false;
		} else
			return false;
	}
	private function View($header, $content)
	{
		$h = $this->load()->view('header');
		$h->PrintHeader($header);
		$c = $this->load()->view('content');
		$c->PrintContent($content);
		$f = $this->load()->view('footer');
		$f->PrintFooter();
	}
}
