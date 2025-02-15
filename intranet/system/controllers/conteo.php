<?php
	class conteo extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function conteo() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_conteo");
	        $this->modelo      = $this->load()->model("modelo");
	        //$this->gi3         = $this->load()->getid3("getid3");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Conteo de Vistas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Conteo de Vistas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Conteo de Vistas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Conteo de Vistas";
	            $this->View($h, $c);
	        } else
	            $this->Login();
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
	    public function loadconteo() {
	        $values = array();
	        /*$clases = json_decode($this->modelo3->select_all_where("clase", array("id_curso" => $_POST['id_curso'])));
	        
	        foreach($clases->Records as $clase){
	            $sql = "SELECT COUNT(*) as cant FROM progreso WHERE id_clase = ".$clase->id." and estado = 1 AND DATE(fecha) >= '".$_POST['f_d']."' AND DATE(fecha) <= '".$_POST['f_h']."' ;";
	            //echo $sql;
	            $cant = json_decode($this->modelo3->run_query($sql, false));
	            
	            $values[] = array(
	                "titulo" => $clase->titulo,
	                "conteo" => $cant[0]->cant
	            );
	        }
	        echo json_encode($values);*/
	        $sql_ = "SELECT c.titulo, c.id, p.nombres FROM cursos as c, profesores as p WHERE c.id_profesor = p.id";
	        $cursos = json_decode($this->modelo3->run_query($sql_, false));
	        foreach($cursos as $curso){
	            $sql = "SELECT COUNT(*) as cant FROM venta_cabecera as vc, venta_detalle as vd WHERE vc.identificador = vd.identificador_venta AND vd.id_curso = ".$curso->id." and DATE(vc.fecha) >= '".$_POST['f_d']."' AND DATE(vc.fecha) <= '".$_POST['f_h']."' ;";
	            $cant = json_decode($this->modelo3->run_query($sql, false));
	            
	            $values[] = array(
	                "id" => $curso->id,
	                "titulo" => $curso->titulo,
	                "profesor" => $curso->nombres,
	                "conteo" => $cant[0]->cant
	            );
	        }
	        echo json_encode($values);
	    }
	    function save(){
			$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			    exit();
			}
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/cursos_online/system/controllers/uploads/$fileName")){
				$_POST['video'] = $fileName;
				
				echo $this->modelo3->insert_data("videos", $_POST, false);
			} else {
			}
	    }
	    function eliminar(){
	        $ar = json_decode($this->modelo3->select_one("videos", array('id' => $_POST['id'])));
	        if (!unlink($_SERVER['DOCUMENT_ROOT']."/cursos_online/system/controllers/uploads/".$ar->video)) {  
			    echo ("$file_pointer cannot be deleted due to an error");  
			}  
			else {
			    echo $this->modelo3->delete_data("videos", array('id' => $_POST['id']));
			}
	    }
	    function editar(){
	        echo $this->modelo3->select_one("categorias", array('id' => $_POST['id_categoria']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("categorias", $_POST);
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