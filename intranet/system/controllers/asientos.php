<?php
    class asientos extends f{
        var $modelo = "";
        var $html_basico = "";
        var $html = "";
        var $baseurl = "";
        var $modelo2 = "";
        function asientos() {
            session_start();
            $this->html_basico = $this->load()->lib("Html_basico");
            $this->html        = $this->load()->lib("html_asientos");
            $this->modelo      = $this->load()->model("modelo");
            $this->baseurl     = BASEURL;
            //$this->modelo2     = $this->load()->model("MySQLiManager");
            $this->modelo2     = $this->load()->model("Monodon");
        }
        function index() {
            if ($this->valida(5)) {
                $h["title"]   = "Asientos";
                $c["content"] = $this->html->container();
                $c["title"]   = "Asientos";
                $this->View($h, $c);
            } elseif ($this->valida(3)) {
                $h["title"]   = "Asientos";
                $c["content"] = $this->html->container();
                $c["title"]   = "Asientos";
                $this->View($h, $c);
            } else
                $this->Login();
        }
        public function loadsalidas() {
            $sql = "SELECT s.id, r.identificador, s.fecha, s.hora_salida, b.placa, c.apellidos FROM salidas s, rutas r, buses b, conductores c WHERE s.id_ruta = r.id AND s.id_bus = b.id AND s.id_conductor_1 = c.id";
            echo $this->modelo2->run_query($sql);
        }
        public function get_asientos(){
            echo $this->modelo2->select_all_where("asientos", array('placa_bus' => $_GET['placa_bus'], 'piso' => $_GET['piso']), false);
        }
        public function get_salida(){
            $sql = "SELECT s.id, r.identificador, s.fecha, s.hora_salida FROM salidas s, rutas r WHERE s.id_ruta = r.id AND r.identificador LIKE '%".$_GET['term']."%'";
            $result = json_decode($this->modelo2->run_query($sql));
            $values = array();
            foreach ($result as $key) {
                $values[] = array(
                    'id' => $key->id,
                    'value' => $key->identificador." - ".$key->fecha." - ".$key->hora_salida
                );
            }
            echo json_encode($values);
        }
        public function get_one(){
            $sql = "SELECT s.id, r.identificador, s.fecha, s.hora_salida, b.placa, c.apellidos, b.modelo, b.t_asientos FROM salidas s, rutas r, buses b, conductores c WHERE s.id_ruta = r.id AND s.id_bus = b.id AND s.id_conductor_1 = c.id AND s.id = ".$_GET['id_ruta'];
            echo $this->modelo2->run_query($sql);
        }
        function guardar_tipo_asiento(){
            $sql = "UPDATE asientos SET id_tipo = ". $_POST['id_tipo'] .", estado = NULL, background = '".$_POST['background']."' WHERE placa_bus = '". $_POST['placa_bus'] ."' AND piso = ". $_POST['piso']." AND n_asiento = ".$_POST['n_asiento'];
            echo $this->modelo2->executor($sql, "update");
        }
        function save(){
            echo $this->modelo2->insert_data("salidas", $_POST, false);
        }
        function eliminar(){
            $this->modelo2->delete_data("salidas", array('id' => $_POST['id']));
        }
        function editar(){
            $sql = "SELECT s.id, r.identificador, s.fecha, s.hora_salida, b.placa, b.modelo, CONCAT(c.apellidos, ', ', c.nombres) as conductor_1, CONCAT(c.apellidos, ', ', c.nombres) as conductor_2, b.id as id_bus, r.id as id_ruta, c.id as id_conductor_2, c.id as id_conductor_1 FROM salidas s, rutas r, buses b, conductores c WHERE s.id_ruta = r.id AND s.id_bus = b.id AND s.id_conductor_1 = c.id AND b.id = ".$_POST['id'];
            echo $this->modelo2->run_query($sql);
        }
        function editarBD(){
            echo $this->modelo2->update_data("salidas", $_POST);
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