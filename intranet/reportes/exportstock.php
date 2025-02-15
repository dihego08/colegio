<?php
include('db.php');
$inicio    = $_POST['inicio'];
$fin = $_POST['fin'];
$conn = new mysqli('localhost', 'root', 'password');
mysqli_select_db($conn, 'sisferre2');

$setSql = "SELECT `ur_Id`,`ur_username`,`ur_password` FROM `tbl_user`";
$setRec = mysqli_query($conn,$setSql);

$stmt=$db_con->prepare('select * from costo_servicio WHERE cantidad BETWEEN "'.$inicio.'" AND "'.$fin.'"');
$stmt->execute();


$columnHeader ='';
$columnHeader = "CODIGO"."\t"."PRODUCTO"."\t"."COSTO"."\t"."CANTIDAD"."\t";


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
