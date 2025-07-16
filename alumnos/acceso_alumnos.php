<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesi&oacute;n</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/funciones_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
	</head>
	<body>
		<header>
		</header>

		<main>
			<?php
				// Iniciar la sesión
				session_start();

				// Si no podemos acceder al indice del alumno correspondiente nos redirigmos al index
				if($_GET['indice'] == null){
					header('Location: ../index.php');
				}
				else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){		// Si hay una sesión ya activa de alumnos redirigimos al alumno a la página correspondiente
					header('Location: ../alumnos/alumno.php');
				}
				else{
					// Acceder a los datos de los alumnos almacenados en la variable de sesión
					// Usamos $_GET porque en este caso el indice de los alumnos no compromete
					// al sistema ni a la seguridad y privacidad del mismo
					$alumno = unserialize($_SESSION['alumno'][$_GET['indice']]);

					$tipo_password = $alumno['tipo_password'];

					$_SESSION['id_alumno'] = $alumno['id'];
					$_SESSION['nombre_alumno'] = $alumno['nombre'];
					$_SESSION['apellidos_alumno'] = $alumno['apellidos'];
					$_SESSION['ruta_foto_alumno'] = $alumno['ruta_foto'];
					$_SESSION['tipo_password'] = $alumno['tipo_password'];

					// Según el tipo de contraseña del alumno tendrá un inicio de sesión personalizado
					if(strpos($tipo_password, 'pulsadores') || strpos($tipo_password, 'pulsadores') === 0){
						header("Location: inicio_sesion_pulsadores.php");
					}else if(strpos($tipo_password, 'pictogramas') || strpos($tipo_password, 'pictogramas') === 0){
						header("Location: inicio_sesion_pictogramas.php");
					}else{
						header("Location: inicio_sesion_estandar.php");
					}
				}
			?>
		</main>

		<footer>
		</footer>
	</body>
</html>