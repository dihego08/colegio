<?php
class Header {
    function Header() {
    }
    function PrintHeader($data) {
        $baseurl = BASEURL;
        echo '
<html>' . PHP_EOL . '
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" media="all">-->
    
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">' . PHP_EOL . '
       <script src="https://kit.fontawesome.com/03bde48e5b.js"></script>
<link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">

' . PHP_EOL . '
<title>' . $data["title"] . '</title>' . PHP_EOL . '
<meta name="viewport" content="width=device-width, initial-scale=1.0" />' . PHP_EOL . '
<link rel="icon" type="image/png" href="' . $baseurl . 'includes/img/icons/favicon.png"/>' . PHP_EOL;
        echo $this->agregar_links('js', 'jquery', 'jquery-1.12.4.min') . PHP_EOL;
        echo $this->agregar_links('css', 'bootstrap/css', 'bootstrap.min') . PHP_EOL;
        echo $this->agregar_links('js', 'bootstrap/js', 'bootstrap.min') . PHP_EOL;
        echo $this->agregar_links('js', 'bootstrap/js', 'popper.min') . PHP_EOL;
        echo $this->agregar_links('css', 'datatables', 'datatables.min') . PHP_EOL;
        echo $this->agregar_links('js', 'datatables', 'datatables.min') . PHP_EOL;
        echo $this->agregar_links('js', 'general', 'datatables') . PHP_EOL;
        echo $this->agregar_links('js', 'colorbox', 'jquery.colorbox-min') . PHP_EOL;
        echo $this->agregar_links('css', 'colorbox', 'colorbox') . PHP_EOL;
        echo $this->agregar_links('js', 'dialog_prompt', 'jquery-impromptu') . PHP_EOL;
        echo $this->agregar_links('css', 'dialog_prompt', 'jquery-impromptu') . PHP_EOL;
        echo $this->agregar_links('css', 'general', 'navbar') . PHP_EOL;
        echo $this->agregar_links('css', 'general', 'datatable') . PHP_EOL;
        echo $this->agregar_links('css', 'general', 'general') . PHP_EOL;
        echo $this->agregar_links('js', 'general', 'datepicker') . PHP_EOL;
        echo $this->agregar_links('css', 'alertifyjs/css', 'alertify.min') . PHP_EOL;
        echo $this->agregar_links('css', 'alertifyjs/css', 'bootstrap.min') . PHP_EOL;
        echo $this->agregar_links('js', 'alertifyjs/js', 'alertify.min') . PHP_EOL;
       echo $this->agregar_links('css', 'jqueryui', 'jquery-ui.min') . PHP_EOL;
        echo $this->agregar_links('css', 'jqueryui', 'jquery-ui.theme.min') . PHP_EOL;
        echo $this->agregar_links('js', 'jqueryui', 'jquery-ui.min') . PHP_EOL;
        echo $this->agregar_links('js', 'highcharts', 'jsapi') . PHP_EOL;
        echo $this->agregar_links('js', 'highcharts', 'loader') . PHP_EOL;
        echo '<script>' . PHP_EOL . '      
      function showLoading(){$(".loading").css("display","inline");}' . PHP_EOL . '
      function hideLoading(){$(".loading").css("display","none");}' . PHP_EOL . ' 
       </script>' . PHP_EOL . '
       <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
   </head>' . PHP_EOL;
    }
    public function agregar_links($tipo_archivo, $carpeta, $archivo) {
        switch ($tipo_archivo) {
            case 'css':
                return '<link rel="stylesheet" href="' . BASEURL . 'includes/' . $carpeta . '/' . $archivo . '.css">';
                break;
            case 'js':
                return '<script type="text/javascript" src="' . BASEURL . 'includes/' . $carpeta . '/' . $archivo . '.js"></script>';
                break;
            default:
            case '':
                exit;
                break;
        }
    }
    public static function menu() {
         include("check_logo.php"); 
        //session_start();
        $baseurl = BASEURL;
        echo '<nav  style="background-color:'.$color_general.';"   class="navbar navbar-expand-md navbar-dark navbar-custom p-0 fixed-top">
                <a class="navbar-brand" href="#">';
        
        $baseurl = BASEURL;
        if($flag==1){
            echo '<img class="img-fluid" src="' . $baseurl . 'includes/img/logo.png" alt="" style="width:250px;height:100px">';
        }else{
            echo $nombre_empresa;
        }
    echo'</a>
    <style>
        .navbar-custom .navbar-nav .nav-link{
            color:'.$color_letra.'!important;
        }
        .colorLetra{
            color:red!important;    
        }
    </style>
    <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a id="" class="nav-link" href="#" onclick="location.href = \'' . $baseurl . '\'">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Control </a>
                <div class="dropdown-menu">
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'ventas/">Ventas</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'venta_rapida/">Venta R&aacutepida</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'orden_compra/">Orden de Compra</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'compras/">Compras</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'gastos/">Gastos</a>
                    
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'cotizaciones/">Cotizaciones</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'kits/">Kits</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'kardex/">Kardex</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'pagos/">Pagos</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'pagos_archivados/">Pagos Archivados</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'historial_pagos/">Historial de Pagos</a>

                     <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'cobranzas/">Cobranzas</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'cobranzas_archi/">Cobranzas Archivadas</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'historial_cobros/">Historial de Cobros</a>


                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'clientes/">Clientes</a>
                     <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'proveedores/">Proveedores</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Almacen </a>
                <div class="dropdown-menu">
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'articulo/">Articulos</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'lista_precio/">Lista Precios</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'familia/">Familia</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'marca/">Marca</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'fabricante/">Fabricante</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'unidadmedida/">Unidad de Medida</a>
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'ubicacion/">Ubicaciones</a>
                </div>
            </li>
            
            <li class="nav-item">
                <a id="" class="nav-link" href="' . $baseurl . INDEX . 'ventas/" >Venta</a>
            </li>
            
            <li class="nav-item">
                <a id="" class="nav-link" href="' . $baseurl . INDEX . 'venta_rapida/" >Venta R&aacutepida</a>
            </li>
            <li class="nav-item">
                <a id="" class="nav-link" href="' . $baseurl . INDEX . 'reporte/" >Reporte General</a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Configuracion </a>
                <div class="dropdown-menu">
                    <!-- <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'costo_servicio/">Fondo Capital</a> -->
                    <!-- <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'costo_servicio/valores/">Valores por defecto</a> -->
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'configuracion_empresa/">Empresa</a>
                </div>
            </li> 
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Usuarios </a>
                <div class="dropdown-menu">
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'usuario/">Usuarios</a>
                </div>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Cuenta </a>
                <div class="dropdown-menu">
                    <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'home/logout">Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>';
    }
}
?>
