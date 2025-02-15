<?php
	class clases extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function clases() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_clases");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Clases";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Clases";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Clases";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Clases";
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
	    public function get_clases(){
	    	echo $this->modelo3->select_all_where("clase", array('id_curso' => $_POST['id_curso']));
	    }
	    public function loadclases() {
	    	$sql = "SELECT cl.*, c.titulo as curso FROM clase as cl, cursos as c WHERE cl.id_curso = c.id";
	    	
	        $all_clases = json_decode($this->modelo3->run_query($sql, false));
	        
	        $result = array();
	        
	        foreach($all_clases as $clase){
	            $pre = "SELECT titulo FROM clase WHERE id = ".$clase->id;
	            $pre_ = json_decode($this->modelo3->select_one("clase", array("id_predecesor" => $clase->id)));
	            
	            $result[] = array(
	                'id' => $clase->id,
	                'curso' => $clase->curso,
	                'titulo' => $clase->titulo,
	                'precedesor' => $pre_->titulo
                );
	        }
	        echo json_encode($result);
	    }
	    public function clases_by(){
	        echo $this->modelo3->select_all_where("clase", array("id_curso" => $_POST['id_curso']));
	    }
	    function save(){
			echo $this->modelo3->insert_data("clase", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("clase", array('id' => $_POST['id']));
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