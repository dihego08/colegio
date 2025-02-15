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
     clientes.nombre, desc_venta.descripcion,  desc_venta.cantidad, desc_venta.precio_unitario, desc_venta.dscto, desc_venta.importe_neto,  ventas.hecho_por,  ventas.mesa
FROM ventas
INNER JOIN desc_venta
  ON ventas.id_venta=desc_venta.id_venta INNER JOIN clientes ON ventas.id_client=clientes.id_client  where mesa="credito" and fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');

/*
$stmt=$db_con->prepare('select id_venta, fecha,id_client, valor_venta,comentario from ventas WHERE fecha BETWEEN "'.$inicio.'" AND "'.$fin.'"');
*/

$stmt->execute();


$columnHeader ='';
$columnHeader = "FECHA"."\t"."CLIENTE "."\t"."DESCRIPCION"."\t"."CANTIDAD"."\t"."PRECIO UNITARIO"."\t"."DESCUENTO"."\t"."TOTAL"."\t"."MOZO"."\t"."CREDITO";


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
header("Content-Disposition: attachment; filename=Book record sheet.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";

?>
