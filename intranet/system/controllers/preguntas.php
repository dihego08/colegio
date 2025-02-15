<?php
	class preguntas extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function preguntas() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_preguntas");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Banco de Preguntas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Banco de Preguntas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Banco de Preguntas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Banco de Preguntas";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function eliminar_alternativa(){
	    	echo $this->modelo3->delete_data("alternativas", array('id' => $_POST['id_alternativa']));
	    }
	    public function loadpreguntas_non(){
	    	$a = json_decode($this->modelo3->select_all_where("pregunta_examen", array('id_examen' => $_POST['id_examen'])));
	    	$vr = array();
	    	$f = 0;
	    	$vf = 0;
	    	foreach ($a->Records as $key) {
	    		$vr[] = $key->id_pregunta;
	    		if($f == 0){
	    			$vf = $key->id_pregunta;
	    		}
	    		if((count($a->Records) - $f) == 1){
	    			
	    			$vf .= ",".$key->id_pregunta;
	    		}else{
	    		}
	    		$f = $f + 1;
	    	}

	    	$sql = "SELECT * FROM preguntas WHERE id NOT IN (".$vf.")";
	    	echo $this->modelo3->run_query($sql, true);
	    }
	    public function loadpreguntas_added(){
	    	$sql = "SELECT p.pregunta, pe.id FROM preguntas as p, pregunta_examen as pe WHERE p.id = pe.id_pregunta AND pe.id_examen = " . $_POST['id_examen'];
	    	echo $this->modelo3->run_query($sql, true);
	    }
	    public function loadpreguntas() {
	    	
	        $ar = json_decode($this->modelo3->select_all("preguntas", true));
	        //print_r($ar);
	        $values = array();
	        foreach ($ar as $key) {
	        	//echo $key->pregunta;
	    		$sql = "SELECT count(*) as alternativas FROM alternativas as a WHERE a.id_pregunta = ".$key->id;
	    		$ar_2 = json_decode($this->modelo3->run_query($sql, true));
	    		//print_r($ar_2);
	    		$r = 0;
	    		//echo $ar_2['Records'][0]->alternativas."....";
	    		if($ar_2->Records[0]->alternativas == null || is_null($ar_2->Records[0]->alternativas)){

	    		}else{
	    			$r = $ar_2->Records[0]->alternativas;
	    		}
	    		$values[] = array(
	    			'id' => $key->id,
	    			'pregunta' => $key->pregunta,
	    			'alternativas' => $r
	    		);
	    	}
	    	echo json_encode($values);
	    }
	    public function loadalternativas(){
	    	echo $this->modelo3->select_all_where("alternativas", array('id_pregunta' => $_POST['id_pregunta']));
	    }
	    public function save_alternativas(){
	    	echo $this->modelo3->insert_data("alternativas", $_POST, false);
	    }
	    public function del_que(){
	    	echo $this->modelo3->delete_data("pregunta_examen", array('id' => $_POST['id']));
	    }
	    function save(){
			echo $this->modelo3->insert_data("preguntas", $_POST, false);
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
	    function editar(){
	        echo $this->modelo3->select_one("preguntas", array('id' => $_POST['id_pregunta']));
	    }
	    function editarBD(){
	    	$_POST['id_profesor'] = 1;
	        echo $this->modelo3->update_data("preguntas", $_POST);
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