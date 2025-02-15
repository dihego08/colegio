
<html>
<head>
<title>Export </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="datepicker.css"/>
</head>
<body>
<div class="container">
  <div class="panel">
    <div class="panel-heading">
      <h3>Exportar</h3> <a href="javascript: window.history.go(-1)">REGRESAR</a>
      <div class="panel-body">
   
    
        <form action="exportstock.php" method="post">
          <input type="text"   name="inicio">
          A
        <input type="text"   name="fin">
          <input type="submit" value="Generar">
        </form>

      </div>

    </div>

  </div>

</div>


  <?php
$scategoria = "paquete4";
//$scategoria = htmlentities($_GET['scategoria']);

$pid ="1";
//$pid = htmlentities($_GET['pid']);


		    //primero obtenemos el parametro que nos dice en que pagina estamos
		    $page = 1; //inicializamos la variable $page a 1 por default
		    if(array_key_exists('pg', $_GET)){
		        $page = $_GET['pg']; //si el valor pg existe en nuestra url, significa que estamos en una pagina en especifico.
		    }
		    //ahora que tenemos en que pagina estamos obtengamos los resultados:
		    // a) el numero de registros en la tabla
		   		   $mysqli = new mysqli("localhost","root","password","sisferre2");
		    if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}


		    $conteo_query =  $mysqli->query("SELECT COUNT(*) as cantidad FROM costo_servicio ");
		    $conteo = "";
		    if($conteo_query){
		    	while($obj = $conteo_query->fetch_object()){
		    	 	$conteo =$obj->conteo;
		    	}
		    }
		    $conteo_query->close();
		    unset($obj);

		    //ahora dividimos el conteo por el numero de registros que queremos por pagina.
		    $max_num_paginas = intval($conteo/4); //en esto caso 10

		    // ahora obtenemos el segmento paginado que corresponde a esta pagina
		    $segmento = $mysqli->query("SELECT *  FROM costo_servicio    ORDER by cantidad ASC LIMIT ".(($page-1)*2000).", 2000");

		    //ya tenemos el segmento, ahora le damos output.
		    if($segmento){
			    echo '<table class="table"> 				   <tr bgcolor="#AAF37F" >
<th ></th>
<th >ID</th>
<th >PRODUCTO</th>
<th >STOCK</th>

</tr>	';
			    while($obj2 = $segmento->fetch_object())
			    {
			       echo '
			 
	<td>		


 </td>	<td>		
 '.$obj2->id_costo.' 

 </td>
		<td>		
 '.$obj2->servicio.' 

 </td>

 
			
		
					
		
								   <td>
						 '.$obj2->cantidad.' 		   
				
			       ';
			       
			       
			       
			       $stock  = $obj2->cantidad;
             
 if($stock>=5)
 {
    echo  '<span class="btn-success btn-sm"> Disponible</span>';
 }


 else if($stock<=5)
 {
    echo '<span class="btn-danger btn-sm">   Falta </span>  ';
 }
  
  else if($stock===0)
 {
    echo '<span class="btn-danger btn-sm">   Complet </span>  ';
 }
  else
 {
    echo ' ';
 }
			       
			       
			       echo '
			       
				    </td>
				    
				    	   <td>
			       '.$obj2->moneda.$obj2->precio.'
				    </td>
</tr>';
			    }
			    echo '</table> 
			    
			    ';
			}

		    //ahora viene la parte importante, que es el paginado
		    //recordemos que $max_num_paginas fue previamente calculado.
		    for($i=0; $i<$max_num_paginas;$i++){
		       echo '
            
                <!--<li>
                <a href="?pg='.($i+1).'">'.($i+1).'</a> </li> -->';
		       
		       
		       
		     
		    }
		?>
		


</body>
</html>
