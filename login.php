<?php
	session_start();

	if($_SESSION['validar_intentos']!=1){
		header("Location: valida.php");
	}

	if($_SESSION['mensaje']!=1){
		$_SESSION['mensaje']=1;
		?>
			<script>
				alert("Se recomienda utilizar los navegadores CHROME, FIREFOX U OPERA para que el sistema funcione correctamente :D");
			</script>
		<?php
	}
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
	    <meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="shortcut icon" href="imagenes_GEMA/icon2_gema.ico">
		<title> G.E.M.A. </title>
	</head>
	<body>
	<!-- LIMPIA ERRORES SI EL CONTENIDO DE OTRA CAJA ES MUY GRANDE	<div class="clearfix visible-lg-block">
			</div>
	-->
		<br>
		<center>
			<div class="container">
				<div class="main row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<img src="imagenes_GEMA/logo1.png" width="180" heigth="130">
					</div>
				</div>
			</div>

			<div class="col-xs-10 col-sm-7 col-md-5" id="caja_login">
				<form method="POST" class="box">
				<br>
					<img src="imagenes_GEMA/user.png" width="40" heigth="40">
					<input type="text" name="usuario" required placeholder="Nombre o Correo..." autocomplete="off">
					<img src="imagenes_GEMA/pass.png" width="30" heigth="30">
					<input type="password" name="pass" required placeholder="Contraseña...">
					<button name="iniciar_sesion" type="submit">Iniciar Sesión</button>
					<br><br>
				</form>	
			</div>
		</center>
		
			<?php

			if (isset($_POST['iniciar_sesion'])) {
				//conexion de php a MySQL
				require("conexion_bd.php");
						$usuario=$_POST['usuario'];
						$pass=$_POST['pass'];

						$resultado=mysqli_query($conexion, "SELECT * from usuarios where nombre_usuario='$usuario' OR correo_usuario='$usuario'");

						if($contenido=mysqli_fetch_array($resultado)){
							$_SESSION['tipousuario']=$contenido['tipo_usuario'];
							$_SESSION['id_usuario']=$contenido['id_usuario'];
							$_SESSION['nombre_usuario']=$contenido['nombre_usuario'];
							if($contenido['password_usuario']==$pass){
								$_SESSION['intentos']=0;
								$_SESSION['autentico']="yes";
								$_SESSION['precio_final']=0;
								header("Location: sesion_admin.php");
							}
							else{
								$_SESSION['intentos']+=1;
								?>
								<script>
									alert("Password Incorrecto");
								</script>
								<?php
							}
						}
						else{
							$_SESSION['intentos']+=1;
							?>
								<script>
									alert("Usuario Incorrecto");
								</script>
							<?php
						}
						if($_SESSION['intentos']>2){
							$_SESSION['intentos']=0;
							?>
							<script languaje="JavaScript">
								alert("Haz intentado ingresar más de tres veces, el sistema se bloqueará por 2 minutos...");
								window.location="login_bloq.php";
						    </script>
							<?php	
						}
			}
			?>
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->
		
		<footer>
		  <center>
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-3 col-lg-3">
				</div>

				<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
					<br>
					<img src="imagenes_GEMA/logo2.png" width="200"  height="100">
				</div>

				<div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
				<br>
					<h6>SOPORTE TÉCNICO</h6>
					<h6>tel: 55-78-32-98-83</h6>
					<h6>correo: sip_gema@gmail.com</h6>
				<br>
				</div>

				<div class="col-xs-12 col-sm-1 col-md-3 col-lg-3">
				</div>
			</div>
		  </center>
		</footer>


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>