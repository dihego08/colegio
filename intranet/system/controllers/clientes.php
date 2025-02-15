<?php
//tabla t_clientes
class clientes extends f{

	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $modelo2 ="";
	
	function clientes(){
		session_start();	
		
		$this->html_basico =  $this->load()->lib("Html_basico");
		$this->html =  $this->load()->lib("html_clientes");
		$this->modelo = $this->load()->model("modelo");
		$this->baseurl = BASEURL;
		$this->modelo2 = $this->load()->model("MySQLiManager");
	}

	function index(){
		if($this->valida(5)){
		
			$h["title"] = "Clientes";
			$c["content"] = $this->html->containerUsers();
			$c["title"] = "Clientes";
			$this->View($h, $c);
		}
		elseif	
		($this->valida(3)){
		
			$h["title"] = "Clientes";
			$c["content"] = $this->html->containerUsers();
			$c["title"] = "Clientes";
			$this->View($h, $c);
		}		
		else	
			$this->Login();
	}
	function nuevo() {
        if ($this->valida(5)) {
            $h["title"]   = "Agregar Nuevo Cliente";
            $c["content"] = $this->html->nuevo($this->modelo->db->query("select * from valores order by id asc"));
            $c["title"]   = "Agregar Nuevo Cliente";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Agregar Nuevo Cliente";
            $c["content"] = $this->html->nuevo($this->modelo->db->query("select * from valores order by id asc"));
            $c["title"]   = "Agregar Nuevo Cliente";
            $this->View($h, $c);
        } else
            $this->Login();
    }

	function save(){
	 
		if($this->valida(5)||$this->valida(3))
		{		
		$rs_dup = $this->modelo->db->query("select * from t_clientes where cli_ruc='".$_POST["ruc"]."'");

		if(count($rs_dup) > 0) {
	        $nothing="nothing";
			/*echo "Cliente  ya existe.";
			die();*/
		}
			 $data["cli_nombre"] = $_POST["nombre"];
			 $data["cli_telefono"] = $_POST["telefono"];
			 $data["cli_celular"] = $_POST["celular"];
			 $data["cli_ruc"] = $_POST["ruc"];
			 //$data["cli_direccion"] = $_POST["direccion"];
			 $data["cli_dni"] = $_POST["dni"];
			 $data["cli_empresa"] = $_POST["empresa"];
			 $data["cli_lista_precio"] = $_POST["lista_precio"];
			 
			$this->modelo->insert("t_clientes", $data);
			$id_cliente =  mysqli_insert_id($this->modelo->getCon());
            $data_direccion["id_cliente"]=$id_cliente;
            $data_direccion["direccion"]=$_POST["direccion"];
            $this->modelo->insert("t_direccion_cliente", $data_direccion);
			echo "Cliente Guardado";
			
		}
		
		else
		    echo "Error 404";
	}		

