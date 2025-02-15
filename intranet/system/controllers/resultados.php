<?php
	class resultados extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function resultados() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_resultados");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Resultados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Resultados";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Resultados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Resultados";
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
	    public function load_examenes(){
	    	$sql = "SELECT DISTINCT c.titulo, e.*, date(r.fecha) as fecha FROM examenes as e, cursos as c, resolucion as r WHERE e.id_curso = c.id AND r.id_examen = e.id AND r.id_alumno = 1";
	        echo $this->modelo3->run_query($sql, true);
	    }
	    public function load_resultados(){
	    	$sql = "SELECT p.id, p.pregunta, a.id as id_alterntaiva, a.alternativa, FROM alternativas as a, preguntas as p, pregunta_examen as pe WHERE pe.id_pregunta = p.id AND a.id_pregunta = p.id AND pe.id_examen = 1";

	    	$sql_ = "SELECT p.id, p.pregunta FROM preguntas as p, pregunta_examen as pe WHERE p.id = pe.id_pregunta AND pe.id_examen = 1";
	    	$ar = json_decode($this->modelo3->run_query($sql_, true));
	    	$val = array();
	    	$val_ = array();
	    	foreach ($ar->Records as $key) {
	    		$val['pregunta'] = $key->pregunta;

	    		$sq = "SELECT a.id, a.alternativa FROM alternativas as a WHERE a.id_pregunta = ".$key->id." AND correcta = 1 UNION SELECT a.id, a.alternativa FROM alternativas as a, resolucion as r WHERE a.id = r. id_alternativa_marcada AND a.id_pregunta = ".$key->id;
	    		$ar_ = json_decode($this->modelo3->run_query($sq, true));

	    		$val['res'] = $ar_->Records;
	    		$val_[] = $val;
	    	}
	    	echo json_encode($val_);
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
	        $h = $this->load()->view('header');
	        $h->PrintHeader($header);
	        $c = $this->load()->view('content');
	        $c->PrintContent($content);
	        $f = $this->load()->view('footer');
	        $f->PrintFooter();
	    }
	}
?>