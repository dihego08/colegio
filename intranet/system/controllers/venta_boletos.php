<?php
	class venta_boletos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function venta_boletos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_venta_boletos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Venta de Boletos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Venta de Boletos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Venta de Boletos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Venta de Boletos";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadalumnos() {
	        $sql = "SELECT a.*, CONCAT(p.apellidos, ', ', p.nombres) as padre FROM alumnos as a INNER JOIN padres as p ON a.id_padre = p.id";
	        $result = $this->modelo2->run_query('','','',$sql);
	        echo json_encode($result);
	    }
	    function save(){
	        if(isset($_POST['nombre'])){
	            
	        }else{
	            $_POST['nombre'] = NULL;
	        }
	        if(isset($_POST['dni'])){
	            
	        }else{
	            $_POST['dni'] = NULL;
	        }
	        $_POST['cabecera'] = NULL;
	        $_POST['sub_total'] = NULL;
	        $_POST['id_usuario'] = NULL;
	        $_POST['igv'] = NULL;
	        $_POST['estado_pago'] = NULL;
	        $_POST['t_documento'] = NULL;
	        $_POST['id_ruta'] = NULL;
	        $sql = "UPDATE asientos SET estado = 1 WHERE placa_bus = '".$_POST['placa_bus']."' AND n_asiento = ".$_POST['asiento']." AND piso = ".$_POST['piso'];
            $this->modelo2->executor($sql, "update");
	    	echo $this->modelo2->insert_data("ventas", $_POST, false);
	    }
	    function eliminar(){
	        $id  = $_POST['id'];
	        $param = "id = " . $id;
	        $this->modelo2->delete('alumnos', $param, true);
	    }
	    function editar(){
	        $sql = "SELECT a.*, CONCAT(p.apellidos, ', ', p.nombres) as padre FROM alumnos as a INNER JOIN padres as p ON a.id_padre = p.id WHERE a.id = " . $_POST['id'];
	        echo json_encode($this->modelo2->select("", "", "", $sql));
	    }
	    function editarBD(){
	        $data["dni"] = $_POST["dni"];
		    $data["nombres"] = $_POST["nombres"]; 
		    $data["apellidos"] = $_POST["apellidos"]; 
		    $data["telefono"] = $_POST["telefono"]; 
		    $data["fecha_nacimiento"] = $_POST["fecha_nacimiento"]; 
		    $data["direccion"] = $_POST["direccion"]; 
		    $data["correo"] = $_POST["correo"];
		    $data["id_padre"] = $_POST["id_padre"];
	        $this->modelo->update("alumnos", $data, array("id"=>$_POST['id']));
	    }
	    function get_valores(){
	    	$JSONData = file_get_contents("http://clientes.reniec.gob.pe/padronElectoral2012/consulta.htm?hTipo=2&hDni=".$_POST['dni']);
			$JSONData = strip_tags($JSONData);
			$JSONData = explode("\n", $JSONData);
			echo json_encode($JSONData);
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