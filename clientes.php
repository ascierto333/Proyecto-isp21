<?php
include("verifica_sesion.php");
include("conexion.php");

$error = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
try {
    $conexion->beginTransaction();

    if (isset($_POST['insertar'])) {
        $n = $_POST['nombre'];
        $a = $_POST['direccioncliente'];
        $d = $_POST['dni'];
        $c = $_POST['cuit'];
        $sql_insert = "CALL sp_InsertCliente(:n, :a, :d, :c)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bindParam(':n', $n);
        $stmt_insert->bindParam(':a', $a);
        $stmt_insert->bindParam(':d', $d);
        $stmt_insert->bindParam(':c', $c);
        $stmt_insert->execute();
    }

    if (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $n = $_POST['nombre'];
        $a = $_POST['direccioncliente'];
        $d = $_POST['dni'];
        $c = $_POST['cuit'];
        $sql_update = "CALL sp_UpdateCliente(:id, :n, :a, :d, :c)";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bindParam(':id', $id);
        $stmt_update->bindParam(':n', $n);
        $stmt_update->bindParam(':a', $a);
        $stmt_update->bindParam(':d', $d);
        $stmt_update->bindParam(':c', $c);
        $stmt_update->execute();
    }

    $conexion->commit();

    echo "<script>alert('Operación exitosa');</script>";
} catch (Exception $e) {
    $conexion->rollBack();
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "delete from clientes where idCliente=$id";
    if ($resultado = $conexion->query($sql)) $error = 0;
    else $error = 2;
}

if (isset($_GET['mod'])) {
    $id = $_GET['mod'];
    $sql = "select * from clientes where idCliente=$id";
    $modif = $conexion->query($sql);
    $acambiar = $modif->fetch(PDO::FETCH_ASSOC);
}


$rango_pag = 7;
if (isset($_GET["pagina"])) {
    if ($_GET["pagina"] == 1) {
        header("location:clientes.php");
    } else {
        $pagina = $_GET["pagina"];
    }
} else {
    $pagina = 1;
}
$desde = ($pagina - 1) * $rango_pag;
$sql = "select * from clientes";
$resultado = $conexion->query($sql);
$cant_registros = $resultado->rowCount();
$cant_pag = ceil($cant_registros / $rango_pag);


$sql = "select * from clientes limit $desde, $rango_pag";
$mostrar = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Menu de clientes</title>
	<link rel="icon" href="img/loguito.ico">	
    <link rel="stylesheet" type="text/css" href="css/estilomenus.css"> 
	<link rel="stylesheet" type="text/css" href="css/tabla.css"> 
	<style type="text/css">
		.body .contenedor .figure a img {
			font-family: Georgia, Times New Roman, Times, serif;
		}
		</style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<section class= section></section>
<body bgcolor="#0000032" background="img/fondopro.jpg" class= body>

<div class="contenedor">
	<br></br>
	<input class="figure" id="boton" type="image"  img src="img/pedidos.jpg" width="250" height="200" value="Nuevo producto" onClick="location='pedidos.php'" class="boton" />
	<br></br>
	<input class="figure" id='boton' type="image" img src="img/produccion.jpg" width="250" height="200" value='Modificar producto' onClick='location="produccion.php"' class="boton" />
	<br></br>
	<input class="figure" id="boton" type="image"  img src="img/consultas.jpg" width="250" height="200" value="Nuevo producto" onClick="location='consulta.php'" class="boton" />
	<br></br>
	<input class="figure" id='boton' type="image" img src="img/stock.jpg" width="250" height="200" value='Listar productos' onClick='location="stock.php"' class="boton" />
	<br></br>
	<input class="figure" id='boton' type="image" img src="img/clientes.jpg" width="250" height="200" value='clientes' onClick='location="clientes.php"' class="boton" />
	<br></br>
	<input class="figure" id="boton" type="image" img src="img/salir.jpg" width="250" height="200" value="Salir" onClick='location="index.php"' class="boton" />
	<br></br> <br></br> <br></br>
    </div>
    <form  class="contact_form" action="clientes.php" method="post">
        <h1 class="centrateh1">Gestión de Clientes</h1>
        <?php if ($error == 1) echo "<p id='controlPatente'> Error-El cliente ya existe </p>";
        if ($error == 2) echo "<p id='controlPatente'> Error-No es posible eliminar un cliente que tiene ventas </p>";
        ?>
        <input type="hidden" name="id" value="<?php if (isset($_GET['mod'])) echo $_GET['mod']; else echo ''; ?>"></input>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        DNI <input type="text" name="dni" minlength="5" pattern="\d+" maxlength="7"
                   value="<?php if (isset($_GET['mod'])) echo $acambiar['dni']; else echo ''; ?>" placeholder="dni" autofocus required></input>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Nombre <input type="text" name="nombre" maxlength="50" pattern="^[a-zA-Z0-9]+$"
                     value="<?php if (isset($_GET['mod'])) echo $acambiar['nombre']; else echo ''; ?>" placeholder="nombre" required></input>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Dirección <input type="text" name="direccioncliente" maxlength="50" pattern="^[a-zA-Z0-9]+$"
                       value="<?php if (isset($_GET['mod'])) echo $acambiar['direccioncliente']; else echo ''; ?>" placeholder="Dirección" required></input>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Cuit <input type="text" name="cuit" minlength="11" maxlength="11" pattern="[0-9]{11,11}"
                    value="<?php if (isset($_GET['mod'])) echo $acambiar['cuit']; else echo ''; ?>" placeholder="cuit"></input>
        &nbsp;&nbsp;&nbsp;
        <br> </br>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit"
               name="<?php if (isset($_GET['mod'])) echo 'actualizar'; else echo 'insertar'; ?>"
               value="<?php if (isset($_GET['mod'])) echo 'Modificar'; else echo 'Crear'; ?>"
               style='width:120px;height:20px'>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="cancelar" value="Cancelar" style='width:120px;height:20px'
               onClick="window.location.href = 'clientes.php'">
    </form>
    <form  class="contact_form" action="clientes.php" method="post">
    <h1 class="centrateh1">Lista de Clientes</h1>
    <table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10" class="">
        <tr>
            <th>Id</th>
            <th>Dni</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Cuit</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
        <?php
        while ($fila = $mostrar->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $fila['idCliente'] . "</td>
                    <td>" . $fila['dni'] . "</td>
                    <td>" . $fila['nombre'] . "</td>
                    <td>" . $fila['direccioncliente'] . "</td>
                    <td>" . $fila['cuit'] . "</td></td>
                    <td><center><a href='clientes.php?mod=" . $fila['idCliente'] . "'><img src='img/editar.png' width='30' height='25'></a></center></td>
                    <td><center><a href=\"javascript:preguntar('" . $fila['idCliente'] . "')\"><img src='img/borrar-archivo.png' width='30'></td> 
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
    </form>
    <script>
        function preguntar(valor) {
            rpta = confirm("Estás seguro de eliminar el cliente " + valor + "?");
            if (rpta) window.location.href = "clientes.php?eliminar=" + valor;
        }
    </script>
</body>
</html>
