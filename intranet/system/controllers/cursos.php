<?php
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3600);
ini_set('max_execution_time', 3600);
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
class cursos extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function cursos()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_cursos");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Cursos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Cursos";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Cursos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Cursos";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadcursosbyalumno()
	{
		$alumno = json_decode($this->modelo3->select_one("usuarios", array("id" => $_POST['id_alumno'])));
		echo $this->modelo3->select_all_where("cursos", array("id_grado" => $alumno->id_grado));
	}
	public function loadcursos()
	{
		$result = array();
		$cursos = json_decode($this->modelo3->select_all("cursos", true));
		foreach ($cursos as $key => $value) {
			$area = json_decode($this->modelo3->select_one("areas", array("id" => $value->id_area)));
			$grado = json_decode($this->modelo3->select_one("grados", array("id" => $value->id_grado)));

			$value->area = $area->area;
			$value->grado = $grado->grado;
			$result[] = $value;
		}

		echo json_encode($result);
	}
	function cursos_by()
	{
		$sql = "SELECT c.*, p.nombres, ca.categoria, n.nivel FROM cursos as c, profesores as p, categorias as ca, niveles as n WHERE c.id_profesor = p.id AND c.id_categoria = ca.id AND c.id_nivel = n.id AND c.id_profesor = " . $_POST['id'];
		echo $this->modelo3->run_query($sql, false);
	}
	function set_alarmas($id_docente)
	{
		$sql = "SELECT u.correo, u.id FROM usuarios as u, seguidores as s WHERE u.id = s.id_alumno AND s.id_profesor = " . $id_docente . ";";
		return $this->modelo3->run_query($sql, false);
	}
	function save()
	{
		$fileName = $_FILES["file1"]["name"];
		$fileTmpLoc = $_FILES["file1"]["tmp_name"];
		$fileType = $_FILES["file1"]["type"];
		$fileSize = $_FILES["file1"]["size"];
		$fileErrorMsg = $_FILES["file1"]["error"];

		if (!$fileTmpLoc) {
			//exit();
		}
		if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {
			$_POST["portada"] = $fileName;


			$sql = "SELECT u.id FROM usuarios as u, seguidores as s WHERE u.id = s.id_alumno AND s.id_profesor = " . $_POST['id_profesor'] . ";";
			$alus = json_decode($this->modelo3->run_query($sql, false));

			$docente_nombre = json_decode($this->modelo3->select_one("profesores", array("id" => $_POST['id_profesor'])));

			foreach ($alus as $key) {
				$data['id_usuario'] = $key->id;
				$data['estado'] = "0";
				$data['notificacion'] = $docente_nombre->nombres . " acaba de subir un curso nuevo que quizás te interese.";
				$this->modelo3->insert_data("notificaciones", $data, false);
			}
		} else {
		}

		echo $this->modelo3->insert_data("cursos", $_POST, false);
	}
	function add_index()
	{
		echo $this->modelo3->executor("UPDATE cursos set estado = 1 WHERE id = " . $_POST['id'], "update");
	}
	function rem_index()
	{
		echo $this->modelo3->executor("UPDATE cursos set estado = 0 WHERE id = " . $_POST['id'], "update");
	}
	function eliminar()
	{
		echo $this->modelo3->delete_data('cursos', array("id" => $_POST['id']));
	}
	function editar()
	{
		echo $this->modelo3->select_one("cursos", array('id' => $_POST['id_curso']));
	}
	function editarBD()
	{
		$rf = json_decode($this->modelo3->select_one("cursos", array('id' => $_POST['id'])));

		if ($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0) {
			$_POST['portada'] = $rf->portada;
		} else {
			$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
				exit();
			}
			if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {
				$_POST["portada"] = $fileName;
			} else {
			}
		}

		echo $this->modelo3->update_data("cursos", $_POST);
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
