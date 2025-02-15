<?php
include('db.php');

$stmt=$db_con->prepare('select * from ventas order by fecha limit 10');
$stmt->execute();

?>

<html>
<head>
<title>Exportar depositos </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="datepicker.css"/>
</head>
<body>
<div class="container">
  <div class="panel">
    <div class="panel-heading">
      <h3>Exportar Historial Depositos</h3>
         <form action="exporthdep.php" method="post">
          <input type="text"  class="datepicker" name="inicio">
          a
        <input type="text"  class="datepicker" value="<?php echo date("Y-m-d");?>" name="fin">
          <input type="submit" value="Generar">
        </form>
      <div class="panel-body">
        
     

      </div>

    </div>

  </div>

</div>



</body>
</html>
