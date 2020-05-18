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
    $fecha_oficial=$fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
    $valor_x=$_SESSION['ventas'];
    $id_venta=$id_usuario.$fecha['mday'].$fecha['hours'].$valor_x;
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
		<title>VENTAS G.E.M.A. </title>
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
						<h3>REALIZAR VENTAS</h3>
						<h6><?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
						<br>
					<center>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-2">
						<center>
						<br>
						<img src="imagenes_GEMA/venta2.png" width="80" heigth="90">
						</center>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<form method="POST">
						   <center>
							<br>
							<button id="cerrar" type="submit" name="regresar">Regresar y Cancelar Venta</button>
						   </center>
						</form>
					</div>
				
				<?php
					if(isset($_POST['regresar'])){
						$regresa_cantidad=mysqli_query($conexion, "SELECT SUM(cantidad_producto), id_producto FROM ventas_descripcion WHERE id_venta='$id_venta' GROUP BY id_producto;");
			      		while($regresa_cant=mysqli_fetch_array($regresa_cantidad)){
			      			$cantidad=$regresa_cant[0];
			      			$id_producto=$regresa_cant[1];

			      			$obtener_old_cant=mysqli_query($conexion, "SELECT cantidad_producto FROM productos WHERE id_producto='$id_producto';");
			      			$resul_old_cant=mysqli_fetch_array($obtener_old_cant);

			      			$new_cantidad=$resul_old_cant[0]+$cantidad;

			      			mysqli_query($conexion, "UPDATE productos SET cantidad_producto=$new_cantidad WHERE id_producto='$id_producto';");
			      		}

						mysqli_query($conexion, "DELETE from ventas_descripcion WHERE id_venta='$id_venta';");
						mysqli_query($conexion, "DELETE from ventas_encabezado WHERE id_venta='$id_venta';");
						header("Location: sesion_admin.php");
					}
				?>
				</div>
			</div>
		</header>


		<div class="row">
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3">
				<center>
				<br>
				<strong><label>Datos del vendedor</label></strong>
				</center>
			</div>

			<div class="col-xs-12 col-sm-2 col-md-2">
				<label>ID Venta</label>
				<textarea type="text" class="form-control" rows="1" disabled><?php echo $id_venta; ?></textarea>
			</div>

			<div class="col-xs-12 col-sm-2 col-md-2">
				<label>ID Usuario</label>
				<textarea type="text" class="form-control" rows="1" disabled><?php echo $id_usuario; ?></textarea>
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3">
				<label>Nombre</label>
				<textarea type="text" class="form-control" rows="1" disabled><?php echo $nombre_usuario; ?></textarea>
			</div>

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>
		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">  <!-- BUSCADOR ********************-->

			<div class="row">
