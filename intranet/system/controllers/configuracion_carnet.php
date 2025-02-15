<?php
class configuracion_carnet extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function configuracion_carnet()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_configuracion_carnet");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
        $this->modelo3     = $this->load()->model("Monodon");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Configuracion de Diseño de Carnet";
            $c["content"] = $this->html->container();
            $c["title"]   = "Configuracion de Diseño de Carnet";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Configuracion de Diseño de Carnet";
            $c["content"] = $this->html->container();
            $c["title"]   = "Configuracion de Diseño de Carnet";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    public function loadconfiguracion_carnet()
    {
        $sql = "SELECT * FROM settings ORDER BY id DESC LIMIT 1;";
        echo $this->modelo3->run_query($sql, false);
    }
    function save()
    {
        $_POST['imagen'] = "";
        $aux = 0;
        $fileName = $_FILES["foto"]["name"];
        $fileTmpLoc = $_FILES["foto"]["tmp_name"];
        $fileType = $_FILES["foto"]["type"];
        $fileSize = $_FILES["foto"]["size"];
        $fileErrorMsg = $_FILES["foto"]["error"];
        if (!$fileTmpLoc) {
            //exit();
        }

        if (move_uploaded_file($fileTmpLoc, $_SERVER['DOCUMENT_ROOT'] . "/intranet/system/controllers/fondos_carnet/$fileName")) {
            $_POST['imagen'] = $fileName;
            echo "Se ha guardado";
        } else {
        }

        echo $this->modelo3->insert_data("settings", $_POST, false);
    }
    function eliminar()
    {
        echo $this->modelo3->delete_data("horario_ciclo", array("id" => $_POST['id']));
    }
    function editar()
    {
        $horario = json_decode($this->modelo3->select_one("horario_ciclo", array('id' => $_POST['id'])));

        $grupo = json_decode($this->modelo3->select_one("grupos", array("id" => $horario->id_grupo)));

        $curso = json_decode($this->modelo3->select_one("ciclos", array("id" => $grupo->id_ciclo)));

        $horario->id_ciclo = $grupo->id_ciclo;
        $horario->id_grupo = $grupo->id;

        echo json_encode($horario);
    }
    function editarBD()
    {
        echo $this->modelo3->update_data("horario_ciclo", $_POST);
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
