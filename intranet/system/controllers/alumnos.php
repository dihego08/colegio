<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
class alumnos extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function alumnos()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_alumnos");
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
	public function get_alumno_dni()
	{
		$sql = "SELECT * FROM alumnos WHERE dni LIKE '%" . $_GET['term'] . "%'";
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
	function add_index()
	{
		echo $this->modelo2->executor("UPDATE usuarios set estado = 1 WHERE id = " . $_POST['id'], "update");
	}
	function rem_index()
	{
		echo $this->modelo2->executor("UPDATE usuarios set estado = 0 WHERE id = " . $_POST['id'], "update");
	}
	public function get_alumno()
	{
		$sql = "SELECT * FROM alumnos WHERE apellidos LIKE '%" . $_GET['term'] . "%' OR nombres like '%" . $_GET['term'] . "%'";
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

	public function by_padre()
	{
		$where = " id_padre = " . $_POST['id'];
		$result = $this->modelo2->select('*', 'alumnos', $where, '');
		echo json_encode($result);
	}
	public function get_tipo_estudiantes()
	{
		echo $this->modelo2->select_all("tipo_estudiantes", true);
	}
	public function loadalumnos()
	{
		/*$sql = "SELECT us.*, g.grupo, a.area, u.universidad, ci.ciclo, c.carrera FROM usuarios as us, grupos as g, areas as a, universidades as u, carreras as c, ciclos as ci WHERE us.id_grupo = g.id AND g.id_ciclo = ci.id AND us.id_carrera = c.id AND c.id_universidad = u.id AND ci.id_universidad = u.id AND c.id_area = a.id";*/
		$sql = "SELECT us.* , g.grado FROM usuarios as us left join grados as g on us.id_grado = g.id ;";

		$alumnos = json_decode($this->modelo2->run_query($sql, false));

		$result = array();
		foreach ($alumnos as $key => $value) {
			unset($value->pass);
			$correos = "";

			$value->carrera = "<p><span class=\"w-100\" style=\"display: block;\">" . $value->carrera . "</span><small>" . $value->area . " - " . $value->universidad . "</small></p>";
			$value->ciclo = "<p class=\"text-center\"><span class=\"w-100\" style=\"display: block;\">" . $value->ciclo . " -</span><small>" . $value->grupo . "</small></p>";

			$result[] = $value;
		}
		echo json_encode($result);
	}
	public function get_alumnos()
	{
		$sql = "SELECT * FROM usuarios";
		$alumnos = json_decode($this->modelo2->run_query($sql, false));

		$result = array();
		foreach ($alumnos as $key => $value) {
			unset($value->pass);
			$result[] = $value;
		}
		echo json_encode($result);
	}
	public function loadalumnos_2()
	{
		$sql = "SELECT * FROM usuarios";
		$alumnos = json_decode($this->modelo2->run_query($sql, false));

		$result = array();
		foreach ($alumnos as $key => $value) {
			unset($value->pass);
			$correos = "";

			$value->correo = "";

			$el_area = "";
			$la_carrera = "";
			$la_universidad = "";
			if ($value->id_carrera == "" || is_null($value->id_carrera) || $value->id_carrera == 0) {
				$universidad = json_decode($this->modelo2->select_one("universidades", array("id" => $value->id_universidad)));
				$la_universidad = $universidad->universidad;
			} else {
				$carrera = json_decode($this->modelo2->select_one("carreras", array("id" => $value->id_carrera)));
				$universidad = json_decode($this->modelo2->select_one("universidades", array("id" => $carrera->id_universidad)));
				$area = json_decode($this->modelo2->select_one("areas", array('id' => $carrera->id_area)));

				$el_area = $area->area;
				$la_carrera = $carrera->carrera;
				$la_universidad = $universidad->universidad;
			}
			$el_ciclo = "";
			if ($value->id_ciclo == "" || is_null($value->id_ciclo) || $value->id_ciclo == 0) {
			} else {
				$ciclo = json_decode($this->modelo2->select_one("ciclos", array("id" => $value->id_ciclo)));
				$el_ciclo = $ciclo->ciclo;
			}


			$el_grupo = "";
			$grupo = json_decode($this->modelo2->select_one("grupos", array("id" => $value->id_grupo)));
			if (count($grupo) > 0) {
				$el_grupo = $grupo->grupo;
			} else {
			}

			$value->carrera = "<p><span class=\"w-100\" style=\"display: block;\">" . $la_carrera . "</span><small>" . $el_area . " - " . $la_universidad . "</small></p>";
			$value->ciclo = "<p class=\"text-center\"><span class=\"w-100\" style=\"display: block;\">" . $el_ciclo . " -</span><small>" . $el_grupo . "</small></p>";

			$result[] = $value;
		}
		echo json_encode($result);
	}
	function save()
	{
		$_POST['foto'] = "";
		$aux = 0;
		$fileName = $_FILES["foto"]["name"];
		$fileTmpLoc = $_FILES["foto"]["tmp_name"];
		$fileType = $_FILES["foto"]["type"];
		$fileSize = $_FILES["foto"]["size"];
		$fileErrorMsg = $_FILES["foto"]["error"];
		if (!$fileTmpLoc) {
			//exit();
		}

		if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/photo/$fileName")) {
			$_POST['foto'] = $fileName;
			$aux++;
		} else {
		}

		$_POST['pass'] = md5($_POST['pass']);

		$alumno = json_decode($this->modelo2->select_one("usuarios", array("dni" => $_POST["dni"])));

		if (isset($alumno->nombres)) {
			echo json_encode(array("Result" => "ERROR", "Code" => "125"));
		} else {
			echo $this->modelo2->insert_data("usuarios", $_POST, false);
		}
	}
	function eliminar()
	{
		echo $this->modelo2->delete_data('usuarios', array("id" => $_POST["id"]));
	}
	function editar()
	{
		$alumno = json_decode($this->modelo2->select_one("usuarios", array("id" => $_POST["id"])));

		unset($alumno->pass);

		$pago = json_decode($this->modelo2->select_one("pagos", array("id_usuario" => $_POST["id"])));

		$alumno->n_cuotas = $pago->n_cuotas;
		$alumno->monto = $pago->monto;

		echo json_encode($alumno);
	}
	function editarBD()
	{
		$rf = json_decode($this->modelo2->select_one("usuarios", array('id' => $_POST['id'])));

		$_POST['estado'] = $rf->estado;
		if ($_FILES['foto']['size'] == 0 && $_FILES['foto']['error'] == 0) {
			$_POST["foto"] = $rf->foto;
			if (!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null) {
				$_POST["pass"] = $rf->pass;
			} else {
				$_POST["pass"] = md5($_POST['pass']);
			}
		} else {
			if (!isset($_POST['pass']) || $_POST['pass'] == "" || $_POST['pass'] == null) {
				$_POST["pass"] = $rf->pass;
			} else {
				$_POST["pass"] = md5($_POST['pass']);
			}
			$fileName = $_FILES["foto"]["name"];
			$fileTmpLoc = $_FILES["foto"]["tmp_name"];
			$fileType = $_FILES["foto"]["type"];
			$fileSize = $_FILES["foto"]["size"];
			$fileErrorMsg = $_FILES["foto"]["error"];
			if (!$fileTmpLoc) {
				//exit();
			}
			if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/photo/$fileName")) {
				$_POST["foto"] = $fileName;
			} else {
				$_POST["foto"] = "";
			}
		}
		$_POST['updated_at'] = date("Y-m-d H:i:s");
		echo $this->modelo2->update_data("usuarios", $_POST);
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
