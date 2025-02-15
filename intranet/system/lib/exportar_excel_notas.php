<?php
	$fecha = $_GET['fecha'];
	
	//echo 'https://laclave.softluttion.com/intranet/?/notas/loadnotas/=&fecha='+$fecha;

	/*include("clsInsumos.php");
    $compra = new ClsInsumos;
    $compras = json_decode($compra->lista_compras_2($_GET));*/
	
	$json = file_get_contents('https://laclave.diegoaranibar.com/intranet/?/notas/loadnotas/=&fecha='.$fecha);
	$obj = json_decode($json);

	//print_r($obj);

	$aux = 0;
	foreach($obj as $key => $value){
	    $values[] = array(
			"Alumno" => strtoupper($value->nombres),
			"Puntaje" => $value->examen
        );
	}
	
	if(!empty($values)) {
		$filename = "reporte_notas-" . date('d-m-Y') . ".xls";
		header("Content-type: text/html; charset=utf8");
		header("Content-Type: application/vnd.ms-excel charset=UTF-8");
		header("Content-Disposition: attachment; filename=".$filename);
		$mostrar_columnas = false;
		foreach($values as $libro) {
			if(!$mostrar_columnas) {
				echo implode("\t", array_keys($libro)) . "\n";
				$mostrar_columnas = true;
			}
			echo implode("\t", array_values($libro)) . "\n";
		}
	}else{
		echo 'No hay datos a exportar';

	}
?>