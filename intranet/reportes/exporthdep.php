<?php
include('db.php');
//$inicio    ="2018-04-21";
//$fin    ="2018-04-21";
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$conn = new mysqli('localhost', 'root', 'password');
mysqli_select_db($conn, 'sisbitel2');

$setSql = "SELECT `id_venta`,`fecha`,`hora` FROM `ventas`";
$setRec = mysqli_query($conn,$setSql);

    $stmt=$db_con->prepare(' SELECT  r.id_hd id, clientes.nombre, clientes.cod_cliente, clientes.dni,  r.fret,r.horar, r.cap,r.mre, r.sald, r.rcap, r.sed, r.ope, r.com, r.intgene, r.stint, r.penal  
FROM hdeposit r INNER JOIN clientes  ON r.id_client=clientes.id_client  where fret BETWEEN "'.$inicio.'" AND "'.$fin.'"');


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
$columnHeader = "ID"."\t"."CLIENTE"."\t"."CODIGO CLIENTE"."\t"."DNI"."\t"."FECHA RETIRO"."\t"."HORA"."\t"."CAPITAL "."\t"."MONTO RETIRADO"."\t"."SALDO"."\t"."RETIRO CAPITAL"."\t"."AGENCIA"."\t"."OPERADOR(A)"."\t"."COMENTARIO"."\t"."INT. GENERADO"."\t"."STINT"."\t"."PENALIDAD";


$setData='';

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  foreach($rec as $value)
  {
    $value = '"' . $value . '"' . "\t";
    $rowData .= $value;
  }
  $setData .= trim($rowData)."\n";
}


header("Content-type: application/octet-stream");

// header("Content-Disposition: attachment; filename=Book record sheet.xls");
header("Content-Disposition: attachment; filename=Reporte Historial Deposito".date('Y-m-d h:i:sa')."  report.xls ");

header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";

?>
