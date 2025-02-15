<?php
    class slider extends f{
        var $modelo = "";
        var $html_basico = "";
        var $html = "";
        var $baseurl = "";
        var $modelo2 = "";
        function slider() {
            session_start();
            $this->html_basico = $this->load()->lib("Html_basico");
            $this->html        = $this->load()->lib("html_slider");
            $this->modelo      = $this->load()->model("modelo");
            $this->baseurl     = BASEURL;
            $this->modelo2     = $this->load()->model("MySQLiManager");
            $this->modelo3     = $this->load()->model("Monodon");
        }
        function index() {
            //echo $_SESSION["id"]." - ".$_SESSION["user_level"];

            if ($_SESSION["id"] != NULL) {
                $h["title"]   = "Gestión de Slider";
                $c["content"] = $this->html->container();
                $c["title"]   = "Gestión de Slider";
                $this->View($h, $c);
            } elseif ($this->valida(10)) {
                $h["title"]   = "Gestión de Slider";
                $c["content"] = $this->html->container();
                $c["title"]   = "Gestión de Slider";
                $this->View($h, $c);
            } else
                $this->Login();
        }
        public function loadslider() {
            echo $this->modelo3->select_all("slider", true);
        }
        function add_index(){
            echo $this->modelo3->executor("UPDATE slider set estado = 1 WHERE id = ".$_POST['id'], "update");
        }
        function rem_index(){
            echo $this->modelo3->executor("UPDATE slider set estado = 0 WHERE id = ".$_POST['id'], "update");
        }
        function getAll(){
            echo json_encode($this->modelo2->select("","","","select * from slider"),JSON_PRETTY_PRINT);
        }
        function save(){
            $_POST['imagen'] = "";
            $fileName = $_FILES["file1"]["name"];
            $fileTmpLoc = $_FILES["file1"]["tmp_name"];
            $fileType = $_FILES["file1"]["type"];
            $fileSize = $_FILES["file1"]["size"];
            $fileErrorMsg = $_FILES["file1"]["error"];
            if (!$fileTmpLoc) {
                //exit();
            }
            if(move_uploaded_file($fileTmpLoc, "../img/$fileName")){
                $_POST['imagen'] = $fileName;
            } else {
            }
            $_POST['estado'] = 1;
            echo $this->modelo3->insert_data("slider", $_POST, false);
        }
        function eliminar(){
            $clase = json_decode($this->modelo3->select_one("slider", array('id' => $_POST['id'])));

            unlink('system/controllers/slider/'.$clase->imagen);

            echo $this->modelo3->delete_data("slider", array('id' => $_POST['id']));
        }
        function editar(){
            echo $this->modelo3->select_one("slider", array('id' => $_POST['id']));
        }
        function editarBD(){
            $clase = json_decode($this->modelo3->select_one("slider", array('id' => $_POST['id'])));
            if($_FILES['file1']['size'] == 0 && $_FILES['file1']['error'] == 0){
                $_POST['imagen'] = $clase->imagen;
            }else{
                $fileName = $_FILES["file1"]["name"];
                $fileTmpLoc = $_FILES["file1"]["tmp_name"];
                $fileType = $_FILES["file1"]["type"];
                $fileSize = $_FILES["file1"]["size"];
                $fileErrorMsg = $_FILES["file1"]["error"];
                if (!$fileTmpLoc) {
                    exit();
                }
                if(move_uploaded_file($fileTmpLoc, "../img/$fileName")){
                    $_POST["imagen"] = $fileName;
                } else {
                }
            }
            echo $this->modelo3->update_data("slider", $_POST);
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
        function Login() {
            $h["title"]   = "Iniciar Sesi&oacute;n";
            $c["title"]   = "Iniciar Sesi&oacute;n";
            $c["content"] = $this->html_basico->FormLogin();
            $this->View($h, $c);
        }
    }
?>