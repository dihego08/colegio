<?php
class videos_web extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function videos_web()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_videos_web");
		$this->modelo      = $this->load()->model("modelo");
		//$this->gi3         = $this->load()->getid3("getid3");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Vídeos en la Pagina Web";
			$c["content"] = $this->html->container();
			$c["title"]   = "Vídeos en la Pagina Web";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Vídeos en la Pagina Web";
			$c["content"] = $this->html->container();
			$c["title"]   = "Vídeos en la Pagina Web";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadvideos()
	{
		echo $this->modelo3->select_all("videos_web", true);
	}
	function save()
	{
		echo $this->modelo3->insert_data("videos_web", $_POST, false);
	}
	function eliminar()
	{
		echo $this->modelo3->delete_data("videos_web", array('id' => $_POST['id']));
	}
	function editar()
	{
		echo $this->modelo3->select_one("videos_web", array('id' => $_POST['id']));
	}
	function editarBD()
	{
		echo $this->modelo3->update_data("videos_web", $_POST);
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
