<?php
	session_start();

	$_SESSION['validar_intentos']=1;
	$_SESSION['intentos']=0;
	$_SESSION['mensaje']=0;
	$_SESSION['ventas']=0;
	header("Location: login.php");

?>
