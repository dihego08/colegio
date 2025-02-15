<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	class examenes extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function examenes() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_examenes");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Registro de Examenes";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Registro de Examenes";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Registro de Examenes";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Registro de Examenes";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    function Login() {
	        $h["title"]   = "Iniciar Sesi&oacute;n";
	        $c["title"]   = "Iniciar Sesi&oacute;n";
	        $c["content"] = $this->html_basico->FormLogin();
	        $this->View($h, $c);
	    }
	    public function preview(){
	    	$sql = "SELECT p.pregunta, p.id as id_pregunta, pe.id FROM preguntas as p, pregunta_ranking as pe WHERE p.id = pe.id_pregunta AND pe.id_ranking = ".$_POST['id'];

	    	$values = array();

	    	$vv = array();

	    	$preguntas = json_decode($this->modelo3->run_query($sql, false));

	    	foreach ($preguntas as $key => $pregunta) {
	    		$alternativas = json_decode($this->modelo3->select_all_where("alternativas", array("id_pregunta" => $pregunta->id_pregunta), true));
	    		$alter = array();
	    		foreach ($alternativas as $k => $alternativa) {
	    			$alter[] = $alternativa;
	    		}
	    		$vv[] = array(
	    			"id_pregunta" => $pregunta->id_pregunta,
	    			"pregunta" => $pregunta->pregunta,
	    			"alternativas" =>  $alter
	    		);
	    	}
	    	$values["QUES"] = $vv;
	    	echo json_encode($values);
	    }
	    public function save_respuestas(){
	    	if($_POST['metodo'] == "upd"){
	    		for ($i = 1; $i < count($_POST['letras']); $i++) { 
		    		$query = "UPDATE respuestas SET letra = '".$_POST['letras'][$i]."', curso = ".$_POST['cursos'][$i]." WHERE id_ranking = ".$_POST['id_examen']." AND n_pregunta = ".$i;
		    		$this->modelo3->executor($query, "update");
		    	}
	    	}elseif ($_POST['metodo'] == "ist") {
	    		for ($i = 1; $i < count($_POST['letras']); $i++) { 
		    		$data = array();
		    		$data["n_pregunta"] = $i;
		    		$data["id_ranking"] = $_POST['id_examen'];
		    		$data["letra"] = $_POST['letras'][$i];
		    		$data["curso"] = $_POST['cursos'][$i];
		    		$this->modelo3->insert_data("respuestas", $data, false);
		    	}
	    	}
	    	echo json_encode(array("Result" => "OK"));
	    }
	    function save_respuestas_alt(){
	    	$this->modelo3->delete_data("respuestas", array("id_examen" => $_POST['id_examen']));
	    	$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];

			if (!$fileTmpLoc) {
			}
			if(move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/rankings/$fileName")){
				$excel = $fileName;
			} else {
			}

			require_once $_SERVER['DOCUMENT_ROOT'].'/intranet/PHPExcel/Classes/PHPExcel.php';
			$archivo = $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/rankings/".$excel;
			$inputFileType = PHPExcel_IOFactory::identify($archivo);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($archivo);
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();

			$celdas = array(
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L',
				'M',
				'N',
				'O',
				'P',
				'Q',
				'R',
				'S',
				'T',
				'U',
				'V',
				'W',
				'X',
				'Y',
				'Z',
				'AA',
				'AB',
				'AC',
				'AD',
				'AE',
				'AF',
				'AG',
				'AH',
				'AI',
				'AJ',
				'AK',
				'AL',
				'AM',
				'AN',
				'AO',
				'AP',
				'AQ',
				'AR',
				'AS',
				'AT',
				'AU',
				'AV',
				'AW',
				'AX',
				'AY',
				'AZ',
				'BA',
				'BB',
				'BC',
				'BD',
				'BE',
				'BF',
				'BG',
				'BH',
				'BI',
				'BJ',
				'BK',
				'BL',
				'BM',
				'BN',
				'BO',
				'BP',
				'BQ',
				'BR',
				'BS',
				'BT',
				'BU',
				'BV',
				'BW',
				'BX',
				'BY',
				'BZ',
				'CA',
				'CB',
				'CC',
				'CD'
			);
			$cols = $_POST['n_preguntas'];

			$qmarks = '(n_pregunta,id_examen,letra,curso)'. str_repeat(',(n_pregunta,id_examen,letra,curso)', $cols-1);

			$sql = "INSERT INTO `respuestas`(n_pregunta, id_examen, letra, curso) VALUES $qmarks";
			$vals = array();

			for ($row = 2; $row <= 2; $row++){
				for ($i = 1; $i <= $cols; $i++) { 
		    		$data[] = array(
		    			'n_pregunta' =>  $i,
						'id_examen' =>  $_POST['id_examen'],
						'letra' =>  $sheet->getCell($celdas[$i].$row)->getValue(),
						'curso' =>  $sheet->getCell($celdas[$i].($row + 1))->getValue(),
		    		);
				}
			}

			try {

                $this->modelo3->con->beginTransaction(); // also helps speed up your inserts.

				$datafields = array('n_pregunta', 'id_examen', 'letra', 'curso');

				$insert_values = array();
				foreach($data as $d){
				    $question_marks[] = '('  . $this->placeholders('?', sizeof($d)) . ')';
				    $insert_values = array_merge($insert_values, array_values($d));
				}

				$sql = "INSERT INTO respuestas (" . implode(",", $datafields ) . ") VALUES " .
				       implode(',', $question_marks);

				
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
	    public function loadexamenes() {
			$rankings = json_decode($this->modelo3->select_all("tbl_examenes", true));

			$result = array();
			foreach($rankings as $key => $value){
				$grupo = json_decode($this->modelo3->select_one("grupos", array("id" => $value->id_grupo)));

				$ciclo = json_decode($this->modelo3->select_one("ciclos", array("id" => $grupo->id_ciclo)));

				$area = json_decode($this->modelo3->select_one("areas", array("id" => $value->id_area)));

				$value->ciclo = "<p class=\"text-center\"><span class=\"w-100\" style=\"display: block;\">".$ciclo->ciclo." -</span><small>".$grupo->grupo."</small></p>";//$ciclo->ciclo;
				$value->grupo = $grupo->grupo;
				$value->area = $area->area;
				$result[] = $value;
			}

			echo json_encode($result);
	    }
	    function save_preguntas(){
			$ruta = $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/ranking_".$_POST["id"];
			if(file_exists($ruta)){
			}else{
				mkdir($ruta, 0777);
			}
	    	
	    	$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			}
			
			if(move_uploaded_file($fileTmpLoc, $ruta."/$fileName")){
				$_POST['id_examen'] = $_POST['id'];
				$_POST['pregunta'] = $fileName;
				$_POST['n_pregunta'] = $_POST['n_pregunta'];
				
			} else {
			}
			
			$cuenta = json_decode($this->modelo3->run_query("SELECT COUNT(*) as cant FROM preguntas_rankings WHERE id_examen = ".$_POST['id_examen']." AND n_pregunta = ".$_POST['n_pregunta'], false));
			if($cuenta[0]->cant == 0){
				echo $this->modelo3->insert_data("preguntas_rankings", $_POST, false);
			}else{
				$sql = "UPDATE preguntas_rankings SET pregunta = '".$_POST['pregunta']."' WHERE id_examen = ".$_POST['id_examen']." AND n_pregunta = ".$_POST['n_pregunta'];
				echo $this->modelo3->executor($sql, "update");
			}
		}
		function save_preguntas_enunciado(){
			$ruta = $_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/ranking_".$_POST["id"];
			if(file_exists($ruta)){
			}else{
				mkdir($ruta, 0777);
			}
	    	
	    	$fileName = $_FILES["file1"]["name"];
			$fileTmpLoc = $_FILES["file1"]["tmp_name"];
			$fileType = $_FILES["file1"]["type"];
			$fileSize = $_FILES["file1"]["size"];
			$fileErrorMsg = $_FILES["file1"]["error"];
			if (!$fileTmpLoc) {
			}
			
			if(move_uploaded_file($fileTmpLoc, $ruta."/$fileName")){
				$_POST['id_examen'] = $_POST['id'];
				$_POST['enunciado'] = $fileName;
				$_POST['n_pregunta'] = $_POST['n_pregunta'];
				
			} else {
			}

			$cuenta = json_decode($this->modelo3->run_query("SELECT COUNT(*) as cant FROM preguntas_rankings WHERE id_examen = ".$_POST['id_examen']." AND n_pregunta = ".$_POST['n_pregunta'], false));
			if($cuenta[0]->cant == 0){
				echo $this->modelo3->insert_data("preguntas_rankings", $_POST, false);
			}else{
				$sql = "UPDATE preguntas_rankings SET enunciado = '".$_POST['enunciado']."' WHERE id_examen = ".$_POST['id_examen']." AND n_pregunta = ".$_POST['n_pregunta'];
				echo $this->modelo3->executor($sql, "update");
			}
		}
	    function save(){
			$_POST['archivo'] = $_POST['iframe'];
			echo $this->modelo3->insert_data("tbl_examenes", $_POST, false);
	    }
	    function eliminar(){
	        $ar = json_decode($this->modelo3->select_one("tbl_examenes", array('id' => $_POST['id'])));
	        if($ar->archivo == "" || empty($ar->archivo) || $ar->archivo == null){
	        	echo $this->modelo3->delete_data("tbl_examenes", array('id' => $_POST['id']));
			    $this->modelo3->delete_data("resueltas", array("id_examen" => $_POST['id']));
			    $this->modelo3->delete_data("respuestas", array("id_examen" => $_POST['id']));
	        }else{
	        	if (!unlink($_SERVER['DOCUMENT_ROOT']."/intranet/system/controllers/ranking_".$ar->id)) {  
				    echo $this->modelo3->delete_data("tbl_examenes", array('id' => $_POST['id']));
				    $this->modelo3->delete_data("resueltas", array("id_examen" => $_POST['id']));
				    $this->modelo3->delete_data("respuestas", array("id_examen" => $_POST['id']));
				}  
				else {
				    echo $this->modelo3->delete_data("tbl_examenes", array('id' => $_POST['id']));
				    $this->modelo3->delete_data("resueltas", array("id_examen" => $_POST['id']));
				    $this->modelo3->delete_data("respuestas", array("id_examen" => $_POST['id']));
				}
	        }
	    }
	    function get_preguntas_guardadas(){
	    	$preguntas = json_decode($this->modelo3->select_all_where("preguntas_rankings", array("id_examen" => $_POST['id_ranking'])));
	    	echo json_encode($preguntas->Records);
	    }
	    function save_que(){
	    	echo $this->modelo3->insert_data("pregunta_ranking", $_POST, false);
	    }
	    function editar(){
	        $ranking = json_decode($this->modelo3->select_one("tbl_examenes", array('id' => $_POST['id_ranking'])));

	        $grupo = json_decode($this->modelo3->select_one("grupos", array("id" => $ranking->id_grupo)));

	        $ranking->id_ciclo = $grupo->id_ciclo;

	        echo json_encode($ranking);
	    }
	    function loadrespuestas(){
	    	$sql = "SELECT * FROM respuestas WHERE id_ranking = ".$_POST['id_examen']." ORDER BY n_pregunta ASC";
	    	echo $this->modelo3->run_query($sql, false);
	    }
	    function editarBD(){
	        $_POST['archivo'] = $_POST['iframe'];

	        echo $this->modelo3->update_data("tbl_examenes", $_POST);
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
