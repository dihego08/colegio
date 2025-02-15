<?php
	//require ("./src/autoload.php");
	require ("./vendor/autoload.php");
	
	$persona = new \Reniec\Reniec();
	$dni = "44274795";

	// ---------- json
	echo $persona->search( $dni, true );
	
	// ---------- object
	$yo = $persona->search( $dni );
	if( $yo!=false )
	{
		echo $yo->result->DNI." - ".$yo->result->CodVerificacion." | ".$yo->result->Nombres." ".$yo->result->Apellidos."\n";
	}
?>
