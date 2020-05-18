<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
	    <meta charset="utf-8">
	    <script src="js/custom.js"></script>
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="shortcut icon" href="imagenes_GEMA/icon2_gema.ico">
		<title>BLOQ G.E.M.A. </title>
	</head>
	<body onload="nobackbutton();">
	<!-- LIMPIA ERRORES SI EL CONTENIDO DE OTRA CAJA ES MUY GRANDE	<div class="clearfix visible-lg-block">
			</div>
	-->
	    <script type="text/javascript">
	        var contador = 120; // Segundos
	        var redirecciona = "login.php";
	         
	        function temporizador(){
	            var mensaje = document.getElementById("mensaje");
	            if(contador > 0){
	                contador--;
	                mensaje.innerHTML = contador+" Segundos.";
	                setTimeout("temporizador()", 1000);
	            }else{
	                window.location.href = redirecciona;
	            }
	        }
	    </script>

    <div>
		<center>
			<br><br><br>
				<img src="imagenes_GEMA/bloq.png" width="200" heigth="200">
			<br><br><br>
		</center>
	</div>

    <footer>
    	<br>
		<center>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h6>EL LOGIN SE DESBLOQUEARÁ EN...</h6>
				<span id="mensaje">
			        <script type="text/javascript">temporizador();</script>
			    </span>
			</div>
		</center>
		<br>
	</footer> 
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>