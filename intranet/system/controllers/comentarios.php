<?php
	class comentarios extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function comentarios() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_comentarios");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Comentarios";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Comentarios";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Comentarios";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Comentarios";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function add_index(){
	        echo $this->modelo3->executor("UPDATE comentarios set estado = 1 WHERE id = ".$_POST['id'], "update");
	    }
        function rem_index(){
            echo $this->modelo3->executor("UPDATE comentarios set estado = 0 WHERE id = ".$_POST['id'], "update");
        }
	    public function loadcomentarios() {
	    	$sql = "SELECT a.nombres, co.*, c.titulo FROM comentarios as co, usuarios as a, cursos as c WHERE a.id = co.id_usuario AND c.id = co.id_curso";
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function save(){
			//$_POST['id_usuario'] = 1;
			$_POST['estado'] = 0;
			//echo $_POST['comentario'];
			echo $this->modelo3->insert_data("comentarios", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("comentarios", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("clase", array('id' => $_POST['id_clase']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("clase", $_POST);
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