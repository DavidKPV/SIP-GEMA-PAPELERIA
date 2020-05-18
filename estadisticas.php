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
		<title>ESTADÍSTICAS G.E.M.A.</title>
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
						<h3>ESTADÍSTICAS</h3>
						<h6>ADMINISTRADOR <?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
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
			<div class="col-xs-12 col-sm-6 col-md-3" id="borde-der">
				<br>
				<center>
					<h5 id="mejor"><strong>Ventas hasta el momento</strong></h5>
					<?php
						$ventas=mysqli_query($conexion, "SELECT COUNT(*) FROM ventas_encabezado WHERE month(fecha)=$mes;");
						$ventas_totales=mysqli_fetch_array($ventas)
					?>
					<h2 id="precio_final"><strong><?php echo $ventas_totales[0]; ?></strong></h2>
				</center>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-3" id="borde-der">
				<br>
				<center>
					<h5 id="mejor"><strong>Total de Ganancias</strong></h5>
					<?php
						$gananciatotal=0;

						$total_ga=mysqli_query($conexion, "SELECT * FROM ventas_encabezado WHERE month(fecha)=$mes;");
			     		while($ganancias=mysqli_fetch_array($total_ga)){
			     			$ganancia1=$ganancias['precio_final'];
			     			$gananciatotal=$ganancia1+$gananciatotal;
			     		}
					?>
					<h2 id="precio_final"><strong>$ <?php echo $gananciatotal;?> <h6>(MXN)</h6></strong></h2>
				</center>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6" id="borde-der">
				<br>
				<center>	
					<h5 id="mejor"><strong>Producto más vendido</strong></h5>
					<?php
						$producto_mas=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE month(fecha)=$mes) GROUP BY vd.id_producto ORDER BY cantidad DESC LIMIT 1;");

						$producto_mas_vendido=mysqli_fetch_array($producto_mas);

						$id=$producto_mas_vendido[1];

						$producto_mas_nom=mysqli_query($conexion, "SELECT nombre_producto, id_producto FROM productos WHERE id_producto='$id';");
						$producto_mas_nombre=mysqli_fetch_row($producto_mas_nom);
					?>
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Cantidad</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_vendido[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Nombre</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_nombre[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>ID</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_vendido[1]; ?></strong></h6>
						</div>
					</div>
				</center>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6" id="borde-der">
				<br>
				<center>
					<h5 id="mejor"><strong>Vendedor Destacado</strong></h5>
					<?php
						$user_mas=mysqli_query($conexion, "SELECT COUNT(*) as cantidad, id_usuario FROM ventas_encabezado WHERE month(fecha)=$mes GROUP BY id_usuario ORDER BY cantidad DESC limit 1;");

						$user_mas_ven=mysqli_fetch_array($user_mas);

						$id_user=$user_mas_ven[1];

						$nombre=mysqli_query($conexion, "SELECT nombre_usuario FROM usuarios WHERE id_usuario='$id_user'");
						$nombre_user=mysqli_fetch_row($nombre);
					?>
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Ventas</h6>
							<h6 id="precio_final"><strong><?php echo $user_mas_ven[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Nombre</h6>
							<h6 id="precio_final"><strong><?php echo $nombre_user[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>ID</h6>
							<h6 id="precio_final"><strong><?php echo $user_mas_ven[1]; ?></strong></h6>
						</div>
					</div>
				</center>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6" id="borde-der">
				<br>
				<center>
					<h6 id="peor"><strong>Producto menos vendido</strong></h6>
					<?php
						$producto_mas=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE month(fecha)=$mes) GROUP BY vd.id_producto ORDER BY cantidad ASC LIMIT 1;");

						$producto_mas_vendido=mysqli_fetch_array($producto_mas);

						$id=$producto_mas_vendido[1];

						$producto_mas_nom=mysqli_query($conexion, "SELECT nombre_producto, id_producto FROM productos WHERE id_producto='$id';");
						$producto_mas_nombre=mysqli_fetch_row($producto_mas_nom);
					?>
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Cantidad</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_vendido[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Nombre</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_nombre[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>ID</h6>
							<h6 id="precio_final"><strong><?php echo $producto_mas_vendido[1]; ?></strong></h6>
						</div>
					</div>
				</center>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6" id="borde-der">
				<br>
				<center>
					<h6 id="peor"><strong>Vendedor con menor cantidad ventas</strong></h6>
					<?php
						$user_men=mysqli_query($conexion, "SELECT COUNT(*) as cantidad, id_usuario FROM ventas_encabezado WHERE month(fecha)=$mes GROUP BY id_usuario ORDER BY cantidad ASC limit 1;");

						$user_men_ven=mysqli_fetch_array($user_men);

						$id_user=$user_men_ven[1];

						$nombre=mysqli_query($conexion, "SELECT nombre_usuario FROM usuarios WHERE id_usuario='$id_user'");
						$nombre_user=mysqli_fetch_row($nombre);
					?>
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Ventas</h6>
							<h6 id="precio_final"><strong><?php echo $user_men_ven[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>Nombre</h6>
							<h6 id="precio_final"><strong><?php echo $nombre_user[0]; ?></strong></h6>
						</div>

						<div class="col-xs-4 col-sm-4 col-md-4">
							<h6>ID</h6>
							<h6 id="precio_final"><strong><?php echo $user_men_ven[1]; ?></strong></h6>
						</div>
					</div>
				</center>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-6" id="borde-der">
				<center>
					<h6><strong>No. de Productos</strong></h6>
					<div class="row">
						<div class="col-xs-3 col-sm-4 col-md-4" id="borde-der">
							<h6>Total</h6>
							<div class="row">
							<?php
								$tipo=mysqli_query($conexion, "SELECT COUNT(*) as cantidad FROM productos;");

								while($tipos=mysqli_fetch_array($tipo)){
							?>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<h5 id="precio_final"><?php echo $tipos[0]; ?></h5>
								</div>
							<?php
								}
							?>
							</div>
						</div>

						<div class="col-xs-9 col-sm-8 col-md-8">
							<h6>Tipos</h6>
							<div class="row">
							<?php
								$tipo=mysqli_query($conexion, "SELECT dp.caracteristica, COUNT(*) as cantidad FROM diccionario_de_productos dp, productos p WHERE dp.id_tipoproducto=p.id_tipoproducto GROUP BY p.id_tipoproducto;");

								while($tipos=mysqli_fetch_array($tipo)){
							?>
								<div class="col-xs-6 col-sm-9 col-md-9">
									<?php echo $tipos[0]; ?>
								</div>

								<div class="col-xs-6 col-sm-3 col-md-3">
									<h6 id="precio_final"><?php echo $tipos[1]; ?></h6>
								</div>
							<?php
								}
							?>
							</div>
						</div>
					</div>
				</center>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="borde-der">
				<center>
					<h6 id="peor"><strong>Productos agotados o por agotarse</strong></h6>
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
			      $resultado=mysqli_query($conexion, "SELECT * from productos WHERE cantidad_producto<5;");
			      while($datos=mysqli_fetch_array($resultado)){
			    	//$codigo=$datos['codigo']; 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['precio_producto']."</h6>";?></td>
				      <td><?php
				      if($datos['cantidad_producto']>0){
				      	echo "<h6 id='wordinicio'>".$datos['cantidad_producto']."</h6>";
				      }
				      else{
				      	echo "<h6 id='wordalert'>".$datos['cantidad_producto']."</h6>";
				      }
				      ?></td>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<br>
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" id="ventas">
				<center>
					<br>
					<h6><strong>Productos vendidos durante el mes</strong></h6>
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
			      		$productos=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE month(fecha)=$mes) GROUP BY vd.id_producto ORDER BY cantidad ASC;");
			      
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
					<h6><strong>Productos vendidos durante el día</strong></h6>
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
			      		$productos=mysqli_query($conexion, "SELECT SUM(vd.cantidad_producto) as cantidad, vd.id_producto FROM ventas_descripcion vd WHERE vd.id_venta IN (SELECT id_venta FROM ventas_encabezado WHERE day(fecha)=$dia) GROUP BY vd.id_producto ORDER BY cantidad ASC;");
			      
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