<?php
    class rutas extends f{
        var $modelo = "";
        var $html_basico = "";
        var $html = "";
        var $baseurl = "";
        var $modelo2 = "";
        function rutas() {
            session_start();
            $this->html_basico = $this->load()->lib("Html_basico");
            $this->html        = $this->load()->lib("html_rutas");
            $this->modelo      = $this->load()->model("modelo");
            $this->baseurl     = BASEURL;
            //$this->modelo2     = $this->load()->model("MySQLiManager");
            $this->modelo2     = $this->load()->model("Monodon");
        }
        function index() {
            if ($this->valida(5)) {
                $h["title"]   = "Rutas";
                $c["content"] = $this->html->container();
                $c["title"]   = "Rutas";
                $this->View($h, $c);
            } elseif ($this->valida(3)) {
                $h["title"]   = "Rutas";
                $c["content"] = $this->html->container();
                $c["title"]   = "Rutas";
                $this->View($h, $c);
            } else
                $this->Login();
        }
        public function get_ruta(){
            $sql = "SELECT * FROM rutas WHERE identificador LIKE '%".$_GET['term']."%'";
            $result = json_decode($this->modelo2->run_query($sql));
            $values = array();
            foreach ($result as $key) {
                $values[] = array(
                    'id' => $key->id,
                    'value' => $key->identificador
                );
            }
            echo json_encode($values);
        }
        public function get_one(){
            $result = $this->modelo2->select_one("rutas", array('id' => $_GET['id_ruta']));
            echo $result;
        }
        public function loadrutas() {
            $result = $this->modelo2->select_all("rutas", true);//select_all("rutas", true);
            echo $result;
        }
        function save(){
            echo $this->modelo2->insert_data("rutas", $_POST, false);
        }
        function eliminar(){
            $this->modelo2->delete_data("rutas", array('id' => $_POST['id']));
        }
        function editar(){
            echo $this->modelo2->select_one("rutas", array('id' => $_POST['id']));
        }
        function editarBD(){
            echo $this->modelo2->update_data("rutas", $_POST);
        }
        function combo_departamento(){
            echo $this->modelo2->select_all("ubdepartamento", false);
        }
        function combo_provincia(){
            echo $this->modelo2->select_all_where("ubprovincia", array('idDepa' => $_POST['idDepa'],), false);
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