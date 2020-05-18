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
		<title>AGREGAR G.E.M.A. </title>
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
						<h3>AGREGAR PRODUCTO</h3>
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
			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>

			<div class="col-xs-12 col-sm-10 col-md-10">	
				<form method="POST">
				  <br>
				  	<div class="form-group">
						 <label>ID del Producto</label>
						 <input type="text" class="form-control" required placeholder="Ejemplo: asDE12" name="id" autocomplete="off">
						 <small class="form-text text-muted">Acepta cualquier tipo de caracter, evita escribir con acentos y la Ñ.</small>
					</div>

					<div class="form-group">
						 <label>Nombre del Producto</label>
						 <input type="text" class="form-control" required placeholder="Ejemplo: Lapiz" name="nombre" autocomplete="off">
						 <small class="form-text text-muted">Evita escribir con acentos y la Ñ.</small>
					</div>
					
					<div class="form-group">
						 <label>Precio del Producto</label>
						 <input type="number" class="form-control" required placeholder="Ejemplo: 5.55" name="precio" step="any" min="1" max="10000" >
						 <small class="form-text text-muted">Solamente números, si es necesario con decimal.</small>
					</div>

					<div class="form-group">
						 <label>Cantidad del Producto</label>
						 <input type="number" class="form-control" required placeholder="Ejemplo: 5" name="cantidad" min="1" max="1000000">
						 <small class="form-text text-muted">Solamente números enteros.</small>
					</div>

					<div class="form-group">
					     <label>Descripción del producto</label>
					     <textarea class="form-control" rows="1" required placeholder="Descripción..." name="descripcion" autocomplete="off"></textarea>
					     <small class="form-text text-muted">Evita escribir con acentos y la Ñ.</small>
					</div>

						<label>Elige el tipo de producto</label>
					<div class="form-check">
					<?php
			      	$resultado=mysqli_query($conexion, "SELECT * from diccionario_de_productos");
			    	while($datos=mysqli_fetch_array($resultado)){
			    	//$codigo=$datos['codigo']; 
			      	?>
  						<input class="form-check-input" type="radio" name="tipo" value="<?php echo $datos['id_tipoproducto']; ?>" checked>
  						<label class="form-check-label" for="exampleRadios1">
    						<?php echo $datos['id_tipoproducto']." = ".$datos['caracteristica']; ?> 
  						</label>
  						<br>
  					<?php
  					 }
  					?>
  					</div>
  					
  					<!-- VERIFICA QUE TODOS LOS DATOS SEAN CORRECTOS SEGUN EL USUARIO -->
  					<div class="custom-control custom-checkbox my-1 mr-sm-2">
  					  <center>	
  						<br>
					    <input type="checkbox" class="custom-control-input" id="customControlInline" required>
					    <label class="custom-control-label" for="customControlInline">TODOS LOS DATOS SON CORRECTOS</label>
					    <br><br>
					    <button class="btn btn-outline-success my-2 my-sm-1" type="submit" name="ok">Agregar</button>
					  </center>
					</div>
				</form>
				
				<?php
				if(isset($_POST['ok'])){
					$new_id=normaliza($_POST['id']);
					$new_nombre=normaliza($_POST['nombre']);
					$new_precio=$_POST['precio'];
					$new_cantidad=$_POST['cantidad'];
					$new_descripcion=normaliza($_POST['descripcion']);
					$new_tipopro=$_POST['tipo'];
					
					$resultado=mysqli_query($conexion, "SELECT * from productos where id_producto='$new_id'");

						if($contenido=mysqli_fetch_array($resultado)){
							?>
								<script>
									alert("EL PRODUCTO YA HA SIDO REGISTRADO ANTERIORMENTE");
								</script>
							<?php
						}
						else{					
							$agregar=("INSERT INTO productos VALUES ('$new_nombre', $new_precio, $new_cantidad, '$new_descripcion', '$new_id', '$new_tipopro');");
																							
							mysqli_query($conexion, $agregar);
							?>
								<script>
									alert("REGISTRO DE PRODUCTO EXITOSO");
								</script>
							<?php  	
						}
				}
				?>
							
			</div>

			<div class="col-xs-12 col-sm-1 col-md-1">
			</div>
		</div>	
		<br>
		
		
		<!-- PIE DE LA PÁGINA ********************************************************************************** -->
		
		<footer>
		</footer>


		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>