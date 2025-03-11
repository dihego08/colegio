<?php 
	try{
		$mbd = new PDO('mysql:host=localhost; dbname=u622044135_colegio;', 'u622044135_colegio', 'KU:SBHq^9', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\', SESSION SQL_BIG_SELECTS=1'/*, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION SQL_BIG_SELECTS=1'*//*,  PDO::MYSQL_ATTR_INIT_COMMAND => "max_join_size=#"*/));

		//$mbd = new PDO('mysql:host=softluttioncom.ipagemysql.com; dbname=db_laclave;', 'db_laclave', 'db_laclave', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\', SESSION SQL_BIG_SELECTS=1'/*, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION SQL_BIG_SELECTS=1'*//*,  PDO::MYSQL_ATTR_INIT_COMMAND => "max_join_size=#"*/));
		
		//$mbd = new PDO('mysql:host=localhost; dbname=plataforma_laclave;', 'aramos', 'aramos', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
		//session_start();
	}catch(PDOException $e){
		echo "Fallo en la conexion ".$e->getMessage();
	}
?>