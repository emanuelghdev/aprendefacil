<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Inicio</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/alumno.css">
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

					// Si hay una sesión activa de usuario, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['sesion_alumno']) && $_SESSION['sesion_alumno'] == true) {		
						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['nombre'];
						$ruta_foto = $_SESSION['ruta_foto'];
						$idAlumno = $_SESSION['id_alumno'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../alumnos/alumno.php'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div><h2>$username</h2></div>
							</a>
						</div>";
					}
					else{		// Si no hay ninguna sesión de usuario activa
						header("Location: ../index.php");
					}

					$seccion_actual = isset($_GET['section']) ? $_GET['section'] : 'imagenes';
				?>
				
				<div id='div-titulo'><img src='../multimedia/imagenes/icono_comandas1.png' width='60' height='60' alt='Icono página del alumno'>
				<h1 id='tituloPrincipal'>Comandas</h1></div>
				<a id='enlace-header' href='../php/logout.php' style="visibility: hidden;"><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
			
		</header>

		<main>

			<a href='../alumnos/alumno.php' class='boton-pantalla' id='casa' >
				<button>
					<img src='../multimedia/imagenes/icono_casa.png' width="50px" height="50px" alt='Casa'>
				</button>
			</a>
			
			<section class="tareas">
				
				<div class='botones-pantalla'><button class='boton-pantalla' id='prevTareas' aria-label="Ir a tareas anteriores" style='visibility: hidden;'>&#129152;</button></div>
				

				<?php
					require_once('../php/profesores.class.php');
					

					$tmp = new Profesores();
					$aulas = $tmp->obtenerAulas();

					if($aulas){
						foreach ($aulas as $aula) {
								$profesor = $tmp->obtenerProfesorAula($aula);
							
								$nombre = $profesor['nombre'];
								$aula = $profesor['aula'];
                                $ruta_foto = $profesor['ruta_foto'];
					
								// Mostrar la información de la profesor
								echo "<a href='ver_menus.php?aula=$aula' class='tarea'>";
								echo "<img id='imagen-profesor-comanda' src='../multimedia/imagenes/$ruta_foto' alt='Foto del profesor'>";
								echo "<h3>$nombre</h3>";
                                echo "<p>$aula</p>";
								//echo "<img src='../multimedia/imagenes/icono_tick.png' alt='Foto del profesor'>";
								echo "</a>";
						}
					}
					else {
						echo "<article class='alumno'><h2>Has completado todas las tareas</h2>
						<img src='../multimedia/imagenes/icono_bien.png' alt='Foto de la tarea'></article>";
					}

					echo "<div class='botones-pantalla'><button class='boton-pantalla' id='posTareas' aria-label='Mostrar más tareas'>&#129154;</button></div>";
				?>
			</section>

			<script>
				document.addEventListener("DOMContentLoaded", function () {
					var tareasContainer = document.querySelector(".tareas");
					var tareas = document.querySelectorAll(".tarea");
					var posButton = document.getElementById("posTareas");
					var prevButton = document.getElementById("prevTareas");

					// Establece el número máximo de tareas por pantalla
					var tareasPorPantalla = 2;

					// Inicializa el estado de la pantalla
					var pantallaActual = 0;
					actualizarPantalla();

					// Escucha el evento del botón para avanzar de pantalla
					posButton.addEventListener("click", function () {
						pantallaActual++;
						actualizarPantalla();
					});

					// Escucha el evento del botón para retroceder de pantalla
					prevButton.addEventListener("click", function () {
						pantallaActual--;
						actualizarPantalla();
					});

					function actualizarPantalla() {
						var startIndex = pantallaActual * tareasPorPantalla;
						var endIndex = startIndex + tareasPorPantalla;

						// Muestra u oculta las tareas según la pantalla actual
						tareas.forEach(function (tarea, index) {
							tarea.style.display = index >= startIndex && index < endIndex ? "block" : "none";
						});

						// Muestra u oculta los botones dependiendo de si hay más pantallas
						posButton.style.visibility = endIndex < tareas.length ? "visible" : "hidden";
						prevButton.style.visibility = pantallaActual > 0 ? "visible" : "hidden";
					}

					// Actualizamos el número de tareas por pantalla al cambiar el tamaño de la ventana
					window.addEventListener("resize", function () {
						actualizarPantalla();
					});
				});
			</script>
		</main>


	</body>
</html>