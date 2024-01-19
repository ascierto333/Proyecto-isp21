<?php
require('fpdf/fpdf.php'); 

if (isset($_GET['nroFactCab']) && is_numeric($_GET['nroFactCab'])) {
    $nroFactCab = $_GET['nroFactCab'];
    
    include("conexion.php");

    $sql = "SELECT cf.nroFact as nroFactCab,
            cf.fechaFact as fechaFact,
            cf.tipoFact as tipoFact,
            cf.idCliente as idCliente,
            c.nombre as nombre,
            c.dni as dni,
            c.cuit as cuit,
            c.direccioncliente as direccioncliente
            FROM cabfacturas as cf
            INNER JOIN clientes as c ON c.idCliente = cf.idCliente
            WHERE cf.nroFact = :nroFactCab"; // parámetro para evitar SQL Injection
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nroFactCab', $nroFactCab, PDO::PARAM_INT);
    $stmt->execute();

    $factura = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($factura) { 
        $pdf = new FPDF();
        $pdf->SetMargins(17,17,17);
        $pdf->AddPage();
        $pdf->Image('img/factura.png',165,12,35,35,'PNG');
        $pdf->SetFont('Arial','B',16);
        $pdf->SetTextColor(32,100,210);
        $pdf->Cell(150,10,utf8_decode(strtoupper("PapasFriends")),0,0,'L');
        $pdf->Ln(9);
        $pdf->SetFont('Arial','',10);
        $pdf->SetTextColor(39,39,51);     
        $pdf->Ln(5);
        
        $pdf->Cell(150,9,utf8_decode("Gaboto,34"),0,0,'L');
        
        $pdf->Ln(5);
        
        $pdf->Cell(150,9,utf8_decode("Teléfono: 3402528448"),0,0,'L');
        
        $pdf->Ln(5);
        
        $pdf->Cell(150,9,utf8_decode("Email: vamopapafriend@papas.com"),0,0,'L');
        
        $pdf->Ln(10);
        
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,7,utf8_decode("Fecha de emisión:"),0,0);    
        $pdf->SetTextColor(97,97,97);
        $pdf->Cell(116,7,utf8_decode((  $factura['fechaFact'])),0,0,'L');
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(39,39,51);
        $pdf->Cell(35,7,utf8_decode(strtoupper(' Venta: ' . $factura['tipoFact'])),0,0,'C');

$pdf->Ln(7);

$pdf->SetFont('Arial','',10);
$pdf->Cell(12,7,utf8_decode("Cajero:"),0,0,'L');
$pdf->SetTextColor(97,97,97);
$pdf->Cell(134,7,utf8_decode("Ascierto3"),0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(97,97,97);
$pdf->Cell(35,7,utf8_decode(strtoupper("")),0,0,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(39,39,51);
$pdf->Cell(13,7,utf8_decode("Cliente:"),0,0);
$pdf->SetTextColor(97,97,97);
$pdf->Cell(60,7,utf8_decode($factura['nombre']),0,0,'L');
$pdf->SetTextColor(39,39,51);
$pdf->Cell(8,7,utf8_decode("Dni: "),0,0,'L');
$pdf->SetTextColor(97,97,97);
$pdf->Cell(60,7,utf8_decode($factura['dni']),0,0,'L');
$pdf->SetTextColor(39,39,51);
$pdf->Cell(9,7,utf8_decode("CUIT:"),0,0,'L');
$pdf->SetTextColor(97,97,97);
$pdf->Cell(35,7,utf8_decode($factura['cuit']),0,0);
$pdf->SetTextColor(39,39,51);

$pdf->Ln(7);

$pdf->SetTextColor(39,39,51);
$pdf->Cell(16,7,utf8_decode("Dirección:"),0,0);
$pdf->SetTextColor(97,97,97);
$pdf->Cell(109,7,utf8_decode($factura['direccioncliente']),0,0);

$pdf->Ln(9);     

$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(23,83,201);
$pdf->SetDrawColor(23,83,201);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(90,8,utf8_decode("Descripcion"),1,0,'C',true);
$pdf->Cell(15,8,utf8_decode("Código"),1,0,'C',true);
$pdf->Cell(25,8,utf8_decode("Cantidad"),1,0,'C',true);
$pdf->Cell(19,8,utf8_decode("Precio unitario"),1,0,'C',true);
$pdf->Cell(32,8,utf8_decode("Importe"),1,0,'C',true);

$pdf->Ln(8);


$pdf->SetTextColor(39,39,51);

        $sql = "SELECT df.codProd as codProd,
                df.cantidad as cantProd,
                df.precio as precio,
                p.descProd as descProd
                FROM detallefactura as df
                INNER JOIN productos as p ON df.codProd = p.codProd
                WHERE df.nroFact = :nroFactCab";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nroFactCab', $nroFactCab, PDO::PARAM_INT);
        $stmt->execute();



        while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $subtotal = 0;
            $subtotal = $producto['precio'] * $producto['cantProd']; 
            $iva = $subtotal * 0.21; 
            $subsubtotal = $subtotal * 0.79;
            $ivadelprecio = ($factura['tipoFact'] ===  'Factura A') ? $producto['precio'] * 0.21 : 0;
            $preciosiniva = ($factura['tipoFact'] ===  'Factura A') ? $producto['precio'] - $ivadelprecio :$producto['precio'];
            $pdf->Cell(90,7,utf8_decode($producto['descProd']),'L',0,'C');
            $pdf->Cell(15,7,utf8_decode($producto['codProd']),'L',0,'C');
            $pdf->Cell(25,7,utf8_decode($producto['cantProd']),'L',0,'C');
            $pdf->Cell(19,7,utf8_decode(number_format($preciosiniva, 2)),'L',0,'C');
            $pdf->Cell(32,7,utf8_decode($producto['cantProd'] * $preciosiniva,),'LR',0,'C');
            $pdf->Ln(7);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(100, 7, utf8_decode(''), 'T', 0, 'C');
            $pdf->Cell(15, 7, utf8_decode(''), 'T', 0, 'C');
            $pdf->Cell(32, 7, utf8_decode("SUBTOTAL"), 'T', 0, 'C');
            if ($factura['tipoFact'] ===  'Factura A') {
                $pdf->Cell(34, 7, utf8_decode(number_format($subsubtotal, 2)), 'T', 0, 'C');
            } else {
                $pdf->Cell(34, 7, utf8_decode(number_format($subtotal, 2)), 'T', 0, 'C');} 
                $pdf->Ln(7);
            
            if ($factura['tipoFact'] ===  'Factura A') {
                $pdf->Cell(100, 7, utf8_decode(''), '', 0, 'C');
                $pdf->Cell(15, 7, utf8_decode(''), '', 0, 'C');
                $pdf->Cell(32, 7, utf8_decode("IVA (21%)"), '', 0, 'C');
                $pdf->Cell(34, 7, utf8_decode(number_format($iva, 2)), '', 0, 'C'); 
               $pdf->Ln(7); 
            }
            
            
            
            
            $pdf->Cell(100,7,utf8_decode(''),'',0,'C');
            $pdf->Cell(15,7,utf8_decode(''),'',0,'C');
            
            
            $pdf->Cell(32,7,utf8_decode("TOTAL A PAGAR"),'T',0,'C');
            $pdf->Cell(34,7,utf8_decode($subtotal),'T',0,'C');
            
            $pdf->Ln(7);
            
            $pdf->Ln(12);
            
            $pdf->SetFont('Arial','',9);
            
            $pdf->SetTextColor(39,39,51);
            $pdf->MultiCell(0,9,utf8_decode("***revisar el pedido al momento de la entrega, luego no se aceptan reclamos ***"),0,'C',false);
            
            $pdf->Ln(9);
        }




        $pdf->Output("I","Factura_Nro_1.pdf",true);
    } else {
        echo "Factura no encontrada.";
    }
} else {
    echo "Número de factura no válido.";
}

if (isset($_GET['el'])) {
    $id = $_GET['el'];
    $sql = "DELETE FROM produccion WHERE codigoproduccion=$id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
}