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
		<title>C.A. G.E.M.A.</title>
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
						<h3>CONSULTA AVANZADA</h3>
						<h6><?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
						<br>
					<center>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-2">
						<center>
						<br>
						<img src="imagenes_GEMA/lup2.png" width="80" heigth="90">
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

<!-- CAJA DEL BUSCADOR **********************************************************************************************************-->

		<div class="row">

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>

			<div class="col-xs-12 col-sm-10 col-md-10">
			<br>
				<nav class="navbar navbar-light bg-light">
					  <form class="form-inline" method="POST">
					  <center>
					    <input class="form-control mr-sm-1" type="search" placeholder="Buscar producto..." aria-label="Search" name="valor" autocomplete="off">

					    <select id="select" name="tipo">
					    	
					    	<option>TODOS</option>
					    	<?php
					      	$resultado1=mysqli_query($conexion, "SELECT * from diccionario_de_productos;");
					    	while($datos1=mysqli_fetch_array($resultado1)){
					    	//$codigo=$datos['codigo']; 
					      	?>
		  						<option name="<?php echo $datos['caracteristica']; ?>"> <?php echo $datos1['caracteristica']; ?> </option>
		  					<?php
		  					 }
		  					?>
						</select>

						<select id="select" name="por">
					    	<option value="id_producto">SIN ORDEN</option>
					    	<option value="precio_producto">POR PRECIO</option>
					    	<option value="cantidad_producto">POR CANTIDAD</option>
					    	<option value="nombre_producto">POR NOMBRE</option>
						</select>

					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="buscador">Buscar</button>
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="ver_todo">Ver todo</button>
					  </center>
					  </form>
				</nav>

				<br>
			</div>

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>
		</div>

<!-- FIN DE LA CAJA DEL BUSCADOR ************************************************************************************************-->
		

		<div class="row">

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>

			<div class="col-xs-12 col-sm-10 col-md-10">
			<br>

<!-- SI SE ACTIVA EL BUSCADOR ********************************************************************************** -->

	<?php if(isset($_POST['buscador'])){
		$buscador=$_POST['valor'];
		$opcion=$_POST['tipo'];
		$order_by=$_POST['por'];
		$id_obten=1;

		$obten_tipo=mysqli_query($conexion, "SELECT * from diccionario_de_productos where caracteristica='$opcion';");
		while($dato_id=mysqli_fetch_array($obten_tipo)){
			$id_obten=$dato_id['id_tipoproducto'];
		}
		
		if($id_obten===1){
			?>
			<table class="table table-striped">
				  <thead>
				  	<tr>
						<th colspan="5"><h6 class="wordinicio"><center><strong>PRODUCTOS ENCONTRADOS</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				      <th scope="col">Descripción</th>
				      <th scope="col">Tipo</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
				  $resultado=mysqli_query($conexion, "SELECT * from productos where id_producto='$buscador' OR nombre_producto='$buscador' OR id_producto LIKE'$buscador%' OR nombre_producto LIKE '$buscador%' ORDER BY $order_by ASC;");

			      while($datos=mysqli_fetch_array($resultado)){
			    	 
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
				      <td><?php echo "<h6 id='wordinicio'>".$datos['descripcion_producto']."</h6>";?></td>
				      <?php
				      $valor_id=$datos['id_tipoproducto'];

				      $resultado_ca=mysqli_query($conexion, "SELECT * from diccionario_de_productos where id_tipoproducto='$valor_id'");
				      		while($datos_ca=mysqli_fetch_array($resultado_ca)){
				      ?>
				      <td><?php echo "<h6 id='wordinicio'>".$datos_ca['caracteristica']."</h6>";?></td>
				      <?php
				  		}
				      ?>
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
				<table class="table table-striped">
				  <thead>
				  	<tr>
						<th colspan="5"><h6 class="wordinicio"><center><strong>PRODUCTOS ENCONTRADOS</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				      <th scope="col">Descripción</th>
				      <th scope="col">Tipo</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
	  	  

			  	  $resultado=mysqli_query($conexion, "SELECT * from productos where (id_tipoproducto='$id_obten' AND id_producto='$buscador') OR (id_tipoproducto='$id_obten' AND nombre_producto='$buscador') OR (id_tipoproducto='$id_obten' AND id_producto LIKE'$buscador%') OR (id_tipoproducto='$id_obten' AND nombre_producto LIKE '$buscador%') ORDER BY $order_by ASC;");

			      while($datos=mysqli_fetch_array($resultado)){
			    	 
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
				      <td><?php echo "<h6 id='wordinicio'>".$datos['descripcion_producto']."</h6>";?></td>
				      <?php
				      
				      $resultado_ca=mysqli_query($conexion, "SELECT * from diccionario_de_productos where id_tipoproducto='$id_obten'");
				      		while($datos_ca=mysqli_fetch_array($resultado_ca)){
				      ?>
				      <td><?php echo "<h6 id='wordinicio'>".$datos_ca['caracteristica']."</h6>";?></td>
				      <?php
				  		}
				      ?>
				    </tr>
				   <?php
				   }
				   ?>
				  </tbody>
				</table>
	<?php 
			} //Finaliza el ELSE DE TODOS
		}
		else{
	?>

<!-- SI NO SE ACTIVA EL BUSCADOR ********************************************************************************** -->

				<table class="table table-striped">
				  <thead>
				  	<tr>
						<th colspan="5"><h6 class="wordinicio"><center><strong>PRODUCTOS DISPONIBLES</strong></center><h6></td>
					</tr> 
				    <tr>
				      <th scope="col">ID</th>
				      <th scope="col">Nombre</th>
				      <th scope="col">Precio (MXN)</th>
				      <th scope="col">Cantidad</th>
				      <th scope="col">Descripción</th>
				      <th scope="col">Tipo</th>
				    </tr>
				  </thead>
				  <tbody>
				  <?php
			      $resultado2=mysqli_query($conexion, "SELECT * from productos;");
			      while($datos2=mysqli_fetch_array($resultado2)){
			    	//$codigo=$datos['codigo']; 
			      ?>
				    <tr>
				      <th scope="row"><?php echo "<h6 id='wordinicio'>".$datos2['id_producto']."</h6>";?></th>
				      <td><?php echo "<h6 id='wordinicio'>".$datos2['nombre_producto']."</h6>";?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos2['precio_producto']."</h6>";?></td>
				      <td><?php
				      if($datos2['cantidad_producto']>0){
				      	echo "<h6 id='wordinicio'>".$datos2['cantidad_producto']."</h6>";
				      }
				      else{
				      	echo "<h6 id='wordalert'>".$datos2['cantidad_producto']."</h6>";
				      }
				      ?></td>
				      <td><?php echo "<h6 id='wordinicio'>".$datos2['descripcion_producto']."</h6>";?></td>
				      <?php
				      $valor_id=$datos2['id_tipoproducto'];

				      $resultado_ca2=mysqli_query($conexion, "SELECT * from diccionario_de_productos WHERE id_tipoproducto='$valor_id'");
				      		while($datos_ca2=mysqli_fetch_array($resultado_ca2)){
				      ?>
				      <td><?php echo "<h6 id='wordinicio'>".$datos_ca2['caracteristica']."</h6>";?></td>
				      <?php
				  		}
				      ?>
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

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>
		</div>
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>