<?php
	class temas extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function temas() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_temas");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Configuracion de Temas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Configuracion de Temas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Configuracion de Temas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Configuracion de Temas";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadtemas() {
	    	$sql = "SELECT * FROM tbl_temas";
	        $temas = json_decode($this->modelo3->run_query($sql, false));

	        $values = array();

	        foreach ($temas as $key => $value) {
	        	if ($value->id_curso == null || $value->id_curso == "" || $value->id_curso == 0) {
	        		$value->curso = "";
	        	}else{
	        		$curso = json_decode($this->modelo3->select_one("cursos", array('id' => $value->id_curso)));
	        		$value->curso = $curso->curso;
				}
				
				$grupo = json_decode($this->modelo3->select_one("grupos", array('id' => $curso->id_grupo)));
				$ciclo = json_decode($this->modelo3->select_one("ciclos", array('id' => $curso->id_ciclo)));
				$value->grupo = "<p class=\"text-center\"><span class=\"w-100\" style=\"display: block;\">".$grupo->grupo." -</span><small>".$ciclo->ciclo."</small></p>";//$ciclo->ciclo;
	        	
	        	$values[] = $value;
	        }

	        echo json_encode($values);
		}
		function temamodulo(){
			echo $this->modelo3->select_all_where("tbl_temas", array("id_modulo" => $_POST['id_modulo']));
		}
	    function save(){
	        echo $this->modelo3->insert_data("tbl_temas", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("tbl_temas", array('id' => $_POST['id']));
	    }
	    function editar(){
			$sql = "SELECT t.*, g.id as id_grupo, c.id as id_ciclo, cu.id as id_curso FROM tbl_temas as t, grupos as g, ciclos as c, cursos as cu WHERE c.id = g.id_ciclo AND g.id = cu.id_grupo AND cu.id = t.id_curso AND t.id = ".$_POST['id'];
			//echo $this->modelo3->select_one("tbl_temas", array('id' => $_POST['id_nivel']));
			$tema = json_decode($this->modelo3->run_query($sql, false));

			//print_r($tema);

			echo json_encode($tema[0]);
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("tbl_temas", $_POST);
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