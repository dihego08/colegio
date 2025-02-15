<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include("env.php");
$id_venta = $_GET['id_venta'];
$query = $mbd->prepare("SELECT * from pagos_2 where id = :id_venta");
$query->bindParam(":id_venta", $id_venta);
$query->execute();
$venta = $query->fetch(PDO::FETCH_ASSOC);
$alumno = $mbd->prepare("SELECT * FROM usuarios where id = " . $venta['id_usuario']);
$alumno->execute();
$alumno = $alumno->fetch(PDO::FETCH_ASSOC);
// CONFIGURACIÓN PREVIA
require('fpdf/fpdf.php');
define('EURO', chr(128)); // Constante con el símbolo Euro.
$pdf = new FPDF('P', 'mm', array(80, 200)); // Tamaño tickt 80mm x 150 mm (largo aprox)
$pdf->AddPage();
// CABECERA
$pdf->Image('https://' . $_SERVER['HTTP_HOST'] . '/img/logo-1.PNG', 20, 10, 40, 0, 'PNG');
$pdf->Ln(20);
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(60, 5, "Academia La Clave", 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(60, 5, utf8_decode('Av. Los Colonizadores Mz 0 Lote 60'), 0, 'C');
$pdf->MultiCell(60, 5, utf8_decode('959164918 - 950295222'), 0, 'C');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 5, utf8_decode('RECIBO DE PAGO'), 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 5, 'N001-' . str_pad($venta['id'], 8, "0", STR_PAD_LEFT), 0, 1, 'C');
// DATOS FACTURA        
$pdf->Ln(5);
// COLUMNAS
$pdf->SetFont('Times', 'B', 7);
$pdf->Cell(35, 10, 'Concepto', 0);
$pdf->Cell(10, 10, 'Monto', 0, 0, 'R');
$pdf->Cell(15, 10, 'Total', 0, 0, 'R');
$pdf->Ln(8);
$pdf->Cell(60, 0, '', 'T');
$pdf->Ln(1);
$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$pdf->MultiCell(30, 4, utf8_decode((is_null($venta['concepto']) || empty($venta['concepto'])) ? "Mensualidad Mes: " . $meses[$venta['mes']] : $venta['concepto']), 0, 'L');
$pdf->Cell(45, -5, "S/ " . number_format(round($venta['monto'], 2), 2, '.', ' '), 0, 0, 'R');
$pdf->Cell(15, -5, "S/ " . number_format(round($venta['monto'] * 1, 2), 2, '.', ' '), 0, 0, 'R');
$pdf->Ln(1);
$pdf->MultiCell(60, 4, utf8_decode("Alumno(a): " . $alumno['nombres'] . " " . $alumno['apellidos']), 0, 'L');
$pdf->MultiCell(60, 4, utf8_decode("Fecha: " . $venta['fecha']), 0, 'L');
$total = 0;
$total += $venta['monto'] * 1;
$pdf->Cell(60, 0, '', 'T');
$pdf->Ln(2);
$pdf->Cell(25, 10, 'TOTAL', 0);
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, 'S/ ' . number_format($total, 2, '.', ' '), 0, 1, 'R');
$total_letras = json_decode(file_get_contents('https://diegoaranibar.com/numero_2_letras/conversor.php?total=' . $total));
$pdf->Ln(1);
$pdf->Cell(60, 0, '', 'T', 1);
$pdf->SetFont('Times', 'B', 8);
$pdf->MultiCell(60, 4, "Son: " . ucwords($total_letras->letras) . " SOLES", 0, 'L');
$pdf->Output('Ticket de Venta', 'f');
$pdf->Output('Ticket de Venta', 'i');
