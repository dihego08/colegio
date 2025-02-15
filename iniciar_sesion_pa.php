<?php 
	include('env/env.php');
	$usuario = $_POST['usuario'];
	$pass = $_POST['pass'];
	session_start();
	
	try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();
    
        $query = $mbd->prepare("SELECT count(*) as cant FROM profesores WHERE usuario = :usuario AND pass = :pass");
    	$query->bindParam(':usuario', $usuario);
    	$query->bindParam(':pass', md5($pass));
    	$query->execute();
    	$cc = $query->fetch(PDO::FETCH_ASSOC);
    
        //echo $cc['cant'];
        
        if($cc['cant'] == 0){
            $result = array(
                'Result' => 'ERROR',
                'Message' => 'Datos Incorrectos'
            );
        }else{
            $qr = $mbd->prepare("SELECT * FROM profesores WHERE usuario = :usuario AND pass = :pass");
        	$qr->bindParam(':usuario', $usuario);
        	$qr->bindParam(':pass', md5($pass));
        	$qr->execute();
        	$user = $qr->fetch(PDO::FETCH_ASSOC);
        	$result = array(
                'Result' => 'OK',
                'Values' => $user
            );
            
            unset($_SESSION['CARRITO']); 
            
            $_SESSION['id'] = $user['id'];
        	$_SESSION['nombres'] = $user['nombres'];
        	$_SESSION['nivel'] = "DOC";
        }
    	
        $mbd->commit();
        
        echo json_encode($result);
    }catch (Exception $e) {
        $mbd->rollBack();
        $result = array(
            'Result' => 'ERROR',
            'Message' => $e->getMessage()
        );
        echo json_encode($result);
    }
?>