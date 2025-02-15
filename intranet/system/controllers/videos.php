<?php
class videos extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function videos()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_videos");
		$this->modelo      = $this->load()->model("modelo");
		//$this->gi3         = $this->load()->getid3("getid3");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Vídeos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Vídeos";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Vídeos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Vídeos";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function get_docente()
	{
		$sql = "SELECT * FROM categorias WHERE apellidos LIKE '%" . $_GET['term'] . "%' OR nombres like '%" . $_GET['term'] . "%'";
		$result = $this->modelo2->select('', '', '', $sql);
		$values = array();
		foreach ($result as $key) {
			$values[] = array(
				'id' => $key['id'],
				'value' => $key['apellidos'] . ", " . $key['nombres']
			);
		}
		echo json_encode($values);
	}
	public function get_one()
	{
		$sql = "SELECT * FROM docentes WHERE id = " . $_GET['id_docente'];
		$result = $this->modelo2->select('', '', '', $sql);
		echo json_encode($result);
	}
	public function loadvideos()
	{
		$sql = "SELECT v.*, ci.id as id_ciclo, ci.ciclo, g.grupo, g.id as id_grupo, cu.id as id_curso, cu.curso FROM videos as v, ciclos as ci, grupos as g, cursos as cu WHERE v.id_curso = cu.id AND cu.id_grupo = g.id AND g.id_ciclo = ci.id";
		echo $this->modelo3->run_query($sql, false);
	}
	public function ver_materiales()
	{
		$materiales =  json_decode($this->modelo3->select_all_where("materiales", array("id_video" => $_POST['id_video'])));
		$video = json_decode($this->modelo3->select_one("videos", array("id" => $_POST['id_video'])));

		$result = array();

		foreach ($materiales->Records as $key => $value) {
			$result[] = array(
				'material' => $value->material
			);
		}
		if ($video->material_adicional == "" || is_null($video->material_adicional)) {
			
		}else{
			$result[] = array(
				'material' => $video->material_adicional
			);
		}

		echo json_encode($result);
	}
	function save()
	{	
		$_POST['material_adicional'] = "";
		$result = json_decode($this->modelo3->insert_data("videos", $_POST, false));
		for ($i = 0; $i < count($_FILES['file']['name']); $i++) { 
			$data = array();

			$fileName = $_FILES["file"]["name"][$i];
			$fileTmpLoc = $_FILES["file"]["tmp_name"][$i];
			$fileType = $_FILES["file"]["type"][$i];
			$fileSize = $_FILES["file"]["size"][$i];
			$fileErrorMsg = $_FILES["file"]["error"][$i];
			if (!$fileTmpLoc) {
			}

			if (move_uploaded_file($fileTmpLoc, "system/controllers/material_adicional/$fileName")) {
				$data['material'] = $fileName;
				$data['id_video'] = $result->LID;

				$this->modelo3->insert_data("materiales", $data, false);
			} else {
			}
		}

		echo  json_encode(array("Result" => "OK"));
	}
	function eliminar()
	{
		echo $this->modelo3->delete_data("videos", array('id' => $_POST['id']));
	}
	function editar()
	{
		echo $this->modelo3->select_one("categorias", array('id' => $_POST['id_categoria']));
	}
	function editarBD()
	{
		echo $this->modelo3->update_data("categorias", $_POST);
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
