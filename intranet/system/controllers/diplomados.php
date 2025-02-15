<?php
    ini_set('upload_max_filesize', '1024M');
    ini_set('post_max_size', '1024M');
    ini_set('max_input_time', 3600);
	ini_set('max_execution_time', 3600);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	class diplomados extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function diplomados() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_diplomados");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Gestion de Diplomados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Gestion de Diplomados";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Gestion de Diplomados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Gestion de Diplomados";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loaddiplomados() {
	       	$diplomados = json_decode($this->modelo3->select_all("diplomados", true));

	       	$result = array();
	       	foreach ($diplomados as $key => $value) {
	       		$area = json_decode($this->modelo3->select_one("areas", array("id" => $value->id_area)));
	       		$modalidad = json_decode($this->modelo3->select_one("modalidades", array("id" => $value->id_modalidad)));

	       		$value->area = $area->area;
	       		$value->modalidad = $modalidad->modalidad;
	       		$value->descripcion = strip_tags($value->descripcion);
	       		$result[] = $value;
	       	}
	       	echo json_encode($result);
	    }
	    function diplomados_by(){
	    	$sql = "SELECT c.*, p.nombres, ca.categoria, n.nivel FROM diplomados as c, profesores as p, categorias as ca, niveles as n WHERE c.id_profesor = p.id AND c.id_categoria = ca.id AND c.id_nivel = n.id AND c.id_profesor = ".$_POST['id'];
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function set_alarmas($id_docente){
	        $sql = "SELECT u.correo, u.id FROM usuarios as u, seguidores as s WHERE u.id = s.id_alumno AND s.id_profesor = ".$id_docente.";";
	        return $this->modelo3->run_query($sql, false);
	    }
	    function save(){
			$_POST['imagen'] = "";
            $fileName = $_FILES["imagen"]["name"];
            $fileTmpLoc = $_FILES["imagen"]["tmp_name"];
            $fileType = $_FILES["imagen"]["type"];
            $fileSize = $_FILES["imagen"]["size"];
            $fileErrorMsg = $_FILES["imagen"]["error"];
            if (!$fileTmpLoc) {
                //exit();
            }
            if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/agogo/includes/img/$fileName")){
                $_POST['imagen'] = $fileName;
            } else {
            }
            $_POST['estado'] = 1;
            echo $this->modelo3->insert_data("diplomados", $_POST, false);
	    }
	    function add_index(){
	        echo $this->modelo3->executor("UPDATE diplomados set estado = 1 WHERE id = ".$_POST['id'], "update");
	    }
        function rem_index(){
            echo $this->modelo3->executor("UPDATE diplomados set estado = 0 WHERE id = ".$_POST['id'], "update");
        }
	    function eliminar(){
	        echo $this->modelo3->delete_data('diplomados', array("id" => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("diplomados", array('id' => $_POST['id_curso']));
		}
		function ver_detalles(){
			echo $this->modelo3->select_one("diplomados", array('id' => $_POST['id_curso']));
		}
		function guardar_detalles(){
			$sql = "UPDATE diplomados SET dirigido_a = '".$_POST['dirigido_a']."', metodologia = '".$_POST['metodologia']."', certificacion = '".$_POST['certificacion']."', ventajas = '".$_POST['ventajas']."', plan_estudios = '".$_POST['plan_estudios']."', competencias = '".$_POST['competencias']."' WHERE id = ".$_POST['id'];
			echo $this->modelo3->executor($sql, "update");
		}
	    function editarBD(){
	        $clase = json_decode($this->modelo3->select_one("diplomados", array('id' => $_POST['id'])));
            if($_FILES['imagen']['size'] == 0 && $_FILES['imagen']['error'] == 0){
                $_POST['imagen'] = $clase->imagen;
            }else{
                $fileName = $_FILES["imagen"]["name"];
                $fileTmpLoc = $_FILES["imagen"]["tmp_name"];
                $fileType = $_FILES["imagen"]["type"];
                $fileSize = $_FILES["imagen"]["size"];
                $fileErrorMsg = $_FILES["imagen"]["error"];
                if (!$fileTmpLoc) {
                    exit();
                }
                if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/agogo/includes/img/$fileName")){
                    $_POST["imagen"] = $fileName;
                } else {
                }
            }
            echo $this->modelo3->update_data("diplomados", $_POST);
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