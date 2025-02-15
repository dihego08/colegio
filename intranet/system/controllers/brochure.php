<?php
class brochure extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function brochure()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_brochure");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
        $this->modelo3     = $this->load()->model("Monodon");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Brochure";
            $c["content"] = $this->html->container();
            $c["title"]   = "Brochure";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Brochure";
            $c["content"] = $this->html->container();
            $c["title"]   = "Brochure";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    public function loadbrochure()
    {
        echo $this->modelo3->select_all("brochure", true);
    }
    function save()
    {
        $res = 0;

        $tmpFilePath = $_FILES['file1']['tmp_name'];
        if ($tmpFilePath != "") {
            $newFilePath = $_SERVER['DOCUMENT_ROOT'] . "/web/" . $_FILES['file1']['name'];
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $_POST['brochure'] = $_FILES['file1']['name'];
                $this->modelo3->insert_data("brochure", $_POST, false);
            } else {
                $res = $res + 1;
            }
        }
        if ($res > 0) {
            echo json_encode(array('Result' => "ERROR"));
        } else {
            echo json_encode(array('Result' => "OK"));
        }
    }
    function eliminar()
    {
        $ar = json_decode($this->modelo3->select_one("brochure", array('id' => $_POST['id'])));
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/web/" . $ar->brochure)){
        	unlink($_SERVER['DOCUMENT_ROOT'] . "/web/" . $ar->brochure);
        	echo $this->modelo3->delete_data("brochure", array('id' => $_POST['id']));
        }else{
        	echo $this->modelo3->delete_data("brochure", array('id' => $_POST['id']));
        }
        
    }
    function editar()
    {
        echo $this->modelo3->select_one("categorias", array('id' => $_POST['id_categoria']));
    }
    function editarBD()
    {
        echo $this->modelo3->update_data("categorias", $_POST);
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
