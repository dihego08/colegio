<?



$DB_host = "localhost";
$DB_user = "iacorp_livi";
$DB_pass = "iacorp_livi15";
$DB_name = "iacorp_livi";

 try
 {
     $db_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
     echo "ERROR : ".$e->getMessage();
 }
?>