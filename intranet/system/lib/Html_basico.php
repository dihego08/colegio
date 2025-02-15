<?php
class Html_basico extends f{


	private $baseurl = "";



	function Html_basico(){

		$this->baseurl = BASEURL;
	}
	function FormLogin(){

	 $tbl = $this->load()->lib_html("Table");

	 //$tbl = new Table();
		$elements = array(
			array('<a href="./login">Tiene que iniciar sesion</a>', ''),
			
		//	array('Usuario:', '<input type="text" class="texts" name="email" id="txtuser" value="luis@luis.com"/>'),
		//	array('Contrase&ntilde;a:', '<input type="password" class="texts" name="key" id="txtkey" value=""/>')
		);


		foreach($elements as $row) {

			$tbl->addRow();
				$tbl->addCell($row[0], array("style" => "height:24px;"));
				$tbl->addCell($row[1]);
		}

		$tbl->addRow();
		//	$tbl->addCell('<br/><a href="javascript:;" onclick="Login();" class="btn_send">Ingresar</a>', array("colspan" => 2, "align" => "center"));

		$r = $tbl->getTable();


	$r .= '<script type="text/javascript">';
		$r .= 'document.getElementById("txtuser").focus();';
		$r .= 'function Login(){';

		$r .= 'var user = $("#txtuser").val();';
		$r .= 'var key = $("#txtkey").val();';

		$r .= 'if(!(/\w{1,}[@][\w\-]{1,}([.]([\w\-]{2,3}))$/.test(user))){';
		$r .= 'alert("Email incorrecto");';
		$r .= '}else ';
		$r .= 'if(key=="" || /\s+$/.test(key)    || key.length==0){';
		$r .= 'alert("Contrasena incorrecta");';
		$r .= '}else{';
				$r .= 'showLoading();';
				$r .= '$.post("'.$this->baseurl.INDEX.'home/SignIn",';
				$r .= '{"email":user, "pass":key},';
				$r .= 'function(data) {';
					$r .= 'hideLoading();';
					 $r .= 'if(data == "1")location.href = "'.$this->baseurl.INDEX.'home";';
					 $r .= ' else $.prompt("Su cuenta o contrase&ntilde;a es incorrecta.",{buttons:{Aceptar:true}});';
				$r .= '});';
		$r .= '}';
    $r .= '}';
	$r .= '</script>';

	return '<center><br/><br/>'.$r.'<br/><br/></center>';

	}



}
