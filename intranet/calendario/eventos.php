<?php require "config.php";

$eventos = new calendario();
$eventos -> listado($db_connect);