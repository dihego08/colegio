<?php
	class categorias extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function categorias() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_categorias");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Categorías";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Categorías";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Categorías";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Categorías";
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
	    public function loadcategorias() {
	        echo $this->modelo3->select_all("categorias", true);
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