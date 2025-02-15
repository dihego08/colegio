<?php
class usuario extends f {
    var $modelo = "";
    var $html_basico = "";
    var $html = "";
    var $baseurl = "";
    var $modelo2 = "";
    function usuario() {
        session_start();
        $this->html_basico = $this->load()->lib("Html_basico");
        $this->html        = $this->load()->lib("html_usuario");
        $this->modelo      = $this->load()->model("modelo");
        $this->baseurl     = BASEURL;
        $this->modelo2     = $this->load()->model("MySQLiManager");
    }
    function index() {
        if ($this->valida(5)) {
            $h["title"]   = "Usuarios";
            $c["content"] = $this->html->container();
            $c["title"]   = "Usuarios";
            $this->View($h, $c);
        } elseif ($this->valida(3)) {
            $h["title"]   = "Usuarios";
            $c["content"] = $this->html->container();
            $c["title"]   = "Usuarios";
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
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
   
    public function loadusuario() {
        if ($this->valida(5)) {
            $sql= "select *,t_ubicaciones.nombre as ubicacion from users inner join t_ubicaciones on t_ubicaciones.id=users.id_ubicacion";  
        } elseif ($this->valida(3)) {
            $sql= "select *,t_ubicaciones.nombre as ubicacion from users inner join t_ubicaciones on t_ubicaciones.id=users.id_ubicacion";  
        }
        $usuarios = $this->modelo2->select('','','',$sql);
        
        $data   = array();
        foreach ($usuarios as $value) {
            $tipo  ="";
            switch($value['level']){
                case '0': $tipo = "BLOQUEADO";break;
                case '1': $tipo = "CAJERO";break;
                case '3': $tipo = "ADMINISTRADOR";break;
                case '5': $tipo = "SUPERUSUARIO";break;
            }
            
            array_push($data, array(
                "id_user" => mb_strtoupper($value['id_user']),
                "fullname" => mb_strtoupper($value['fullname']),
                "email" => ($value['email']),
                "level" => mb_strtoupper($tipo),
                "ubicacion" => mb_strtoupper($value['ubicacion']),
            ));
        }
        
        echo json_encode($data,JSON_PRETTY_PRINT);
    }
    function save(){
        $data['id_ubicacion'] = $_POST['ubicacion'];

        $data['fullname'] = $_POST['fullname'];
        $data['email'] = $_POST['email'];
        $data['passt'] = md5($_POST['passt']);
        $data['level'] = $_POST['level'];
        
        $sql="select * from users where email='".$_POST['email']."'";
        $usuarios = $this->modelo2->select('','','',$sql);
        
        if(sizeof($usuarios)>0){
            echo "Usuario ya existe.";
            die();
            exit();
        }
        
        $this->modelo2->insert("users",$data);
        echo 1;
    }
    function eliminar(){
        $id  = $_POST['id'];
        $param = "id_user = ".$id;
        $this->modelo2->delete('users',$param,true);
    }
    function editar(){
        $id  = $_POST['id'];
        $param = "id_user = ".$id;
        echo json_encode($this->modelo2->select('*','users',$param,''));
    }
    function editarBD(){
        $data['fullname'] = $_POST['fullname'];
        $data['email'] = $_POST['email'];
        $data['passt'] = md5($_POST['passt']);
        $data['level'] = $_POST['level'];
        $this->modelo->update("users", $data, array("id_user" => $_POST['id']));
    }
    
    function Login() {
        $h["title"]   = "Iniciar Sesi&oacute;n";
        $c["title"]   = "Iniciar Sesi&oacute;n";
        $c["content"] = $this->html_basico->FormLogin();
        $this->View($h, $c);
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
    private function random_string($lenght = 6) {
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
