<?php
	require_once("../../src/autoload.php");
	$cliente = new \Reniec\Reniec();
	$dni = ( isset($_REQUEST["ndni"]))? $_REQUEST["ndni"] : false;
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Consulta RENIEC sin Captcha Perú - GeekDev</title>
	</head>
	<body>
	<?php	
		if( $dni != false )
		{
			$persona = $cliente->search( $dni );
			if($persona->success!=false)
			{
				echo "DNI: " . $persona->result->DNI . "-" . $persona->result->CodVerificacion . "<br>";
				echo "Nombre: " . $persona->result->Nombre . "<br>";
				echo "Apellido Paterno: " . $persona->result->Paterno . "<br>";
				echo "Apellido Materno: " . $persona->result->Materno . "<br>";
			}
			else
			{
				echo $persona->msg;
			}
		}
		else
		{
	?>
		<form>
			<input name="ndni" placeholder="Ingrese DNI">
			<button type="submit"> Enviar </button>
		</form>
	<?php
		}
	?>
	</body>
</html>
