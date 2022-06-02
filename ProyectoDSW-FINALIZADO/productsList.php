<!-- IMPORTANTE -->
<!-- Lo que yo estoy haciendo es básicamente ponerte todas las cosas en su lugar
lo único que tienes que hacer es editar las palabras que van dentro de las etiquetas,
no debes cambiar las etiquetas ni las clases porque podria afectar el diseño -->
<?php 
	session_start();
	include './php/conexion.php';
	error_reporting(0);

	//Capturando Datos de SESIÓN
	$correo = $_SESSION['mail'];
	$nombres = $_SESSION['nombres'];
	$usuarioRol = $_SESSION['rol'];
	//Comprobamos si se ha solicitdado comprar, editar o eliminar algún producto.
	if(isset($_POST['submitComprar']) or isset($_POST['submitEditar']) or isset($_POST['submitEliminar'])){
		//Comprobamos sesión
		if($nombres == null || $nombres == ''){//Si no hay sesión, entonces redirigimos al Login
			header("Location:./signin.php");
		}else{//Si hay SESIÓN, entonces redirigimos a otra página.
			//ObtenemoS el código del producto sobre el cual se seleccionó la opción (comprar, editar o eliminar)
			$codProducto = $_GET['cod'];

				if(isset($_POST['submitComprar'])){
					header("Location:./product.php?cod=$codProducto");
				}elseif(isset($_POST['submitEditar'])){
					header("Location:./editProduct.php?cod=$codProducto");
				}elseif(isset($_POST['submitEliminar'])){
					$sql = "SELECT * FROM `producto` WHERE CodProducto=$codProducto";
					$resultado = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($resultado);
					$rutaImagen = $row['RutaImagen'];
					if(file_exists ($rutaImagen)){
						echo "imagen encontrada";

						if(unlink($rutaImagen)){
							echo "la imagen sí se pudo eliminar";
							$sql = "DELETE FROM `producto` WHERE CodProducto=$codProducto";
							$resultado = mysqli_query($conn, $sql);
							header("Location:./productsList.php");
						}else{
							echo "la imagen no se pudo eliminar";
						}
					}
					
				}
		}
	}
	//Consulta SQL
		$sql = "SELECT * from `producto`";
		$resultado = mysqli_query($conn, $sql);
		$lista=mysqli_num_rows($resultado);
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
							<a class="menu__link active" href="./productsList.php">Catalogo de Productos</a>
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
		<main>
			<section class="ourProducts">
				<div class="container">
					<h2>Catalogo de Productos</h2>
					<div class="ourProducts__list">
					<?php
						for($i=0;$i<$lista;$i++) {
							$row = mysqli_fetch_array($resultado);
					?>
						<div class="ourProducts__product">
							<img
								class="ourProducts__img"
								src="<?php echo $row['RutaImagen'] ?>"
								alt=""
							/>
                            <br>
							<label for="nombreProducto"><?php echo $row['Nombre'] ?></label>
							<?php
								if($usuarioRol=='Cliente' or $usuarioRol=='' or $usuarioRol==null){
							?>
								<form class="container--buttons" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']."?cod=".$row['CodProducto']) ?>" method="POST">
									<input class="btn btn--buy" type="submit" name = "submitComprar" value="¡Compralo!">
								</form>
							<?php 
								}elseif($usuarioRol=='Admin'){
								?>
									<form class="container--buttons" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']."?cod=".$row["CodProducto"]) ?>" method="POST">
										<input class="btn btn--edit" type="submit" name = "submitEditar" value="¡Editar!">
										<input class="btn btn--delete" type="submit" name = "submitEliminar" value="¡Eliminar!">
									</form>
							<?php		
								}
							?>							
						</div>
					<?php
						}
                	?>
				</div>
			</section>

			<?php 
				if($usuarioRol =='Admin'){
			 ?>    
				<div class="container">
					<div class="container--addProducts">
						<a href="./addProduct.php"><i class="fas fa-plus-circle"></i></a>
					</div>
				</div>
			 <?php
				}
			?>

			<section class="contactUs">
				<div class="container">
					<h2>Contactanos</h2>
					<div class="socialMedia">
						<div class="socialMedia__box">
							<a href="https://www.facebook.com/lacteossansalvador"><i class="fab fa-facebook"></i></a>
						</div>
						<div class="socialMedia__box">
							<a href="#"><i class="fab fa-twitter"></i></a>
						</div>
						<div class="socialMedia__box">
							<a href="https://www.instagram.com/lacteossansalvador/?hl=es"><i class="fab fa-instagram"></i></a>
						</div>
					</div>
				</div>
			</section>
			
		</main>
		<footer class="footer">
			<p>Todos los derechos reservados</p>
		</footer>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
	</body>
</html>
