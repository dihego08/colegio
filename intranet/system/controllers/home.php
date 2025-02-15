<?php

class Home extends f{

	var $modelo = "";
	var $html_basico = "";
	var $html = "";
	var $baseurl = "";
	var $uri = "";
	function Home(){
		session_start();

		$this->html_basico =  $this->load()->lib("Html_basico");
		$this->html =  $this->load()->lib("html");
		$this->modelo = $this->load()->model("modelo");
		$this->uri = $this->uri();
		$this->baseurl = BASEURL;

	}
	function index(){
		if(!isset($_SESSION['user_level']))
				$this->Login();

		else{
	$script='
				';
                
                
                
				$h["title"] = "Bienvenido ".$_SESSION["fullname"];
				$c["title"] = "<br>Bienvenido ".$_SESSION["fullname"];
				$c["content"] = "<br/>Bienvenido ".$_SESSION['fullname'].", Ud. a ingresado correctamente al sistema.<br/><br/>
				<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>
				<h5>PUEDE ACCEDER RÁPIDAMENTE A ESTOS MÓDULOS </h5>

".$script;
			
				$this->View($h, $c);
		}

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



	function Login(){
	header("Location: login");
			$h["title"] = "Iniciar Sesi&oacute;n";
			$c["title"] = "Iniciar Sesi&oacute;n";
			$c["content"] = $this->html_basico->FormLogin();

			$this->View($h, $c);

	}
	function SignIn(){

		if($_POST["email"] != "")
		{


			foreach($_POST as $key => $value) {
				$data[$key] = $this->filter($value); // post variables are filtered
			}

			$user_email = $data['email'];
			$pass = $data['pass'];



				$user_cond = "email='$user_email' and level = 5 or level=2 ";


			$result = $this->modelo->db->query("SELECT * FROM users WHERE $user_cond	");
			$num = count($result);

		  // Match row found with more than 1 results  - the user is authenticated.
			if ( $num > 0 ) {

			//list($id,$pwd,$full_name,$approved,$user_level) = mysql_fetch_row($result);


				//check against salt
			if ($result[0]->pass === $this->PwdHash($pass,substr($result[0]->pass,0,9))) {
				if(empty($err)){

				 // this sets session and logs user in
				   session_regenerate_id (true); //prevent against session fixation attacks.

				   // this sets variables in the session


					$_SESSION['user_id']= $result[0]->id_user;
					$_SESSION['user_name'] = $result[0]->fullname;
					$_SESSION['user_level'] = $result[0]->level;
					$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

					//update the timestamp and key for cookie
					// $stamp = time();
					// $ckey = $this->GenKey();
					// $this->modelo->query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$result[0]->id'");

					//set a cookie

				   // if(isset($_POST['remember'])){
							  // setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
							  // setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
							  // setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
							   // }
					  echo "1";

					 }
				}
				else
				{
				//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
				echo "Ingreso invalido, por favor ingresea correctamente su correo y su clave.";
				//header("Location: login.php?msg=$msg");
				}
			} else {
				echo "Error - Ingreso invalido, no existe en el registro";

			  }




			// $r = $this->modelo->isAlready2('users', trim($this->input->post("user")), md5(trim($this->input->post("pass"))));
			// if(count($r) > 0){
				// $_SESSION['user_tipo'] = "admin";
				// $_SESSION['user_id'] = $r[0]->id_user;
				// $_SESSION['user_name'] = $r[0]->nombres;
				// echo "bien";
			// }
			// else{
				// echo "Invalido";
				// }
		}
		else
		echo "Error 404";
	}
	function Logout(){

		session_destroy();
		header("Location: login");
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
