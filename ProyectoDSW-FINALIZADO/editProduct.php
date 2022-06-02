<!-- IMPORTANTE -->
<!-- Lo que yo estoy haciendo es básicamente ponerte todas las cosas en su lugar
lo único que tienes que hacer es editar las palabras que van dentro de las etiquetas,
no debes cambiar las etiquetas ni las clases porque podria afectar el diseño -->
<?php 
	//Comprobar la sesión
	session_start();
	include './php/conexion.php';
	//error_reporting(0);
	//Capturando Datos de SESIÓN
	$correo = $_SESSION['mail'];
	$nombres = $_SESSION['nombres'];
	$usuarioRol = $_SESSION['rol'];
//declaramos las variables em un GLOBAL SCOPE
	$nombreProducto = "";
	$precio = "";
	$delivery = "";
	$descripcion = "";
	
	$update=0;
	$codProducto="";
	$row="";
	if($usuarioRol =='Admin'){
		if(isset($_POST['submitEditarProducto'])){
			//Actualizamos los datos del producto
			$codProducto = $_GET['cod'];
			$nombreProducto = $_REQUEST['nombreProducto'];
			$precio = $_REQUEST['precio'];
			$descripcion = $_REQUEST['descripcion'];
			
			$sql = "UPDATE `producto` SET `Nombre`='$nombreProducto',`Descripcion`='$descripcion',`Precio`='$precio' 
					WHERE `CodProducto`='$codProducto'";
			mysqli_query($conn, $sql);
			$update=1;
			//Podríamos agregar una ventana de confirmación.
		}else{
			//Mostramos los datos del producto a editar.
			$codProducto = $_GET['cod'];
			$sql = "SELECT * from producto WHERE CodProducto=$codProducto";
			$resultado = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($resultado);
		//leemos los datos de la consulta.
			$nombreProducto= $row['Nombre'];
			$precio=$row['Precio'];
			$delivery=$row['Delivery'];
			$descripcion=$row['Descripcion'];
		}
	}else{
		header("Location:./signin.php");
		die();
	}
	
?>


<!DOCTYPE html>
<html lang="es-pe">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Inicio</title>
		<!-- Preload -->
		<link rel="preload" href="./css/normalize.css" as="style" />
		<link rel="stylesheet" href="./css/normalize.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&family=Teko:wght@700&display=swap"
			rel="stylesheet"
		/>
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
			integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer"
		/>
		<link rel="preload" href="./css/style.css" as="style" />
		<link rel="stylesheet" href="./css/style.css" />
	</head>
	<body>
		<header class="header">
			<div class="container container--header">
				<a class="brand" href="./index.html">San Salvador</a>
				<span class="menuBtn"><i class="fas fa-bars"></i></span>
				<nav class="navigation">
					<ul class="menu">
						<li class="menu__item">
							<a class="menu__link" href="./index.php">Inicio</a>
						</li>
						<li class="menu__item">
							<a class="menu__link" href="./nosotros.php">Nosotros</a>
						</li>
						<li class="menu__item">
							<a class="menu__link active" href="./productsList.php"
								>Catalogo de Productos</a
							>
						</li>
						<!-- Aquí lo tienes que cambiar con el php nada más
                        puedes hacer que sea "mis pedidos" en caso de ser un cliente
                        o tal vez "pedidos pendientes", lo activas cuando inicia sesion alguno
                        de estos usuarios -->
						<!-- Te dejo ambos li para que ya solo lo metas dentro del php y actives
                        el que corresponda segun el tipo de usuario -->
						<!-- Si ninguno está logeado, estos 2 li siguientes no deben aparecer
                        eso es facil de hacer ya con el php -->
						<!-- Para el caso de "catalogo de productos" o "mis productos"
                        se puede utilizar el mismo frame de "catalogo de productos" solo
                        que cambiarian algunas cosas dependiendo del tipo de usuario -->
						<!-- En el caso de que se tenga que logear, estos 2 li no aparecen obligatoriamente -->
						<?php
							if($usuarioRol == 'Cliente' || $usuarioRol == 'Admin'){
								if($usuarioRol=="Cliente"){
						?>
						
						<li class="menu__item">
							<a class="menu__link" href="./myOrders.php">Mis Pedidos</a>
						</li>

						<?php
								}
								if($usuarioRol=="Admin"){
						?>

						<li class="menu__item">
							<a class="menu__link" href="./pendingOrders.php">Pedidos Pendientes</a>
						</li>
						<?php
								}
							}
						?>
						<!-- Aquí, una vez logeado el usuario, puedes cambiar esta parte,
                        y en lugar de que diga "inicia sesion" puedes poner "mi perfil"
                        pero eso cambia con el php así que te inspiras que poner -->
						<?php
                			if($nombres == null || $nombres == ''){
            			?>
                			<li class="menu__item">
								<a class="btn btn--signin" href="./signin.php">Inicia Sesion</a>
							</li>
            			<?php
                			} else {
            			?>
							<li class="menu__item">
               					<a>Bienvenido, <?php echo $nombres; ?></span></a>
							</li>
							<li class="menu__item">
               					<a class="btn btn--signin" href="./php/logout.php">Cerrar Sesión</a>
							</li>
            			<?php
                			}
            			?>
					</ul>
				</nav>
			</div>
		</header>
		<main class="editProduct">
			<div class="container">
				<h2>Editar Producto</h2>
				
				<form class="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']."?cod=".$codProducto) ?>" method="POST" >
					<div class="form__field">
						<label for="nombreProducto">Nombre del Producto</label>
						<input type="text" name="nombreProducto" value="<?php echo $nombreProducto?>" title="No olvide la mayúscula inicial y no ingresar números o caracteres especiales." pattern="[A-Z][a-z]+( +[A-Z]{0,1}[a-z]*)*" required/>
					</div>
					<div class="form__field">
						<label for="precio">Precio</label>
						<input type="text" name="precio" value="<?php echo $precio ?>" tittle="Solo se aceptan números." pattern="[0-9]+([\.][0-9]+){0,1}" required />
					</div>
					<div class="form__field">
						<label for="descripcion">Descripción</label>
						<input type="text" name="descripcion" value="<?php echo $descripcion ?>" required/>
					</div>
					<input class="btn btn--form" type="submit" name = "submitEditarProducto" value="Editar Producto">
					<?php 
						if($update==1){
							echo "<p>Cambios guardados correctamente</p>";
						}
					?>
				</form>			


				<div class="form__img"></div>
			</div>
		</main>
		<footer class="footer">
			<p>Todos los derechos reservados</p>
		</footer>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
	</body>
</html>
