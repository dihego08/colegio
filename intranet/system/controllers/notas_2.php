<?php
	/*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

	class notas_2 extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function notas_2() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_notas_2");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Reporte de Notas por Alumno";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Notas por Alumno";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Reporte de Notas por Alumno";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Notas por Alumno";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadnotas() {

	    	$result = array();

	        /*$sql_alumnos = "SELECT u.nombres, u.apellidos, u.id as id_alumno, n.* FROM usuarios as u, tbl_notas as n WHERE n.id_alumno = u.id AND n.id_modulo = ".$_GET['id_modulo'];
	        $alumnos = json_decode($this->modelo3->run_query($sql_alumnos, false));

	        foreach ($alumnos as $key => $value) {
	        	$temas = json_decode($this->modelo3->select_all_where("tbl_temas", array("id_modulo" => $_GET['id_modulo'])));

		        $cant_clases = 0;
		        $cant_asistencias = 0;
		        

		        foreach ($temas->Records as $k => $v) {
		        	$sql_horario = "SELECT COUNT(*) as cant FROM horarios_2 WHERE id_tema = ".$v->id;
		        	$horario = json_decode($this->modelo3->run_query($sql_horario, false));

		        	$sql_asistencia = "SELECT COUNT(*) as cant FROM tbl_asistencias WHERE id_tema = ".$v->id." AND id_alumno = ".$value->id;

		        	$asistencia = json_decode($this->modelo3->run_query($sql_asistencia, false));

		        	$cant_clases += $horario[0]->cant;
		        	$cant_asistencias += $asistencia[0]->cant;
		        }

		        $nota_asistencias = ($cant_asistencias * 100 / $cant_clases);

		        $nota_asistencias_ = $nota_asistencias*20/100;

		        $result[] = array(
		        	'nombres' => '<p style="width: 90px; white-space: break-spaces;">'.$value->nombres . " " . $value->apellidos . '</p>',
		        	'examen' => '<input id="examen_'.$value->id_alumno.'" style="width: 70px;" type="text" class="form_control" value="'.$value->examen.'">',
		        	'informe' => '<input id="informe_'.$value->id_alumno.'" style="width: 70px;" type="text" class="form_control" value="'.$value->informe.'">',
		        	'asistencias' => '<input id="asistencias_'.$value->id_alumno.'" style="width: 70px;" type="text" class="form_control" value="'.$nota_asistencias_.'" disabled>',
		        	'boton' => '<button title="Guardar Notas" class="btn btn-sm btn-success" onclick="guardar_notas('.$value->id_alumno.', '.$value->id.');"><i class="fa fa-check"></i></button>',
		        	'promedio' => '<input id="promedio_'.$value->id_alumno.'" style="width: 70px;" type="text" class="form_control" value="'.$value->promedio.'" disabled>',
		        );
	        }


            echo json_encode($result);*/

            /*$notas = json_decode($this->modelo3->select_all_where("tbl_notas", array("id_alumno" => $_GET['id_alumno'])));

            foreach ($notas->Records as $key => $value) {
            	$alumno = json_decode($this->modelo3->select_one("usuarios", array("id" => $value->id_alumno)));

            	$result[] = array(
            		"nombres" => $alumno->nombres . " " . $alumno->apellidos,
            		'examen' => $value->examen,
            		'fecha' => $value->fecha,
            		'id' => $value->id,
            	);
            }

            echo json_encode($result);*/
            $sql = "SELECT n.*, CONCAT(u.nombres, ' ', u.apellidos) AS alumno, e.identificador, e.fecha as fecha_examen FROM tbl_notas as n, usuarios as u, tbl_examenes as e WHERE n.id_alumno = u.id AND n.id_examen = e.id AND n.id_alumno = ".$_GET['id_alumno'];
            echo $this->modelo3->run_query($sql, false);
	    }
	    public function cargar_excel()
	    {
	    	require_once __DIR__ . '/simplexlsx/vendor/shuchkin/simplexlsx/src/SimpleXLSX.php';
			$fileName = $_FILES["archivo"]["name"];
			$fileTmpLoc = $_FILES["archivo"]["tmp_name"];
			$fileType = $_FILES["archivo"]["type"];
			$fileSize = $_FILES["archivo"]["size"];
			$fileErrorMsg = $_FILES["archivo"]["error"];
			if (!$fileTmpLoc) {
			}

			if (move_uploaded_file($fileTmpLoc, __DIR__."/upload/excels/$fileName")) {
				$excel = $fileName;
				$archivo = __DIR__."/upload/excels/" . $excel;
			}
			$u = 0;
			if ($xlsx = SimpleXLSX::parse($archivo)) {

				$data_detalle = array();
				foreach ($xlsx->rows() as $key) {

					if ($u <= 2) {
					} else {
						if (empty($key[0])) {
						}else{
							//echo $key[1];
							$alumno = json_decode($this->modelo3->select_one("usuarios", array('dni' => $key[0])));

							$data_detalle[] = array(
								'id_alumno' => $alumno->id,
								'examen' => $key[4],
								'id_examen' => 299,
								'fecha' => date("Y-m-d H:i:s"),
							);
						}
					}
					$u++;
				}
				//print_r($data_detalle);
				

				try {

	                $this->modelo3->con->beginTransaction(); // also helps speed up your inserts.

					$datafields = array('id_alumno', 'examen', 'id_examen', 'fecha');

					$insert_values = array();
					foreach($data_detalle as $d){
					    $question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
					    $insert_values = array_merge($insert_values, array_values($d));
					}

					$sql = "INSERT INTO tbl_notas (" . implode(",", $datafields ) . ") VALUES " .
					       implode(',', $question_marks);

					/*//echo $sql;
					print_r($insert_values);*/
					$stmt = $this->modelo3->con->prepare ($sql);
					$stmt->execute($insert_values);
					$this->modelo3->con->commit();
	                $result = array(
	                    'Result' => 'OK',
	                    'Message' => 'OK'
	                );
	                echo json_encode($result);
	            }catch (Exception $e) {
	                $this->modelo3->con->rollBack();
	                $result = array(
	                    'Result' => 'ERROR',
	                    'Message' => $e->getMessage()
	                );
	                echo json_encode($result);
	            }

			} else {
				echo SimpleXLSX::parseError();
			}
	    }
	    function placeholders($text, $count=0, $separator=","){
    		$result = array();
			if($count > 0){
        		for($x=0; $x<$count; $x++){
            		$result[] = $text;
        		}
    		}

    		return implode($separator, $result);
		}
	    function save(){
	        echo $this->modelo3->insert_data("niveles", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("tbl_notas", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("niveles", array('id' => $_POST['id_nivel']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("tbl_notas", $_POST);
	    }
	    function actualizar_nota(){
	        $sql = "UPDATE tbl_notas SET examen = ".$_POST['examen']." WHERE id = ".$_POST['id'];
	        echo $this->modelo3->executor($sql, "update");
	        //print_r($_POST);
	    }
	    private function valida($level) {
	        if (isset($_SESSION["user_level"])) {
	            if ($_SESSION["user_level"] == $level) {
	                return true;
	            } else
	                return false;
	        } else
	            return false;
	    }
	    private function View($header, $content) {
	        $h = $this->load()->view('header');
	        $h->PrintHeader($header);
	        $c = $this->load()->view('content');
	        $c->PrintContent($content);
	        $f = $this->load()->view('footer');
	        $f->PrintFooter();
	    }
	}
?>