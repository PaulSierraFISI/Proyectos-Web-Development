<!-- IMPORTANTE -->
<!-- Lo que yo estoy haciendo es básicamente ponerte todas las cosas en su lugar
lo único que tienes que hacer es editar las palabras que van dentro de las etiquetas,
no debes cambiar las etiquetas ni las clases porque podria afectar el diseño -->
<?php
	$fechaActual = date("Y-m-d H:i:s");
	$fechaActual = strtotime ( '-5 hour' , strtotime ($fechaActual) ) ; 
	$fechaActual = date ( 'Y-m-d' , $fechaActual);
	$lista="";
	$valido=true;
	$mensaje="";//Lo declaramos de forma flobal para que se pueda utilizar en cualquier part del código PHP
	if(isset($_POST['submit'])){
		include './php/conexion.php';
    //Capturando Datos
			$correo = $_REQUEST['mail'];
			$contrasena = md5($_REQUEST['password']);
			$verificar = md5($_REQUEST['v_password']);
			$nombres = $_REQUEST['nombres'];
			$apellidos = $_REQUEST['apellidos'];
			$telefono = $_REQUEST['telefono'];
			$fechaNacimiento = $_REQUEST['fechaNacimiento'];
			$direccion = $_REQUEST['direccion'];
			//Consulta SQL
		
		
		if($contrasena != $verificar){
			$valido=false;
			$mensaje= "Las contraseñas son distintas";
		}else{
			$sql = "SELECT * from usuario WHERE Correo='$correo'";
			$resultado = mysqli_query($conn, $sql);
			$lista = mysqli_num_rows($resultado);
			if($lista==0){
				//REGISTRO EXITOSO (GUARDAMOS EN LA BD)
				session_start();
				$sql = "INSERT INTO usuario (`Correo`, `Contrasena`, `Rol`, `Nombres`, `Apellidos`, `Telefono`, `FechaNacimiento`,`Direccion`) 
				VALUES ('$correo','$contrasena','Cliente','$nombres','$apellidos','$telefono','$fechaNacimiento','$direccion')";
				mysqli_query($conn, $sql);
				//Iniciamos sesión
				$_SESSION['mail']= $correo;
				$_SESSION['nombres']=$nombres;
				$_SESSION['rol']='Cliente'; 
				//Nos redirigimos al Home con la sesión del usuario iniciada.
				header("Location:./index.php");
			}
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

						<!-- Aquí, una vez logeado el usuario, puedes cambiar esta parte,
                        y en lugar de que diga "inicia sesion" puedes poner "mi perfil"
                        pero eso cambia con el php así que te inspiras que poner -->
						<li class="menu__item">
								<a class="btn btn--signin" href="./signin.php">Inicia Sesion</a>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<main class="signup">
			<div class="container">
				<h2>Únete a Nosotros</h2>
				<p>Llena los datos correctamente para crear tu cuenta</p>
				<form class="form" action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
					<div class="container--signup">
						<div class="form__field">
							<label for="mail">Correo Electronico</label>
							<input type="text" name="mail" title="Ejemplo: example@example.example" pattern ="([A-Za-z])([A-Za-z0-9]*)(.[A-Za-z0-9]+)*(@[a-z]+)([.][a-z]+)+" required/>
						</div>
						<div class="form__field">
							<label for="password">Contrasena</label>
							<input type="password" name="password" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$"  title="Al menos una letrá mayúscula, una minúscula, un número y un caracter especial(!@#$&*)." required/>
						</div>
						<div class="form__field">
							<label for="v_password">Verificar Contrasena</label>
							<input type="password" name="v_password" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$"  title="Al menos una letrá mayúscula, una minúscula, un número y un caracter especial(!@#$&*)." required/>
						</div>
						<div class="form__field">
							<label for="nombres">Nombres</label>
							<input type="text" name="nombres" title="No olvide la mayúscula inicial y no ingresar números o caracteres especiales." pattern="[A-Z][a-z]+( +[A-Z]{0,1}[a-z]*)*" required/>
						</div>
						<div class="form__field">
							<label for="apellidos">Apellidos</label>
							<input type="text" name="apellidos" title="No olvide la mayúscula inicial y no ingresar números o caracteres especiales." pattern="[A-Z][a-z]+( +[A-Z]{0,1}[a-z]*)*" required/>
						</div>
						<div class="form__field">
							<label for="telefono">Telefono</label>
							<input type="tel" name="telefono" title="Solo se aceptan números y el código postal." required/>
						</div>
						<div class="form__field">
							<label for="direccion">Dirección</label>
							<input type="tel" name="direccion" required/>
						</div>
						<div class="form__field">
							<label for="fechaNacimiento">Fecha de Nacimiento</label>
							<input type="date" name="fechaNacimiento" min="1900-01-01" max="<?php echo $fechaActual?>"  name="fechaNacimiento" required />
						</div>
					</div>
					<?php 
						if($valido){
							if($lista ==1){
								//YA EXISTE UN USUARIO REGISTRADO CON EL MISMO CORREO
								//MOSTRAMOS MENSAJE SIN TRASLADARNOS DE PÁGINA.
								echo "<p>Ya existe un usuario registrado con ese correo</p>";							
							}
						}else{
							echo "<p>".$mensaje."</p>";
						}
						
					?>
					<input class="btn btn--form" type="submit" name = "submit" value="Registrarme">

					
				</form>
				<div class="form__img"></div>
			</div>
		</main>
		<script src="./js/Menu.js"></script>
		<script src="./js/ButtonHref.js"></script>
	</body>
</html>
