<?php
	class descuentos extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function descuentos() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_descuentos");
	        $this->modelo      = $this->load()->model("modelo");
	        //$this->gi3         = $this->load()->getid3("getid3");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Configuración de Descuentos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Configuración de Descuentos";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Configuración de Descuentos";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Configuración de Descuentos";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loaddescuentos() {
	        $sql = "SELECT c.titulo, c.precio as precio_ant, c.precio_2 as precio_ant_2, d.* FROM cursos as c, descuentos as d WHERE c.id = d.id_curso";
	        echo $this->modelo3->run_query($sql, false);
	    }
	    function save(){
	        
	        $curso = json_decode($this->modelo3->select_one("cursos", array("id" => $_POST['id_curso'])));
	        $pre_do = $curso->precio_2;
	        
	        $percent_ = $_POST['precio'] * 100 / $_POST['precio_ant'];
	        $percent = 100 - number_format($percent_, 2);
	         
	        $_POST['percent'] = number_format($percent, 0);
	        
	        $_POST['precio_2'] = $pre_do - ($pre_do * $percent/100);
	        
	        $p_dolar = explode(".", $_POST['precio_2']);
	        
	        $precio_dolar = "";
	        
	        /*echo $_POST['precio_2']."<br>";
	        echo $p_dolar[1]."<br>";*/
	        
	        if($p_dolar[1] == 5 || $p_dolar[1] == "50"){
	            $precio_dolar = $_POST['precio_2'];
	        }else{
	            $precio_dolar = number_format(round( $_POST['precio_2'], 0, PHP_ROUND_HALF_UP), 2);
	        }
			$_POST['precio_2'] = $precio_dolar;
			
			//print_r($_POST);
			
			echo $this->modelo3->insert_data("descuentos", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("descuentos", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("descuentos", array('id' => $_POST['id']));
	    }
	    function editarBD(){
	        
	        $curso = json_decode($this->modelo3->select_one("cursos", array("id" => $_POST['id_curso'])));
	        $pre_do = $curso->precio_2;
	        
	        $percent_ = $_POST['precio'] * 100 / $_POST['precio_ant'];
	        $percent = 100 - number_format($percent_, 2);
	         
	        $_POST['percent'] = number_format($percent, 0);
	        
	        $_POST['precio_2'] = $pre_do - ($pre_do * $percent/100);
	        
	        $p_dolar = explode(".", $_POST['precio_2']);
	        
	        $precio_dolar = "";
	        
	        /*echo $_POST['precio_2']."<br>";
	        echo $p_dolar[1]."<br>";*/
	        
	        if($p_dolar[1] == 5 || $p_dolar[1] == "50"){
	            $precio_dolar = $_POST['precio_2'];
	        }else{
	            $precio_dolar = number_format(round( $_POST['precio_2'], 0, PHP_ROUND_HALF_UP), 2);
	        }
			$_POST['precio_2'] = $precio_dolar;
			
			echo $this->modelo3->update_data("descuentos", $_POST, false);
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