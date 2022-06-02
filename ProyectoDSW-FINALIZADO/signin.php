<!-- IMPORTANTE -->
<!-- Lo que yo estoy haciendo es básicamente ponerte todas las cosas en su lugar
lo único que tienes que hacer es editar las palabras que van dentro de las etiquetas,
no debes cambiar las etiquetas ni las clases porque podria afectar el diseño -->
<?php
    $lista="";
	include './php/conexion.php';
	if(isset($_POST['submit'])){
		//Capturando Datos
		
		$correo =$_REQUEST['mail'];
		$contrasena = md5($_REQUEST['password']);
		//Conuslta SQL
		$sql ="SELECT * FROM usuario WHERE Correo = '$correo' AND Contrasena = '$contrasena'";
		$resultado = mysqli_query($conn, $sql);
		//Cantidad de usuarios
		$lista = mysqli_num_rows($resultado);
		//Generar un usuario
		$user = mysqli_fetch_assoc($resultado);
		
			if($lista==1){
				session_start();
				$_SESSION['mail']= $user['Correo'];
				$_SESSION['rol'] = $user['Rol'];
				$_SESSION['nombres'] = $user['Nombres'];
				
				//Liberamos variables
				mysqli_free_result($resultado);
				//Cerramos la BD
				mysqli_close($conn);
				//NOS REDIRIGIMOS AL HOME
				header("Location:./index.php");

			}
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
							<a class="menu__link " href="./index.php">Inicio</a>
						</li>
						<li class="menu__item">
							<a class="menu__link" href="./nosotros.php">Nosotros</a>
						</li>
						<li class="menu__item">
							<a class="menu__link" href="./productsList.php">Catalogo de Productos</a>
						</li>
						
						<li class="menu__item">
								<a class="btn btn--signin active" href="./signin.php">Inicia Sesion</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<main class="signin">
			<div class="container">
				<h2>Inicia Sesión</h2>
				<form class="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
					<div class="form__field">
						<label for="mail">Correo Electronico</label>
						<input type="text" name="mail" />
					</div>
					<div class="form__field">
						<label for="password">Contraseña</label>
						<input type="password" name="password" />
					</div>
					<a class="form__forgot" href="./signup.php">¿No tienes una cuenta? ¡Registrate!</a>
					<input class="btn btn--form" type="submit" name = "submit" value="Iniciar Sesión">
					<?php 
						if($lista===0){
							echo "<p>Correo o contraseña incorrectos";
							mysqli_close($conn);
						}
						
					?>
					
				</form>
				<div class="form__img"></div>
			</div>
		</main>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
	</body>
</html>
