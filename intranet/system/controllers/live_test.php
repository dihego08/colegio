<?php
	class live_test extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
    	var $id_con = "S";
		function live_test() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_live_test");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");

	        $this->id_con 	   = $this->uri()->seg(2);
	    }
	    function index() {
	    	//$id_exa = $_GET['id_examen'];
	        if ($this->valida(5)) {
	            $h["title"]   = "Examen en Línea";
	            $c["content"] = $this->html->container($this->id_con);
	            $c["title"]   = "Examen en Línea";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Examen en Línea";
	            $c["content"] = $this->html->container($this->id_con);
	            $c["title"]   = "Examen en Línea";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function get_pregunta(){
	    	$ex = json_decode($this->modelo3->select_one("examenes", array('id' => $this->id_con)));
	    	$sql = "SELECT p.pregunta, p.id as id_pregunta, pe.id FROM preguntas as p, pregunta_examen as pe WHERE p.id = pe.id_pregunta AND pe.id_examen = ".$this->id_con;// . $_POST['id_examen'];
	    	//echo $sql;
	    	$rr = json_decode($this->modelo3->run_query($sql, true));

	    	$values = array();
	    	$vv = array();
	    	$values['duracion'] = $ex->duracion;
	    	foreach ($rr->Records as $key) {
	    		$ar = json_decode($this->modelo3->select_all_where("alternativas", array('id_pregunta' => $key->id_pregunta)));
	    		$vv[] = array(
	    			"id_pregunta" => $key->id_pregunta,
	    			"pregunta" => $key->pregunta,
	    			"alternativas" =>  $ar->Records
	    		);
	    	}
	    	$values["QUES"] = $vv;
	    	echo json_encode($values);
	    }
	    function finalizar_evaluacion(){
	    	foreach ($_POST['arr'] as $key => $value) {
	    		$data['id_examen'] = $_POST['id_examen'];
	    		$data['id_alumno'] = $_POST['id_alumno'];
	    		$data['id_pregunta'] = $key;
	    		$data['id_alternativa_marcada'] = $value;
	    		$this->modelo3->insert_data("resolucion", $data, false);
	    	}
	    	echo json_encode(array('Result' => "OK"));
	    }
	    public function get_detalle_examen(){
	    	$sql = "SELECT c.titulo, e.* FROM examenes as e, cursos as c WHERE e.id_curso = c.id AND e.id = 1";//."1";
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