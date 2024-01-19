<?php
require('fpdf/fpdf.php');
date_default_timezone_set("America/Argentina/Buenos_Aires"); 

class PDF extends FPDF {

    function Header() {
    }

    function Footer() {
    }
}

$pdf = new PDF();
$pdf->AddPage('L');
$pdf->SetFont('Arial', 'BU', 18);

$pdf->Cell(0, 30, utf8_decode('Reporte de Ventas papas friends'), 0, 1, 'C', 0);

$grafico = $_POST['imagen'];
$img = explode(',', $grafico, 2)[1];

$pic = 'data:text/plain;base64,'. $img;

$offsetX = 5;
$offsetY = 50;
$width = 260; 

$pdf->Image($pic, $offsetX, $offsetY, $width, 0, 'png');  

$pdf->Rect($offsetX, $offsetY, $width, 0);

$otraImagen = 'img/factura.png';
$pdf->Image($otraImagen, $offsetX + 10, $offsetY + 20, 60, 0);  

$pdf->Output();
?>
