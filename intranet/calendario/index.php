<?php require "config.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Boostrap datepicker</title>

    <script src="components/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="components/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="components/bootstrap-calendar/css/calendar.min.css">
    <link rel="stylesheet" href="components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
  </head>
  <body>
    <div class="container">
     
      <!-- Nuevo evento -->
      <?php if (isset($_GET["action"]) && ($_GET["action"]=="nuevo")):
      $evento = new calendario();
      $evento -> nuevo($db_connect);?>
      
      <!-- Eliminar evento -->
      <?php elseif (isset($_GET["action"]) && ($_GET["action"]=="eliminar")):
      $evento = new calendario();
      $evento -> eliminar($db_connect);?>

      <!-- Listado de eventos -->
      <?php else: ?>
      <?php include_once "calendario.php"; ?>

      <?php endif; ?>
    </div>
  </body>
</html>


<?php $db_connect = null; ?>