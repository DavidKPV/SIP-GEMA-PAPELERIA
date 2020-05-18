<?php
session_start();

if($_SESSION['autentico']!="yes"){	
	header("Location: login.php");
	exit();
}
else{
	if($_SESSION['tipousuario']=='vendedor'){
	   header("Location: sesion_vendedor.php");
	}
	$nombre_usuario=$_SESSION['nombre_usuario'];
	//Conexion a la base de datos...
	require("conexion_bd.php");
	require("valida_cadena.php");

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
		<title>ELIMINAR G.E.M.A.</title>
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
						<h3>ELIMINAR PRODUCTO</h3>
						<h6><?php echo "<strong>".$nombre_usuario."</strong>"; ?></h6>
						<br>
					<center>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-2">
						<center>
						<br>
						<img src="imagenes_GEMA/administrador.png" width="80" heigth="90">
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


		<div class="main row">

		<div class="col-xs-12 col-sm-12 col-md-6">
			<div class="row">

				<div class="col-xs-1 col-sm-1 col-md-1">
				</div>
<!--******************************** BARRA DERECHA ***************************************************************-->
			<div class="col-xs-11 col-sm-10 col-md-11">

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
			      $resultado=mysqli_query($conexion, "SELECT * from productos where id_producto='$buscador' OR nombre_producto='$buscador' OR id_producto LIKE'$buscador%' OR nombre_producto LIKE '$buscador%';");
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
			      $resultado=mysqli_query($conexion, "SELECT * from productos LIMIT 15;");
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
<!--**************************************************************************************************************-->
			<div class="col-xs-12 col-sm-1 col-md-12">
			</div>

			</div>
		</div>	

		<div class="col-xs-12 col-sm-12 col-md-6">
			<div class="row">

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>
			
			<div class="col-xs-12 col-sm-10 col-md-10">
				<form method="POST">
				  <br>
				  	<div class="form-group">
						 <label>ID o Nombre del Producto</label>
						 <input type="text" class="form-control" required placeholder="Ejemplo: ID = asDE12  O  Nombre = Lapiz" name="id" autocomplete="off">
						 <small class="form-text text-muted">Acepta cualquier tipo de caracter, evita escribir con acentos y la Ñ.</small>
						 <center>
						 <br>
						 <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="buscar">Buscar</button>
						 </center>
					</div>
				</form>

			<?php

				if(isset($_POST['buscar'])){
					$new_id=normaliza($_POST['id']);

					$resultado=mysqli_query($conexion, "SELECT * from productos where id_producto='$new_id' OR nombre_producto='$new_id'");

						if($contenido=mysqli_fetch_array($resultado)){
							$_SESSION['id_g']=$contenido['id_producto'];
							$tipo_pro=$contenido['id_tipoproducto'];

							$obtener_carac=mysqli_query($conexion, "SELECT * FROM diccionario_de_productos where id_tipoproducto='$tipo_pro'");
							if($contenido2=mysqli_fetch_array($obtener_carac)){
					
					?>
							
				 <form method="POST">
				 	<div class="form-group">
						 <label>Código del Producto</label>
						 <textarea type="text" class="form-control" rows="1" disabled><?php echo $contenido['id_producto']; ?> </textarea>
					</div>

					<div class="form-group">
						 <label>Nombre del Producto</label>
						 <textarea type="text" class="form-control" rows="1" disabled><?php echo $contenido['nombre_producto']; ?> </textarea>
					</div>
					
					<div class="form-group">
						 <label>Precio del Producto</label>
						 <input type="text" class="form-control" disabled value=<?php echo $contenido['precio_producto']; ?> >
					</div>

					<div class="form-group">
						 <label>Cantidad del Producto</label>
						 <input type="text" class="form-control" disabled value=<?php echo $contenido['cantidad_producto']; ?> >
					</div>

					<div class="form-group">
					     <label>Descripción del producto</label>
					     <textarea class="form-control" rows="1" disabled><?php echo $contenido['descripcion_producto']; ?> </textarea>
					</div>

					<div class="form-group">
					     <label>Tipo de producto</label>
					     <textarea type="text" class="form-control" disabled rows="1"> <?php echo $contenido2['caracteristica']; ?> </textarea>
					</div>
  					
  					<!-- VERIFICA QUE TODOS LOS DATOS SEAN CORRECTOS SEGUN EL USUARIO -->
  					<div class="custom-control custom-checkbox my-1 mr-sm-2">
  					  <center>
  						<br>
					    <input type="checkbox" class="custom-control-input" id="customControlInline" required>
					    <label class="custom-control-label" for="customControlInline">ES CORRECTO EL PRODUCTO ELEGIDO</label>
					    <br><br>
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="eliminar">Eliminar</button>
					  </center>
					</div>
				</form>

				<?php
							}
						}
						else{					
							?>
								<script>
									alert("EL PRODUCTO INGRESADO NO EXISTE, VUELVE A INTENTARLO");
								</script>
							<?php
						}

				}

				if(isset($_POST['eliminar'])){
					$id_def=$_SESSION['id_g'];


					$obtener_ven=mysqli_query($conexion, "SELECT * FROM ventas_descripcion where id_producto='$id_def'");
					if($contenido_ven=mysqli_fetch_array($obtener_ven)){
						?>
							<script>
								alert("NO SE PUEDE ELIMINAR PRODUCTO, TE RECOMENDAMOS EDITARLO CON NUEVOS DATOS O COMUNICATE CON NUESTRO SOPORTE TÉCNICO");
							</script>
						<?php
					}
					else{																	
						mysqli_query($conexion, "DELETE FROM productos WHERE id_producto='$id_def';");

						$_SESSION['id_g']="";
						?>
							<script>
								alert("PRODUCTO ELIMINADO EXITOSAMENTE");
							</script>
						<?php
					}  
				}
				
			?>
			</div>

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>

				</div>  <!-- ROW -->
			</div>   <!-- SEGUNDA CLASE -->				
		</div>   <!-- MAIN ROW -->
			
		
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->
		
		<footer>
		</footer>


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>