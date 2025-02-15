<?php
class sunat extends f {
    public function __construct() {
        parent::__construct();
    }
    
    public function datos_jossmp() {
        
        //require("/home/iacorp/public_html/sisventademo/includes/jossmp/sunatphp/src/autoload.php");
        require("/home/adiasis/public_html/ferreteriasansebastian/includes/jossmp/sunatphp/src/autoload.php");
        
        $company = new \Sunat\Sunat();
        $ruc = $_POST['ruc'];
        
        $search = $company->search($ruc);
        echo json_encode($search);
    }
    public function datos_konta($ruc) {
        /*require("/home/iacorp/public_html/sisventademo/includes/konta/sunat/src/Konta/curl.php");
        require("/home/iacorp/public_html/sisventademo/includes/konta/sunat/src/Konta/sunat.php");*/
        require("/home/adiasis/public_html/ferreteriasansebastian/includes/konta/sunat/src/Konta/curl.php");
        require("/home/adiasis/public_html/ferreteriasansebastian/includes/konta/sunat/src/Konta/sunat.php");
        
        $cliente         = new Konta\Sunat;
        $ruc             = trim($ruc);
        $datos_sunat     = $cliente->BuscaDatosSunat($ruc);
        //$datos_obtenidos = $this->separar_direccion($datos_sunat['Direccion']);
        //$resultado       = array_merge($datos_sunat, $datos_obtenidos);
        echo json_encode($datos_sunat, JSON_PRETTY_PRINT);
    }
    public function separar_direccion($datos) {
        $direccion            = trim($datos);
        $variable             = explode("-", trim($direccion));
        $variable             = array_reverse($variable);
        $conteo               = count($variable) - 1;
        $deparmanento_separar = explode(" ", trim($variable[2]));
        $conto_depa           = count($deparmanento_separar) - 1;
        $departamento         = trim($deparmanento_separar[$conto_depa]);
        $provincia            = trim($variable[$conteo - $conteo + 1]);
        $distrito             = trim($variable[$conteo - $conteo]);
        $data                 = array(
            'ubi_departamento' => $departamento,
            'ubi_provincia' => $provincia,
            'ubi_distrito' => $distrito
        );
        $ubigeo               = Ubigeo::whereV($data, 'and');
        $juntar               = '';
        for ($i = 0; $i <= $conto_depa - 1; $i++) {
            $juntar = $juntar . ' ' . $deparmanento_separar[$i];
        }
        $datos_final = array(
            'Direccion_corregida' => trim($juntar),
            'Id_ubigeo' => $ubigeo[0]['id'],
            'ubi_departamento' => $departamento,
            'ubi_provincia' => $provincia,
            'ubi_distrito' => $distrito
        );
        return $datos_final;
    }
}