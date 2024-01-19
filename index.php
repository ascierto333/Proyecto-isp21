<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> PapasFriends </title>
	<link rel="stylesheet" href="css/indexx.css">
	<link rel="icon" href="img/loguito.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

</head>
<body background="img/papasfrita.jpg">
 <div class="contact_form">
	<h1>PapasFriends</h1>
	<div class="formulario">
		<form name="loguin" id="loguin" method="post" action ="index.php">
		<p>
				<label class="colocar_nombre">Usuario
				  <span class="obligatorio">*</span>
				</label>
				  <input id="usuario" type="text" name="usuario"  required="obligatorio" placeholder="Escribe tu usuario" required autofocus>
	    </p> 

    	<p>
		    <label class="colocar_nombre">Contraseña
			  <span class="obligatorio">*</span>
			</label>
			  <input id="pass" type="password" name="clave"  required="obligatorio" placeholder="Escribe tu contraseña" required autofocus>
			  <button class="buttonmostrarcontra" type="button" onclick="mostrarContrasena()">Mostrar Contraseña</button> 	 		  
			</div>
	     </p> 

		  <input class="button" type="reset" value="Borrar" /> &nbsp;&nbsp;&nbsp;&nbsp; 
		  <input class="button" type="submit" id="submit" name="enviar" value="Enviar" />
		</form>
	  	<?php
		if (isset($_POST["enviar"])) {  
			include ("conexion.php");
			$usu = $_POST['usuario'];
			$cla = $_POST['clave'];
			$sql = "SELECT * FROM usuarios WHERE usuario='$usu' AND clave='$cla'" ;
			if ($resultado = $conexion->query($sql)) { 
				if ($resultado->fetchColumn() > 0) {
					session_start();   
					$_SESSION["logueado"] = $usu; 
					header("location:principal.php");
				} 
			}	
			echo "<H4 id='errorLoguin'> Usuario o contraseña no valida, por favor ingrese nuevamente los datos correctamente. </H4>" ;
			$conexion = null;
		}
	?>
	  </div>
 </div>
 <script src="js/index.js" ></script>

</body>
</html>
