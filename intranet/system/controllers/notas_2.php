<?php
/*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

class notas_2 extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function notas_2()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_notas_2");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Reporte de Notas por Alumno";
			$c["content"] = $this->html->container();
			$c["title"]   = "Reporte de Notas por Alumno";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Reporte de Notas por Alumno";
			$c["content"] = $this->html->container();
			$c["title"]   = "Reporte de Notas por Alumno";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadnotas()
	{
		if ($_GET['id_alumno'] < 0 || empty($_GET['id_alumno']) || is_null($_GET['id_alumno'])) {
			echo json_encode(array());
		} else {
			$sql = "SELECT n.*, nn.nota FROM notas as n LEFT JOIN tbl_notas nn ON nn.id_nota = n.id AND nn.id_alumno = " . $_GET['id_alumno'] . " AND nn.id_curso = " . $_GET['id_curso'];
			echo $this->modelo3->run_query($sql, false);
		}
	}
	public function cargar_excel()
	{
		require_once __DIR__ . '/simplexlsx/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';
		$fileName = $_FILES["archivo"]["name"];
		$fileTmpLoc = $_FILES["archivo"]["tmp_name"];
		$fileType = $_FILES["archivo"]["type"];
		$fileSize = $_FILES["archivo"]["size"];
		$fileErrorMsg = $_FILES["archivo"]["error"];
		if (!$fileTmpLoc) {
		}

		if (move_uploaded_file($fileTmpLoc, __DIR__ . "/upload/excels/$fileName")) {
			$excel = $fileName;
			$archivo = __DIR__ . "/upload/excels/" . $excel;
		}
		$u = 0;
		if ($xlsx = SimpleXLSX::parse($archivo)) {

			$data_detalle = array();
			foreach ($xlsx->rows() as $key) {

				if ($u <= 2) {
				} else {
					if (empty($key[0])) {
					} else {
						//echo $key[1];
						$alumno = json_decode($this->modelo3->select_one("usuarios", array('dni' => $key[0])));

						$data_detalle[] = array(
							'id_alumno' => $alumno->id,
							'examen' => $key[4],
							'id_examen' => 299,
							'fecha' => date("Y-m-d H:i:s"),
						);
					}
				}
				$u++;
			}

			try {

				$this->modelo3->con->beginTransaction(); // also helps speed up your inserts.

				$datafields = array('id_alumno', 'examen', 'id_examen', 'fecha');

				$insert_values = array();
				foreach ($data_detalle as $d) {
					$question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
					$insert_values = array_merge($insert_values, array_values($d));
				}

				$sql = "INSERT INTO tbl_notas (" . implode(",", $datafields) . ") VALUES " .
					implode(',', $question_marks);

				/*//echo $sql;
					print_r($insert_values);*/
				$stmt = $this->modelo3->con->prepare($sql);
				$stmt->execute($insert_values);
				$this->modelo3->con->commit();
				$result = array(
					'Result' => 'OK',
					'Message' => 'OK'
				);
				echo json_encode($result);
			} catch (Exception $e) {
				$this->modelo3->con->rollBack();
				$result = array(
					'Result' => 'ERROR',
					'Message' => $e->getMessage()
				);
				echo json_encode($result);
			}
		} else {
			echo SimpleXLSX::parseError();
		}
	}
	function placeholders($text, $count = 0, $separator = ",")
	{
		$result = array();
		if ($count > 0) {
			for ($x = 0; $x < $count; $x++) {
				$result[] = $text;
			}
		}

		return implode($separator, $result);
	}
	function save()
	{
		echo $this->modelo3->insert_data("niveles", $_POST, false);
	}
	function eliminar()
	{
		echo $this->modelo3->delete_data("tbl_notas", array('id' => $_POST['id']));
	}
	function editar()
	{
		echo $this->modelo3->select_one("niveles", array('id' => $_POST['id_nivel']));
	}
	function editarBD()
	{
		echo $this->modelo3->update_data("tbl_notas", $_POST);
	}
	function actualizar_nota()
	{
		$nota = json_decode($this->modelo3->select_one("tbl_notas", array(
			"id_alumno" => $_POST['id_alumno'],
			"id_curso" => $_POST['id_curso'],
			"id_nota" => $_POST['id']
		)));
		if (is_null($nota) || empty($nota)) {
			$sql = "INSERT INTO tbl_notas (id_alumno, nota, id_nota, id_curso) VALUES(" . $_POST['id_alumno'] . ", " . $_POST['nota'] . ", " . $_POST['id'] . ", " . $_POST['id_curso'] . ")";
			echo $this->modelo3->executor($sql, "update");
		} else {
			$sql = "UPDATE tbl_notas SET nota = " . $_POST['nota'] . " WHERE id_alumno = " . $_POST['id_alumno'] .
				" AND id_curso = " . $_POST['id_curso'] .
				" AND id_nota = " . $_POST['id'];
			echo $this->modelo3->executor($sql, "update");
		}
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
