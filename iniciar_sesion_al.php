<?php 
	include('env/env.php');
	$usuario = $_POST['usuario'];
	$pass = $_POST['pass'];
	session_start();
	date_default_timezone_set('America/Lima');
	
	$hoy_ = date("Y-m-d");
    //$dateTimestamp1 = strtotime($hoy_); 

	try {
        $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mbd->beginTransaction();
    
        $query = $mbd->prepare("SELECT count(*) as cant FROM usuarios WHERE usuario = :usuario AND pass = :pass");
    	$query->bindParam(':usuario', $usuario);
    	$query->bindParam(':pass', md5($pass));
    	$query->execute();
    	$cc = $query->fetch(PDO::FETCH_ASSOC);
        
        if($cc['cant'] == 0){
            $result = array(
                'Result' => 'ERROR',
                'Message' => 'Datos Incorrectos'
            );
        }else{
            $qr = $mbd->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :pass");
        	$qr->bindParam(':usuario', $usuario);
        	$qr->bindParam(':pass', md5($pass));
        	$qr->execute();
        	$user = $qr->fetch(PDO::FETCH_ASSOC);
        	
        	if($user['estado'] == 0 || is_null($user['estado'])){
				$result = array(
					'Result' => 'ERROR',
					'Message' => 'La cuenta no ha sido habilitada por el administrador'
				);
			}else{
				$hora = date("H:i:s");
				$consulta = $mbd->prepare("SELECT * FROM asistencias WHERE id_alumno = :id_alumno AND fecha = :fecha");
				$consulta->bindParam(":fecha", $hoy_);
				$consulta->bindParam(":id_alumno", $user['id']);
				$consulta->execute();
				
				if ($consulta->fetchColumn() == 0) {
					//echo "es CERO";
					$insertar = $mbd->prepare("INSERT INTO asistencias(id_alumno, fecha, hora) VALUES(:id_alumno, :fecha, :hora)");
					$insertar->bindParam(":fecha", $hoy_);
					$insertar->bindParam(":id_alumno", $user['id']);
					$insertar->bindParam(":hora", $hora);
					$insertar->execute();
				}else{
					$asistencias = $consulta->fetch(PDO::FETCH_ASSOC);
					//echo "es MAS QUE CERO";
					$actualizar = $mbd->prepare("UPDATE asistencias SET hora_2 = :hora_2 WHERE id = :id");
					$actualizar->bindParam(":hora_2", $hora);
					$actualizar->bindParam(":id", $asistencias['id']);
					$actualizar->execute();
				}
				/*$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

				$query_pagos_pendiente = $mbd->prepare("SELECT * FROM pagos WHERE id_usuario = :id_usuario");
				$query_pagos_pendiente->bindParam(":id_usuario", $user['id']);
				$query_pagos_pendiente->execute();

				$pagos = $query_pagos_pendiente->fetch(PDO::FETCH_ASSOC);
				
				$hoy = date("Y-m-d");
				$fecha_pago = "2021-02-15";
				//echo $fecha_pago;
				if($pagos['debe'] > 0 && strtotime($hoy) >= strtotime($fecha_pago)){
					$result = array(
						'Result' => 'ERROR',
						'Code' => 'DB+1',
						'Message' => 'La cuenta esta con un saldo pendiente, realiza tus pagos para poder continuar.',
						'User_id' => $user['id'].substr(str_shuffle($permitted_chars), 0, 6)
					);
				}else{*/
					$result = array(
						'Result' => 'OK',
						'Values' => $user
					);
					
					unset($_SESSION['CARRITO']); 
					
					$_SESSION['id'] = $user['id'];
					$_SESSION['nombres'] = $user['nombres'];
					$_SESSION['nivel'] = "ALU";
				/*}*/
			}
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
