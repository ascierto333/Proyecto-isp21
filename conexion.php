<?php  
	require("config.php"); 
	try {	
		$conexion = new PDO("mysql:host=$servidor; dbname=$bd", $usuario, $pass);
		$conexion -> exec("SET CHARACTER SET utf8");
	} catch(Exception $e) {
		die('Error: ' . $e->GetMessage());	
	} 
?>

