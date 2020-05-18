<?php 
session_start();
require("conexion_bd.php");

if($_SESSION['autentico']!="yes"){	
	header("Location: login.php");
	exit();
}
else{
	$id_usuario=$_SESSION['id_usuario'];
    $nombre_usuario=$_SESSION['nombre_usuario'];	

    $fecha=getdate();
    $mes=$fecha['mon'];
    $dia=$fecha['mday'];
}
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
	    <meta charset="utf-8">
	    <script src="graficas/plotly-latest.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<link rel="shortcut icon" href="imagenes_GEMA/icon2_gema.ico">
		<title>VENTAS G.E.M.A.</title>
	</head>
	<body>

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
						<h3>TUS VENTAS</h3>
						<h6>VENDEDOR <?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
						<br>
					<center>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-2">
						<center>
						<br>
						<img src="imagenes_GEMA/estadistica.jpg" width="80" heigth="90">
						</center>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<form method="POST">
						   <center>
							<br>
							<button id="cerrar" type="submit" name="regresar">Regresar</button>
						   </center>
						</form>
					</div>
				
				<?php
					if(isset($_POST['regresar'])){
						header("Location: sesion_admin.php");
					}
				?>
				</div>
			</div>
		</header>

<!-- CUERPO DE LAS ESTADISTICAS ********************************************************************************-->

<div class="row">
	<div class="col-xs-1 col-sm-1 col-md-1">
	</div>

	<div class="col-xs-10 col-sm-10 col-md-10">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
			<br>
				<center>
					<label><strong>MES - <?php echo $fecha['month'] ?></strong><label>
				</center>
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-4">
			</div>
			
			<div class="col-xs-12 col-sm-6 col-md-4" id="borde-der">
				<br>
				<center>
					<h5 id="mejor"><strong>Tus ventas del mes hasta el momento</strong></h5>
					<?php
						$ventas=mysqli_query($conexion, "SELECT COUNT(*) FROM ventas_encabezado WHERE month(fecha)=$mes AND id_usuario='$id_usuario';");
						$ventas_totales=mysqli_fetch_array($ventas)
					?>
					<h2 id="precio_final"><strong><?php echo $ventas_totales[0]; ?></strong></h2>
				</center>
			</div>

			<div class="col-xs-12 col-sm-3 col-md-4">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="ventas">
				<center>
					<br>
					<h6><strong>Tus productos vendidos durante el mes</strong></h6>
				</center>
				<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      		$productos=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE month(fecha)=$mes AND id_usuario='$id_usuario') GROUP BY vd.id_producto ORDER BY cantidad ASC;");
			      
			      while($datos_pro=mysqli_fetch_array($productos)){

						$id=$datos_pro[1];

						$producto_nom=mysqli_query($conexion, "SELECT nombre_producto, precio_producto, id_producto FROM productos WHERE id_producto='$id';");
						$producto_nombre=mysqli_fetch_row($producto_nom); 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos_pro[1]."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$producto_nombre[0]."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$producto_nombre[1]."</h6>";?></td>
				      <td><?php echo "<h6 id='precio_final'>".$datos_pro[0]."</h6>";
				      ?></td>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="ventas">
				<center>
					<br>
					<h6><strong>Tus productos vendidos durante el día</strong></h6>
				</center>
				<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      		$productos=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE day(fecha)=$dia AND id_usuario='$id_usuario') GROUP BY vd.id_producto ORDER BY cantidad ASC;");
			      
			      while($datos_pro=mysqli_fetch_array($productos)){

						$id=$datos_pro[1];

						$producto_nom=mysqli_query($conexion, "SELECT nombre_producto, precio_producto, id_producto FROM productos WHERE id_producto='$id';");
						$producto_nombre=mysqli_fetch_row($producto_nom); 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos_pro[1]."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$producto_nombre[0]."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$producto_nombre[1]."</h6>";?></td>
				      <td><?php echo "<h6 id='precio_final'>".$datos_pro[0]."</h6>";
				      ?></td>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="col-xs-1 col-sm-1 col-md-1">
	</div>
</div>


<!-- CUERPO DE LAS ESTADISTICAS ********************************************************************************-->

		<!-- PIE DE LA PÁGINA ********************************************************************************** -->


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>