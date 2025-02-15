<?php
	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	
	/*include("clsInsumos.php");
    $compra = new ClsInsumos;
    $compras = json_decode($compra->lista_compras_2($_GET));*/
	
	$json = file_get_contents('https://laclave.diegoaranibar.com/intranet/?/alumnos/loadalumnos');
	$obj = json_decode($json);

	$aux = 0;
	foreach($obj as $key => $value){
	    $values[] = array(
			"N° Doc." => $value->dni,
			"Nombres" => $value->nombres,
			"Apellidos" => strval($value->apellidos),
			"Correos" => str_replace("<br>", " - ", $value->correo),
			"Ciclo - Grupo" => strip_tags($value->ciclo),
        );
	}
	
	if(!empty($values)) {
		$filename = "reporte_alumnos-" . date('d-m-Y') . ".xls";
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