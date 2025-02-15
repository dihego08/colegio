<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
class inscripciones extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function inscripciones()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_inscripciones");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		//$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo2     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Alumnos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Alumnos";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Alumnos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Alumnos";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadinscripciones()
	{
		$sql = "SELECT * FROM inscripciones_taller";
		//echo $this->modelo2->run_query($sql, false);
		$alumnos = json_decode($this->modelo2->run_query($sql, false));

		$result = array();
		foreach ($alumnos as $key => $value) {
			$tipo_estudiante = json_decode($this->modelo2->select_one("tipo_estudiantes", array("id" => $value->id_tipo_estudiante)));
			$value->tipo_estudiante = $tipo_estudiante->tipo_estudiante;

			$result[] = $value;
		}
		echo json_encode($result);
	}
	private function valida($level)
	{
		if (isset($_SESSION["user_level"])) {
			if ($_SESSION["user_level"] == $level) {
				return true;
			} else
				return false;
		} else
			return false;
	}
	private function View($header, $content)
	{
		$h = $this->load()->view('header');
		$h->PrintHeader($header);
		$c = $this->load()->view('content');
		$c->PrintContent($content);
		$f = $this->load()->view('footer');
		$f->PrintFooter();
	}
}
