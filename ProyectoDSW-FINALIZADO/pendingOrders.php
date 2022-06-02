<!-- IMPORTANTE -->
<!-- Lo que yo estoy haciendo es básicamente ponerte todas las cosas en su lugar
lo único que tienes que hacer es editar las palabras que van dentro de las etiquetas,
no debes cambiar las etiquetas ni las clases porque podria afectar el diseño -->
<?php 
	session_start();
	include './php/conexion.php';
	//error_reporting(0);

	//Capturando Datos de SESIÓN
	$correo = $_SESSION['mail'];
	$nombres = $_SESSION['nombres'];
	$usuarioRol = $_SESSION['rol'];
	$update=0;
	if(isset($_POST['submitActualizarEstado'])){
		if($nombres == null || $nombres == ''){
			header("Location:./signin.php");
		}else{
			$estado=$_REQUEST['Estado'];
			$codPedido = $_GET['codPedido'];
			$sql = "UPDATE `pedido` SET `Estado`='$estado'  WHERE `CodPedido`='$codPedido'";
			mysqli_query($conn, $sql);
			$update=1;
		}
	}


		if($nombres == null || $nombres == ''){
			header("Location:./signin.php");
		}else{
			$sql = "SELECT * FROM `pedido`";
			$resultado = mysqli_query($conn, $sql);
			$lista=mysqli_num_rows($resultado);
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
							<a class="menu__link" href="./productsList.php"
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
							<a class="menu__link active" href="./pendingOrders.php">Pedidos Pendientes</a>
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
		<main class="tabla">
			<div class="container">
				<h2>Pedidos Pendientes</h2>
				<div class="container--table">
					<?php 
						if($update==1){
							echo "<p>Estado de Pedido actualizado</p>";
						}
					?>
					<table class="table">
						<tr>
							<th>Cliente</th>
							<th>NumContacto</th>
							<th>Direccion</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Total</th>
							<th>Fecha y Hora</th>
							<th colspan="2">Estado</th>
						</tr>
					<?php 
						for($i=0; $i<$lista; $i++){
							$row = mysqli_fetch_array($resultado);
					?>
						<tr class="fila">
							<td><?php echo $row['NombreCliente'] ;?></td>
							<td><?php echo $row['NumContacto'] ;?></td>
							<td><?php echo $row['Direccion'] ;?></td>
							<td><?php echo $row['NombreProducto'] ;?></td>
							<td><?php echo $row['Cantidad'] ;?></td>
							<td>$<?php echo $row['Total'] ;?></td>
							<td><?php echo $row['FechaPedido'] ;?></td>
							<td>
								<form class="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']."?codPedido=".$row['CodPedido']) ?>" method="POST">
									<select name="Estado" required>
										<option selected><?php echo $row['Estado'] ;?></option>
										<option value="Por Atender">Por atender</option>
										<option value="En envio">En envio</option>
										<option value="Entregado">Entregado</option>
									</select>
									</td>
									<td><input class="btn btn--modificar" type="submit" name="submitActualizarEstado" value="Actualizar"></td>
								</form>
						</tr>
					<?php 
						}
					?>
					</table>
				</div>
			</div>
		</main>
		<footer class="footer">
			<p>Todos los derechos reservados</p>
		</footer>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
		<script src="./js/PendingOrders.js"></script>
	</body>
</html>
