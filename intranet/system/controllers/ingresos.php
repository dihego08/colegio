<?php
	class ingresos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function ingresos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_ingresos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Ingresos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Ingresos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Ingresos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Ingresos";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function detalle(){
	        $sql = "SELECT d.*, c.titulo as curso FROM venta_detalle as d, cursos as c WHERE d.id_curso = c.id AND d.identificador_venta = ".$_POST['identificador'];
	        echo $this->modelo3->run_query($sql, false);
	    }
	    public function loadingresos() {
	        $sql = "SELECT i.*, CONCAT(u.apellidos, ', ', u.nombres) as usuario, DATE(i.fecha) as fecha FROM venta_cabecera as i, usuarios as u WHERE i.id_alumno = u.id";
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("categorias", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("categorias", array('id' => $_POST['id']));
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