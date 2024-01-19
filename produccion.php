<?php
include("verifica_sesion.php");
include("conexion.php");
//transaccion y sp
if (isset($_POST['insert'])) {
    try {
        $id = $_POST['codProd'];
        $im = $_POST['fecha'];
        $d = $_POST['cantidad'];
        $p = $_POST['materiaprima'];
        $conexion->beginTransaction();
        $stmt = $conexion->prepare("CALL sp_InsertProduccion(:id, :im, :d, :p)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':im', $im);
        $stmt->bindParam(':d', $d);
        $stmt->bindParam(':p', $p);
        $stmt->execute();
        $conexion->commit();
        echo "<script>alert('El registro de producción se generó correctamente');</script>";
    } catch (Exception $e) {
        $conexion->rollBack();
        echo "<script>alert('Error al insertar: " . $e->getMessage() . "');</script>";
    }
}



if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $im = $_POST['codProd'];
    $d = $_POST['fecha'];
    $f = $_POST['cantidad'];
    $p = $_POST['materiaprima'];
    $sql = "UPDATE produccion SET codProd='$im', fecha='$d', cantidad='$f', materiaprima='$p' WHERE codigoproduccion=$id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
}
//trigger en delete
if (isset($_GET['el'])) {
    $id = $_GET['el'];
    $sql = "DELETE FROM produccion WHERE codigoproduccion=$id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
}

if (isset($_GET['mo'])) {
    $id = $_GET['mo'];
    $sql = "SELECT * FROM produccion WHERE codigoproduccion=$id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $acambiar = $stmt->fetch(PDO::FETCH_ASSOC);
}



$rango_pag = 7;
if (isset($_GET["pagina"])) {
    if ($_GET["pagina"] == 1) {
        header("location:produccion.php");
    } else {
        $pagina = $_GET["pagina"];
    }
} else {
    $pagina = 1;
}
$desde = ($pagina - 1) * $rango_pag;
$sql = "select * from produccion";
$resultado = $conexion->query($sql);
$cant_registros = $resultado->rowCount();
$cant_pag = ceil($cant_registros / $rango_pag);



//aca use la vista
$sql = "SELECT * FROM vista_produccion
        ORDER BY fecha DESC
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
    <title>Menu de producción</title>
    <link rel="icon" href="img/loguito.ico">
    <style type="text/css">
        .body .contenedor .figure a img {
            font-family: Georgia, Times New Roman, Times, serif;
        }
    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
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
<section>
    <form class="contact_form" action="produccion.php" method="post">
    <h1 class="centrateh1"> Producción de hoy </h1>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="hidden" 
    value="<?php if(isset($_GET['mo'])) echo $_GET['mo']; else echo '';?>" 
    name="id"></input>
    <label class=”form-date__label” >Tipo de Corte </label>
    <select class="select-css" name="codProd" required>Tipo de Corte 
    <?php
        if(isset($_GET['mo'])){
            $sql= "SELECT * FROM productos WHERE codProd=".$acambiar['codProd'];
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $stock = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<option value='".$stock['codProd']."' selected>".$stock['descProd']."</option>";
        }
        $sql= "SELECT * FROM productos WHERE precio > 0";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($stock as $fila) {
            echo "<option value='".$fila['codProd']."'>".$fila['descProd']."</option>";
        }
    ?>    
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class=”form-date__label” for=”input-date”>Fecha de la producción</label>
    <input type="date" 
    value="<?php if(isset($_GET['mo'])) echo $acambiar['fecha']; else echo '';?>" 
    name="fecha" placeholder="Fecha" required></input>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class=”form-date__label” ”>Cantidad producida </label><input type="text" 
    value="<?php if(isset($_GET['mo'])) echo $acambiar['cantidad']; else echo '';?>" 
    name="cantidad" placeholder="Cantidad (Kg.)" pattern="\d+" autofocus required title="La cantidad producida debe ser solo en números."></input> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class=”form-date__label” ”>Materia prima</label><input type="text" 
    value="<?php if(isset($_GET['mo'])) echo $acambiar['materiaprima']; else echo '';?>" 
    name="materiaprima" placeholder="Kg. utilizados" pattern="\d+" autofocus required title="los Kg utilizados deben ser solo números."></input>
    <br></br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" 
    name="<?php if(isset($_GET['mo'])) echo 'update'; else echo 'insert';?>" 
    value="<?php if(isset($_GET['mo'])) echo 'Modificar'; else echo 'Crear';?>" 
    style='width:120px;height:20px'> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancelar" value="Cancelar" style='width:120px;height:20px' onClick="window.location.href = 'produccion.php'">
    </form>
    <br></br>
    <form class="contact_form" action="produccion.php" method="post">

    <h1 class="centrateh1"> Registro de Producciones </h1>
    <table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10">
        <tr>
            <th>Código </th>
            <th>Tipo de corte</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Materia prima</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    <?php
        while ($fila = $mostrar->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>".$fila['codigoproduccion']."</td>
                    <td>".$fila['tipo_corte']."</td>
                    <td>".$fila['fecha']."</td>
                    <td>".$fila['cantidad']."</td>
                    <td>".$fila['materiaprima']."</td></td>
                    <td><center><a href='produccion.php?mo=".$fila['codigoproduccion']."')\"><img src='img/editar.png' width='30' height='25'></a></center></td>
                    <td><center><a href=\"javascript:preguntar('".$fila['codigoproduccion']."')\"><img src='img/borrar-archivo.png' width='30' height='25'></a></center></td>
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
            if (rpta) window.location.href = "produccion.php?el=" + valor;
        }
    </script>
</section>
</body>
</html>