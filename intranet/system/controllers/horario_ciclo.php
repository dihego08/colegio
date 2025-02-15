<?php
class horario_ciclo extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function horario_ciclo()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_horario_ciclo");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
        $this->modelo3     = $this->load()->model("Monodon");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Configuracion de Horarios";
            $c["content"] = $this->html->container();
            $c["title"]   = "Configuracion de Horarios";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Configuracion de Horarios";
            $c["content"] = $this->html->container();
            $c["title"]   = "Configuracion de Horarios";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    public function loadhorarios()
    {
        $sql = "SELECT c.ciclo, g.grupo, h.* FROM ciclos as c, grupos as g, horario_ciclo as h WHERE g.id_ciclo = c.id AND g.id = h.id_grupo;";
        echo $this->modelo3->run_query($sql, false);
    }
    function save()
    {
        echo $this->modelo3->insert_data("horario_ciclo", $_POST, false);
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
