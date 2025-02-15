<?php
class horarios extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function horarios()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_horarios");
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
        $sql = "SELECT c.ciclo, cu.curso, g.grupo, h.* FROM cursos as cu, ciclos as c, grupos as g, horarios as h WHERE g.id = cu.id_grupo AND g.id_ciclo = c.id AND h.id_curso = cu.id";
        echo $this->modelo3->run_query($sql, false);
    }
    function save()
    {
        echo $this->modelo3->insert_data("horarios", $_POST, false);
    }
    function eliminar()
    {
        echo $this->modelo3->delete_data("horarios", array("id" => $_POST['id']));
    }
    function editar()
    {
        /*$sql = "SELECT h.*, t.id_modulo FROM horarios as h, tbl_temas as t WHERE t.id = h.id_tema AND h.id = ".$_POST['id'];
        $data = json_decode($this->modelo3->run_query($sql, false));

        echo json_encode($data[0]);*/

        $horario = json_decode($this->modelo3->select_one("horarios", array('id' => $_POST['id'])));

        //print_r($horario);

        $curso = json_decode($this->modelo3->select_one("cursos", array("id" => $horario->id_curso)));

        $grupo = json_decode($this->modelo3->select_one("grupos", array("id" => $curso->id_grupo)));

        //$ciclo = json_decode($this->modelo3->select_one("ciclos", array("id" => $grupo->id_ciclo)));

        $horario->id_ciclo = $grupo->id_ciclo;
        $horario->id_grupo = $grupo->id;

        echo json_encode($horario);
    }
    function editarBD()
    {
        echo $this->modelo3->update_data("horarios", $_POST);
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
