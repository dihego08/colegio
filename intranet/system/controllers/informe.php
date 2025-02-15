<?php
/*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

class informe extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function informe()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_informe");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Informe Académico por Alumno";
			$c["content"] = $this->html->container();
			$c["title"]   = "Informe Académico por Alumno";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Informe Académico por Alumno";
			$c["content"] = $this->html->container();
			$c["title"]   = "Informe Académico por Alumno";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function loadnotas()
	{
		$result = array();

		$id_alumno = $_GET['id_alumno'];
		$fecha_desde = $_GET['fecha_desde'] . "-1";
		$fecha_hasta = $_GET['fecha_desde'] . "-" . date("t", strtotime($fecha_desde));

		$sql_notas = "SELECT n.*, CONCAT(u.nombres, ' ', u.apellidos) AS alumno, e.identificador, n.fecha as fecha_examen FROM tbl_notas as n, usuarios as u, tbl_examenes as e WHERE n.id_alumno = u.id AND n.id_examen = e.id AND n.id_alumno = " . $_GET['id_alumno'] . " AND YEAR(n.fecha) = " . date("Y", strtotime($fecha_desde)) . " AND MONTH(n.fecha) = " . date("m", strtotime($fecha_desde));
		//echo $this->modelo3->run_query($sql, false);

		$sql = "SELECT * FROM asistencias WHERE id_alumno = " . $id_alumno . " AND fecha BETWEEN '" . $fecha_desde . "' AND '" . $fecha_hasta . "'";

		$sql_2 = "SELECT * FROM asistencias_new WHERE id_usuario = " . $id_alumno . " AND fecha BETWEEN '" . $fecha_desde . "' AND '" . $fecha_hasta . "'";

		$asistencias_1 = json_decode($this->modelo3->run_query($sql, false));

		$asistencias_2 = json_decode($this->modelo3->run_query($sql_2, false));

		echo json_encode(
			array(
				'asistencias_1' => $asistencias_1,
				'asistencias_2' => $asistencias_2,
				"notas" => json_decode($this->modelo3->run_query($sql_notas, false))
			)
		);
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
			//print_r($data_detalle);


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
