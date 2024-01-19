<?php
include("verifica_sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>   
    <link rel="stylesheet" type="text/css" href="css/estilomenus.css">
    <link rel="icon" href="img/loguito.ico">
    <style type="text/css">
        .body .contenedor .figure a img {
            font-family: Georgia, Times New Roman, Times, serif;
        }
  </style>
    </style>
</head>
<body bgcolor="#0000032"   background="img/fondopro.jpg" class="body">
    <div class="contenedor">
        <br><br>
        <input class="figure" id="boton" type="image" src="img/pedidos.jpg" width="250" height="200" value="Nuevo producto" onClick="location='pedidos.php'" class="boton" />
        <br><br>
        <input class="figure" id='boton' type="image" src="img/produccion.jpg" width="250" height="200" value='Modificar producto' onClick='location="produccion.php"' class="boton" />
        <br><br>
        <input class="figure" id="boton" type="image" src="img/consultas.jpg" width="250" height="200" value="Nuevo producto" onClick="location='consulta.php'" class="boton" />
        <br><br>
        <input class="figure" id='boton' type="image" src="img/stock.jpg" width="250" height="200" value='Listar productos' onClick='location="stock.php"' class="boton" />
        <br><br>
        <input class="figure" id='boton' type="image" src="img/clientes.jpg" width="250" height="200" value='clientes' onClick='location="clientes.php"' class="boton" />
        <br><br>
        <input class="figure" id="boton" type="image" src="img/salir.jpg" width="250" height="200" value="Salir" onClick='location="cerrar_sesion.php"' class="boton" />
        <br><br> <br><br> <br><br>
    </div>
</body>
</html>
