<?php
	class aulas extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function aulas() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_aulas");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
			$this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Aulas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Aulas";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Aulas";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Aulas";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
		public function guardaraforo()
		{
			$this->modelo3->execute_query("UPDATE aulas set aforo = :aforo where id = :id", $_POST);
			echo json_encode(array("Result" => "OK"));
		}
	    public function loadaulas() {
	        if ($this->valida(5)) {
	             $sql= "select * from aulas";   
	        } elseif ($this->valida(3)) {
	            $sql="select * from aulas";
	        }
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result);
	    }
	    function save(){
	        $this->modelo2->insert("aulas", $_POST);
	    }
	    function eliminar(){
	        $id  = $_POST['id'];
	        $param = "id = " . $id;
	        $this->modelo2->delete('aulas', $param, true);
	    }
	    function editar(){
	        $where = " id = " . $_POST['id'];
	        echo json_encode($this->modelo2->select("*", "aulas", $where, ''));
	    }
	    function editarBD(){
	        $data["aula"] = $_POST["aula"];
			$data["aforo"] = $_POST["aforo"];
			$data["orden"] = $_POST["orden"];
	        $this->modelo->update("aulas", $data, array("id" => $_POST['id']));
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