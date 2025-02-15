<?php
	class padres extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function padres() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_padres");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Padres/Apoderados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Padres/Apoderados";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Padres/Apoderados";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Padres/Apoderados";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadpadres() {
	        if ($this->valida(5)) {
	             $sql= "select * from padres";   
	        } elseif ($this->valida(3)) {
	            $sql="select * from padres";
	        }
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }
	    public function get_padre(){
	    	$sql = "SELECT * FROM padres WHERE apellidos LIKE '%".$_GET['term']."%' OR nombres like '%".$_GET['term']."%'";
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
	    	$sql = "SELECT * FROM padres WHERE id = ".$_GET['id_padre'];
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }
	    function save(){
	        $this->modelo2->insert("padres", $_POST);
	    }
	    function eliminar(){
	        $id  = $_POST['id'];
	        $param = "id = " . $id;
	        $this->modelo2->delete('padres', $param, true);
	    }
	    function editar(){
	        $where = " id=".$_POST['id'];
	        echo json_encode($this->modelo2->select("*", "padres", $where, ''));
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
	        $this->modelo->update("padres",$data,array("id"=>$_POST['id']));
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