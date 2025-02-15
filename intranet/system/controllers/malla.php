<?php
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 3600);
ini_set('max_execution_time', 3600);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class malla extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function malla()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_malla");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
        $this->modelo3     = $this->load()->model("Monodon");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Gestion de Malla Curricular";
            $c["content"] = $this->html->container();
            $c["title"]   = "Gestion de Malla Curricular";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Gestion de Malla Curricular";
            $c["content"] = $this->html->container();
            $c["title"]   = "Gestion de Malla Curricular";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    public function get_malla()
    {
        $query = "SELECT * FROM malla ORDER BY id DESC Limit 1";
        $malla = json_decode($this->modelo3->run_query($query, false));
        if(count($malla) > 0){
            echo json_encode($malla[0]);
        }else{
            echo json_encode($malla);
        }
    }
    function save()
    {
        echo $this->modelo3->insert_data("malla", $_POST, false);
    }
    function add_index()
    {
        echo $this->modelo3->executor("UPDATE diplomados set estado = 1 WHERE id = " . $_POST['id'], "update");
    }
    function rem_index()
    {
        echo $this->modelo3->executor("UPDATE diplomados set estado = 0 WHERE id = " . $_POST['id'], "update");
    }
    function eliminar()
    {
        echo $this->modelo3->delete_data('diplomados', array("id" => $_POST['id']));
    }
    function editar()
    {
        $query = "SELECT * FROM malla ORDER BY id DESC Limit 1";
        $malla = json_decode($this->modelo3->run_query($query, false));
        if(count($malla) > 0){
            echo json_encode($malla[0]);
        }else{
            echo json_encode($malla);
        }
    }
    function ver_detalles()
    {
        echo $this->modelo3->select_one("diplomados", array('id' => $_POST['id_curso']));
    }
    function guardar_detalles()
    {
        $sql = "UPDATE diplomados SET dirigido_a = '" . $_POST['dirigido_a'] . "', metodologia = '" . $_POST['metodologia'] . "', certificacion = '" . $_POST['certificacion'] . "', ventajas = '" . $_POST['ventajas'] . "', plan_estudios = '" . $_POST['plan_estudios'] . "', competencias = '" . $_POST['competencias'] . "' WHERE id = " . $_POST['id'];
        echo $this->modelo3->executor($sql, "update");
    }
    function editarBD()
    {
        echo $this->modelo3->update_data("malla", $_POST);
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
