<?php
	/*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);*/

	class asistencias extends f{
		var $modelo = "";
    	var $html_basico = "";
    	var $html = "";
    	var $baseurl = "";
    	var $modelo2 = "";
		function asistencias() {
	        session_start();
	        $this->html_basico = $this->load()->lib("Html_basico");
	        $this->html        = $this->load()->lib("html_asistencias");
	        $this->modelo      = $this->load()->model("modelo");
	        $this->baseurl     = BASEURL;
	        $this->modelo2     = $this->load()->model("MySQLiManager");
	        $this->modelo3     = $this->load()->model("Monodon");
	    }
	    function index() {
	        if ($this->valida(5)) {
	            $h["title"]   = "Reporte de Asistencias";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Asistencias";
	            $this->View($h, $c);
	        } elseif ($this->valida(3)) {
	            $h["title"]   = "Reporte de Asistencias";
	            $c["content"] = $this->html->container();
	            $c["title"]   = "Reporte de Asistencias";
	            $this->View($h, $c);
	        } else
	            $this->Login();
	    }
	    public function loadasistencias() {
	    	$dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
            $id_alumno = $_GET['id_alumno'];
            $fecha_desde = new DateTime( $_GET['fecha_desde']);
            $fecha_hasta = new DateTime( $_GET['fecha_hasta']);
            $result = array();
            for($i = $fecha_desde; $i <= $fecha_hasta; $i->modify('+1 day')){
			    $sql = "SELECT h.*, c.curso FROM horarios as h, cursos as c, grupos as g, usuarios as u WHERE h.dia = ".$i->format("w")." AND h.id_curso = c.id AND c.id_grupo = g.id AND g.id = u.id_grupo AND u.id = ".$id_alumno;
			    $horarios = json_decode($this->modelo3->run_query($sql, false));
			    $cursos = '<table>';
			    foreach ($horarios as $key => $value) {
			    	$sql_asistencia = "SELECT * FROM tbl_asistencias WHERE id_curso = ".$value->id_curso." AND id_alumno = ".$id_alumno." AND fecha = '".$i->format("Y-m-d")."'";
			    	$asistencias = json_decode($this->modelo3->run_query($sql_asistencia, false));
			    	if(count($asistencias) == 0){
			    		$cursos .= '<td>
			    			<table>
			    				<tr>
			    					<th>'.$value->curso." (".$value->inicio." - ".$value->fin.")</th>
		    					</tr>
		    					<tr>
		    						<td class=\"text-center\">
		    							<span class=\"badge badge-danger\">FALTA</span>
	    							</td>
	    						</tr>
    						</table>
						</td>";
			    	}else{
			    		$cursos .= '<td><table><tr><th>'.$value->curso." (".$value->inicio." - ".$value->fin.")</th></tr><tr><td class=\"text-center\">".$asistencias[0]->entrada." - ".$asistencias[0]->salida."</td></tr></table></td>";
			    	}
			    }
			    $cursos .= '</table>';
			    $result[] = array(
			    	"fecha" => "<b>".$dias[$i->format("w")]."</b> ".$i->format("Y-m-d"),
			    	"asistencias" => $cursos
			    );
			}
			echo json_encode($result);
	    }
	    function save(){
	        echo $this->modelo3->insert_data("niveles", $_POST, false);
	    }
	    function eliminar(){
	        echo $this->modelo3->delete_data("niveles", array('id' => $_POST['id']));
	    }
	    function editar(){
	        echo $this->modelo3->select_one("niveles", array('id' => $_POST['id_nivel']));
	    }
	    function editarBD(){
	        echo $this->modelo3->update_data("tbl_notas", $_POST);
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