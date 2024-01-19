<?php
include("verifica_sesion.php");
include("conexion.php");


$desde = 0; 
$rango_pag = 10; 


$sql_total_registros = "SELECT COUNT(*) as total FROM detallefactura";
$total_registros = $conexion->query($sql_total_registros)->fetchColumn();
$cant_pag = ceil($total_registros / $rango_pag);


if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
    if ($pagina < 1) {
        $pagina = 1;
    } elseif ($pagina > $cant_pag) {
        $pagina = $cant_pag;
    }
} else {
    $pagina = 1;
}
//eliminacion x logica
if (isset($_GET['el'])) {
    $id = $_GET['el'];
    $sql = "UPDATE cabfacturas SET eliminado = 1 WHERE nroFact=$id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
}


$desde = ($pagina - 1) * $rango_pag;

$sql = "SELECT cf.nroFact as nroFactCab,
        MAX(cf.fechaFact) as fechaFact,
        MAX(cf.tipoFact) as tipoFact,
        cf.idCliente as idCliente,
        MAX(c.nombre) as nombre,
        MAX(df.nroDetalle) as nroDetalle,
        MAX(df.nroFact) as nroFact,
        MAX(df.codProd) as codProd,
        SUM(df.cantidad * df.precio) as importe_total, 
        MAX(p.descProd) as descripcion
        FROM cabfacturas as cf
        INNER JOIN (
            SELECT nroFact, SUM(precio) as precio
            FROM detallefactura
            GROUP BY nroFact
        ) df_sumado ON cf.nroFact = df_sumado.nroFact
        INNER JOIN detallefactura as df ON cf.nroFact = df.nroFact
        INNER JOIN productos as p ON df.codProd = p.codProd
        INNER JOIN clientes as c ON c.idCliente = cf.idCliente
        WHERE cf.eliminado = 0
        GROUP BY cf.nroFact
        ORDER BY MAX(cf.fechaFact) DESC
        LIMIT $desde, $rango_pag";

$mostrar = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilomenus.css"> 
    <link rel="stylesheet" type="text/css" href="css/tabla.css"> 
    <title>Menu de consultas</title>
    <link rel="icon" href="img/loguito.ico">
    <style type="text/css">
        .body .contenedor .figure a img {
            font-family: Georgia, Times New Roman, Times, serif;
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Rubro', 'Cantidad'],
                <?php 
                    include ("conexion.php");
                    $sql = "SELECT concat('[\"' , p.descProd, '\",' , cast(sum(df.cantidad) as char), '],' ) as fila
                            FROM cabfacturas as cf, detallefactura as df, productos as p
                            WHERE cf.nroFact = df.nroFact AND df.codProd = p.codProd
                            GROUP BY p.descProd
                            ORDER BY cantidad DESC";
                    $resultado = $conexion->query($sql);
                    while ($r = $resultado->fetch(PDO::FETCH_ASSOC)) echo $r['fila'];
                ?>
            ]);

            var options = {
                title: 'Cantidad vendida por Tipo De Corte', 
                is3D: true,
                backgroundColor: 'transparent',
                titleTextStyle: {
                    fontSize: 33, 
                    bold: true,
                    textAlign: 'center' 
                },
                legend: {
                    textStyle: {
                        fontSize: 23, 
                        bold: true 
                    },
                    alignment: 'center' 
                },
                slices: {
                    0: { textStyle: { fontSize: 23, bold: true } }, 
                    1: { textStyle: { fontSize: 23, bold: true } },
                   
                },
                chartArea: {
                    left: '33%', 
                    top: '15%', 
                    width: '80%', 
                    height: '70%'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafico'));
            chart.draw(data, options);

            document.getElementById('imagen').value = chart.getImageURI();
        }
    </script>
</head>
<body bgcolor="#0000032" background="img/fondopro.jpg" class="body">

<div class="contenedor">
    <br></br>
    <input class="figure" id="boton" type="image" src="img/pedidos.jpg" width="250" height="200" value="Nuevo producto" onClick="location='pedidos.php'" class="boton" />
    <br></br>
    <input class="figure" id='boton' type="image" src="img/produccion.jpg" width="250" height="200" value='Modificar producto' onClick='location="produccion.php"' class="boton" />
    <br></br>
    <input class="figure" id="boton" type="image" src="img/consultas.jpg" width="250" height="200" value="Nuevo producto" onClick="location='consulta.php'" class="boton" />
    <br></br>
    <input class="figure" id='boton' type="image" src="img/stock.jpg" width="250" height="200" value='Listar productos' onClick='location="stock.php"' class="boton" />
    <br></br>
    <input class="figure" id='boton' type="image" src="img/clientes.jpg" width="250" height="200" value='clientes' onClick='location="clientes.php"' class="boton" />
    <br></br>
    <input class="figure" id="boton" type="image" src="img/salir.jpg" width="250" height="200" value="Salir" onClick='location="index.php"' class="boton" />
    <br></br> <br></br> <br></br>
</div>
<section>
    <form class="contact_form" method="post" id="hacer_pdf" action="graficoPdf.php">
        <input type="hidden" size="100" name="imagen" id="imagen" >
        <div id="grafico" style="width:80%; height: 400px; float:left;"></div>
        <br></br><br></br><br></br><br></br><br></br><br></br>
        <br></br><br></br><br></br>
        <input type="submit" value="Generar PDF" style='width:120px;height:20px'/>
    </form>
</section>

<form class="contact_form" action="pedidos.php" method="post">
    <h1 class="centrateh1"> Registro de ventas </h1>
    <table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10">
        <tr>
            <th>nroFact</th>
            <th>fecha</th>
            <th>tipo factura</th>
            <th>cliente</th>
            <th>importe total</th>
            <th>imprimir factura</th>
            <th>eliminar</th>
        </tr>            
        <?php
            while ($fila = $mostrar->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>".$fila['nroFactCab']."</td>
                        <td>".$fila['fechaFact']."</td>
                        <td>".$fila['tipoFact']."</td>
                        <td>".$fila['nombre']."</td>
                        <td>".$fila['importe_total']."</td>
                        <td><center><a href='generar_factura_pdf.php?nroFactCab=".$fila['nroFactCab']."'><img src='img/iconoimprimir.png' width='30' height='25'></a></center></td>
                        <td><center><a href=\"javascript:preguntar('".$fila['nroFactCab']."')\"><img src='img/borrar-archivo.png' width='30' height='25'></a></center></td>
                      </tr>";
            }
        ?>
    </table>

    <?php
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "Pág.:  ";
        for ($i = 1; $i <= $cant_pag; $i++) {
            echo "<a href='?pagina=" . $i . "'>" . $i . "</a>  ";
        }
    ?>

    <script>
        function preguntar(valor) {
            rpta = confirm("Estás seguro de eliminar la producción hecha con el Código " + valor + "?");
            if (rpta) window.location.href = "consulta.php?el=" + valor;
        }
    </script>    
</form>
</body>
</html>
