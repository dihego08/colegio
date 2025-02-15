<?php
	class nuevo_pago extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function nuevo_pago() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_nuevo_pago");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Pagos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Pagos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Pagos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Pagos";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function get_historial(){
	    	$sql = "SELECT a.dni, CONCAT(a.apellidos, ', ', a.nombres) as alumno, p.*, p_d.* FROM alumnos as a INNER JOIN pagos as p ON a.id = p.id_alumno INNER JOIN pago_d as p_d ON p.id = p_d.id_pago WHERE p.id_alumno = " . $_GET['id_alumno'];
	    	$result = $this->modelo2->select('','','',$sql);
        	echo json_encode($result);
	    }
	    public function cancelar_deuda(){
	    	$sql = "INSERT INTO "
	    }
	    /*public function get_docente(){
	    	$sql = "SELECT * FROM pagos WHERE apellidos LIKE '%".$_GET['term']."%' OR nombres like '%".$_GET['term']."%'";
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
	    	$sql = "SELECT * FROM pagos WHERE id = ".$_GET['id_docente'];
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }*/
	    public function loadpagos() {
	        if ($this->valida(5)) {
	             $sql= "select * from pagos";   
	        } elseif ($this->valida(3)) {
	            $sql="select * from pagos";
	        }
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }
	    function save(){
	        $this->modelo2->insert("pagos", $_POST);
	    }
	    function eliminar(){
	        $id  = $_POST['id'];
	        $param = "id = " . $id;
	        $this->modelo2->delete('pagos', $param, true);
	    }
	    function editar(){
	        $where = " id=".$_POST['id'];
	        echo json_encode($this->modelo2->select("*", "pagos", $where, ''));
	    }
	    function editarBD(){
	        $data["dni"] = $_POST["dni"];
		    $data["nombres"] = $_POST["nombres"]; 
		    $data["apellidos"] = $_POST["apellidos"]; 
		    $data["telefono"] = $_POST["telefono"]; 
		    $data["fecha_nacimiento"] = $_POST["fecha_nacimiento"]; 
		    $data["direccion"] = $_POST["direccion"]; 
		    $data["correo"] = $_POST["correo"];
		    $data["usuario"] = $_POST["usuario"];
		    if($_POST["pass"] == "" || $_POST["pass"] == null){

		    }else{
		    	$data["pass"] = $_POST["pass"];	
		    }
	        $this->modelo->update("pagos",$data,array("id"=>$_POST['id']));
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