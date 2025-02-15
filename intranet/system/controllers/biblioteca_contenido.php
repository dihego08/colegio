<?php
	class biblioteca_contenido extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
    	var $id_con = "S";
    	public $zzz = "";
		function biblioteca_contenido() {
	        session_start();

	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_biblioteca_contenido");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	        
			$this->id_con 	   = $this->uri()->seg(2);
			//echo "OBVI " .$this->id_con. " O NO";
	    	$ploxis = $this->uri()->seg(2);
			$this->zzz = $ploxis;
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Contenido de la Carpeta";
	            $c["content"] = $this->html->container($this->id_con);
	            $c["title"]   = "Contenido de la Carpeta";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Contenido de la Carpeta";
	            $c["content"] = $this->html->container($this->id_con);
	            $c["title"]   = "Contenido de la Carpeta";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function data_carpeta(){
	    	echo $this->modelo3->select_one("biblioteca", array("id" => $_POST['id_carpeta']));
	    }
	    function lista_contenido(){
	    	$sql = "SELECT * FROM contenido_biblioteca WHERE id_carpeta = ".$_POST['id_carpeta'];
		    $contenido = json_decode($this->modelo3->run_query($sql, false));

		    $sql_2 = "SELECT * FROM biblioteca WHERE id_padre = ".$_POST['id_carpeta'];
		    $carpetas = json_decode($this->modelo3->run_query($sql_2, false));
		    
		    $sql_3 = json_decode($this->modelo3->select_one("biblioteca", array("id" => $_POST['id_carpeta'])));
		    
		    $padre = "";
		    if($sql_3->id_padre == "" || is_null($sql_3->id_padre) || empty($sql_3->id_padre)){
		        $padre = "NO";
		    }else{
		        $padre = json_decode($this->modelo3->select_one("biblioteca", array("id" => $sql_3->id_padre)));
		        $padre = $padre->nombre_carpeta;
		    }

		    $result = array();

		    foreach($carpetas as $key => $value){
		        $result[] = array(
		            "id" => $value->id,
		            "nombre_carpeta" => $value->nombre_carpeta,
		            "id_padre" => $value->id_padre,
		            "padre" => $padre,
		            "type" => "C"
		        );
		    }

		    foreach($contenido as $key => $value){
		        $result[] = array(
		            "id" => $value->id,
		            "archivo" => $value->archivo,
		            "id_carpeta" => $value->id_carpeta,
		            "padre" => $padre,
		            "type" => "A"
		        );
		    }

		    echo json_encode($result);
	    }
	    public function guardar_material_permanente()
	    {
	    	$la_carpeta = json_decode($this->modelo3->select_one("biblioteca", array("id" => $_POST['id_carpeta'])));

		    if($la_carpeta->id_padre == "" || is_null($la_carpeta->id_padre)){
		        $fileName = $_FILES["file1"]["name"];
		        $fileTmpLoc = $_FILES["file1"]["tmp_name"];
		        $fileType = $_FILES["file1"]["type"];
		        $fileSize = $_FILES["file1"]["size"];
		        $fileErrorMsg = $_FILES["file1"]["error"];
		    
		        if (!$fileTmpLoc) {
		        }
		        echo $_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $la_carpeta->nombre_carpeta . "/" . $fileName;
		        if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" . $la_carpeta->nombre_carpeta . "/" . $fileName)) {
		            $_POST['archivo'] = $fileName;
		            echo $this->modelo3->insert_data("contenido_biblioteca", $_POST, false);
		        } else {
		            echo json_encode(array("Result" => "ERROR"));
		        }
		    }else{

		        $padre = json_decode($this->modelo3->select_one("biblioteca", array("id" => $la_carpeta->id_padre)));

		        $fileName = $_FILES["file1"]["name"];
		        $fileTmpLoc = $_FILES["file1"]["tmp_name"];
		        $fileType = $_FILES["file1"]["type"];
		        $fileSize = $_FILES["file1"]["size"];
		        $fileErrorMsg = $_FILES["file1"]["error"];

		        if (!$fileTmpLoc) {
		        }
		        //echo $_SERVER['DOCUMENT_ROOT'] . "/Admin/" .$padre->nombre_carpeta."/". $la_carpeta->nombre_carpeta . "/" . $fileName;
		        if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/BIBLIOTECA/" .$padre->nombre_carpeta."/". $la_carpeta->nombre_carpeta . "/" . $fileName)) {
		            $_POST['archivo'] = $fileName;
		            echo $this->modelo3->insert_data("contenido_biblioteca", $_POST, false);
		        } else {
		            echo json_encode(array("Result" => "ERROR"));
		        }
		    }
	    }


	    public function get_detalle_examen(){

	    	$sql = "SELECT c.titulo, e.* FROM examenes as e, cursos as c WHERE e.id_curso = c.id AND e.id = ". $this->id_con;//$this->id_examen;//."1";
	    	//echo $sql;
	    	$ar = json_decode($this->modelo3->run_query($sql, true));

	    	$values = $ar->Records[0];
	    	echo json_encode($values);
	    }
	    public function get_docente(){
	    	$sql = "SELECT * FROM categorias WHERE apellidos LIKE '%".$_GET['term']."%' OR nombres like '%".$_GET['term']."%'";
	    	$result = $this->modelo2->select('','','',$sql);
			$values = array();
        	foreach ($result as $key) {
        		$values[] = array(
            		'id' => $key['id'],
            		'value' => $key['apellidos'].", ".$key['nombres']
            	);
        	}
        	echo json_encode($values);
	    }
	    public function get_one(){
	    	$sql = "SELECT * FROM docentes WHERE id = ".$_GET['id_docente'];
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }
	    public function load_examenes(){
	    	$sql = "SELECT c.titulo, e.* FROM examenes as e, cursos as c WHERE e.id_curso = c.id";//.$_SESSION['id'];
	        echo $this->modelo3->run_query($sql, true);
	    }
	    public function loadexamenes() {
	        $sql = "SELECT c.titulo, e.* FROM examenes as e, cursos as c WHERE e.id_curso = c.id AND e.id_profesor = 1";//.$_SESSION['id'];
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function save(){
			$_POST['id_profesor'] = 1;
			echo $this->modelo3->insert_data("examenes", $_POST, false);
	    }
	    function eliminar(){
	        $ar = json_decode($this->modelo3->select_one("videos", array('id' => $_POST['id'])));
	        if (!unlink("/var/www/html/sis_transportes/system/controllers/uploads/".$ar->video)) {  
			    echo ("$file_pointer cannot be deleted due to an error");  
			}  
			else {
			    echo $this->modelo3->delete_data("videos", array('id' => $_POST['id']));
			}
	    }
	    function save_que(){
	    	echo $this->modelo3->insert_data("pregunta_examen", $_POST, false);
	    }
	    function editar(){
	        echo $this->modelo3->select_one("examenes", array('id' => $_POST['id_examen']));
	    }
	    function editarBD(){
	    	$_POST['id_profesor'] = 1;
	        echo $this->modelo3->update_data("examenes", $_POST);
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
	    	//$id_exa = $_GET['id_examen'];
	        $h = $this->load()->view('header');
	        $h->PrintHeader($header);
	        $c = $this->load()->view('content');
	        $c->PrintContent($content);
	        $f = $this->load()->view('footer');
	        $f->PrintFooter();
	    }
	}
?>