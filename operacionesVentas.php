<?php
session_start();

$operacion = $_POST['operacion'];

switch ($operacion) {
    case 'Buscar Cliente':
        buscarCliente();
        break;
    case 'Buscar Producto':
        buscarProducto();
        break;
    case 'Cancelar':
        cancelar();
        break;
    case 'Facturar':
        facturar();
        break;
}

function buscarCliente()
{
    include("conexion.php");
    $dni = $_POST['dni'];
    $sql = "SELECT count(*) FROM clientes WHERE dni = $dni";
    if ($resultado = $conexion->query($sql)) {
        if ($resultado->fetchColumn() > 0) {
            $sql = "SELECT * FROM clientes WHERE dni = $dni";
            $cliente = $conexion->query($sql)->fetch(PDO::FETCH_OBJ);
            $_SESSION['cliente'] = $cliente;
            header("location:pedidos.php");
        } else {
            $_SESSION['errorCliente'] = "Cliente $dni no encontrado";
            cancelar();
        }
    } else {
        $_SESSION['errorCliente'] = "Error al buscar el cliente";
        cancelar();
    }
}

function buscarProducto()
{
    include("conexion.php");
    $codProd = $_POST['codProd'];
    $cantProd = $_POST['cantProd'];
    $encontrado = false;
    $sql = "SELECT count(*) FROM productos WHERE codProd = $codProd";
    if ($resultado = $conexion->query($sql)) {
        if ($resultado->fetchColumn() > 0) {
            foreach ($_SESSION['productos'] as $p) {
                if ($p->codProd == $codProd) $encontrado = true;
            }
            if ($encontrado) $_SESSION['errorProducto'] = "Producto $codProd ya fue ingresado";
            else {
                $sql = "SELECT * FROM productos WHERE codProd = $codProd";
                $producto = $conexion->query($sql)->fetch(PDO::FETCH_OBJ);
                if ($producto->stock >= $cantProd) {
                    $producto->cantProd = $cantProd;
                    $_SESSION['productos'][] = $producto;
                } else {
                    $_SESSION['errorProducto'] = "Stock insuficiente ($producto->stock) del producto $codProd";
                }
            }
        } else {
            $_SESSION['errorProducto'] = "Producto $codProd no encontrado";
        }
    } else {
        $_SESSION['errorProducto'] = "Error al buscar el producto";
    }
    header("location:pedidos.php");
}

function facturar()
{
    include("conexion.php");

    if (isset($_POST['tipoFact'])) {
        $tipoFact = $_POST['tipoFact'];
    } else {
        $tipoFact = ""; 
    }

    $cliente = $_SESSION['cliente'];
    $productos = $_SESSION['productos'];

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha = new DateTime();
    $hoy = $fecha->format("Y-m-d H:i:s");
    $sql = "INSERT INTO cabfacturas (idCliente, fechaFact, tipoFact) VALUES ($cliente->idCliente, '$hoy', '$tipoFact')";
    $conexion->query($sql);

    $ultimoId = $conexion->lastInsertId();

    foreach ($productos as $p) {
        $sql = "INSERT INTO detallefactura (nroFact, codProd, cantidad, precio) VALUES ($ultimoId, $p->codProd, $p->cantProd, $p->precio)";
        $conexion->query($sql);
        $sql = "UPDATE productos SET stock = stock - $p->cantProd WHERE codProd = $p->codProd ";
        $conexion->query($sql);
    }

    $_SESSION['cliente']->fecha = $fecha->format("d/m/Y H:i:s");
    imprimir($tipoFact); 
    cancelar();
}

