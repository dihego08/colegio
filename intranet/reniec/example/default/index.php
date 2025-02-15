<?php
	require_once("../../src/autoload.php");
	$cliente = new \Reniec\Reniec();
	$dni = "00000000";
	
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
?>
