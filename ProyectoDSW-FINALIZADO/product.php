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
	$descripcion = "";
	$rutaImagen = "";
	$codProducto = $_GET['cod'];

	if($usuarioRol == 'Cliente'){//Si la sesión no está iniciada
		//Cargamos los datos del producto

		$sql = "SELECT * from producto WHERE CodProducto=$codProducto";
		$resultado = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($resultado);
		//leemos los datos de la consulta.
		$nombreProducto= $row['Nombre'];
		$precio=$row['Precio'];
		$descripcion=$row['Descripcion'];
		$rutaImagen = $row['RutaImagen'];
		
		if(isset($_POST['submitPagarProducto'])){
			//GUARDAMOS LA CANTIDAD DE PRODUCTOS
			$_SESSION['cantidad'] = $_REQUEST['cantidad'];
			header("Location:./buyProduct.php?cod=".$codProducto);
		}

	}else{//Sino, Redireccionamos al Login.
		header("Location:./signin.php");
	}
?>


<!DOCTYPE html>
<html lang="es-pe">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Catalogo de Productos</title>
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
				<a class="brand" href="./index.php">San Salvador</a>
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
		<main class="productChosen">
			<div class="container">
				<h2>Datos del producto a comprar</h2>
				<form class="container--product" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']."?cod=".$row['CodProducto']) ?>" method="POST">
					<div class="productChosen__img">
						<img src="<?php echo $rutaImagen ?>" alt="" />
					</div>
					<div class="productChosen__description">
						<p class="productChosen__name"><?php echo $nombreProducto?> </p>
						<p class="productChosen__prize"><?php echo "$".$precio ?></p>
						<p>
							<?php echo $descripcion?>
						</p>
						
						<p class="">Cantidad</p>
						<div class="form__field">
							<input type="text" for="cantidad" name="cantidad" required/>
						</div>
						<p class="shipping">*Costo de envío $2.00</p>
					</div>
					<input class="btn btn--buyProduct" type="submit" name = "submitPagarProducto" value="Comprar">
				</form>
				
			</div>
		</main>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
		<script src="./js/Quantity.js"></script>
	</body>
</html>
