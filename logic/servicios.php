<?php
session_start();
include("../env/env.php");
if ($_GET['parAccion'] == "list_docentes") {
	$query = $mbd->prepare("SELECT * FROM profesores WHERE nacionalidad = 'PERU' AND estado = 1");
	$query->execute();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		unset($res['pass']);
		unset($res['usuario']);
		$bandera = "🇵🇪";
		$res['bandera'] = $bandera;
		$nacionales[] = $res;
	}

	$query = $mbd->prepare("SELECT * FROM profesores WHERE nacionalidad != 'PERU' AND estado = 1");
	$query->execute();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		unset($res['pass']);
		unset($res['usuario']);
		$bandera = "";
		switch ($res['nacionalidad']) {
			case 'CHILE':
				$bandera = "🇨🇱";
				break;
			case 'COLOMBIA':
				$bandera = "🇨🇴";
				break;
			case 'ESPAÑA':
				$bandera = "🇪🇸";
				break;
			default:
				# code...
				break;
		}
		$res['bandera'] = $bandera;
		$internacionales[] = $res;
	}

	echo json_encode(array("nacionales" => $nacionales, "internacionales" => $internacionales));
} elseif ($_GET['parAccion'] == "get_brochure") {
	$query = $mbd->prepare("SELECT * FROM brochure ORDER BY id DESC LIMIT 1");
	$query->execute();

	echo json_encode($query->fetch(PDO::FETCH_ASSOC));
} elseif ($_GET['parAccion'] == "get_videos") {
	$query = $mbd->prepare("SELECT * FROM videos_web ORDER BY id DESC LIMIT 1");
	$query->execute();

	echo json_encode($query->fetch(PDO::FETCH_ASSOC));
} elseif ($_GET['parAccion'] == "get_data_deuda") {
	$query = $mbd->prepare("SELECT p.*, CONCAT(u.apellidos, ' ', u.nombres) as usuario FROM pagos as p, usuarios as u WHERE p.id_usuario = :id_usuario AND p.id_usuario = u.id");
	$id_usuario = substr($_POST['user_id'], 0, -6);

	$query->bindParam(":id_usuario", $id_usuario);
	$query->execute();

	echo json_encode($query->fetch(PDO::FETCH_ASSOC));
} elseif ($_GET['parAccion'] == "get_prices") {
	$query = $mbd->prepare("SELECT * FROM precios WHERE id_tipo_estudiante = :id_tipo_estudiante");
	$query->bindParam(":id_tipo_estudiante", $_POST['id_tipo_estudiante']);
	$query->execute();

	$hoy = date("Y-m-d");
	$values = array();
	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		if (strtotime($hoy) >= strtotime($res['desde']) && strtotime($hoy) <= strtotime($res['hasta'])) {
			$values = $res;
		} else {
		}
	}
	echo json_encode($values);
} elseif ($_GET['parAccion'] == "save_inscription") {
	try {
		// Usando Composer (o puedes incluir las dependencias manualmente)
		require 'vendor/autoload.php';

		// Configurar tu API Key y autenticación
		$SECRET_KEY = "sk_live_2e111a3e5986fc07";
		$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

		$moneda = "";
		if ($_POST[''] == 6) {
			$moneda = "USD";
		} else {
			$moneda = "PEN";
		}
		// Creando Cargo a una tarjeta
		$charge = $culqi->Charges->create(
			array(
				"amount" => $_POST['amount'],
				"capture" => true,
				"currency_code" => $moneda,
				"description" => "DIPLOMADO DE ESPECIALIZACION EN GESTION SANITARIA Y ENFERMEDADES DE TRUCHAS",
				"installments" => 0,
				"email" => $_POST['correo'],
				"metadata" => array("test" => "test"),
				"source_id" => $_POST['token']
			)
		);
		// Respuesta
		//echo json_encode($charge);

		$_POST['imagen_documento'] = "";
		$fileName = $_FILES["img_tipo_estudiante"]["name"];
		$fileTmpLoc = $_FILES["img_tipo_estudiante"]["tmp_name"];
		$fileType = $_FILES["img_tipo_estudiante"]["type"];
		$fileSize = $_FILES["img_tipo_estudiante"]["size"];
		$fileErrorMsg = $_FILES["img_tipo_estudiante"]["error"];
		if (!$fileTmpLoc) {
			//exit();
		}

		if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName")) {
			$_POST['imagen_documento'] = $fileName;
		} else {
			$_POST['imagen_documento'] = "";
		}

		$_POST['voucher_pago'] = "";
		$fileName_2 = $_FILES["voucher_pago"]["name"];
		$fileTmpLoc_2 = $_FILES["voucher_pago"]["tmp_name"];
		$fileType_2 = $_FILES["voucher_pago"]["type"];
		$fileSize_2 = $_FILES["voucher_pago"]["size"];
		$fileErrorMsg_2 = $_FILES["voucher_pago"]["error"];
		if (!$fileTmpLoc_2) {
			//exit();
		}

		if (move_uploaded_file($fileTmpLoc_2, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/uploads/$fileName_2")) {
			$_POST['voucher_pago'] = $fileName_2;
		} else {
			$_POST['voucher_pago'] = "";
		}

		try {
			$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$mbd->beginTransaction();

			$insertar_alumno = $mbd->prepare("INSERT INTO usuarios(nombres, apellidos, telefono, fecha_nacimiento, correo, usuario, pass, dni, id_tipo_estudiante, tipo_documento, nacionalidad, imagen_documento, voucher_pago, estado) VALUES(:nombres, :apellidos, :telefono, :fecha_nacimiento, :correo, :usuario, :pass, :dni, :id_tipo_estudiante, :tipo_documento, :nacionalidad, :imagen_documento, :voucher_pago, 1);");
			$insertar_alumno->bindParam(":nombres", $_POST['nombres']);
			$insertar_alumno->bindParam(":apellidos", $_POST['apellidos']);
			$insertar_alumno->bindParam(":telefono", $_POST['telefono']);
			$insertar_alumno->bindParam(":fecha_nacimiento", $_POST['fecha_nacimiento']);
			$insertar_alumno->bindParam(":correo", $_POST['correo']);
			$insertar_alumno->bindParam(":usuario", $_POST['usuario']);
			$insertar_alumno->bindParam(":pass", md5($_POST['pass']));
			$insertar_alumno->bindParam(":dni", $_POST['dni']);
			$insertar_alumno->bindParam(":id_tipo_estudiante", $_POST['id_tipo_estudiante']);
			$insertar_alumno->bindParam(":tipo_documento", $_POST['tipo_documento']);
			$insertar_alumno->bindParam(":nacionalidad", $_POST['nacionalidad']);
			$insertar_alumno->bindParam(":imagen_documento", $_POST['imagen_documento']);
			$insertar_alumno->bindParam(":voucher_pago", $_POST['voucher_pago']);
			/*$estado = 0;
			$insertar_alumno->bindParam(":estado", $estado);*/
			$insertar_alumno->execute();

			$LID = $mbd->lastInsertId();

			$insertar_pago = $mbd->prepare("INSERT INTO pagos(id_usuario, monto, n_cuotas, debe) VALUES (:id_usuario, :monto, :n_cuotas, :debe);");
			$insertar_pago->bindParam(":id_usuario", $LID);
			$insertar_pago->bindParam(":monto", $_POST['monto']);
			$insertar_pago->bindParam(":n_cuotas", $_POST['n_cuotas']);
			$debe = 0;
			if ($_POST['n_cuotas'] == 2) {
				$debe = $_POST['monto'];
			} else {
				$debe = 0;
			}
			$insertar_pago->bindParam(":debe", $debe);
			$insertar_pago->execute();

			$query_modulos = $mbd->prepare("SELECT * FROM tbl_modulos");
			$query_modulos->execute();

			while ($mod = $query_modulos->fetch(PDO::FETCH_ASSOC)) {
				$query_nota = $mbd->prepare("INSERT INTO tbl_notas(id_alumno, examen, asistencias, informe, promedio, id_modulo) VALUES(:id_alumno, 0, 0, 0, 0, :id_modulo);");
				$query_nota->bindParam(":id_alumno", $LID);
				$query_nota->bindParam(":id_modulo", $mod['id']);
				$query_nota->execute();
			}



			$_SESSION['id'] = $LID;
			$_SESSION['nombres'] = $_POST['nombres'];
			$_SESSION['nivel'] = "ALU";

			$destinatario = 'info@nabavet.com';
			$cuerpo = ' 
	        <html> 
	        <head> 
	           <title>Nuevo Registro en la Plataforma - Nabavet</title> 
	        </head> 
	        <body> 
		        <h1>El usuario: ' . $_POST['nombres'] . ' ' . $_POST['apellidos'] . ' acaba de registrarse en la plataforma.</h1>
		        
		        <a href="https://nabavet.com/intranet/system/controllers/uploads/' . $fileName_2 . '" target="_blank">Voucher de pago</a>
	        </body> 
	        </html>';
			$asunto = "Nuevo Registro en la Plataforma - Nabavet";

			//para el envío en formato HTML 
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

			//dirección del remitente 
			$headers .= "From: Diplomados <info@nabavet.com>\r\n" .
				"CC: nabavetperu@gmail.com";

			mail($destinatario, $asunto, $cuerpo, $headers);

			$mbd->commit();
			$result = array(
				'Result' => 'OK',
			);
			echo json_encode($result);
		} catch (Exception $e) {
			$mbd->rollBack();
			$result = array(
				'Result' => 'ERROR',
				'Message' => $e->getMessage()
			);
			echo json_encode($result);
		}
	} catch (Exception $e) {
		echo json_encode($e->getMessage());
	}
} elseif ($_GET['parAccion'] == "cancelar_deuda") {
	// Usando Composer (o puedes incluir las dependencias manualmente)
	require 'vendor/autoload.php';

	// Configurar tu API Key y autenticación
	$SECRET_KEY = "sk_live_2e111a3e5986fc07";
	$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

	$moneda = "";
	if ($_POST[''] == 6) {
		$moneda = "USD";
	} else {
		$moneda = "PEN";
	}
	// Creando Cargo a una tarjeta
	$charge = $culqi->Charges->create(
		array(
			"amount" => $_POST['amount'],
			"capture" => true,
			"currency_code" => $moneda,
			"description" => "DIPLOMADO DE ESPECIALIZACION EN GESTION SANITARIA Y ENFERMEDADES DE TRUCHAS",
			"installments" => 0,
			"email" => $_POST['correo'],
			"metadata" => array("test" => "test"),
			"source_id" => $_POST['token']
		)
	);
	// Respuesta
	//echo json_encode($charge);
	try {
		$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mbd->beginTransaction();

		$insertar_pago = $mbd->prepare("UPDATE pagos SET fecha_modificacion = :fecha, monto = monto + :monto, debe = 0 WHERE id_usuario = :id_usuario;");
		
		$insertar_pago->bindParam(":id_usuario", $_POST['user_id']);
		$insertar_pago->bindParam(":monto", $_POST['monto']);
		$fecha_hoy = date("Y-m-d H:i:s");
		$insertar_pago->bindParam(":fecha", $fecha_hoy);
		$insertar_pago->execute();

		$query_usuario = $mbd->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
		$query_usuario->bindParam(":id_usuario", $_POST['user_id']);
		$query_usuario->execute();

		$el_usuario = $query_usuario->fetch(PDO::FETCH_ASSOC);

		$_SESSION['id'] = $el_usuario['id'];
		$_SESSION['nombres'] = $el_usuario['nombres'];
		$_SESSION['nivel'] = "ALU";

		$mbd->commit();
		$result = array(
			'Result' => 'OK',
		);
		echo json_encode($result);
	} catch (Exception $e) {
		$mbd->rollBack();
		$result = array(
			'Result' => 'ERROR',
			'Message' => $e->getMessage()
		);
		echo json_encode($result);
	}
} elseif ($_GET['parAccion'] == "get_prices_web") {
	$query_tipos = $mbd->prepare("SELECT * FROM tipo_estudiantes WHERE id NOT IN (6, 5)");
	$query_tipos->execute();

	$result = array();

	while ($res = $query_tipos->fetch(PDO::FETCH_ASSOC)) {
		$query = $mbd->prepare("SELECT * FROM precios WHERE id_tipo_estudiante = :id_tipo_estudiante  AND desde != '2020-12-09' ORDER BY desde ASC");
		$query->bindParam(":id_tipo_estudiante", $res['id']);
		$query->execute();

		/*$query_descuento = $mbd->prepare("SELECT * FROM precios WHERE id_tipo_estudiante = :id_tipo_estudiante  AND desde = '2020-12-09'");
		$query_descuento->bindParam(":id_tipo_estudiante", $res['id']);
		$query_descuento->execute();*/

		$values = array();
		//$values[] = $query_descuento->fetch(PDO::FETCH_ASSOC);

		while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			$values[] = $r;
		}
		$result[] = array(
			'tipo_estudiante' => $res['tipo_estudiante'],
			'precios' => $values
		);
	}

	echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_jumbotron") {
	$query = $mbd->prepare("SELECT * FROM facilidades");
	$query->execute();

	$result = array();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		$result[] = $res;
	}

	echo json_encode($result);
} elseif ($_GET['parAccion'] == "enviar_correo") {

	$destinatario = 'info@nabavet.com';
	$cuerpo = ' 
	        <html> 
	        <head> 
	           <title>' . $_POST['subject'] . '</title> 
	        </head> 
	        <body> 
		        ' . $_POST['message'] . '
	        </body> 
	        </html>';
	$asunto = $_POST['subject'];

	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	//dirección del remitente 
	$headers .= "From: " . $_POST['name'] . " <" . $_POST['email'] . ">\r\n" .
		"CC: nabavetperu@gmail.com";

	mail($destinatario, $asunto, $cuerpo, $headers);

	$result = array(
		'Result' => 'OK',
	);
	echo json_encode($result);
} elseif ($_GET['parAccion'] == "guardar_registro") {
	$destinatario = 'info@nabavet.com';
	$cuerpo = ' 
	        <html> 
	        <head> 
	           <title>Nueva inscripcion para el taller de inicio</title> 
	        </head> 
	        <body> 
		        <h4>' . $_POST['nombres'] . " " . $_POST['apellidos'] . ' se ha inscrito correctamente al taller de incio del 9 de Diciembre del 2020</h4>
		        <strong>Nombres: </strong> ' . $_POST['nombres'] . '<br>
                <strong>Apellidos: </strong> ' . $_POST['apellidos'] . '<br>
                <strong>DNI: </strong> ' . $_POST['dni'] . '<br>
                <strong>Celular: </strong> ' . $_POST['celular'] . '<br>
                <strong>Correo: </strong> ' . $_POST['correo'] . '<br>
                <strong>Fecha de nacimiento: </strong> ' . $_POST['fecha_nacimiento'] . '<br>
                <strong>Formacion academica: </strong> ' . $_POST['formacion_academica_text'] . '<br>
                <strong>Institucion: </strong> ' . $_POST['institucion'] . '<br>
	        </body> 
	        </html>';
	$asunto = 'Nueva inscripcion para el taller de inicio';

	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	//dirección del remitente 
	$headers .= "From: " . $_POST['nombres'] . " " . $_POST['apellidos'] . " <" . $_POST['correo'] . ">\r\n" .
		"CC: nabavetperu@gmail.com";

	mail($destinatario, $asunto, $cuerpo, $headers);

	$query_taller = $mbd->prepare("INSERT INTO inscripciones_taller(nombres, apellidos, dni, celular, correo, fecha_nacimiento, formacion_academica, institucion, tipo_documento, nacionalidad) VALUES(:nombres, :apellidos, :dni, :celular, :correo, :fecha_nacimiento, :formacion_academica, :institucion,  :tipo_documento, :nacionalidad);");
	$query_taller->bindParam(":nombres", $_POST['nombres']);
	$query_taller->bindParam(":apellidos", $_POST['apellidos']);
	$query_taller->bindParam(":dni", $_POST['dni']);
	$query_taller->bindParam(":celular", $_POST['celular']);
	$query_taller->bindParam(":correo", $_POST['correo']);
	$query_taller->bindParam(":fecha_nacimiento", $_POST['fecha_nacimiento']);
	$query_taller->bindParam(":formacion_academica", $_POST['formacion_academica_text']);
	$query_taller->bindParam(":institucion", $_POST['institucion']);
	$query_taller->bindParam(":tipo_documento", $_POST['tipo_documento']);
	$query_taller->bindParam(":nacionalidad", $_POST['nacionalidad']);
	$query_taller->execute();

	$result = array(
		'Result' => 'OK',
	);
	echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_malla") {
	//$query = $mbd->prepare("SELECT * FROM malla ORDER BY id DESC Limit 1");
	$query = $mbd->prepare("SELECT * FROM modulos");
	$query->execute();

	$result = array();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		$result[] = $res;
	}

	echo json_encode($result);
} elseif ($_GET['parAccion'] == "detail_docentes") {
	$query = $mbd->prepare("SELECT sobre_mi FROM profesores WHERE id = :id");
	$query->bindParam(":id", $_POST['id']);
	$query->execute();

	echo json_encode($query->fetch(PDO::FETCH_ASSOC));
} elseif ($_GET['parAccion'] == "fill_sliders") {
	$query = $mbd->prepare("SELECT * FROM slider WHERE estado = 1");
	$query->execute();

	$result = array();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		$result[] = $res;
	}

	echo json_encode($result);
} elseif ($_GET['parAccion'] == "get_tipo_estudiantes") {
	$query = $mbd->prepare("SELECT * FROM tipo_estudiantes");
	$query->execute();

	$result = array();

	while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
		$result[] = $res;
	}

	echo json_encode($result);
}
