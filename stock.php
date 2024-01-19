<?php
	include("verifica_sesion.php");
	
	include ("conexion.php");
	
	$error=0;
	
	if (isset($_POST['insertar'])) {
		$c = $_POST['codProd'];
		$d = $_POST['descProd'];
		$p = $_POST['precio'];
		$s = $_POST['stock'];
		$sql = "insert into productos (codProd, descProd, precio, stock) values ('$c','$d', $p, $s)";
		if ($resultado = $conexion->query($sql)) $error=0; 
		else $error=1;
	}
	
	if (isset($_POST['actualizar'])) {
		$c = $_POST['codProd'];
		$d = $_POST['descProd'];
		$p = $_POST['precio'];
		$s = $_POST['stock'];
		$sql = "update productos set descProd='$d', precio=$p, stock=$s where codProd=$c";
		$resultado = $conexion->query($sql);
	}
	
	if (isset($_GET['eliminar'])) {
		$id = $_GET['eliminar'];
		$sql = "delete from productos where codProd=$id";
		if ($resultado = $conexion->query($sql)) $error=0; 
		else $error=2;
	}
	
	if (isset($_GET['mod'])) {
		$id = $_GET['mod'];
		$sql = "select * from productos where codProd=$id";
		$modif = $conexion->query($sql);
		$acambiar = $modif->fetch(PDO::FETCH_ASSOC);
	}
	


	$rango_pag=8;
	if (isset($_GET["pagina"])) {
		if ($_GET["pagina"]==1) {
			header("location:stock.php");
	    } else {
		$pagina=$_GET["pagina"];
		}
	} else {
		$pagina=1;
	}
	$desde = ($pagina-1)*$rango_pag;
	$sql="select * from productos";
	$resultado = $conexion->query($sql);
	$cant_registros = $resultado->rowCount();
	$cant_pag = ceil($cant_registros/$rango_pag);

	
	
	$sql = "select * from productos limit $desde, $rango_pag";  
	$mostrar = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
 
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/estilomenus.css"> 
	<link rel="stylesheet" type="text/css" href="css/tabla.css"> 
	<title>Menu de pedidos</title>
	<link rel="icon" href="img/loguito.ico">
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
	<section>
		<form class="contact_form" action="stock.php" method="post">
		  <H1 class="centrateh1"> Gestión de Productos </H1>
		  <?php if ($error==1) echo "<p id='controlPatente'> Error-El producto ya existe </p>"; 
		        if ($error==2) echo "<p id='controlPatente'> Error-No es posible eliminar un producto que figura en ventas </p>";
		  ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Código <input type="text" pattern="\d+" name="codProd" maxlength="7" size="10"
		  value="<?php if(isset($_GET['mod'])) echo $acambiar['codProd']; else echo ''; ?>" 
		  <?php if(isset($_GET['mod'])) echo ' readonly '; ?> placeholder="código " autofocus required></input>	
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Descripción <input type="text" name="descProd" pattern="^[a-zA-Z]+$" maxlength="50" size="40"
		  value="<?php if(isset($_GET['mod'])) echo $acambiar['descProd']; else echo ''; ?>" placeholder="descripción " required></input>	
          &nbsp;&nbsp;	        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Precio <input type="text" name="precio" minlength="1" maxlength="20" pattern="[0-9.]{1,20}" size="10"
		  value="<?php if(isset($_GET['mod'])) echo number_format($acambiar['precio'],2,'.',''); else echo ''; ?>" placeholder="precio" required></input>
		  &nbsp;&nbsp;        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  Stock <input type="text" name="stock" minlength="1" maxlength="6" pattern="[0-9]{1,6}" size="10"
		  value="<?php if(isset($_GET['mod'])) echo $acambiar['stock']; else echo ''; ?>" placeholder="stock" required></input>
		  &nbsp;&nbsp;        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <br></br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="submit" 
		  name="<?php if(isset($_GET['mod'])) echo 'actualizar'; else echo 'insertar';?>"
		  value="<?php if(isset($_GET['mod'])) echo 'Modificar'; else echo 'Crear';?>"
		  style='width:120px;height:20px'>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="button" name="cancelar" value="Cancelar" style='width:120px;height:20px' onClick="window.location.href = 'stock.php'">
		</form>  
		  
		<form class="contact_form" method="post">
		<H1 class="centrateh1"> Listado de Productos </H1>
		<table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10" class="">
			<tr>
				<th><center>Código</th>
				<th><center>Descripción</th>
				<th><center>Precio</th>
				<th><center>Stock</th>
				<th><center>Modificar</th>
				<th><center>Eliminar</th>
			</tr>
		  <?php
			while ($fila=$mostrar->fetch(PDO::FETCH_ASSOC)){
				echo "<tr>
						<td align='right'>".$fila['codProd']."</td>
						<td>".$fila['descProd']."</td>
						<td align='right'>".number_format($fila['precio'],2,'.','')."</td>
						<td align='right'>".$fila['stock']."</td></td>
						<td><center><a href='productos.php?mod=".$fila['codProd']."'><img src='img/editar.png' width='30' height='25'></a></center></td>
						<td><center><a href=\"javascript:preguntar('".$fila['codProd']."')\"><img src='img/borrar-archivo.png' width='30'></td>
					  </tr>";
			}
		  ?>
		  </table>
		  <?php

			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."Pág.:  ";
			for ($i=1 ; $i<=$cant_pag ; $i++) {
				echo "<a href='?pagina=".$i."'>".$i."</a>  " ;
			}

		  ?>
		  <script>
			function preguntar(valor) {
				rpta = confirm("Estas seguro de eliminar el producto " + valor + "?");
				if (rpta) window.location.href = "stock.php?eliminar=" + valor;
			}
		  </script>
	</section>
	</form> 
</body>
</html>
