<?php
	class buses extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function buses() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_buses");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        //$this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo2     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Buses";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Buses";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Buses";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Buses";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function get_bus(){
            $sql = "SELECT * FROM buses WHERE placa LIKE '%".$_GET['term']."%'";
            $result = json_decode($this->modelo2->run_query($sql));
            $values = array();
            foreach ($result as $key) {
                $values[] = array(
                    'id' => $key->id,
                    'value' => $key->placa." - ".$key->modelo
                );
            }
            echo json_encode($values);
        }
        public function get_one(){
            $result = $this->modelo2->select_one("buses", array('id' => $_GET['id_bus']));
            echo $result;
        }
	    public function loadbuses() {
	        $result = $this->modelo2->select_all("buses", true);
	        echo $result;
	    }
	    function save(){
	    	if($_POST['pisos'] == 1){
	    		$tables = array(
	    			'buses'
	    		);
	    		for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}

			    $datas = array($_POST);
			   	for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 1, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL, 'background' => '#333333', 'precio' => NULL);
			   	}
	    	}else{
	    		$tables = array(
	    			'buses'
	    		);
	    		for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}
	    		for ($i = 0; $i < $_POST['p_2_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}
			    $datas = array($_POST);
			   	for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 1, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL, 'background' => '#333333', 'precio' => NULL);
			   	}
			   	for ($i = 0; $i < $_POST['p_2_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 2, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL, 'background' => '#333333', 'precio' => NULL);
			   	}
	    	}
	        echo $this->modelo2->multiple_querys($tables, $datas);
	        //echo $this->modelo2->insert_with_delete($tables, $datas, "asientos", array('placa_bus' => $_POST['placa']));
	        //echo $this->modelo2->update_with_delete($tables, $datas, "asientos", array('placa_bus' => $_POST['placa_borrar']), array('id' => $_POST['id'])
	    }
	    function eliminar(){
	        $tables = array(
	    		"buses",
	    		"pisos"
		    );
		    $datas = array(
		    	array("id" => $_POST['id']),
		    	array("placa" => $_POST['placa'])
			 );
	        $this->modelo2->delete_data($tables, $datas);
	    }
	    function editar(){
	    	$tables = array(
	    		"buses",
	    		"pisos"
		    );
	        echo $this->modelo2->select_one("buses", array('id' => $_POST['id']));
	    }
	    function editarBD(){
	    	if($_POST['pisos'] == 1){
	    		$tables = array(
	    			'buses'
	    		);
	    		for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}

			    $datas = array($_POST);
			   	for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 1, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL);
			   	}
	    	}else{
	    		$tables = array(
	    			'buses'
	    		);
	    		for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}
	    		for ($i = 0; $i < $_POST['p_2_asientos']; $i++) { 
	    			$tables[] = "asientos";
	    		}
			    $datas = array($_POST);
			   	for ($i = 0; $i < $_POST['p_1_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 1, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL);
			   	}
			   	for ($i = 0; $i < $_POST['p_2_asientos']; $i++) { 
			   		$datas[] = array('placa_bus' => $_POST['placa'], 'piso' => 2, 'n_asiento' => $i + 1, 'id_tipo' => NULL, 'estado' => NULL);
			   	}
	    	}
	        echo $this->modelo2->update_with_delete($tables, $datas, "asientos", array('placa_bus' => $_POST['placa_borrar']), array('id' => $_POST['id']));
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