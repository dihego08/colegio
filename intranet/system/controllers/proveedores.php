<?php
//tabla t_proveedores
class proveedores extends f
{

	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 = "";

	function proveedores()
	{
		session_start();
		$this->html_basico =  $this->load()->lib("Html_basico");
		$this->html =  $this->load()->lib("html_proveedores");
		$this->modelo = $this->load()->model("modelo");
		$this->baseurl = BASEURL;
		$this->modelo2 = $this->load()->model("MySQLiManager");
	}

	function index()
	{
		if ($this->valida(5)) {

			$h["title"] = "Proveedores";
			$c["content"] = $this->html->containerUsers();
			$c["title"] = "Proveedores";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {

			$h["title"] = "Proveedores";
			$c["content"] = $this->html->containerUsers();
			$c["title"] = "Proveedores";
			$this->View($h, $c);
		} else
			$this->Login();
	}
	function loadProveedores()
	{
		if ($this->valida(5)) {
			$sql = "select * from `t_proveedores`";
		} elseif ($this->valida(3)) {
			$sql = "select * from `t_proveedores`";
		}
		$result = $this->modelo2->select('', '', '', $sql);
		//echo json_encode($result);

		$data = array();
		foreach ($result as $value) {
			array_push($data, array(
				'id' => mb_strtoupper(strval($value['id'])),
				'pro_ruc' => mb_strtoupper(strval($value['pro_ruc'])),
				'pro_razonsocial' => mb_strtoupper(strval($value['pro_razonsocial'])),
				'pro_direccion' => mb_strtoupper(strval($value['pro_direccion'])),
				'pro_telefono' => mb_strtoupper(strval($value['pro_telefono'])),
			));
		}
		echo json_encode($data, JSON_PRETTY_PRINT);
	}
	function nuevo()
	{
		if ($this->valida(5)) {
			$h["title"]   = "Agregar Nuevo Proveedor";
			$c["content"] = $this->html->nuevo($this->modelo->db->query("select * from valores order by id asc"));
			$c["title"]   = "Agregar Nuevo Proveedor";
			$this->View($h, $c);
		} elseif ($this->valida(3)) {
			$h["title"]   = "Agregar Nuevo Proveedor";
			$c["content"] = $this->html->nuevo($this->modelo->db->query("select * from valores order by id asc"));
			$c["title"]   = "Agregar Nuevo Proveedor";
			$this->View($h, $c);
		} else
			$this->Login();
	}


	function save()
	{
		if ($this->valida(5)) {
			$rs_dup = $this->modelo->db->query("select id from t_proveedores where pro_ruc='" . $_POST["ruc"] . "'");

			if (count($rs_dup) > 0) {
				echo "Proveedor ya existe.";
				die();
			}

			$data["pro_telefono"] = $_POST["telefono"];
			$data["pro_ruc"] = $_POST["ruc"];
			$data["pro_razonsocial"] = $_POST["empresa"];
			$data["pro_direccion"] = $_POST["direccion"];
			$this->modelo->insert("t_proveedores", $data);
			echo json_encode(array("Result" => "OK"));
		} elseif ($this->valida(3)) {
			$rs_dup = $this->modelo->db->query("select id from t_proveedores where pro_ruc='" . $_POST["ruc"] . "'");

			if (count($rs_dup) > 0) {
				echo "Proveedor  ya existe.";
				die();
			}

			$data["pro_telefono"] = $_POST["telefono"];
			$data["pro_ruc"] = $_POST["ruc"];
			$data["pro_razonsocial"] = $_POST["empresa"];
			$data["pro_direccion"] = $_POST["direccion"];
			$this->modelo->insert("t_proveedores", $data);
			echo json_encode(array("Result" => "OK"));
		} else
			echo "Error 404";
	}
	function editar()
	{
		if (!$this->valida(5)) {
			echo "Error 404 ";
		} else {
			$sql = "select * from t_proveedores where id=" . $_POST['id'];
			$result = $this->modelo2->select('', '', '', $sql);
			echo json_encode($result);
		}
	}
	function editarBD()
	{
		if ($this->valida(5)) {
			$data["pro_telefono"] = $_POST["telefono"];
			$data["pro_ruc"] = $_POST["ruc"];
			$data["pro_razonsocial"] = $_POST["empresa"];
			$data["pro_direccion"] = $_POST["direccion"];

			$this->modelo->update("t_proveedores", $data, array("id" => $_POST['id']));
			header("Location: http://iacorp.top/sisventademo/?/proveedores/");
		} elseif ($this->valida(3)) {
			$data["pro_telefono"] = $_POST["telefono"];
			$data["pro_ruc"] = $_POST["ruc"];
			$data["pro_razonsocial"] = $_POST["empresa"];
			$data["pro_direccion"] = $_POST["direccion"];

			$this->modelo->update("t_proveedores", $data, array("id" => $_POST['id']));
			header("Location: http://iacorp.top/sisventademo/?/proveedores/");
		} else
			echo "Error 404";
	}

	function updateUser()
	{
		if ($this->valida(5)) {
			$data["nombre"] = $_POST["nombre"];
			$data["agencia"] = $_POST["agencia"];
			$data["telef"] = $_POST["telefono"];
			$data["direccion"] = $_POST["direccion"];
			$data["cod_cliente"] = $_POST["cod_cliente"];
			$data["celular"] = $_POST["celular"];
			$data["ruc"] = $_POST["ruc"];
			$data["dni"] = $_POST["dni"];

			$this->modelo->update("clientes", $data, array("id_client" => $_POST['id']));
			echo "Guardado";
		} elseif ($this->valida(3)) {


			$data["nombre"] = $_POST["nombre"];
			$data["agencia"] = $_POST["agencia"];
			$data["telef"] = $_POST["telefono"];
			$data["direccion"] = $_POST["direccion"];
			$data["cod_cliente"] = $_POST["cod_cliente"];
			$data["celular"] = $_POST["celular"];
			$data["ruc"] = $_POST["ruc"];
			$data["dni"] = $_POST["dni"];

			$this->modelo->update("clientes", $data, array("id_client" => $_POST['id']));
			echo "Guardado";
		} else
			echo "Error 404";
	}

	function delete()
	{
		if ($this->valida(5)) {
			$this->modelo->delete("t_proveedores", "id", $_POST['id']);
			echo "Eliminado";
		} elseif ($this->valida(3)) {

			$this->modelo->delete("t_proveedores", "id", $_POST['id']);
			echo "Eliminado";
		} else
			echo "Error 404";
	}
	function getProveedores()
	{
		if ($this->valida(5)) {
			echo $this->html->listProveedores($this->modelo->db->query('SELECT *  FROM t_proveedores WHERE pro_ruc LIKE "%' . $_POST['text'] . '%" or pro_razonsocial LIKE "%' . $_POST['text'] . '%" '));
		} elseif ($this->valida(3)) {
			echo $this->html->listProveedores($this->modelo->db->query('SELECT *  FROM t_proveedores WHERE pro_ruc LIKE "%' . $_POST['text'] . '%" or pro_razonsocial LIKE "%' . $_POST['text'] . '%" '));
		} else
			echo "Error 404";
	}

	function Login()
	{

		$h["title"] = "Iniciar Sesi&oacute;n";
		$c["title"] = "Iniciar Sesi&oacute;n";
		$c["content"] = $this->html_basico->FormLogin();

		$this->View($h, $c);
	}
	public function mostrar_select()
	{
		$sql = "select * from `t_proveedores`";
		$proveedores = $this->modelo2->select('', '', '', $sql);

		foreach ($proveedores as $value) {
			echo '<option value="' . $value['id'] . '">' . $value['pro_razonsocial'] . ' - ' . $value['pro_ruc'] . '</option>';
		}
	}
	private function filter($data)
	{
		$data = trim(htmlentities(strip_tags($data)));

		if (get_magic_quotes_gpc())
			$data = stripslashes($data);

		$data = mysql_real_escape_string($data);

		return $data;
	}
	private function GenKey($length = 7)
	{
		$password = "";
		$possible = "0123456789abcdefghijkmnopqrstuvwxyz";

		$i = 0;

		while ($i < $length) {


			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);


			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}

		return $password;
	}
	private function PwdHash($pwd, $salt = null)
	{
		if ($salt === null) {
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
		} else {
			$salt = substr($salt, 0, 9);
		}
		return $salt . sha1($pwd . $salt);
	}
	private function GenPwd($length = 7)
	{
		$password = "";
		$possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels

		$i = 0;

		while ($i < $length) {


			$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);


			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}



	private	function valida($level)
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
	private function random_string($lenght = 6)
	{
		$str = "";
		for ($i = 1; $i <= $lenght; $i++) {
			$part = mt_rand(0, 2);
			switch ($part) {
				case 0:
					$str .= mt_rand(0, 9);
					break;
				case 1:
					$str .= chr(mt_rand(65, 90));
					break;
				case 2:
					$str .= chr(mt_rand(97, 122));
					break;
			}
		}
		return $str;
	}
}
