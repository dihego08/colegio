<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class tipo_estudiantes extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function tipo_estudiantes()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_tipo_estudiantes");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		//$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo2     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Tipos de Estudiantes";
			$c["content"] = $this->html->container();
			$c["title"]   = "Tipos de Estudiantes";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Tipos de Estudiantes";
			$c["content"] = $this->html->container();
			$c["title"]   = "Tipos de Estudiantes";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadtipo_estudiante()
	{
		echo $this->modelo2->select_all("tipo_estudiantes", true);
	}
	function save()
	{
		echo $this->modelo2->insert_data("tipo_estudiantes", $_POST, false);
	}
	function eliminar()
	{
		echo $this->modelo2->delete_data('tipo_estudiantes', array("id" => $_POST["id"]));
	}
	function editar()
	{
		echo $this->modelo2->select_one("tipo_estudiantes", array("id" => $_POST["id"]));
	}
	function editarBD()
	{
		echo $this->modelo2->update_data("tipo_estudiantes", $_POST);
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
