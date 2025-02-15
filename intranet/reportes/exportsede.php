<?php
include('db.php');
//$inicio    ="2018-04-21";
//$fin    ="2018-04-21";
$inicio = $_POST['iniciodia'];
$fin = $_POST['findia'];
$sede = $_POST['sede'];
$conn = new mysqli('localhost', 'root', 'password');
mysqli_select_db($conn, 'sisbitel2');

$setSql = "SELECT `id_venta`,`fecha`,`hora` FROM `ventas`";
$setRec = mysqli_query($conn,$setSql);

    $stmt=$db_con->prepare(' SELECT  r.id_res id, r.fecha,r.hora,
     clientes.nombre,  clientes.cod_cliente, clientes.dni, r.hecho_por,  r.valor_venta, r.interes,r.tiempo,r.tipoe, r.sed, r.ctapro,r.intapr   
FROM reservas r INNER JOIN clientes  ON r.id_client=clientes.id_client  where r.sed="'.$sede.'" and fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
/*
   $stmt=$db_con->prepare(' SELECT  ventas.fecha,
     clientes.nombre,  clientes.cod_cliente, ventas.id_venta, ventas.cuota, ventas.t_cuota,ventas.n_cuota, 
     ventas.portes,ventas.mora, ventas.gastos,ventas.itf,  ventas.total_pagado, ventas.saldo_capital, ventas.p_vencimiento, ventas.operador, ventas.agencia    
FROM ventas INNER JOIN clientes ON ventas.id_client=clientes.id_client  where ventas.fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
*/
/*
$stmt=$db_con->prepare('select id_venta, fecha,id_client, valor_venta,comentario from ventas WHERE fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
*/
$stmt->execute();

$columnHeader ='';
$columnHeader = "ID"."\t"."FECHA"."\t"."HORA"."\t"."NOMBRES "."\t"."COD CLIENTE"."\t"."DNI"."\t"."OPERADOR(A)"."\t"."MONTO"."\t"."INTERES"."\t"."TIEMPO MESES"."\t"."VIG.=0 ARCH =1"."\t"."AGENCIA"."\t"."CAPITAL APROBADO"."\t"."INTERES APROBADO";

$setData='';
$suma_pos7 = 0.0;
$suma_pos8 = 0.0;

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  $i=0;
  foreach($rec as $value)
  {
    switch ($i){
        case 7:
            $value = '"' .doubleval($value) . '"' . "\t";
            $rowData .= $value;
            $suma_pos7 = doubleval($suma_pos7)+doubleval($value);
            break;
        case 8:
            $value = '"' . doubleval($value) . '"' . "\t";
            $rowData .= $value;
            $suma_pos8 = doubleval($suma_pos8)+doubleval($value);
            break;
        case 12:
            $value = '"' .doubleval($value) . '"' . "\t";
            $rowData .= $value;
            break;
        case 13:
            $value = '"' . doubleval($value) . '"' . "\t";
            $rowData .= $value;
            break;  
        default:
            $value = '"' . ($value) . '"' . "\t";
            $rowData .= $value;
            break;
    }
    $i++;
  }
  $setData .= trim($rowData)."\n";
}

$rowSuma = '';
$value = '';
for($i=0;$i<14;$i++){
    switch($i){
        case 7:
            $value= doubleval($suma_pos7) . "\t";
            $rowSuma .= $value;
            
            break;
        case 8:
            $value= doubleval($suma_pos8) . "\t";
            $rowSuma .= $value;
            
            break;
        default:
            
            $value= '' . "\t";
            $rowSuma .= $value;
            break;
    }
    
}
/*$suma1= '"' . $suma_pos7. '"' . "\t";
$rowSuma .= $suma1;
$suma1= '"' . $suma_pos8. '"' . "\t";
$rowSuma .= $suma1;
*/
$setData .= trim($rowSuma)."\n";

header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=Book record sheet.xls");
header("Content-Disposition: attachment; filename=Reporte".date('Y-m-d h:i:sa')."  report.xls ");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";

?>
