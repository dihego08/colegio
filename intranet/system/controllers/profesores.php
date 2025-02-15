<?php
class profesores extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function profesores()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_profesores");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Profesores";
			$c["content"] = $this->html->container();
			$c["title"]   = "Profesores";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Profesores";
			$c["content"] = $this->html->container();
			$c["title"]   = "Profesores";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function get_docente()
	{
		$sql = "SELECT * FROM profesores WHERE apellidos LIKE '%" . $_GET['term'] . "%' OR nombres like '%" . $_GET['term'] . "%'";
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
	public function loadprofesores()
	{
		echo $this->modelo3->select_all("profesores", true);
	}
	function add_index()
	{
		echo $this->modelo3->executor("UPDATE profesores set estado = 1 WHERE id = " . $_POST['id'], "update");
	}
	function rem_index()
	{
		echo $this->modelo3->executor("UPDATE profesores set estado = 0 WHERE id = " . $_POST['id'], "update");
	}
	function save()
	{
		$_POST['foto'] = "";
		$_POST['foto_2'] = "";
		$_POST['seguidores_i'] = rand(200, 400);
		$aux = 0;
		$fileName = $_FILES["file1"]["name"];
		$fileTmpLoc = $_FILES["file1"]["tmp_name"];
		$fileType = $_FILES["file1"]["type"];
		$fileSize = $_FILES["file1"]["size"];
		$fileErrorMsg = $_FILES["file1"]["error"];
		if (!$fileTmpLoc) {
			//exit();
		}

		if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {
			$_POST['foto'] = $fileName;
			$aux++;
		} else {
		}

		$_POST['pass'] = md5($_POST['pass']);

		echo $this->modelo3->insert_data("profesores", $_POST, false);
	}
	function eliminar()
	{
		$id  = $_POST['id'];
		$param = "id = " . $id;
		$this->modelo2->delete('profesores', $param, true);
	}
	function editar()
	{
		echo $this->modelo3->select_one("profesores", array('id' => $_POST['id']));
	}
	function editarBD()
	{
		$rf = json_decode($this->modelo3->select_one("profesores", array('id' => $_POST['id'])));
		$_POST['seguidores_i'] = $rf->seguidores_i;
		$_POST['estado'] = $rf->estado;

		if ($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0) {
			$_POST["foto"] = $rf->foto;

			if (!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null) {
				$_POST["pass"] = $rf->pass;
			} else {
				$_POST["pass"] = md5($_POST['pass']);
			}
		} else {
			$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
				//exit();
			}
			if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {

				$_POST["foto"] = $fileName;
				if (!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null) {
					$_POST["pass"] = $rf->pass;
				} else {
					$_POST["pass"] = md5($_POST['pass']);
				}
			} else {
			}
		}


		echo $this->modelo3->update_data("profesores", $_POST);
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
