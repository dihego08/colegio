<?php
class ingresos_gastos extends f
{
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function ingresos_gastos()
    {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_ingresos_gastos");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
    }
    function index()
    {
        if ($this->valida(5)) {
            $h["title"]   = "Gastos";
            $c["content"] = $this->html->container();
            $c["title"]   = "Gastos";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Gastos";
            $c["content"] = $this->html->container();
            $c["title"]   = "Gastos";
            $this->View($h, $c);
        } else
            $this->Login();
    }
    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }
    function mostrar_proveedores()
    {
        $sql = "select * from t_proveedores";
        $proveedores = $this->modelo2->select('', '', '', $sql);
        foreach ($proveedores as $value) {
            echo '<option value="' . $value['id'] . '">' . $value['pro_razonsocial'] . '</option>';
        }
    }
    public function loadgastos()
    {
        if ($this->valida(5)) {
            $sql = "select * from t_gastos";
        } elseif ($this->valida(3)) {
            $sql = "select * from t_gastos ";
        }
        $gastos = $this->modelo2->select('', '', '', $sql);
        //echo json_encode($result);

        $data   = array();
        foreach ($gastos as $value) {
            $sqlProveedor = "select * from t_proveedores where id=" . $value['proveedor'];
            $proveedorResult = $this->modelo2->select('', '', '', $sqlProveedor);
            $proveedor = $proveedorResult[0]['pro_razonsocial'];

            array_push($data, array(
                "id" => mb_strtoupper($value['id']),
                "fecha" => mb_strtoupper($value['fecha']),
                "impuesto" => mb_strtoupper($value['impuesto']),
                "costo_total" => mb_strtoupper($value['costo_total']),
                "costo" => mb_strtoupper($value['costo']),
                "porcentaje_impuesto" => mb_strtoupper($value['porcentaje_impuesto']),
                "descripcion" => mb_strtoupper($value['descripcion']),
                "usuario" => mb_strtoupper($value['usuario']),
                "razon" => mb_strtoupper($value['razon']),
                "categoria" => mb_strtoupper($value['categoria']),
                "documento" => mb_strtoupper($value['documento']),
                "correlativo" => mb_strtoupper($value['correlativo']),
                "serie" => mb_strtoupper($value['serie']),
                "proveedor" => mb_strtoupper($proveedor),
                "aprobado" => mb_strtoupper($value['aprobado']),
                "nota" => mb_strtoupper($value['nota']),
                "retiro" => mb_strtoupper($value['retiro']),
                "condicion" => mb_strtoupper($value['condicion'])
            ));
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    function save()
    {
        $data['fecha']       = $_POST['fecha'];
        $data['costo_total'] = $_POST['costo_total'];
        $data['descripcion']         = $_POST['descripcion'];

        $data['categoria']         = $_POST['categoria'];
        $data['documento']        = $_POST['documento'];
        $data['serie'] = $_POST['serie'];
        $data['correlativo'] = $_POST['correlativo'];
        $data['proveedor']   = $_POST['proveedor'];
        $data['nota']          = $_POST['nota'];

        $this->modelo2->insert("t_gastos", $data);
        echo json_encode(array("Result" => "OK"));
    }
    function eliminar()
    {
        $id  = $_POST['id'];
        $param = "id = " . $id;
        $this->modelo2->delete('t_gastos', $param, true);
    }
    function editar()
    {
        $id  = $_POST['id'];
        $param = "id = " . $id;
        echo json_encode($this->modelo2->select('*', 't_gastos', $param, ''));
    }
    function editarBD()
    {

        $data['fecha']       = $_POST['fecha'];
        $data['costo_total'] = $_POST['costo_total'];
        $data['descripcion']         = $_POST['descripcion'];

        $data['categoria']         = $_POST['categoria'];
        $data['documento']        = $_POST['documento'];
        $data['serie'] = $_POST['serie'];
        $data['correlativo'] = $_POST['correlativo'];
        $data['proveedor']   = $_POST['proveedor'];
        $data['nota']          = $_POST['nota'];

        $this->modelo->update("t_gastos", $data, array("id" => $_POST['id']));
        echo json_encode(array("Result" => "OK"));
    }

    public function mostrar_select()
    {
        $sql = "select * from t_unidadesmedida";
        $unidades = $this->modelo2->select('', '', '', $sql);

        foreach ($unidades as $value) {
            echo '<option value="' . $value['id'] . '">' . $value['uni_nombre'] . '</option>';
        }
    }

    function Login()
    {
        $h["title"]   = "Iniciar Sesi&oacute;n";
        $c["title"]   = "Iniciar Sesi&oacute;n";
        $c["content"] = $this->html_basico->FormLogin();
        $this->View($h, $c);
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
    private function random_string($lenght = 6)
    {
        $str = "";
        for ($i = 1; $i <= $lenght; $i++) {
            $part = mt_rand(0, 2);
            switch ($part) {
                case 0:
                    $str .= mt_rand(0, 9);
                    break;
                case 1:
                    $str .= chr(mt_rand(65, 90));
                    break;
                case 2:
                    $str .= chr(mt_rand(97, 122));
                    break;
            }
        }
        return $str;
    }
}