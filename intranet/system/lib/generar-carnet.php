<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('allow_url_fopen', 1);
$id_alumno = $_GET['id'];
include("env.php");

require('picker/vendor/autoload.php');

use Picqer\Barcode\BarcodeGeneratorPNG;

$generator = new BarcodeGeneratorPNG();
//echo $generator->getBarcode('123456789', $generator::TYPE_CODE_128);

$query_configuracion = $mbd->prepare("SELECT * FROM settings ORDER BY id DESC LIMIT 1;");
$query_configuracion->execute();
$settings = $query_configuracion->fetch(PDO::FETCH_ASSOC);


$query = $mbd->prepare("SELECT * FROM usuarios where id in (" . $id_alumno . ")");
$query->execute();
$carnets = "";
$auxiliar = 0;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $query_horario = $mbd->prepare("SELECT hora_inicio, hora_fin FROM horario_ciclo WHERE id_grupo = :id");
    $query_horario->bindParam(":id", $row['id_grupo']);
    $query_horario->execute();
    $hora_inicio = '';
    $hora_fin = '';
    $auxiliar_horario = 0;
    while ($r = $query_horario->fetch(PDO::FETCH_ASSOC)) {
        if ($auxiliar_horario == 0) {
            $hora_inicio = $r['hora_inicio'] . ' - ' . $r['hora_fin'];
        } else {
            $hora_fin = $r['hora_inicio'] . ' - ' . $r['hora_fin'];
        }
        $auxiliar_horario++;
    }

    if ($auxiliar == 0) {
        $carnets .= '<tr>';
        $carnets .= '<td style="width: 50%; padding-top: 1%; padding-bottom:2%; padding-left: 6%; padding-right: 16%; margin: 0;">
        <div style="position:relative; border: solid 1px; width: 80mm; height: 48mm; background-image:url(\'https://laclave.diegoaranibar.com/intranet/system/controllers/fondos_carnet/' . $settings['imagen'] . '\');background-size: contain;background-position: top;background-repeat: no-repeat;">
            
            
            
            <table style="width: 100%; margin-top: 15%;">
                <tr>
                    <td style="width: 30%;">
                        <img src="https://laclave.diegoaranibar.com/intranet/system/controllers/photo/' . $row['foto'] . '" style="width: 100%; z-index: 0;">
                    </td>
                    <td>
                        <table border="0" style="width: 100%;" >
                            <tr>
                                <td style="width: 25%; padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Nombres:</h5>
                                </td>
                                <td style="width: 75%; padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['nombres'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Apellidos:</h5>
                                </td>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['apellidos'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Horario:</h5>
                                </td>
                                <td style=" padding: 5px;"><h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $hora_inicio . '<br>' . $hora_fin . '</h5></td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Código:</h5>
                                </td>
                                <td style="text-align: center; font-size: 0.70rem;padding: 5px;">
                                    <div style="width: 100%; text-align: center;">
                                        <img style="width: 80%;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($row['dni'], $generator::TYPE_CODE_128)) . '">
                                    </div>
                                    <span style="display: block;">' . $row['dni'] . '</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h5 style="font-size: 1.2rem; font-weight: 700; margin: 0 !important; color: ' . $settings['color_texto'] . '; text-align: right; display: block; width: 100%;">
                                        ' . date("Y") . '
                                    </h5>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            
            </div>
        </td>';
    } elseif ($auxiliar > 1) {
        $carnets .= '</tr>';
        $auxiliar = 0;
        $carnets .= '<tr>';
        $carnets .= '<td style="width: 50%; padding-top: 1%; padding-bottom:2%; padding-left: 6%; padding-right: 16%; margin: 0; min-height: 400px;">
            <div style="position:relative; border: solid 1px; width: 80mm; height: 48mm; background-image:url(\'https://laclave.diegoaranibar.com/intranet/system/controllers/fondos_carnet/' . $settings['imagen'] . '\');background-size: contain;background-position: top;background-repeat: no-repeat;">
                
                
                <table style="width: 100%; margin-top: 15%;">
                <tr>
                    <td style="width: 30%;">
                        <img src="https://laclave.diegoaranibar.com/intranet/system/controllers/photo/' . $row['foto'] . '" style="width: 100%; z-index: 0;">
                    </td>
                    <td>
                        <table border="0" style="width: 100%;">
                            <tr>
                                <td style="width: 25%; padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Nombres:</h5>
                                </td>
                                <td style="width: 75%; padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['nombres'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Apellidos:</h5>
                                </td>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['apellidos'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Horario:</h5>
                                </td>
                                <td style=" padding: 5px;"><h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $hora_inicio . '<br>' . $hora_fin . '</h5></td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Código:</h5>
                                </td>
                                <td style="text-align: center; font-size: 0.70rem; padding: 5px;">
                                    <div style="width: 100%; text-align: center;">
                                        <img style="width: 80%;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($row['dni'], $generator::TYPE_CODE_128)) . '">
                                    </div>
                                    <span style="display: block;">' . $row['dni'] . '</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h5 style="font-size: 1.2rem; font-weight: 700; margin: 0 !important; color: ' . $settings['color_texto'] . '; text-align: right; display: block; width: 100%;">
                                        ' . date("Y") . '
                                    </h5>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </div>
        </td>';
    } else {
        $carnets .= '<td style="width: 50%; padding-top: 1%; padding-bottom:2%; padding-left: 6%; padding-right: 16%; margin: 0; min-height: 400px;">
        <div style="position:relative; border: solid 1px; width: 80mm; height: 48mm; background-image:url(\'https://laclave.diegoaranibar.com/intranet/system/controllers/fondos_carnet/' . $settings['imagen'] . '\');background-size: contain;background-position: top;background-repeat: no-repeat;">
            
            
            
            <table style="width: 100%; margin-top: 15%;">
                <tr>
                    <td style="width: 30%;">
                        <img src="https://laclave.diegoaranibar.com/intranet/system/controllers/photo/' . $row['foto'] . '" style="width: 100%; z-index: 0;">
                    </td>
                    <td>
                        <table border="0" style="width: 100%;">
                            <tr>
                                <td style="width: 25%; padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Nombres:</h5>
                                </td>
                                <td style="width: 75%; padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['nombres'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Apellidos:</h5>
                                </td>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $row['apellidos'] . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Horario:</h5>
                                </td>
                                <td style=" padding: 5px;"><h5 style="font-size: 0.6rem; margin: 0px 0px 0px 0px;">' . $hora_inicio . '<br>' . $hora_fin . '</h5></td>
                            </tr>
                            <tr>
                                <td style=" padding: 5px;">
                                    <h5 style="font-size: 0.70rem; margin: 0px 0px 0px 0px; color: ' . $settings['color_texto'] . ';">Código:</h5>
                                </td>
                                <td style="text-align: center; font-size: 0.70rem; padding: 5px;">
                                    <div style="width: 100%; text-align: center;">
                                        <img style="width: 80%;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($row['dni'], $generator::TYPE_CODE_128)) . '">
                                    </div>
                                    <span style="display: block;">' . $row['dni'] . '</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h5 style="font-size: 1.2rem; font-weight: 700; margin: 0 !important; color: ' . $settings['color_texto'] . '; text-align: right; display: block; width: 100%;">
                                        ' . date("Y") . '
                                    </h5>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </div>
        </td>';
    }
    $auxiliar++;
}

require_once 'dompdf/dompdf/vendor/autoload.php';

$im = new Imagick();
$im->setBackgroundColor(new ImagickPixel('transparent'));
$im->readImageBlob('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="' . $settings['color_principal'] . '" fill-opacity="1"
        d="M0,96L80,122.7C160,149,320,203,480,192C640,181,800,107,960,112C1120,117,1280,203,1360,245.3L1440,288L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
    </path>
</svg>');

/*png settings*/
$im->setImageFormat("png24");
//$im->resizeImage(720, 320, imagick::FILTER_LANCZOS, 1);  /*Optional, if you need to resize*/

/*png24*/
$im->setImageFormat("png24");
$im->adaptiveResizeImage(1440, 400); /*Optional, if you need to resize*/

$im->writeImage('img/us-map.png');/*(or .jpg)*/
$im->clear();
$im->destroy();

$im = new Imagick();
$im->setBackgroundColor(new ImagickPixel('transparent'));
$im->readImageBlob('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="' . $settings['color_secundario'] . '" fill-opacity="1"
        d="M0,96L80,122.7C160,149,320,203,480,192C640,181,800,107,960,112C1120,117,1280,203,1360,245.3L1440,288L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
    </path>
</svg>');

/*png settings*/
$im->setImageFormat("png24");
//$im->resizeImage(720, 320, imagick::FILTER_LANCZOS, 1);  /*Optional, if you need to resize*/

/*png24*/
$im->setImageFormat("png24");
$im->adaptiveResizeImage(1440, 445); /*Optional, if you need to resize*/

$im->writeImage('img/us-map2.png');/*(or .jpg)*/
$im->clear();
$im->destroy();

$html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <style>
            @page { margin: 0; }
        </style>
    </head>
    <body style="padding: 0; margin: 0;">
        <table style="width: 100%;">
        ' . $carnets . '
        </table>
    </body>    
</html>';
//echo $html;

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class

$dompdf = new Dompdf(array('enable_remote' => true));

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');
$dompdf->set_option('dpi', 300); 
// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("Carnet Impreso.pdf");
