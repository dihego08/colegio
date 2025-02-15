<?php
    include("../env/env.php");
    
    if(isset($_GET['accion'])){
        if($_GET['accion'] == "siguiente"){
            $query = $mbd->prepare("SELECT id FROM usuarios WHERE correo = :correo AND usuario = :usuario");
            $query->bindParam(":correo", $_POST['correo']);
            $query->bindParam(":usuario", $_POST['usuario']);
            $query->execute();
            
            $usuario = $query->fetch(PDO::FETCH_ASSOC);
            
            //echo count($usuario['id']);
            
            //if($usuario['id'] != "" || $usuario['id'] != null){
            if(!empty($usuario['id'])){
                echo json_encode(array("Result" => "OK", "id" => $usuario['id']));
            }else{
                echo json_encode(array("Result" => "ERROR"));
            }
        }elseif($_GET['accion'] == "reestablecer"){
            try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
        	    $sq = $mbd->prepare("UPDATE usuarios SET pass = :pass WHERE id = :id");
                $sq->bindParam(':pass', md5($_POST['pass']));
        	    $sq->bindParam(':id', $_POST['id_usuario']);
        	    $sq->execute();
            	
                $mbd->commit();
                $result = array(
                    'Result' => 'OK'
                );
                echo json_encode($result);
            }catch (Exception $e) {
                $mbd->rollBack();
                $result = array(
                    'Result' => 'ERROR',
                    'Message' => $e->getMessage()
                );
                echo json_encode($result);
            }
        }elseif($_GET['accion'] == "siguiente_d"){
            $query = $mbd->prepare("SELECT id FROM profesores WHERE correo = :correo AND usuario = :usuario");
            $query->bindParam(":correo", $_POST['correo']);
            $query->bindParam(":usuario", $_POST['usuario']);
            $query->execute();
            
            $usuario = $query->fetch(PDO::FETCH_ASSOC);
            
            //echo count($usuario['id']);
            
            //if($usuario['id'] != "" || $usuario['id'] != null){
            if(!empty($usuario['id'])){
                echo json_encode(array("Result" => "OK", "id" => $usuario['id']));
            }else{
                echo json_encode(array("Result" => "ERROR"));
            }
        }elseif($_GET['accion'] == "reestablecer_d"){
            try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
        	    $sq = $mbd->prepare("UPDATE profesores SET pass = :pass WHERE id = :id");
                $sq->bindParam(':pass', md5($_POST['pass']));
        	    $sq->bindParam(':id', $_POST['id_usuario']);
        	    $sq->execute();
            	
                $mbd->commit();
                $result = array(
                    'Result' => 'OK'
                );
                echo json_encode($result);
            }catch (Exception $e) {
                $mbd->rollBack();
                $result = array(
                    'Result' => 'ERROR',
                    'Message' => $e->getMessage()
                );
                echo json_encode($result);
            }
        }
    }
?>