function imprimir($tipoFact)
{
    include("conexion.php");
    include("fpdf/fpdf.php");

    $cliente = $_SESSION['cliente'];
    $productos = $_SESSION['productos'];
    $subtotal = 0;
    foreach ($productos as $p) {
        $subtotal += $p->cantProd * $p->precio;
    }

    $iva = $subtotal * 0.21; 
    $subsubtotal = $subtotal * 0.79;
    $ivadelprecio = ($tipoFact == 'Factura A') ? $p->precio * 0.21 : 0;
    $preciosiniva = ($tipoFact == 'Factura A') ? $p->precio - $ivadelprecio : $p->precio;

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
$pdf->Cell(116,7,utf8_decode(($cliente->fecha)),0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(39,39,51);
$pdf->Cell(35,7,utf8_decode(strtoupper(' Venta: ' . $tipoFact)),0,0,'C');

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
$pdf->Cell(60,7,utf8_decode($cliente->nombre),0,0,'L');
$pdf->SetTextColor(39,39,51);
$pdf->Cell(8,7,utf8_decode("Dni: "),0,0,'L');
$pdf->SetTextColor(97,97,97);
$pdf->Cell(60,7,utf8_decode($cliente->dni),0,0,'L');
$pdf->SetTextColor(39,39,51);
$pdf->Cell(9,7,utf8_decode("CUIT:"),0,0,'L');
$pdf->SetTextColor(97,97,97);
$pdf->Cell(35,7,utf8_decode($cliente->cuit),0,0);
$pdf->SetTextColor(39,39,51);

$pdf->Ln(7);

$pdf->SetTextColor(39,39,51);
$pdf->Cell(16,7,utf8_decode("Dirección:"),0,0);
$pdf->SetTextColor(97,97,97);
$pdf->Cell(109,7,utf8_decode($cliente->direccioncliente),0,0);

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



foreach ($productos as $p) {
$pdf->Cell(90,7,utf8_decode($p->descProd),'L',0,'C');
$pdf->Cell(15,7,utf8_decode($p->codProd),'L',0,'C');
$pdf->Cell(25,7,utf8_decode($p->cantProd),'L',0,'C');
$pdf->Cell(19,7,utf8_decode(number_format($preciosiniva, 2)),'L',0,'C');
$pdf->Cell(32,7,utf8_decode($p->cantProd * $preciosiniva,),'LR',0,'C');
$pdf->Ln(7);
}




$pdf->SetFont('Arial','B',9);


$pdf->Cell(100, 7, utf8_decode(''), 'T', 0, 'C');
    $pdf->Cell(15, 7, utf8_decode(''), 'T', 0, 'C');
    $pdf->Cell(32, 7, utf8_decode("SUBTOTAL"), 'T', 0, 'C');
    if ($tipoFact == 'Factura A') {
    $pdf->Cell(34, 7, utf8_decode(number_format($subsubtotal, 2)), 'T', 0, 'C'); 
} else {
    $pdf->Cell(34, 7, utf8_decode(number_format($subtotal, 2)), 'T', 0, 'C');}
    $pdf->Ln(7);

if ($tipoFact == 'Factura A') {
    $pdf->Cell(100, 7, utf8_decode(''), '', 0, 'C');
    $pdf->Cell(15, 7, utf8_decode(''), '', 0, 'C');
    $pdf->Cell(32, 7, utf8_decode("IVA (21%)"), '', 0, 'C');
    $pdf->Cell(34, 7, utf8_decode(number_format($iva, 2)), '', 0, 'C');
}

    $pdf->Ln(7);


$pdf->Cell(100,7,utf8_decode(''),'',0,'C');
$pdf->Cell(15,7,utf8_decode(''),'',0,'C');


$pdf->Cell(32,7,utf8_decode("TOTAL A PAGAR"),'T',0,'C');
$pdf->Cell(34,7,utf8_decode($cliente->total),'T',0,'C');

$pdf->Ln(7);

$pdf->Ln(12);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(39,39,51);
$pdf->MultiCell(0,9,utf8_decode("***revisar el pedido al momento de la entrega, luego no se aceptan reclamos ***"),0,'C',false);

$pdf->Ln(9);


$pdf->Output("I","Factura_Nro_1.pdf",true);
}
function cancelar()
{
    unset($_SESSION['cliente']);
    unset($_SESSION['productos']);
    header("location:pedidos.php");
}
?>