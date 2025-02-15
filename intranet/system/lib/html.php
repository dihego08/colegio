<?php
class html extends f{

//a6ea9ee3eb764e612062a1437ccec5e3a3034e308a555e4b0
	private $baseurl = "";

	
	function html(){
                
		$this->load()->lib_html("Table", false);
                
		$this->baseurl = BASEURL;
	}

	
	function editMyAccount($data){
	$r = '<script type="text/javascript">';
	$r .= 'function saveUser(){';

		$r .= 'var name = $("#txtname").val();';
		$r .= 'var phone = $("#txtphone").val();';
		$r .= 'var email = $("#txtemail").val();';
		$r .= 'var pass = $("#pass").val();';
		$r .= 'var passt = $("#txtpasst").val();';
		$r .= 'var id = "'.$data[0]->id_user.'";';

		
		$r .= 'if(name=="" || /\s+$/.test(name)    || name.length==0){';
		$r .= 'alert("El campo Nombre es incorrecto");';
		$r .= '}else ';		
		$r .= 'if(!(/\w{1,}[@][\w\-]{1,}([.]([\w\-]{2,3}))$/.test(email))){';
		$r .= 'alert("El campo Email es incorrecto");';	
		$r .= '}else ';
		$r .= 'if(phone=="" || /\s+$/.test(phone)    || phone.length==0){';
		$r .= 'alert("El campo Telefono es incorrecto");';
		$r .= '}else{';
		
				$r .= 'showLoading();';
		
				$r .= '$.post("'.$this->baseurl.INDEX.'common/updateMyAccount",';
				$r .= '{"name":name,"phone":phone,"email":email, "pass":pass,"passt":passt,"id":id},';
				$r .= 'function(data) {';
						$r .= 'hideLoading();';
						
						$r .= '$.fn.colorbox.close();';
						$r .= 'location.href = "'.$this->baseurl.INDEX.'common/myaccount";';
		
				$r .= '});';
				
		$r .= '}';
	$r .= '}';
	
    $r.='<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>';
	
	$r .= '</script>';
	
	$r .= '<br/><br/>';
	
	$tbl = new Table(array("cellspacing" => "3"));
	
	$elements = array(
	array("Nombre:", '<input type="text" name="name" class="texts" id="txtname" value="'.$data[0]->fullname.'"/>'),
	array("Email:", '<input type="text" name="email" class="texts" id="txtemail" value="'.$data[0]->email.'"/>'),
	array("Telef/Cel:", '<input type="text" name="phone" class="texts" id="txtphone" value="'.$data[0]->phone.'"/>'),
	
	array("Nuevo Password (no obligatorio):", '<input type="password" name="pass" class="texts" id="pass"/>'),
	array("Password empleados generador ", '<input type="text" name="passt" class="texts" id="txtpasst" value=""/>'),
	
	);
	
	foreach($elements as $row) { 
			
			$tbl->addRow(); 
				$tbl->addCell($row[0]); 
				$tbl->addCell($row[1]); 
		} 
		$tbl->addRow(); 
			$tbl->addCell('<a href="javascript:;" onclick="saveUser();" class="btn_send">Guardar</a>', array("colspan" => 2, "align" => "right"));
		
		$r .= $tbl->getTable(); 
	
	
		return $r;
	}			
	function myAccount($data){
	
	$tbl = new Table(array("class" => "myaccount"));
	
	if($data[0]->banned == "1")
	$b = "Si";
	else
	$b = "No";
	
	$elements = array(
	array("Nombre:", $data[0]->fullname),
	array("Email/Cuenta:", $data[0]->email),
	array("Telef/Cel:", $data[0]->phone),
	array("Texto passowrd empleado", $data[0]->passt),
	array("Pass codigo empleado:", $data[0]->passtt)
	
	);
	
	foreach($elements as $row) { 
			
			$tbl->addRow(); 
				$tbl->addCell($row[0]); 
				$tbl->addCell($row[1]); 
		} 
		$tbl->addRow(); 
			$tbl->addCell('<a href="'.$this->baseurl.INDEX.'common/editmyaccount" class="btn_send">Editar</a>', array("colspan" => 2, "align" => "right", "style" => "border:0px;"));
		
		return $tbl->getTable(); 

	}			
	
	
	
	
	
	
	
	
	
	
	
	
	

}










