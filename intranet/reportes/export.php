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

    $stmt=$db_con->prepare(' SELECT  ventas.fecha,
     clientes.nombre,  clientes.cod_cliente, clientes.dni, ventas.id_venta, ventas.cuota, ventas.t_cuota,ventas.n_cuota,ventas.portes,ventas.mora, ventas.gastos,ventas.itf,  ventas.total_pagado, ventas.saldo_capital, ventas.p_vencimiento, ventas.operador, ventas.sed  
FROM ventas INNER JOIN clientes ON ventas.id_client=clientes.id_client  where fecha BETWEEN "'.$inicio.'" AND "'.$fin.'" ')  ;



/*
   $stmt=$db_con->prepare(' SELECT  ventas.fecha,
     clientes.nombre,  clientes.cod_cliente, ventas.id_venta, ventas.cuota, ventas.t_cuota,ventas.n_cuota, 
     ventas.portes,ventas.mora, ventas.gastos,ventas.itf,  ventas.total_pagado, ventas.saldo_capital, ventas.p_vencimiento, ventas.operador, ventas.agencia    
FROM ventas INNER JOIN clientes ON ventas.id_client=clientes.id_client  where ventas.fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
*/
/* $stmt=$db_con->prepare(' SELECT  ventas.fecha,
     clientes.nombre,  clientes.cod_cliente, ventas.id_venta, venfetas.cuota, ventas.t_cuota,ventas.n_cuota, 
     ventas.portes,ventas.mora, ventas.gastos,ventas.itf,  ventas.total_pagado, ventas.saldo_capital, ventas.p_vencimiento, ventas.operador, ventas.agencia    
FROM ventas
INNER JOIN desc_venta
  ON ventas.id_venta=desc_venta.id_venta INNER JOIN clientes ON ventas.id_client=clientes.id_client  where fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');

*/


/*
$stmt=$db_con->prepare('select id_venta, fecha,id_client, valor_venta,comentario from ventas WHERE fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
*/

$stmt->execute();


$columnHeader ='';
$columnHeader = "FECHA"."\t"."NOMBRES "."\t"."COD CLIENTE"."\t"."DNI"."\t"."NRO OPE"."\t"."CUOTA"."\t"."T.CUOTAS"."\t"."NRO CUOTA"."\t"."PORTES"."\t"."MORA"."\t"."GASTOS"."\t"."ITF"."\t"."TOTAL PAGADO"."\t"."SALDO DEUDA"."\t"."PROX VEN"."\t"."OPERADOR"."\t"."AGENCIA";


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
//header("Content-Disposition: attachment; filename=Book record sheet.xls");
header("Content-Disposition: attachment; filename=Reporte".date('Y-m-d h:i:sa')."  report.xls ");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";

?>
