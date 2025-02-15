<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
	class salas extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function salas() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_salas");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Creacion de Salas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Creacion de Salas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Creacion de Salas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Creacion de Salas";
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
	    public function crear_externo()
	    {
    		$sql = "SELECT * FROM salas WHERE id_curso = ".$_POST['id_curso']." AND DATE(fecha) = '".date("Y-m-d")."'";
	    	$existe = json_decode($this->modelo3->run_query($sql, false));

	    	if(count($existe) > 0){
	    		$_POST['id'] = $existe[0]->id;
	    		$_POST['sala'] = $existe[0]->sala;
	    		echo $this->modelo3->update_data("salas", $_POST);
	    	}else{
	    		echo $this->modelo3->insert_data("salas", $_POST, false);
	    	}
	    }
	    public function devolver_sala()
	    {
	    	$sql = "SELECT * FROM salas WHERE id_curso = ".$_POST['id_curso']." AND DATE(fecha) = '".date("Y-m-d")."'";
	    	echo $this->modelo3->run_query($sql, false);
	    }
	    function crear_sala()
	    {

	        echo $this->modelo3->insert_data("salas", $_POST, false);
	    }
	    function mis_cursos_profesor_hoy()
	    {
	    	$query = "SELECT c.ciclo, g.grupo, cu.* FROM ciclos as c, grupos as g, cursos as cu WHERE cu.id_grupo = g.id AND g.id_ciclo = c.id";
		    $cursos = json_decode($this->modelo3->run_query($query, false));

		    $result = array();

		    $hoy = date("Y-m-d");
		    $dia_hoy = date("w");

		    foreach ($cursos as $key => $value) {
		        $query_horario = "SELECT * FROM horarios WHERE dia = ".$dia_hoy." AND id_curso = ".$value->id;
		        $horario = json_decode($this->modelo3->run_query($query_horario, false));


		        $query_sala = "SELECT * FROM salas WHERE DATE(fecha) = '".$hoy."' AND id_curso = ".$value->id;
		        $sala = json_decode($this->modelo3->run_query($query_sala, false));

		        $profesor = json_decode($this->modelo3->select_one("profesores", array("id" => $value->id_profesor)));

		        if (empty($horario) || count($horario) == 0) {
		        } else {
		            if (empty($sala) || count($sala) == 0) {
		                $value->sala = "sin_sala";
		            } else {
		                $value->sala = $sala[0]->sala;
		            }
		            $value->profesor = $profesor->nombres;
		            $value->horario = $horario[0];
		            $result[] = $value;
		        }
		    }

		    echo json_encode($result);
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
