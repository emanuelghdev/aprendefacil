<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="javascript/funciones_basicas.js"></script>
		<script src="javascript/validar_formularios.js"></script>
		<script src="javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>

	<body>
		<header>
			<div id="div-header">
				<div id="barra-lateral" class="barra-lateral">
					<a href="#" class="boton-cerrar" onclick="ocultar()"><button><h3>&#10008;</h3></button></a>
					<div id="contenido">
						<div id='perfil-login-reducido'></div>
						<a id='enlace-header-reducido' href='profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>
					</div>
				</div>
					
				<div id="boton-barra-lateral">
					<a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><button><h3>&#9776;</h3></button></a>
					<a id="cerrar" class="abrir-cerrar" href="javascript:void(0)" onclick="ocultar()" style='display: none;'></button><h3>&#9776;</h3></button></a>
				</div>

				<?php
					// Iniciar la sesión
					session_start();

					// Si hay una sesión activa, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['usuario'])) {
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						// Si la sesión activa es la de el administrador añadimos una linea para ir al panel de administrador
						if(isset($_SESSION['admin'])){
							echo "<div id='perfil-login'>
							<a href='profesores/modificacion_profesores.php'>
							<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Inicio</h1></div>
							<a id='enlace-header' href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
						else{
							echo "<div id='perfil-login'>
							<a href='profesores/modificacion_profesores.php'>
							<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
							<h2>$username</h2></a></div>
							<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Inicio</h1></div>
							<a id='enlace-header' href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
						}
					}
					else if(isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true){
						// Acceder al nombre de alumno almacenado en la variable de sesión
						$username = $_SESSION['nombre'] . " " . $_SESSION['apellidos'];
						$ruta_foto = $_SESSION['ruta_foto'];

						echo "<div id='perfil-login'>
						<a href='alumnos/alumno.php'>
						<img src='multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'>
						<h2>$username</h2></a></div>
						<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Inicio</h1></div>
						<a id='enlace-header' href='php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>";
					}
					else{
						echo "<div id='perfil-login'></div>
						<div id='div-titulo'><img src='multimedia/imagenes/icono_index.png' width='60' height='60' alt='Icono página inicial'><h1 id='tituloPrincipal'>Inicio</h1></div>
						<a id='enlace-header' href='profesores/acceso_profesores.php'><button><h3>Acceso de Profesores</h3></button></a>";
					}
				?>
			</div>	
		</header>

		<main>
			<h2>Selecciona tu nombre y foto</h2>
			<section class="alumnos">
				<div class='botones-pantalla'><button class='boton-pantalla' id='prevAlumnos' aria-label="Ir a alumnos anteriores" style='display: none;'>&#129152;</button></div>

				<?php
					require_once('php/alumnos.class.php');

					$tmp = new Alumnos();
					$alumnos = $tmp->obtenerAlumnos();
					$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumno'] como una matriz vacía
					$i = 0;

					if($alumnos){
						foreach ($alumnos as $alumno) {
							$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];

							// Guardamos en una variable de sesion el alumno correspondiente
							$_SESSION['alumno'][$i] = serialize($alumno);
							
							// Creamos todos los articles de los alumnos
							echo "<a href='alumnos/acceso_alumnos.php?indice=$i'>
								<article class='alumno'>
									<img src='multimedia/imagenes/" . $alumno['ruta_foto'] . "' width='70' height='70' alt='Foto de perfil del alumno'>
									<h3>{$alumnosNombre[$i]}</h3>
								</article></a>";

							$i++;
						}
					}	
					else{
						echo "<article class='alumno'><h2>No hay ning&uacute;n alumno registrado</h2></article>";
					}

					echo "<div class='botones-pantalla'><button class='boton-pantalla' id='posAlumnos' aria-label='Mostrar más alumnos'>&#129154;</button></div>";
				?>
			</section>

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var alumnos = document.querySelectorAll(".alumno");
					var posButton = document.getElementById("posAlumnos");
					var prevButton = document.getElementById("prevAlumnos");

					function calcularAlumnosPorPantalla() {
						var anchoVentana = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
						var altoVentana = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
						
						// Ajustamos estos valores según la altura y el ancho de los alumnos
						var anchoAlumno = 150;
						var altoAlumno = 350;

						var alumnosPorFila = Math.floor(anchoVentana / anchoAlumno);

						if(altoVentana < 700){
							var filasVisibles = Math.floor(altoVentana / altoAlumno);
						}
						else if(altoVentana < 1050){
							altoAlumno = 300;
							var filasVisibles = Math.floor(altoVentana / altoAlumno);
						}
						else if(altoVentana < 1350){
							altoAlumno = 275;
							var filasVisibles = Math.floor(altoVentana / altoAlumno);
						}
						else{
							altoAlumno = 250;
							var filasVisibles = Math.floor(altoVentana / altoAlumno);
						}

						var alumnosPorPantalla = alumnosPorFila;

						alumnosPorFila = Math.ceil(alumnosPorFila / 2);

						if(filasVisibles < 1){
							return alumnosPorPantalla;
						}
						else{
							return  alumnosPorFila * (filasVisibles);
						}
					}

					// Inicializamos el estado de la pantalla
					var pantallaActual = 0;
					actualizarPantalla();

					// Escuchamos el evento del botón para avanzar de pantalla
					posButton.addEventListener("click", function () {
						pantallaActual++;
						actualizarPantalla();
					});

					// Escuchamos el evento del botón para retroceder de pantalla
					prevButton.addEventListener("click", function () {
						pantallaActual--;
						actualizarPantalla();
					});

					function actualizarPantalla() {
						var alumnosPorPantalla = calcularAlumnosPorPantalla();
						var startIndex = pantallaActual * alumnosPorPantalla;
						var endIndex = startIndex + alumnosPorPantalla;

						// Mostramos u ocultamos los alumnos según la pantalla actual
						alumnos.forEach(function (alumno, index) {
							alumno.parentNode.style.display = index >= startIndex && index < endIndex ? "block" : "none";
						});

						// Mostramos u ocultamos los botones dependiendo de si hay más pantallas
						posButton.style.display = endIndex < alumnos.length ? "block" : "none";
						prevButton.style.display = pantallaActual > 0 ? "block" : "none";
					}

					// Actualizamos el número de alumnos por pantalla al cambiar el tamaño de la ventana
					window.addEventListener("resize", function () {
						actualizarPantalla();
					});
				});
			</script>
		</main>

		<footer>
    	</footer>
	</body>
</html>