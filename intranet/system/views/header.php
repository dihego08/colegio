<?php
class Header
{
    var $el_titulo = "";
    function Header() {}
    function PrintHeader($data)
    {
        $baseurl = BASEURL;
        $this->el_titulo = $data["title"];
        echo '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="utf-8" />
            <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
            <link rel="icon" type="image/png" href="assets/img/favicon.png">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . PHP_EOL . '
            <title>' . $data["title"] . '</title>' . PHP_EOL . '
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />' . PHP_EOL . '
            <link rel="icon" type="image/png" href="' . $baseurl . 'includes/img/icons/favicon.png"/>' . PHP_EOL;
        echo '<meta content=\'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no\'
            name=\'viewport\' />
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
            <!-- CSS Files -->
            <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
            <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
            <!-- CSS Just for demo purpose, don\'t include it in your project -->
            <link href="assets/demo/demo.css" rel="stylesheet" />
            <!--   Core JS Files   -->
            <script src="assets/js/core/jquery.min.js"></script>
            <script src="assets/js/core/popper.min.js"></script>
            <script src="assets/js/core/bootstrap.min.js"></script>
            <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
            <!-- Chart JS -->
            <script src="assets/js/plugins/chartjs.min.js"></script>
            <!--  Notifications Plugin    -->
            <script src="assets/js/plugins/bootstrap-notify.js"></script>
            <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
            <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet" />
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>';


        echo $this->agregar_links('css', 'jqueryui', 'jquery-ui.theme.min') . PHP_EOL;
        echo $this->agregar_links('js', 'jqueryui', 'jquery-ui.min') . PHP_EOL;
        echo $this->agregar_links('css', 'alertifyjs/css', 'alertify.min') . PHP_EOL;
        echo $this->agregar_links('css', 'alertifyjs/css', 'bootstrap.min') . PHP_EOL;
        echo $this->agregar_links('js', 'alertifyjs/js', 'alertify.min') . PHP_EOL;

        /*echo $this->agregar_links('css', 'datatables', 'datatables.min') . PHP_EOL;
        	echo $this->agregar_links('js', 'datatables', 'datatables.min') . PHP_EOL;*/
        //echo $this->agregar_links('js', 'general', 'datatables') . PHP_EOL;

        echo '<script>' . PHP_EOL . '      
                function showLoading(){$(".loading").css("display","inline");}' . PHP_EOL . '
                function hideLoading(){$(".loading").css("display","none");}' . PHP_EOL . ' 
            </script>' . PHP_EOL . '
            <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

            
            <style>
                .dropdown.show .dropdown-menu[x-placement="top-start"], .dropup.show .dropdown-menu[x-placement="top-start"]{
                    left: 60px !important;
                }
                .dropdown.show .dropdown-menu[x-placement="bottom-start"], .dropup.show .dropdown-menu[x-placement="bottom-start"]{
                    left: 60px !important;
                }
            </style>
   </head>' . PHP_EOL;
    }
    public function agregar_links($tipo_archivo, $carpeta, $archivo)
    {
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
    public static function menu()
    {
        include("check_logo.php");
        $baseurl = BASEURL;
        echo '
        <body><div class="wrapper ">
        <div class="sidebar hideprint" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="#" class="simple-text logo-mini">
                    <div class="logo-image-small">
                        <img src="/img/logo.png">
                    </div>
                </a>
                <a href="#" class="simple-text logo-normal a_nombre">
                	LA CLAVE
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item">
                        <a id="" class="nav-link" href="#" onclick="location.href = \'' . $baseurl . '\'">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'notas/">Notas Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'notas_2/">Notas x Alumno</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'informe/">Informe Académico</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'asistencias_2/">Asistencias</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'inasistencias/">Inasistencias</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'asistencia_diaria/">Reporte Inasistencias</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'asistencia_diaria_2/">Reporte Asistencias</a>
                    </li>
                    <!--<li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'aulas/">Asignación de Aulas</a>
                    </li>-->
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'clasificacion_alumnos/">Clasificación de Alumnos</a>
                    </li>

                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'asistencias_new/">Asistencias Lectora</a>
                    </li>

                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'videos/">Vídeos</a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'biblioteca/">Biblioteca</a>
                    </li>
                    
                    <li class="nav-item">
                        <a id="" class="nav-link" href="' . $baseurl . INDEX . 'configuracion_carnet/">Configuracion Carnet</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Control </a>
                        <div class="dropdown-menu">
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'alumnos/">Alumnos</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'profesores/">Profesores</a>
                            <!--<a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'ciclos/">Ciclos</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'grupos/">Grupos</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'cursos/">Cursos</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'salas/">Salas</a>-->
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'examenes/">Examenes</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'pagos_2/">Pagos</a>
<!--
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'horario_ciclo/">Horarios</a>

                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'carreras/">Carreras</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'universidades/">Universidades</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'proveedores/">Proveedores</a>-->
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'gastos/">Gastos</a>
                            <!--<a id="" class="nav-link" href="' . $baseurl . INDEX . 'aulas/">Aulas</a>-->
                            <a id="" class="nav-link" href="' . $baseurl . INDEX . 'grados/">Grados</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Reportes </a>
                        <div class="dropdown-menu">
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'ingresos_gastos/">Ingresos vs Gastos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Pagina Web </a>
                        <div class="dropdown-menu">
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'brochure/">Brochure</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'slider/">Slider</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'videos_web/">Videos</a>
                            <!--<a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'precios/">Precios</a>
                            <a id="" class="dropdown-item" href="' . $baseurl . INDEX . 'facilidades/">Facilidades</a>-->
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
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;"></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                </div>
            </nav>
            <!-- End Navbar -->';
    }
}
