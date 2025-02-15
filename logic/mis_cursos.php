<?php 
	session_start();
	include("../env/env.php");
	if (isset($_GET['accion'])) {
		if($_GET['accion'] == "mis_cursos"){
			$estado = 0;
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
                if($_SESSION['nivel'] == "ALU"){

                	$al = $mbd->prepare("SELECT estado FROM alumnos WHERE id = :id");
                	$al->bindParam(":id", $_SESSION['id']);
                	$al->execute();

                	$alumno = $al->fetch(PDO::FETCH_ASSOC);

                	$estado = $alumno['estado'];

					$query = $mbd->prepare("SELECT c.*, ci.ciclo FROM cursos_2 as c, ciclos as ci WHERE c.id_ciclo = ci.id");
					$query->execute();
					$values = array();
					while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
						$values[] = $res;
					}
				}elseif($_SESSION['nivel'] == "DOC"){
					$query = $mbd->prepare("SELECT c.*, ci.ciclo FROM cursos_2 as c, ciclos as ci WHERE c.id_ciclo = ci.id AND c.id_docente = :id_docente");
					$query->bindParam(":id_docente", $_SESSION['id']);
					$query->execute();
					$values = array();
					while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
						$values[] = $res;
					}
					$estado = 1;
				}

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values,
                    'Estado' => $estado
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
			
		}elseif($_GET['accion'] == "mis_temas"){
			$result = array();

			$c = $mbd->prepare("SELECT * FROM cursos WHERE id = :id_curso");
			$c->bindParam(":id_curso", $_POST['id_curso']);
			$c->execute();
			$cu = $c->fetch(PDO::FETCH_ASSOC);

			$query = $mbd->prepare("SELECT * FROM temas WHERE id_curso = :id_curso");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result['curso'] = $cu['curso'];
			$result['temas'] = $values;
			echo json_encode($result);
		}elseif ($_GET['accion'] == "mis_clases") {
			$query = $mbd->prepare("SELECT * FROM clases WHERE id_curso = :id_curso");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			echo json_encode($values);
		}elseif ($_GET['accion'] == "primera_clase") {

			$result = array();

			$cu = $mbd->prepare("SELECT c.curso, c.id as id_curso FROM cursos as c WHERE c.id = :id_curso");
			$cu->bindParam(":id_curso", $_POST['id_curso']);
			$cu->execute();
			$ct = $cu->fetch(PDO::FETCH_ASSOC);

			$query = $mbd->prepare("SELECT * FROM clases WHERE id_curso = :id_curso ORDER BY id ASC LIMIT 1");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = $query->fetch(PDO::FETCH_ASSOC);
			
			$result["curso"] = $ct['curso'];
			$result["id_curso"] = $ct['id_curso'];
			$result["clase"] = $values;

			echo json_encode($result);
		}elseif ($_GET['accion'] == "get_clase") {
			$result = array();

			$cu = $mbd->prepare("SELECT c.curso, c.id as id_curso FROM cursos as c, clases as cl WHERE c.id = cl.id_curso AND cl.id = :id_clase");
			$cu->bindParam(":id_clase", $_POST['id_clase']);
			$cu->execute();
			$ct = $cu->fetch(PDO::FETCH_ASSOC);

			$query = $mbd->prepare("SELECT * FROM clases WHERE id = :id_clase");
			$query->bindParam(":id_clase", $_POST['id_clase']);
			$query->execute();
			$values = $query->fetch(PDO::FETCH_ASSOC);
			
			$result["curso"] = $ct['curso'];
			$result["id_curso"] = $ct['id_curso'];
			$result["tema"] = $ct['tema'];
			$result["clase"] = $values;

			echo json_encode($result);
		}elseif ($_GET['accion'] == "mis_tareas") {
			$query = $mbd->prepare("SELECT * FROM tarea WHERE id_curso = :id_curso");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			echo json_encode($values);
		}elseif ($_GET['accion'] == "info_tarea") {
			$query = $mbd->prepare("SELECT c.curso, t.tema, ta.* FROM cursos as c, temas as t, tarea as ta WHERE c.id = t.id_curso AND t.id = ta.id_curso AND ta.id = :id_tarea");
			$query->bindParam(":id_tarea", $_POST['id_tarea']);
			$query->execute();
			$values = $query->fetch(PDO::FETCH_ASSOC);
			echo json_encode($values);
		}elseif ($_GET['accion'] == "entregar_tarea") {
			$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
				exit();
			}
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/teach_online/intranet/system/controllers/tareas/$fileName")){
				try {
	                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	                $mbd->beginTransaction();
	                
	                $query = $mbd->prepare("INSERT INTO entrega(id_alumno, id_tarea, archivo) VALUES(:id_alumno, :id_tarea, :archivo);");
					$_SESSION['id'] = 1;
					$query->bindParam(":id_alumno", $_SESSION['id']);
					$query->bindParam(":id_tarea", $_POST['id_tarea']);
					$query->bindParam(":archivo", $fileName);
					$query->execute();

	                $mbd->commit();
	                $result = array(
	                    'Result' => 'OK',
	                    'Message' => 'OK'
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
			} else {
			}
		}elseif ($_GET['accion'] == "mis_entregas") {
			$query = $mbd->prepare("SELECT * FROM entrega WHERE id_alumno = :id_alumno AND id_tarea = :id_tarea");
			$_SESSION['id'] = 1;
			$query->bindParam(":id_alumno", $_SESSION['id']);
			$query->bindParam(":id_tarea", $_POST['id_tarea']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			echo json_encode($values);
		}elseif ($_GET['accion'] == "eliminar_entrega") {
			$ar = $mbd->prepare("SELECT * FROM entrega WHERE id = :id_entrega");
			$ar->bindParam(":id_entrega", $_POST['id_entrega']);
			$ar->execute();
			$archivo = $ar->fetch(PDO::FETCH_ASSOC);
			if(unlink($_SERVER['DOCUMENT_ROOT']."/teach_online/intranet/system/controllers/tareas/".$archivo['archivo'])){
				$query = $mbd->prepare("DELETE FROM entrega WHERE id = :id_entrega");
				$query->bindParam(":id_entrega", $_POST['id_entrega']);
				$query->execute();

				echo json_encode(array("Result" => "OK"));
			}else{
				echo json_encode(array("Result" => "ERROR"));
			}
		}elseif ($_GET['accion'] == "ejercicios") {
			if(isset($_POST['ids_r'])){
				$result = array();
				$query = $mbd->prepare("SELECT * FROM preguntas WHERE id_curso = :id_curso AND Nivel = :nivel AND id NOT IN (".$_POST['ids_r'].") ORDER BY RAND() LIMIT 1;");
				$query->bindParam(":id_curso", $_POST['id_curso']);
				$query->bindParam(":nivel", $_POST['nivel']);
				$query->execute();
				$pregunta = $query->fetch(PDO::FETCH_ASSOC);
				$alt = $mbd->prepare("SELECT * FROM alternativas WHERE id_pregunta = :id_pregunta");
				$alt->bindParam(":id_pregunta", $pregunta['id']);
				$alt->execute();
				$values = array();
				while ($res = $alt->fetch(PDO::FETCH_ASSOC)) {
					$values[] = $res;
				}
				$result['pregunta'] = $pregunta['pregunta'];
				$result['id'] = $pregunta['id'];
				$result['alternativas'] = $values;
				echo  json_encode($result);
			}else{
				$result = array();
				$query = $mbd->prepare("SELECT * FROM preguntas WHERE id_curso = :id_curso AND Nivel = :nivel ORDER BY RAND() LIMIT 1;");
				$query->bindParam(":id_curso", $_POST['id_curso']);
				$query->bindParam(":nivel", $_POST['nivel']);
				$query->execute();
				$pregunta = $query->fetch(PDO::FETCH_ASSOC);
				$alt = $mbd->prepare("SELECT * FROM alternativas WHERE id_pregunta = :id_pregunta");
				$alt->bindParam(":id_pregunta", $pregunta['id']);
				$alt->execute();
				$values = array();
				while ($res = $alt->fetch(PDO::FETCH_ASSOC)) {
					$values[] = $res;
				}
				$result['pregunta'] = $pregunta['pregunta'];
				$result['id'] = $pregunta['id'];
				$result['alternativas'] = $values;
				echo  json_encode($result);
			}
			
		}elseif ($_GET['accion'] == "ver_solucion") {
			$query = $mbd->prepare("SELECT * FROM preguntas WHERE id = :id_pregunta");
			$query->bindParam(":id_pregunta", $_POST['id_pregunta']);
			$query->execute();
			$pregunta = $query->fetch(PDO::FETCH_ASSOC);
			echo json_encode($pregunta);
		}elseif ($_GET['accion'] == "get_examanes") {
			$result = array();

			$c = $mbd->prepare("SELECT * FROM cursos WHERE id = :id_curso");
			$c->bindParam(":id_curso", $_POST['id_curso']);
			$c->execute();
			$cu = $c->fetch(PDO::FETCH_ASSOC);

			$query = $mbd->prepare("SELECT * FROM examenes WHERE id_curso = :id_curso AND simulacro = 0");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result['curso'] = $cu['curso'];
			$result['examenes'] = $values;
			echo json_encode($result);
		}elseif ($_GET['accion'] == "get_examen") {
			$al = $mbd->prepare("SELECT id_area FROM alumnos WHERE id = :id");
			$al->bindParam(":id", $_SESSION['id']);
			$al->execute();
			$al_ = $al->fetch(PDO::FETCH_ASSOC);

			//$ar = $mbd->prepare("SELECT * FROM carrera")

	    	$fecha = date("Y-m-d");
	    	$query = $mbd->prepare("SELECT r.*, a.area FROM rankings as r, areas as a WHERE :fecha = r.dia AND r.id_area = a.id AND a.id = :id_area");
	    	$query->bindParam(":fecha", $fecha);
	    	$query->bindParam(":id_area", $al_['id_area']);
	    	$query->execute();

	    	$examen = $query->fetch(PDO::FETCH_ASSOC);
	    	/*$preguntas = $mbd->prepare("SELECT p.pregunta, p.id as id_pregunta, pe.id FROM preguntas as p, pregunta_ranking as pe WHERE p.id = pe.id_pregunta AND pe.id_ranking = :id_examen");
	    	$preguntas->bindParam(":id_examen", $examen['id']);
	    	$preguntas->execute();*/
	    	$values = array();
	    	$vv = array();
	    	//$values['duracion'] = $examen['duracion'];
	    	$values['area'] = $examen['area'];
	    	$values['examen'] = $examen['identificador'];
	    	$values['nombres'] = $_SESSION['nombres'];
	    	$values['archivo'] = $examen['archivo'];
	    	$values['n_preguntas'] = $examen['n_preguntas'];
	    	$values['id'] = $examen['id'];
	    	/*while ($res = $preguntas->fetch(PDO::FETCH_ASSOC)) {
	    		$alternativas = $mbd->prepare("SELECT * FROM alternativas WHERE id_pregunta = :id_pregunta");
	    		$alternativas->bindParam(":id_pregunta", $res['id_pregunta']);
	    		$alternativas->execute();
	    		$alter = array();
	    		while ($alt = $alternativas->fetch(PDO::FETCH_ASSOC)) {
	    			$alter[] = $alt;
	    		}
	    		$vv[] = array(
	    			"id_pregunta" => $res['id_pregunta'],
	    			"pregunta" => $res['pregunta'],
	    			"alternativas" =>  $alter
	    		);
	    	}*/
	    	//$values["QUES"] = $vv;
	    	echo json_encode($values);
		}elseif ($_GET['accion'] == "get_examen_2") {
	    	$fecha = date("Y-m-d");
	    	$query = $mbd->prepare("SELECT * FROM tbl_examenes WHERE :fecha = fecha");
	    	$query->bindParam(":fecha", $fecha);
	    	$query->execute();

	    	$examen = $query->fetch(PDO::FETCH_ASSOC);
	    	$values = array();
	    	$vv = array();
	    	
	    	$query_2 = $mbd->prepare("SELECT * FROM preguntas_rankings WHERE id_examen = :id_examen ORDER BY id");
	    	$query_2->bindParam(":id_examen", $examen['id']);
	    	$query_2->execute();
	    	$preguntas = array();

	    	while ($re = $query_2->fetch(PDO::FETCH_ASSOC)) {
	    		$preguntas[] = $re;
	    	}

	    	$values['area'] = $examen['area'];
	    	$values['examen'] = $examen['identificador'];
	    	$values['nombres'] = $_SESSION['nombres'];
	    	$values['archivo'] = $preguntas;
	    	$values['n_preguntas'] = $examen['n_preguntas'];
	    	$values['id'] = $examen['id'];

	    	echo json_encode($values);
		}elseif($_GET['accion'] == "get_simulacros"){
		    $result = array();

			$c = $mbd->prepare("SELECT * FROM cursos WHERE id = :id_curso");
			$c->bindParam(":id_curso", $_POST['id_curso']);
			$c->execute();
			$cu = $c->fetch(PDO::FETCH_ASSOC);

			$query = $mbd->prepare("SELECT * FROM examenes WHERE id_curso = :id_curso AND simulacro = 1");
			$query->bindParam(":id_curso", $_POST['id_curso']);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result['curso'] = $cu['curso'];
			$result['examenes'] = $values;
			echo json_encode($result);
		}elseif ($_GET['accion'] == "set_nota") {
			

			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
                $query = $mbd->prepare("INSERT INTO notas_2(id_examen, id_alumno, nota) VALUES(:id_examen, :id_alumno, :nota);");
				$query->bindParam(":id_examen", $_POST['id_examen']);
				$query->bindParam(":id_alumno", $_SESSION['id']);
				$query->bindParam(":nota", $_POST['nota']);
				$query->execute();

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Message' => 'OK'
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

		}elseif($_GET['accion'] == "get_data"){
			$al = $mbd->prepare("SELECT estado FROM alumnos WHERE id = :id");
        	$al->bindParam(":id", $_SESSION['id']);
        	$al->execute();

        	$alumno = $al->fetch(PDO::FETCH_ASSOC);

		    $values = array(
		        "nombres" => $_SESSION['nombres'],
		        "estado" => $alumno['estado'],
		        "nivel" => $_SESSION['nivel']
	        );
		    echo json_encode($values);
		}elseif ($_GET['accion'] == "get_notas") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
                $curso = $mbd->prepare("SELECT * FROM cursos WHERE id = :id_curso");
                $curso->bindParam(":id_curso", $_POST['id_curso']);
                $curso->execute();

                $curso_ = $curso->fetch(PDO::FETCH_ASSOC);

                $query = $mbd->prepare("SELECT n.*, a.nombres, a.apellidos, e.* FROM notas_2 as n, alumnos as a, examenes as e WHERE n.id_alumno = a.id AND e.id_curso = :id_curso");
                $query->bindParam(":id_curso", $_POST['id_curso']);
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values,
                    'curso' => $curso_['curso']
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
		}elseif ($_GET['accion'] == "get_notas_examen") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT n.*, a.nombres, a.apellidos, e.* FROM notas_2 as n, alumnos as a, examenes as e WHERE n.id_alumno = a.id AND e.id = :id_examen");
                $query->bindParam(":id_examen", $_POST['id_examen']);
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif ($_GET['accion'] == "get_alertas") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT a.*, cl.clase, c.curso FROM alertas as a, cursos as c, clases as cl WHERE a.id_clase = cl.id AND cl.id_curso = c.id AND c.id_docente = :id_docente");
                $query->bindParam(":id_docente", $_SESSION['id']);
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif ($_GET['accion'] == "get_informativo") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT * FROM informativo ORDER BY id DESC");
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif ($_GET['accion'] == "llenar_ciclos") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT * FROM ciclos");
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif ($_GET['accion'] == "llenar_univesidades") {
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT * FROM universidades");
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif($_GET['accion'] == "llenar_carreras"){
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT * FROM carreras WHERE id_universidad = :id_universidad");
                $query->bindParam(":id_universidad", $_POST['id_universidad']);
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif($_GET['accion'] == "resolver"){
			$correctas = 0;
            $incorrectas = 0;
            $noRespondidas = 0;
            $puntaje = 0;

            try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();
                
                $querye = $mbd->prepare("DELETE FROM resueltas WHERE id_alumno = :id_alumno AND id_examen = :id_examen");
                $querye->bindParam(":id_alumno", $_SESSION['id']);
                $querye->bindParam(":id_examen", $_POST['id_examen']);
                $querye->execute();

                $cant_preguntas = $mbd->prepare("SELECT * FROM tbl_examenes WHERE id = :id");
                $cant_preguntas->bindParam(":id", $_POST['id_examen']);
                $cant_preguntas->execute();

                $cant_preguntas_ = $cant_preguntas->fetch(PDO::FETCH_ASSOC);

                $query = $mbd->prepare("SELECT * FROM respuestas WHERE id_examen = :id_examen ORDER BY n_pregunta ASC");
                $query->bindParam(":id_examen", $_POST['id_examen']);
                $query->execute();

                $aux = 0;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$aux++;
                	if($aux > 50){
                	    
                	}else{
                    	$ist = $mbd->prepare("INSERT INTO resueltas(id_alumno, id_examen, n_pregunta, letra) VALUES(:id_alumno, :id_examen, :n_pregunta, :letra)");
    	                $ist->bindParam(":id_alumno", $_SESSION['id']);
    	                $ist->bindParam(":id_examen", $_POST['id_examen']);
    	                $ist->bindParam(":n_pregunta", $aux);
    	                $ist->bindParam(":letra", $_POST['letras'][$aux]);
    	                $ist->execute();
                    	if(empty($_POST['letras'][$aux]) || $_POST['letras'][$aux] == null|| $_POST['letras'][$aux] == ""){
                    		$noRespondidas++;
                    	}else{
                    		if($res['letra'] == $_POST['letras'][$aux]){
                    			$correctas++;
                    		}else{
                    			$incorrectas++;
                    		}
                    	}
                	}
                }

                //$puntaje = $correctas * $cant_preguntas_['n_preguntas']/100;
                //$puntaje = $correctas * 100 / $cant_preguntas_['n_preguntas'];
                $puntaje = $correctas * 100 / 50;

                $values = array(
                	"nota" => $puntaje,
					"correctas" => $correctas,
					"incorrectas" => $incorrectas,
					"noRespondidas" => $noRespondidas
                );

                $mbd->commit();
                echo json_encode($values);
            }catch (Exception $e) {
                $mbd->rollBack();
                $result = array(
                    'Result' => 'ERROR',
                    'Message' => $e->getMessage()
                );
                echo json_encode($result);
            }
		}elseif($_GET['accion'] == "get_rankings"){
			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $query = $mbd->prepare("SELECT DISTINCT r.id, r.identificador FROM rankings_2 as r, resueltas as re WHERE r.id = re.id_ranking AND re.id_alumno = :id_alumno");
                $query->bindParam(":id_alumno", $_SESSION['id']);
                $query->execute();

                $values = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$values[] = $res;
                }

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values
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
		}elseif($_GET['accion'] == "get_estadisticas"){
			$correctas = 0;
            $incorrectas = 0;
            $noRespondidas = 0;
            $puntaje = 0;

			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();

                $cant_preguntas = $mbd->prepare("SELECT * FROM rankings_2 WHERE id = :id");
                $cant_preguntas->bindParam(":id", $_POST['id_ranking']);
                $cant_preguntas->execute();

                $cant_preguntas_ = $cant_preguntas->fetch(PDO::FETCH_ASSOC);

                $query = $mbd->prepare("SELECT re.curso, re.n_pregunta, re.letra as respuesta, rp.letra as clave FROM resueltas as re, respuestas as rp WHERE re.id_ranking = rp.id_ranking AND rp.n_pregunta = re.n_pregunta AND re.id_ranking = :id_ranking AND re.id_alumno = :id_alumno ORDER BY rp.n_pregunta");
                $query->bindParam(":id_alumno", $_SESSION['id']);
                $query->bindParam(":id_ranking", $_POST['id_ranking']);
                $query->execute();

                $values = array();
                $valores = array();
                
                $cfd = array();

                while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
                	$correctas_ = 0;
		            $incorrectas_ = 0;
		            $noRespondidas_ = 0;
		            $puntaje_ = 0;
                	$no_se = $mbd->prepare("SELECT c.curso as curso_, re.n_pregunta, re.letra as respuesta, rp.letra as clave FROM resueltas as re, respuestas as rp, cursos as c WHERE c.id = re.curso AND re.id_ranking = rp.id_ranking AND rp.n_pregunta = re.n_pregunta AND re.id_ranking = :id_ranking AND re.id_alumno = :id_alumno AND re.curso = :curso ORDER BY rp.n_pregunta");
                	$no_se->bindParam(":id_alumno", $_SESSION['id']);
	                $no_se->bindParam(":id_ranking", $_POST['id_ranking']);
	                $no_se->bindParam(":curso", $res['curso']);
	                $no_se->execute();
	                $cdu = "";
	                $tot = 0;
	                while ($r = $no_se->fetch(PDO::FETCH_ASSOC)) {
	                	$cdu = $r['curso_'];
	                	if(empty($r['respuesta']) || $r['respuesta'] == null|| $r['respuesta'] == ""){
	                		$noRespondidas_++;
	                	}else{
	                		if($r['respuesta'] == $r['clave']){
	                			$correctas_++;
	                		}else{
	                			$incorrectas_++;
	                		}
	                	}
	                }

	                $cfd[$cdu] = array(
	                	"correctas" => $correctas_,
						"incorrectas" => $incorrectas_,
						"noRespondidas" => $noRespondidas_
	                );

                	$valores[] = $res;
                	if(empty($res['respuesta']) || $res['respuesta'] == null|| $res['respuesta'] == ""){
                		$noRespondidas++;
                	}else{
                		if($res['respuesta'] == $res['clave']){
                			$correctas++;
                		}else{
                			$incorrectas++;
                		}
                	}
                }

                $cants = $mbd->prepare("SELECT c.curso, COUNT(r.curso) as cant FROM cursos as c, respuestas as r WHERE r.curso = c.id AND r.id_ranking = :id_ranking GROUP BY c.curso");
                $cants->bindParam(":id_ranking", $_POST['id_ranking']);
                $cants->execute();

                $cursos = array();

                while ($res = $cants->fetch(PDO::FETCH_ASSOC)) {
                	$cursos[] = $res['curso'];
                }

                $flo_ = array();

                //$puntaje = $correctas * 80/100;
                //$puntaje = $correctas * 100 / $cant_preguntas_['n_preguntas'];
                $puntaje = $correctas * 100 / 50;
                //$puntaje = $correctas * 100 / 70;

                $values = array(
                	"nota" => $puntaje,
					"correctas" => $correctas,
					"incorrectas" => $incorrectas,
					"noRespondidas" => $noRespondidas
                );

                $mbd->commit();
                $result = array(
                    'Result' => 'OK',
                    'Records' => $values,
                    'Valores' => $valores,
                    'Cursos' => $cursos,
                    'flo' => $cfd
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
		}elseif ($_GET['accion'] == "mis_clases_by_semana") {
			



			try {
                $mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $mbd->beginTransaction();


                $sem = $mbd->prepare("SELECT * FROM semanas");
				$sem->execute();
				
				$values = array();

				while ($res = $sem->fetch(PDO::FETCH_ASSOC)) {
					$query = $mbd->prepare("SELECT * FROM clases WHERE id_curso = :id_curso AND id_semana = :id_semana");//"SELECT c.* FROM clases as c WHERE c.id_curso = :id_curso AND c.id_semana = :id_semana");
					$query->bindParam(":id_curso", $_POST['id_curso']);
					$query->bindParam(":id_semana", $res['id']);
					$query->execute();
					
					$clases = array();

					//echo $_POST['id_curso']." - ".$res['id']."<br>";
					while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
						$clases[] = $r;
					}

					//print_r($clases);

					$values[] = array(
						"semana" => $res['semana'],
						"clases" => $clases
					);
				}

                $mbd->commit();
				echo json_encode($values);
                /*$result = array(
                    'Result' => 'OK',
                    'Records' => $values
                );
                echo json_encode($result);*/
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
