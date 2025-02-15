<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
class asistencia_diaria_2 extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function asistencia_diaria_2()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_asistencia_diaria_2");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        //$this->modelo2     = $this->load()->model("MySQLiManager");
        $this->modelo2     = $this->load()->model("Monodon");
        $this->modelo3     = $this->load()->model("Monodon");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Reporte Asistentes";
            $c["content"] = $this->html->container();
            $c["title"]   = "Reporte Asistentes";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Reporte Asistentes";
            $c["content"] = $this->html->container();
            $c["title"]   = "Reporte Asistentes";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    function load_asistencia_diaria()
    {
        if (empty($_GET['date']) || is_null($_GET['date'])) {
            $hoy = date("Y-m-d");
        } else {
            $hoy = $_GET['date'];
        }
        $sql_2 = "SELECT '" . $hoy . "' as hoy, us.id, concat(us.apellidos, ', ', us.nombres) as alumno, g.grupo, ci.ciclo FROM usuarios as us left JOIN grupos as g on us.id_grupo = g.id left join ciclos as ci on g.id_ciclo = ci.id where us.id IN (SELECT id_usuario FROM asistencias_new WHERE fecha = '" . $hoy . "') AND us.estado = 1";

        $asistencias_2 = json_decode($this->modelo3->run_query($sql_2, false));
        echo json_encode($asistencias_2);
    }
    private function valida($level)
    {
        if (isset($_SESSION["user_level"])) {
            if ($_SESSION["user_level"] == $level) {
                return true;
            } else
                return false;
        } else
            return false;
    }
    private function View($header, $content)
    {
        $h = $this->load()->view('header');
        $h->PrintHeader($header);
        $c = $this->load()->view('content');
        $c->PrintContent($content);
        $f = $this->load()->view('footer');
        $f->PrintFooter();
    }
}