	function loadClientes(){
		if ($this->valida(5)) {
             $sql= "select t_clientes.*,t_lista_precio.nombre from t_clientes left join t_lista_precio on t_lista_precio.id=t_clientes.cli_lista_precio";   
        } elseif ($this->valida(3)) {
            $sql="select t_clientes.* from t_clientes";
        }
        $result = $this->modelo2->select('','','',$sql);
        //echo json_encode($result);

        $data = array();
        foreach ( $result as $value) {
            $nombre_cliente=$value['cli_nombre']=="" ? "-" : $value['cli_nombre'];
            $nombre_empresa=$value['cli_empresa']== "" ? "-" : $value['cli_empresa'];
            $direccion_cliente="-";
            $sql_direcciones="select direccion from t_direccion_cliente where id_cliente=".$value['id'];
            $resultado=$this->modelo2->select('','','',$sql_direcciones);
            if(count($resultado)==1){
                $direccion_cliente=$resultado[0]["direccion"];
            }else if(count($resultado)>1){//acutalizo a un boton que diga ver mas :v
                $direccion_cliente="<a href=\"#\" class=\"c_direcciones\" >Ver Direcciones</a>";
            }
            array_push($data, array(
                'id'=>mb_strtoupper(strval($value['id'])),
                'cli_nombre'=>mb_strtoupper(strval($nombre_cliente)),
                'cli_direccion'=>mb_strtoupper(strval($direccion_cliente)),
                'cli_telefono'=>mb_strtoupper(strval($value['cli_telefono'])),
                'cli_empresa'=>mb_strtoupper(strval($nombre_empresa)),
                'cli_celular'=>mb_strtoupper(strval($value['cli_celular'])),
                'cli_ruc'=>mb_strtoupper(strval($value['cli_ruc'])),
                'cli_dni'=>mb_strtoupper(strval($value['cli_dni'])),
                'lista_precio'=>mb_strtoupper(strval($value['nombre'])),
            ));
        }
        echo json_encode($data,JSON_PRETTY_PRINT);
	}
	function delete(){
		$id  = $_POST['id'];
        $param = "id = ".$id;
        $this->modelo2->delete('t_clientes',$param,true);
	}
	function editar(){
	    if(!$this->valida(5)){
			echo "Error 404 ";
		}else{
		    $sql ="select * from t_clientes where id=".$_POST['id'];
		    $result = $this->modelo2->select('','','',$sql);
            echo json_encode($result);
		}
	}
	function editarBD(){
	    if($this->valida(5))
		{
			$data["cli_nombre"] = $_POST["nombre"];
			$data["cli_telefono"] = $_POST["telefono"];
			$data["cli_celular"] = $_POST["celular"];
			$data["cli_ruc"] = $_POST["ruc"];
			$data["cli_direccion"] = $_POST["direccion"];
			$data["cli_dni"] = $_POST["dni"];
			$data["cli_empresa"] = $_POST["empresa"];
			$data["cli_lista_precio"] = $_POST["lista_precio"];
			 
			$this->modelo->update("t_clientes", $data, array("id" => $_POST['id']));
			header("Location: ".BASEURL."?/clientes/");


	    
		}
		elseif($this->valida(3))
		{
			$data["cli_nombre"] = $_POST["nombre"];
			$data["cli_telefono"] = $_POST["telefono"];
			$data["cli_celular"] = $_POST["celular"];
			$data["cli_ruc"] = $_POST["ruc"];
			$data["cli_direccion"] = $_POST["direccion"];
			$data["cli_dni"] = $_POST["dni"];
			$data["cli_empresa"] = $_POST["empresa"];
			$data["cli_lista_precio"] = $_POST["lista_precio"];
			
			$this->modelo->update("t_clientes", $data, array("id" => $_POST['id']));
			header("Location: ".BASEURL."?/clientes/");

		} 
			else
		echo "Error 404";
	}
    function lista(){
        $string_f="<strong>DIRECCIONES:</strong><br><br>";
        $cliente=$_POST["id_cliente"];
        
        $sql="select * from  t_direccion_cliente where id_cliente =".$cliente;
        $result = $this->modelo2->select('','','',$sql);
        $num=0;
        foreach ($result as $value){
            $num++;
            $string_f .= "Nº ".$num.":<strong> ".strtoupper($value['direccion'])."</strong>.<br><br>";
        }
        
        echo $string_f;
    }
	function getDirecciones(){
	    if($this->valida(5)){
	        $sql= "select * from t_direccion_cliente where id_cliente=".$_POST["id"];  
	        $result = $this->modelo2->select('','','',$sql);
	        echo json_encode($result,JSON_PRETTY_PRINT);
	    }else{
	        echo "error 404";
	    }
	}
	function agregarDireccion(){//ojo no guardo historial de cambio de direcciones xd
        //primero borro y luego vuelvo añado de nuevo xd(se debe corregir..esta es la forma rápida)
        $id  = $_POST['id_cliente_dir'];
        $param = "id_cliente = ".$id;
        $this->modelo2->delete('t_direccion_cliente',$param,true);
	    $cantidad_direcciones=$_POST["cantidad_direcciones"];
	    for($i=1;$i<$cantidad_direcciones+1;$i++){
	        if($_POST["cli_dir".$i]!=""){
    	        $data_direccion["id_cliente"]=$_POST['id_cliente_dir'];
                $data_direccion["direccion"]=$_POST["cli_dir".$i];
                $this->modelo->insert("t_direccion_cliente", $data_direccion);
	        }
	    }
	    header("Location: ".BASEURL."?/clientes/");
	}
	function obtenerLista(){
	    $id_cliente=$_POST["id"];
	    $sql="select t_lista_precio.id,t_lista_precio.nombre from t_lista_precio inner join t_clientes on t_clientes.cli_lista_precio=t_lista_precio.id where t_clientes.id=".$id_cliente;
        $result=$this->modelo2->select("","","",$sql);
        if(count($result)>0){
            echo $result[0]["id"]."--".$result[0]["nombre"];
        }else{
            echo 0;
        }
        
	}
	function getClients(){
	if($this->valida(5))
		{
				echo $this->html->listClients($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%"  or cli_ruc LIKE "%'.$_POST['text'].'%" '));
		}

		elseif($this->valida(3))
		{
				echo $this->html->listClients($this->modelo->db->query('SELECT * FROM t_clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%" or cli_ruc LIKE "%'.$_POST['text'].'%" '));
		}


		else
		echo "Error 404";
	}	
	function getClientsVenta(){
		if($this->valida(5))
		{
				echo $this->html->listClients($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_nombre LIKE "%'.$_POST['text'].'%" or cli_ruc LIKE "%'.$_POST['text'].'%" '));
		}

		elseif($this->valida(3))
		{
				echo $this->html->listClients($this->modelo->db->query('SELECT id_client, nombre, cod_cliente  FROM clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_nombre LIKE "%'.$_POST['text'].'%" or cod_cliente LIKE "%'.$_POST['text'].'%" '));
		}


		else
		echo "Error 404";
	}
	function getClientsVentaRapida(){
		if($this->valida(5)|| $this->valida(1)||$this->valida(4))	{
				echo $this->html->listClientsRapida($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%" '));
		}
		elseif($this->valida(3))	{
				echo $this->html->listClientsRapida($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%" '));
		}
		else
		echo "Error 404";
	}
	
	function getClientsVentaRapidaDni(){
		if($this->valida(5)|| $this->valida(1)||$this->valida(4))	{
				echo $this->html->listClientsRapidaDni($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%" '));
		}
		elseif($this->valida(3))	{
				echo $this->html->listClientsRapidaDni($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_nombre LIKE "%'.$_POST['text'].'%" or cli_dni LIKE "%'.$_POST['text'].'%" '));
		}


		else
		echo "Error 404";
	}
	function getClientsVentaRapidaRuc(){
		if($this->valida(5)|| $this->valida(1)||$this->valida(4))	{
				echo $this->html->listClientsRapidaRuc($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_ruc LIKE "%'.$_POST['text'].'%" '));
		}
		elseif($this->valida(3))	{
				echo $this->html->listClientsRapidaRuc($this->modelo->db->query('SELECT *  FROM t_clientes WHERE cli_empresa LIKE "%'.$_POST['text'].'%" or cli_ruc LIKE "%'.$_POST['text'].'%" '));
		}


		else
		echo "Error 404";
	}
	function obtenerDirecciones(){
	    $sql="select * from t_direccion_cliente where id_cliente=".$_POST["id"];
	    $result=$this->modelo2->select("","","",$sql);
	    echo json_encode($result);
	}
	function Login(){
	
			$h["title"] = "Iniciar Sesi&oacute;n";
			$c["title"] = "Iniciar Sesi&oacute;n";
			$c["content"] = $this->html_basico->FormLogin();
			
			$this->View($h, $c);
		
	}
	
	private function filter($data) {
		$data = trim(htmlentities(strip_tags($data)));
		
		if (get_magic_quotes_gpc())
			$data = stripslashes($data);
		
		$data = mysql_real_escape_string($data);
		
		return $data;
	}
	private function GenKey($length = 7){
	  $password = "";
	  $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 
	  
	  $i = 0; 
		
	  while ($i < $length) { 

		
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		   
		
		if (!strstr($password, $char)) { 
		  $password .= $char;
		  $i++;
		}

	  }

	  return $password;

	}	
	private function PwdHash($pwd, $salt = null){
		if ($salt === null)     {
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
		}
		else     {
			$salt = substr($salt, 0, 9);
		}
		return $salt . sha1($pwd . $salt);
	}
	private function GenPwd($length = 7){
	  $password = "";
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
	  
	  $i = 0; 
		
	  while ($i < $length) { 

		
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		   
		
		if (!strstr($password, $char)) { 
		  $password .= $char;
		  $i++;
		}

	  }
		return $password;

	}	


	
	private	function valida($level){
	
		if(isset($_SESSION["user_level"])){
		
			if($_SESSION["user_level"] == $level)
			{
			
				return true;
			
			}
			else
				
				return false;
		
		}
		else
		
			return false;
	
	}
	private function View($header, $content){
	
		$h = $this->load()->view('header');
		$h->PrintHeader($header);
		
		$c = $this->load()->view('content');
		$c->PrintContent($content);
		
		$f = $this->load()->view('footer');
		$f->PrintFooter();
	}
	private function random_string($lenght = 6) {
	  $str = "";
	  for($i = 1; $i <= $lenght; $i++) {
		$part = mt_rand(0, 2);
		switch ( $part ) {
		  case 0: $str .= mt_rand(0, 9); break;
			case 1: $str .= chr(mt_rand(65, 90)); break;
			case 2: $str .= chr(mt_rand(97, 122)); break;
		}
	  }
	 return $str;
	}
}