<?php
    include_once __DIR__."/../config/database.php";
   $conn = mysqli_connect(_DB_HOST,_DB_USER,_DB_PASS,_DB_NAME);
    if (mysqli_connect_errno()) {
        $error=mysqli_connect_error();      
    }
    $flag="--1";
    //$bd=$hostname._DB_HOST;
    $qq=mysqli_query($conn,"select color_general,color_letra,mostrar_logo,empresa_nombre from empresa_informacion where id_empresa=2");
    if($fila=mysqli_fetch_array($qq)){
        $flag=$fila['mostrar_logo'];
        $color_general=$fila["color_general"];
        $color_letra=$fila["color_letra"];
        $nombre_empresa=$fila['empresa_nombre'];
    }else{
        $flag="-1";
    }
    if($conn==null){
        $flag=100;
    }
?>
