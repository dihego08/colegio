<?php
	class portada extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function portada() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_portada");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Portada";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Portada";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Portada";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Portada";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadportadas() {
	        echo $this->modelo2->select_all("portada", true);
	    }
	    function add_index(){
	        echo $this->modelo2->executor("UPDATE portada set estado = 1 WHERE id = ".$_POST['id'], "update");
	    }
        function rem_index(){
            echo $this->modelo2->executor("UPDATE portada set estado = 0 WHERE id = ".$_POST['id'], "update");
        }
	    function save(){
		    /*$_POST['foto'] = "";
	        $fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			    //exit();
			}
			
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/uploads/$fileName")){
				$_POST['foto'] = $fileName;
				$aux++;
			} else {
			    $_POST['foto'] = "";
			}
			
			$_POST['pass'] = md5($_POST['pass']);
		    echo $this->modelo2->insert_data("usuarios", $_POST, false);*/
		    
		    $fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			    exit();
			}
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/portadas/$fileName")){
				$_POST['portada'] = $fileName;
				$_POST['estado'] = 0;
				echo $this->modelo2->insert_data("portada", $_POST, false);
			} else {
			}
	    }
	    function eliminar(){
	        $ar = json_decode($this->modelo2->select_one("portada", array('id' => $_POST['id'])));
	        if (!unlink($_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/portadas/".$ar->portada)) {  
			    echo ("$file_pointer cannot be deleted due to an error");  
			}  
			else {
			    echo $this->modelo2->delete_data("portada", array('id' => $_POST['id']));
			}
	    }
	    function editar(){
	        echo $this->modelo2->select_one("usuarios", array("id" => $_POST["id"]));
	    }
	    function editarBD(){
	        $rf = json_decode($this->modelo3->select_one("usuarios", array('id' => $_POST['id'])));
	        
	        if($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0){
	            $_POST["foto"] = $rf->foto;
	            
				if(!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null){
				    $_POST["pass"] = $rf->pass;
				}else{
				    $_POST["pass"] = md5($_POST['pass']);
				}
	        }else{
	            $fileName = $_FILES["file1"]["name"];
    			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
    			$fileType = $_FILES["file1"]["type"];
    			$fileSize = $_FILES["file1"]["size"];
    			$fileErrorMsg = $_FILES["file1"]["error"];
    			if (!$fileTmpLoc) {
    			    //exit();
    			}
    			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/uploads/$fileName")){
    				
    				$_POST["foto"] = $fileName;
    				if(!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null){
    				    $_POST["pass"] = $rf->pass;
    				}else{
    				    $_POST["pass"] = md5($_POST['pass']);
    				}
    			} else {
    			}
	        }
	        
	        //echo $this->modelo3->update_data("profesores", $_POST);
	        echo $this->modelo2->update_data("usuarios", $_POST);
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