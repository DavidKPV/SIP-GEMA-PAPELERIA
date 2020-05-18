<?php 
session_start();
require("conexion_bd.php");

if($_SESSION['autentico']!="yes"){	
	header("Location: login.php");
	exit();
}
else{
	if($_SESSION['tipousuario']=='administrador'){
	   header("Location: sesion_admin.php");
	}
	else{
		$id_usuario=$_SESSION['id_usuario'];
    	$nombre_usuario=$_SESSION['nombre_usuario'];
    	$_SESSION['ventas']+=1;
		$_SESSION['precio_final']=0;
	}
}
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
		<title>INICIO G.E.M.A.</title>
	</head>
	<body onload="nobackbutton();">

	<!-- LIMPIA ERRORES SI EL CONTENIDO DE OTRA CAJA ES MUY GRANDE	<div class="clearfix visible-lg-block">
			</div>

			INICIO DE LA PÁGINA
	-->

		<header>
			<div class="container">
				<div class="main row">
					<div class="col-xs-12 col-sm-3 col-md-2">
						<br>
						<center>
						<img src="imagenes_GEMA/logo1.png" width="100" heigth="110">
						</center>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-5">
					<center>
						<br>
						<h3>PAPELERÍA G.E.M.A.</h3>
						<h6>BIENVENIDO VENDEDOR <?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
						<br>
					<center>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-2">
						<center>
						<br>
						<img src="imagenes_GEMA/inicio.png" width="75" heigth="90">
						</center>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<form method="POST">
						   <center>
							<br>
							<button id="cerrar" type="submit" name="cerrar_session">Cerrar Sesión</button>
						   </center>
						</form>
					</div>
				
				<?php
					if(isset($_POST['cerrar_session'])){
						$_SESSION['autentico']="No";
						header("Location: login.php");
					}
				?>
				</div>
			</div>
		</header>

		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-10">
			<br>
				<nav class="navbar navbar-light bg-light">
					  <form class="form-inline" method="POST">
					  <center>
					    <input class="form-control mr-sm-1" type="search" placeholder="Buscar producto..." aria-label="Search" name="valor" autocomplete="off">
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="buscador">Buscar</button>
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="ver_todo">Ver todo</button>
					  </center>
					  </form>
				</nav>

				<br>

<!-- SI SE ACTIVA EL BUSCADOR ********************************************************************************** -->

	<?php if(isset($_POST['buscador'])){
		$buscador=$_POST['valor'];
	?>
				<table class="table table-striped">
				  <thead>
				  	<tr>
						<th colspan="4"><h6 class="wordinicio"><center><strong>PRODUCTOS ENCONTRADOS</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      $resultado=mysqli_query($conexion, "SELECT * from productos where (id_producto='$buscador' OR nombre_producto='$buscador' OR id_producto LIKE'$buscador%' OR nombre_producto LIKE '$buscador%') AND cantidad_producto>0;");
			      while($datos=mysqli_fetch_array($resultado)){
			    	//$codigo=$datos['codigo']; 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['precio_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['cantidad_producto']."</h6>";?></td>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>
	<?php 
		}
		else{ 
	?>

<!-- SI NO SE ACTIVA EL BUSCADOR ********************************************************************************** -->

				<table class="table table-striped">
				  <thead>
				  	<tr>
						<th colspan="4"><h6 class="wordinicio"><center><strong>PRODUCTOS DISPONIBLES</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      $resultado=mysqli_query($conexion, "SELECT * from productos WHERE cantidad_producto>0");
			      while($datos=mysqli_fetch_array($resultado)){
			    	//$codigo=$datos['codigo']; 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['precio_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['cantidad_producto']."</h6>";?></td>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>

			<?php
				}
			?>

			</div>

<!-- BARRA DERECHA DEL BUSCADOR ********************************************************************************** -->

			<div class="col-xs-12 col-sm-4 col-md-2" id="caja_derecha">
				<center>
					<br><br>
				    <img src="imagenes_GEMA/logo2.png" width="120" heigth="130">
				    <br><br>
					<h6>SOPORTE TÉCNICO</h6>
					<h6>tel: 55-78-32-98-83</h6>
					<h6>correo: sip_gema @gmail.com</h6>
					<br>

					<form method="POST">
						<br>
						<button id="boton" type="submit" name="real_ven">Realizar Ventas</button>
						<br>
						<button id="boton" type="submit" name="consul_mat">Consulta Avanzada</button>
						<br>
						<button id="boton" type="submit" name="ver_ventas">Ver mis ventas</button>
					</form>
					<br><br>
					<br><br>
				</center>
			<?php

			if(isset($_POST['consul_mat'])){
				?>
				<script>
					window.location.href = "consulta_avan.php";
				</script>
				<?php
			}
			if(isset($_POST['real_ven'])){
				?>
				<script>
					window.location.href = "ventas.php";
				</script>
				<?php
			}
			if(isset($_POST['ver_ventas'])){
				?>
				<script>
					window.location.href = "ver_ventas.php";
				</script>
				<?php
			}

			?>
			</div>
		</div>
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>