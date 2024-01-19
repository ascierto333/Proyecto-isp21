<?php
    include("conexion.php");
	include("verifica_sesion.php"); 	
	
	if (isset($_SESSION['cliente'])) {
		$id = $_SESSION['cliente']->idCliente;   
		$dni = $_SESSION['cliente']->dni;        
		$nombre = $_SESSION['cliente']->nombre;  
		$direccioncliente = $_SESSION['cliente']->direccioncliente;
		$cuit = $_SESSION['cliente']->cuit; 
	} else {
		$id = "     ";
		$dni = "     ";
		$nombre = "     ";
		$direccioncliente = "     ";
		$cuit = "     ";
	}
	
	if (isset($_SESSION['productos'])) {
		$productos = $_SESSION['productos'];
	} else {
		$productos = array();
	}
	$total = 0;
	
	if (isset($_GET['eliminar'])) {
		$id = $_GET['eliminar'];
		foreach ($_SESSION['productos'] as $p) {
			if($p->codProd == $id) unset($_SESSION['productos'][key($_SESSION['productos'])]);
			next($_SESSION['productos']);
		}
		$productos = $_SESSION['productos'];
    }

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
		<form class="contact_form" action="operacionesVentas.php" method="post">
		<H1 class="centrateh1"> Buscar Cliente </H1>
		<table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10" class="">
		    <tr>
				<th>Id</th>
				<th>Dni</th>
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Cuit</th>
			</tr>
			<tr>
				<td><?php echo $id; ?></td>
				<td><?php echo $dni; ?></td>
				<td><?php echo $nombre; ?></td>
				<td><?php echo $direccioncliente; ?></td>
				<td><?php echo $cuit; ?></td>
			</tr>
		   </table>
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		      <input type="text" name="dni" minlength="5" maxlength="8" placeholder="dni" pattern="\d+" autofocus required title="El DNI debe contener solo números."></input>	&nbsp;&nbsp;&nbsp; 
		   &nbsp;&nbsp;&nbsp; <input type="submit" name="operacion" value="Buscar Cliente" style='width:120px;height:20px'
		         <?php if (isset($_SESSION['cliente'])) echo " disabled='true'";?>>
		  <?php if (isset($_SESSION['errorCliente'])) {
					echo "<em id='errorLoguin'>".$_SESSION['errorCliente']."</em>";
					unset($_SESSION['errorCliente']);
				}
		  ?>	
		</form>  
		
		<form class="contact_form" action="operacionesVentas.php" method="post">
		<table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10" class="">
		  <H1 class="centrateh1"> Buscar productos </H1>
		    <tr>
				<th>Cantidad a Vender</th>
				<th>Codigo Producto</th>
			</tr>
			<tr>
				<th><input style="text-align:center;" type="number" name="cantProd" min="1" max="99" value="1" pattern="\d+" ></input></th>
				<th><input style="text-align:center;" type="text" placeholder="Producto" name="codProd" minlength="1" maxlength="5" size="5" pattern="\d+" autofocus required title="El código debe contener solo números."> </input></th>
				<th ><input type="submit" name="operacion" value="Buscar Producto" style='width:120px;height:20px;color: black;'
				           <?php if (!isset($_SESSION['cliente'])) echo "disabled='true'";?>></th>
                <?php
                if (isset($_SESSION['errorProducto'])) {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '" . $_SESSION['errorProducto'] . "',
                            });
                        </script>";
                    unset($_SESSION['errorProducto']);
                }
                ?>
			</tr>
			</table>
			<br></br>
			</form> 
			<form class="contact_form" action="operacionesVentas.php" method="post">
			<H1 class="centrateh1"> Productos a facturar </H1>
			<table width="100%" border="3" bordercolor="#000000" cellspacing="10" cellpadding="10" class="">
			<tr>
				<th align="center">Codigo Producto</th>
				<th align="center">Descripción</th>
				<th align="center">Cantidad</th>
				<th align="center" width="120">Precio</th>
				<th align="center" width="120">Subtotal</th>
				<th align="center" width="120">Borrar</th>
			</tr>
			<?php foreach($productos as $p): ?>
				<tr>
					<td><?php echo $p->codProd; ?></td>
					<td><?php echo $p->descProd; ?></td>
					<td align="right"><?php echo $p->cantProd; ?></td>
					<td align="right"><?php echo number_format($p->precio, 2); ?></td>
					<td align="right"><?php echo number_format($p->cantProd * $p->precio, 2); ?></td>
					<td><center><a href="javascript:preguntar('<?php echo $p->codProd; ?>')"><img src='img/borrar-archivo.png' width='30'></td> 
				</tr>
				<?php $total = $total + $p->cantProd * $p->precio; ?>
			<?php endforeach; ?>
			<tr>
				<td><?php echo "     " ?></td>
				<td><?php echo "     " ?></td>
				<td><?php echo "     " ?></td>
				<td align="center"><b><?php echo "Total" ?></b></td>
				<td align="right"><b><?php echo number_format($total, 2); ?></b></td>
				<?php if (isset($_SESSION['cliente'])) $_SESSION['cliente']->total=$total; // para usar en el pdf?>
			</tr>
		   </table>
		   <br></br>
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <th>Selecciona tipo de factura</th>
		   <select name="tipoFact" class="caja" required>
			<?php
				if(isset($_GET['mod'])){
					echo "<option value='".$acambiar['tipoFact']."' selected>".$acambiar['tipoFact']."</option>";
				}
			?> 
			<option value="Factura A" selected> Tipo de factura A </option>
			<option value="Factura B">Tipo de factura B </option>
			<option value="Factura C">Tipo de factura C </option>
			<option value="Factura D">Tipo de factura D </option>
			<option value="Factura E">Tipo de factura E </option>
			<option value="Presupuesto"> Presupuesto </option>
		  </select>  
		  <br>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <?php if (!empty($productos)): ?>  
		  <input type="submit" name="operacion" value="Facturar" style='width:120px;height:20px'>
		  <?php endif; ?>
		   &nbsp;&nbsp;&nbsp;<input type="submit" name="operacion" value="Cancelar" style='width:120px;height:20px'> 
		</form>  
		<script src="js/index.js" >
			function preguntar(valor) {
				rpta = confirm("Estas seguro de eliminar el producto " + valor + "?");
				if (rpta) window.location.href = "pedidos.php?eliminar=" + valor;
			}
		</script>
	</section>
</body>
</html>



