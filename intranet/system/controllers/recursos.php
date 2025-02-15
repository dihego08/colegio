<?php
	class recursos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function recursos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_recursos");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Recursos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Recursos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Recursos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Recursos";
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
	    public function loadrecursos() {
	        $sql = "SELECT r.*, c.titulo as curso, cl.titulo as clase FROM recursos as r, clase as cl, cursos as c WHERE r.id_clase = cl.id AND cl.id_curso = c.id";
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function save(){
	        $res = 0;
			$total = count($_FILES['file1']['name']);
			
			//echo $total;
			//echo $_SERVER['DOCUMENT_ROOT'];
			
			for( $i=0 ; $i < $total ; $i++ ) {
			  $tmpFilePath = $_FILES['file1']['tmp_name'][$i];
			  if ($tmpFilePath != ""){
			      //echo $_SERVER['DOCUMENT_ROOT'];
			      $newFilePath = $_SERVER['DOCUMENT_ROOT']."/cursos_online/system/controllers/uploads/" . $_FILES['file1']['name'][$i];
			      if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			          $_POST['recurso'] = $_FILES['file1']['name'][$i];	
			          $this->modelo3->insert_data("recursos", $_POST, false);
			      }else{
			          $res = $res + 1;
			      }
			  }
			}
			if($res > 0){
			    echo json_encode(array('Result' => "ERROR"));
			}else{
			    echo json_encode(array('Result' => "OK"));
			}
	    }
	    function eliminar(){
	        $ar = json_decode($this->modelo3->select_one("recursos", array('id' => $_POST['id'])));
	        if (!unlink($_SERVER['DOCUMENT_ROOT']."/cursos_online/system/controllers/uploads/".$ar->recurso)) {  
			    echo ("$file_pointer cannot be deleted due to an error");  
			}  
			else {
			    echo $this->modelo3->delete_data("recursos", array('id' => $_POST['id']));
			}
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