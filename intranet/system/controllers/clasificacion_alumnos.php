<?php
class clasificacion_alumnos extends f
{
	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";
	function clasificacion_alumnos()
	{
		session_start();
		$this->html_basico = $this->load()->lib("Html_basico");
		$this->html        = $this->load()->lib("html_clasificacion_alumnos");
		$this->modelo      = $this->load()->model("modelo");
		$this->baseurl     = BASEURL;
		$this->modelo2     = $this->load()->model("MySQLiManager");
		$this->modelo3     = $this->load()->model("Monodon");
	}
	function index()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Clasificacion de Alumnos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Clasificacion de Alumnos";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Clasificacion de Alumnos";
			$c["content"] = $this->html->container();
			$c["title"]   = "Clasificacion de Alumnos";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	public function guardaraforo()
	{
		$this->modelo3->execute_query("UPDATE aulas set aforo = :aforo where id = :id", $_POST);
		echo json_encode(array("Result" => "OK"));
	}
	public function loadaulas()
	{
		$this->modelo3->execute_query("UPDATE usuarios set id_aula  = :id_aula", array("id_aula" => null));

		$fecha = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 days"));
		$estado = true;
		$sabados = 0;
		$sabados_array = array();
		while ($estado) {
			if ($sabados >= 1) {
				$estado = false;
			}
			if (date("w", strtotime($fecha)) == 6) {
				$sabados++;
				$sabados_array[] = $fecha;
			}
			$fecha = date("Y-m-d", strtotime($fecha . "- 1 days"));
		}

		$sql = "SELECT u.id, CONCAT(u.nombres, ' ', u.apellidos) as alumno, round(AVG(n.examen), 2) promedio, u.id_aula_designada from usuarios as u LEFT JOIN tbl_notas as n ON u.id = n.id_alumno AND DATE_FORMAT(n.fecha, '%Y-%m-%d') BETWEEN '" . end($sabados_array) . "' AND '" . $sabados_array[0] . "' LEFT JOIN tbl_examenes as e ON n.id_examen = e.id WHERE u.id_ciclo not in (27, 28, 29, 30) GROUP BY id, nombres ORDER BY promedio desc ";
		//echo $sql;
		//return;
		$promedios = json_decode($this->modelo3->run_query($sql));

		if (sizeof($promedios) == 0) {
			$fecha = date("Y-m-d", strtotime(date("Y-m-d") . "+ 1 days"));
			$estado = true;
			$domingos = 0;
			$domingos_array = array();
			while ($estado) {
				if ($domingos >= 1) {
					$estado = false;
				}
				if (date("w", strtotime($fecha)) == 0) {
					$domingos++;
					$domingos_array[] = $fecha;
				}
				$fecha = date("Y-m-d", strtotime($fecha . "- 1 days"));
			}
			$sql = "SELECT u.id, CONCAT(u.nombres, ' ', u.apellidos) as alumno, round(AVG(n.examen), 2) promedio from usuarios as u, tbl_notas as n, tbl_examenes as e WHERE u.id = n.id_alumno and n.id_examen = e.id and DATE_FORMAT(n.fecha, '%Y-%m-%d') BETWEEN '" . end($domingos_array) . "' AND '" . $domingos_array[0] . "' WHERE u.id_ciclo not in (27, 28, 29, 30) GROUP BY id, nombres order by promedio desc ";
			$promedios = json_decode($this->modelo3->run_query($sql));
		}

		$aulas = "SELECT * FROM aulas where aforo > 0 order by orden ASC";
		$result = $this->modelo2->select('', '', '', $aulas);

		$inicio = 0;
		$values = array();
		$i = 0;
		foreach ($promedios as $key) {

			if ($result[$i]['aforo'] <= 1) {
				// echo $result[$i]['aula'] . " " . $result[$i]['aforo'];
				$i++;
			} else {
				$result[$i]['aforo'] = $result[$i]['aforo'] - 1;
			}
			// echo $key->alumno . " => " . $result[$i]['aula'] . " => " . $result[$i]['aforo'] ."<br>";
			$values[] = array(
				"alumno" => $key->alumno,
				"aula" => $result[$i]['aula'],
				"aforo" => $result[$i]['aforo'],
				"promedio" => $key->promedio
			);

			$d = array(
				"id_aula" => $result[$i]['id'],
				"id" => $key->id
			);
			$this->modelo3->execute_query("UPDATE usuarios set id_aula  = :id_aula where id = :id", $d);
		}

		echo json_encode($values);
	}
	function save()
	{
		$this->modelo2->insert("aulas", $_POST);
	}
	function eliminar()
	{
		$id  = $_POST['id'];
		$param = "id = " . $id;
		$this->modelo2->delete('aulas', $param, true);
	}
	function editar()
	{
		$where = " id = " . $_POST['id'];
		echo json_encode($this->modelo2->select("*", "aulas", $where, ''));
	}
	function editarBD()
	{
		$data["aula"] = $_POST["aula"];
		$this->modelo->update("aulas", $data, array("id" => $_POST['id']));
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
