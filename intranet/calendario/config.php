<?php

// Conexión a la BBDD
$db_host = "localhost";
$db_name = "adiahotel";
$db_user = "root";
$db_pass = "password";

try {
  $db_connect = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
  $db_connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db_connect -> exec("SET CHARACTER SET utf8");

} catch(Exception $e) {
  die ('Error' . $e -> GetMessage());
  echo "<div class='alert alert-danger' role='alert'>" . $e -> getLine() . "</div>";
}

// Horario del sistema
date_default_timezone_set("America/Mexico_City");

// Dominio del sistema
define( "__LOCALHOST__", "http://localhost/empresas/adiahotel/calendario" );

// Autoload
function autoload($class) {
  include "classes/" . $class . ".php";
}

spl_autoload_register('autoload');