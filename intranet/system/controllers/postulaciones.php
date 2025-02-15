<?php
	class postulaciones extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function postulaciones() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_postulaciones");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Postulaciones";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Postulaciones";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Postulaciones";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Postulaciones";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadpostulaciones() {
	        /*$sql = "SELECT a.*, CONCAT(p.apellidos, ', ', p.nombres) as padre FROM alumnos as a, padres as p WHERE p.id = a.id_padre";
	        echo $this->modelo2->run_query($sql, false);*/
	        echo $this->modelo2->select_all("postulaciones", true);
	    }
	    function save(){
		    $data["dni"] = $_POST["dni"];
		    $data["nombres"] = $_POST["nombres"]; 
		    $data["apellidos"] = $_POST["apellidos"]; 
		    $data["telefono"] = $_POST["telefono"]; 
		    $data["fecha_nacimiento"] = $_POST["fecha_nacimiento"]; 
		    $data["direccion"] = $_POST["direccion"]; 
		    $data["correo"] = $_POST["correo"];
		    $data["id_padre"] = $_POST["id_padre"];
		    echo $this->modelo2->insert_data("alumnos", $_POST, false);
	    }
	    function eliminar(){
	        $id  = $_POST['id'];
	        $param = "id = " . $id;
	        $this->modelo2->delete('alumnos', $param, true);
	    }
	    function editar(){
	        $sql = "SELECT a.*, CONCAT(p.apellidos, ', ', p.nombres) as padre FROM alumnos as a INNER JOIN padres as p ON a.id_padre = p.id WHERE a.id = " . $_POST['id'];
	        echo $this->modelo2->run_query("SELECT a.*, CONCAT(p.apellidos, ', ', p.nombres) as padre FROM alumnos as a, padres as p WHERE p.id = a.id_padre AND a.id = " . $_POST['id']);
	    }
	    function editarBD(){
	        echo $this->modelo2->update_data("alumnos", $_POST);
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