<!--******************************** BARRA DERECHA ***************************************************************-->
			<div class="col-xs-11 col-sm-12 col-md-12 col-lg-12">

			<br>
				<nav class="navbar navbar-light bg-light">
					  <form class="form-inline" method="POST">
					  <center>
					    <input class="form-control mr-sm-1" type="search" placeholder="Buscar producto..." aria-label="Search" name="valor" autocomplete="off">
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="buscador">Buscar</button>
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
						<th colspan="6"><h6 class="wordinicio"><center><strong>PRODUCTOS EN EXISTENCIA</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio</th>
				      <th scope="col">Existencias</th>
				      <th scope="col">Cantidad</th>
				      <th scope="col"></th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      $resultado=mysqli_query($conexion, "SELECT * from productos where (id_producto='$buscador' OR nombre_producto='$buscador' OR id_producto LIKE'$buscador%' OR nombre_producto LIKE '$buscador%') AND cantidad_producto>0;");
			      while($datos=mysqli_fetch_array($resultado)){
			    	  $cantidad_por_pro=$datos['cantidad_producto']; 
			    	  $id_pro=$datos['id_producto'];
			      ?>
				    <tr>
				    <form method="POST">
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>"."$".$datos['precio_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['cantidad_producto']."</h6>";?></td>
				      <td><?php echo "<input type='number' id='select' class='form-control' value=1 required name='cantidad' min='1' max='$cantidad_por_pro'>" ?></td>
				      <td><?php echo "<button type='submit' name='agregar_pro' value=$id_pro class='btn btn-outline-success my-2 my-sm-1'>Agregar</button>" ?></td>
				    </form>
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
						<th colspan="6"><h6 class="wordinicio"><center><strong>PRODUCTOS EN EXISTENCIA</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio</th>
				      <th scope="col">Existencias</th>
				      <th scope="col">Cantidad</th>
				      <th scope="col"></th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      $resultado=mysqli_query($conexion, "SELECT * from productos where cantidad_producto>0");
			      while($datos=mysqli_fetch_array($resultado)){
			    	  $cantidad_por_pro=$datos['cantidad_producto']; 
			    	  $id_pro=$datos['id_producto'];
			      ?>
				    <tr>
				    <form method="POST">
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>"."$".$datos['precio_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos['cantidad_producto']."</h6>";?></td>
				      <td><?php echo "<input type='number' id='select' class='form-control' value=1 required name='cantidad' min='1' max='$cantidad_por_pro'>" ?></td>
				      <td><?php echo "<button type='submit' name='agregar_pro' value=$id_pro class='btn btn-outline-success my-2 my-sm-1'>Agregar</button>" ?></td>
				    </form>
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
<!--**************************************************************************************************************-->

			</div>			

			</div>  <!-- FIN BUSCADOR *********************************************** -->

 			<!-- INICIO DE CAJA DE VENTAS SI SE ACTIVA-->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
			<br>
			<div class="row">
				<br>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-11" id="caja_venta">
<form method="POST"> <!-- FORMULAIO DE LA VENTA INICIO -->
					<div class="row">

					<div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12"><!-- CAJA DE LA TABLA DE LOS PRODUCTOS INICIO-->
					
					<?php	
					if(isset($_POST['agregar_pro'])){
						$id_pro=$_POST['agregar_pro'];
						$cantidad_pro=$_POST['cantidad'];

						$resultado2=mysqli_query($conexion, "SELECT * from productos WHERE id_producto='$id_pro';");
			      		while($datos2=mysqli_fetch_array($resultado2)){
			      			$precio=$datos2['precio_producto'];
			      			$cantidadtotal=$datos2['precio_producto']*$cantidad_pro;
			      			$valor_viejo=$_SESSION['precio_final'];
			      			$_SESSION['precio_final']=$cantidadtotal+$valor_viejo;

			      			$vieja_cantidad=$datos2['cantidad_producto'];
			      			$new_cantidad=$vieja_cantidad-$cantidad_pro;
			      		}

						mysqli_query($conexion, "INSERT INTO ventas_encabezado VALUES ('$id_venta', '$fecha_oficial', 0, '$id_usuario');");
						mysqli_query($conexion, "INSERT INTO ventas_descripcion VALUES ('$id_venta', '$id_pro', $cantidad_pro, $precio);");
						mysqli_query($conexion, "UPDATE productos SET cantidad_producto=$new_cantidad WHERE id_producto='$id_pro';");
						?>

						<script> window.location.href="ventas.php" </script>

						<table class="table table-striped">
							<thead>
								<tr>
									<th colspan="5"><h6 class="wordinicio"><center><strong>PRODUCTOS ELEGIDOS</strong></center><h6></td>
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
						$resultado3=mysqli_query($conexion, "SELECT * from ventas_descripcion WHERE id_venta='$id_venta';");
			      		while($datos3=mysqli_fetch_array($resultado3)){
			      			$id_pro2=$datos3['id_producto'];
			      			$cantidad_adqui=$datos3['cantidad_producto'];

			      			$resultado4=mysqli_query($conexion, "SELECT * from productos WHERE id_producto='$id_pro2';");
				      		while($datos4=mysqli_fetch_array($resultado4)){
				      			$nombre=$datos4['nombre_producto'];
				      			$precio=$datos4['precio_producto'];
				      			$valor_total=$cantidad_adqui*$precio;
				      		
			      			?>
			      				<tr>
							      <th scope="row"><?php echo"<h6 id='wordinicio'>".$datos3['id_producto']."</h6>";?></th>
							      <td><?php echo "<h6 id='wordinicio'>".$nombre."</h6>";?></td>
							      <td><?php echo "<h6 id='wordinicio'>".$precio."</h6>";?></td>
							      <td><?php echo "<h6 id='wordinicio'>".$datos3['cantidad_producto']."</h6>";?></td>
							      <form method="POST">
							      	<td><?php echo "<button type='submit' name='quitar' value=$id_pro2 id='cancelar'>X</button>" ?></td>
							      </form>
							    </tr>
							<?php
							}
						}
						?>
							</tbody>
						</table>
						<?php
					}
					else{
						?>
						 <table class="table table-striped">
							<thead>
								<tr>
									<th colspan="6"><h6 class="wordinicio"><center><strong>PRODUCTOS ELEGIDOS</strong></center><h6></td>
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
						$resultado3=mysqli_query($conexion, "SELECT * from ventas_descripcion WHERE id_venta='$id_venta';");
			      		while($datos3=mysqli_fetch_array($resultado3)){
			      			$id_pro2=$datos3['id_producto'];
			      			$cantidad_adqui=$datos3['cantidad_producto'];

			      			$resultado4=mysqli_query($conexion, "SELECT * from productos WHERE id_producto='$id_pro2';");
				      		while($datos4=mysqli_fetch_array($resultado4)){
				      			$nombre=$datos4['nombre_producto'];
				      			$precio=$datos4['precio_producto'];
				      			$valor_total=$cantidad_adqui*$precio;
				      		
			      			?>
			      				<tr>
							      <th scope="row"><?php echo"<h6 id='wordinicio'>".$datos3['id_producto']."</h6>";?></th>
							      <td><?php echo "<h6 id='wordinicio'>".$nombre."</h6>";?></td>
							      <td><?php echo "<h6 id='wordinicio'>".$precio."</h6>";?></td>
							      <td><?php echo "<h6 id='wordinicio'>".$datos3['cantidad_producto']."</h6>";?></td>
							      <form method="POST">
							      	<td><?php echo "<button type='submit' name='quitar' value=$id_pro2 id='cancelar'>X</button>" ?></td>
							      </form>
							    </tr>
							<?php
							}
						}
  if(isset($_POST['quitar'])){
  		$id_pro=$_POST['quitar'];

  		$regresa_cantidad=mysqli_query($conexion, "SELECT SUM(cantidad_producto) FROM ventas_descripcion WHERE id_venta='$id_venta' AND id_producto='$id_pro'");
			      		if($regresa_cant=mysqli_fetch_array($regresa_cantidad)){
			      			$cantidad=$regresa_cant[0];
			      			$id_producto=$regresa_cant[1];

			      			$obtener_old_cant=mysqli_query($conexion, "SELECT cantidad_producto FROM productos WHERE id_producto='$id_pro';");
			      			$resul_old_cant=mysqli_fetch_array($obtener_old_cant);

			      			$new_cantidad=$resul_old_cant[0]+$cantidad;

			      			mysqli_query($conexion, "UPDATE productos SET cantidad_producto=$new_cantidad WHERE id_producto='$id_pro';");
			      		}


		$resultado5=mysqli_query($conexion, "SELECT * from ventas_descripcion WHERE id_producto='$id_pro' AND id_venta='$id_venta';");
		while($datos5=mysqli_fetch_array($resultado5)){
			$cantidad=$datos5['cantidad_producto'];

			$resultado6=mysqli_query($conexion, "SELECT * from productos WHERE id_producto='$id_pro';");
			while($datos6=mysqli_fetch_array($resultado6)){
				//$cantidad_invent=$datos6['cantidad_producto'];
				$precio=$datos6['precio_producto'];
				$precio_nuevo=($cantidad*$precio);

				$nuevo_total=$_SESSION['precio_final']-$precio_nuevo;
				$_SESSION['precio_final']=$nuevo_total;

				mysqli_query($conexion, "DELETE from ventas_descripcion WHERE id_producto='$id_pro' AND id_venta='$id_venta';");
				?>
				<script>
					window.location.href = "ventas.php";
				</script>
				<?php
			}
		}	
	}
						?>
							</tbody>
						</table>
						<?php
					}
					?>
					<div class="col-sm-1">
					</div>
						
					</div><!-- CAJA DE LA TABLA DE LOS PRODUCTOS FIN-->

					</div>

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<br>
							<label><strong>PRECIO TOTAL</strong></label>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6">
							<br>
							<div id="caja_total" class="col-xs-12 col-sm-12 col-md-12">
								<label id="precio_final"><strong><?php echo "MXN "."$ ".$_SESSION['precio_final']; ?></strong></label>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="custom-control custom-checkbox my-1 mr-sm-5">
		  					  <center>
		  						<br>
							    <input type="checkbox" class="custom-control-input" id="customControlInline" required>
							    <label class="custom-control-label" for="customControlInline">Permitir acciones</label>
							    <br><br>
							    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="venta_ok">ACEPTAR VENTA</button>
							  </center>
							</div>
						</div>
</form> <!-- FORMULAIO DE LA VENTA FINAL -->
					</div>

					<!--
					<div class="col-xs-12 col-sm-1 col-md-1">
					</div>
					-->


<?php 
	if(isset($_POST['venta_ok'])){
		$resultado7=mysqli_query($conexion, "SELECT * from ventas_descripcion WHERE id_venta='$id_venta';");
		while($datos7=mysqli_fetch_array($resultado7)){
			$id_pro=$datos7['id_producto'];
			$cantidad=$datos7['cantidad_producto'];

			$resultado8=mysqli_query($conexion, "SELECT * from productos WHERE id_producto='$id_pro';");
			while($datos8=mysqli_fetch_array($resultado8)){
				//$cantidad_invent=$datos8['cantidad_producto'];
				$precio_final=$_SESSION['precio_final'];

				$resul_new_cant=$cantidad_invent-$cantidad;

				//mysqli_query($conexion, "UPDATE productos SET cantidad_producto=$resul_new_cant WHERE id_producto='$id_pro';");
				mysqli_query($conexion, "INSERT INTO bitacora VALUES ('$id_usuario', '$id_venta', $precio_final, '$fecha_oficial', 'ven');");
				mysqli_query($conexion, "UPDATE ventas_encabezado SET precio_final=$precio_final WHERE id_venta='$id_venta';");
				
				?>
				<script>
					alert("VENTA REALIZADA, CONTINUA ASÍ :D");
					window.location.href = "sesion_admin.php";
				</script>
				<?php
			}
		}
	}
		
?>			
			</div>

			</div> 
			<!-- FIN DE CAJA DE VENTAS SI SE ACTIVA-->
	
		<br>
		
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->
		
		<footer>
		</footer>


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>