<!DOCTYPE html>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Asignar tarea</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width">
		<script src="../javascript/funciones_basicas.js"></script>
		<script src="../javascript/validar_formularios.js"></script>
		<script src="../javascript/header_responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/formularios.css">
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

					// Si hay una sesión activa de administrador, mostrar el nombre de usuario y la posibilidad de cerrar sesión
					if (isset($_SESSION['admin'])) {

						// Acceder al nombre de usuario almacenado en la variable de sesión
						$username = $_SESSION['usuario'];
						$ruta_foto = $_SESSION['ruta_foto'];

						// Creamos en html la zona arriba a la derecha de un usuario que ha iniciado sesión
						echo "<div id='perfil-login'>
							<a href='../profesores/modificacion_profesores.php'>
								<div><img src='../multimedia/imagenes/$ruta_foto' width='60' height='60' alt='Foto de perfil'></div>
								<div><h2>$username</h2></div>
							</a>
						</div>";
					}
					else{		// Si no hay ninguna sesión de administrador activa
						header("Location: ../index.php");
					}
				?>
				<div id="div-titulo"><img src='../multimedia/imagenes/icono_admin.png' width='60' height='60' alt='Icono administrador'>
				<h1 id='tituloPrincipal'>Asignar Tarea</h1></div>
				<a id='enlace-header' href='../php/logout.php'><button><h3>Cerrar Sesi&oacute;n &#10008;</h3></button></a>
			</div>
		</header>

		<main>
			<?php 	
				require_once('../php/tareas.class.php');

				// Acceder a los datos de las tareas almacenadas en la variable de sesión
				// Usamos $_GET porque en este caso el indice de las tareas no compromete
				// al sistema ni a la seguridad y privacidad del mismo
				$tarea = unserialize($_SESSION['tarea'][$_GET['indice']]);

				$titulo = $tarea['titulo'];
				$tareaId = $tarea['id'];
				$indice = $_GET['indice'];

				// Creamos una instancia de tareas para el código javascript
				$tareas = new Tareas();
			?>

			<a href="../admin/admin_tareas.php" class="boton-volver" aria-label="Volver a la gestión de tareas" role="button">&#129152;</a>

			<article id="tituloSecundario">
				<img src='../multimedia/imagenes/icono_tarea.png' width='30' height='30' alt='Icono tarea'>
				<h2><?php echo $titulo; ?></h2>
			</article>
			
			<form action="../php/asignar_tarea.php" method="POST" class="formulario" id="formulario-asignar">
			<a href='../admin/modificacion_tareas.php?indice=<?php echo $indice;?>' class="boton-modificar"><button type="button"><h3>Modificar tarea</h3></button></a>
				<article class="campo">
					<fieldset id="fieldset-alumnos" name="fieldset-alumnos">
						<?php
							require_once('../php/alumnos.class.php');
							require_once('../php/tareas.class.php');

							$tmp = new Alumnos();
							$alumnos = $tmp->obtenerAlumnos();
							$_SESSION['alumno'] = array(); 			// Inicializa $_SESSION['alumno'] como una matriz vacía
							$i = 0;

							if($alumnos){
								foreach ($alumnos as $alumno) {
									$alumnosNombre[$i] = $alumno['nombre'] . ' ' . $alumno['apellidos'];
									$alumnosFoto[$i] = $alumno['ruta_foto'];
									$alumnosId[$i] = $alumno['id'];
									$fechaIni = $tareas->obtenerFechaInicio($alumnosId[$i], $tareaId);
									$fechaFin = $tareas->obtenerFechaLimite($alumnosId[$i], $tareaId);

									echo "<article class='alumno'>";

									// Guardamos en una variable de sesion el alumno correspondiente
									$_SESSION['alumno'][$i] = serialize($alumno);
									
									// Creamos todos los input de los alumnos
									echo "<img src='../multimedia/imagenes/" . $alumnosFoto[$i] . "' width='50' height='50' alt='Foto de perfil del alumno'>
									<label id='nombre-alumno'><input type='checkbox' name='alumnos_id[]' value='{$alumnosId[$i]}'>{$alumnosNombre[$i]}</label>";

									echo "<article class='campo' id='tarea-fecha'>
										<label for='fecha_ini' class='titulo-campo'>Fecha de inicio:</label>
										<input type='date' id='fecha_ini' name='fecha_ini[{$alumnosId[$i]}]' value='$fechaIni'>
										<p id='fecha_ini-incorrecto' style='display:none;'>La fecha de inicio debe contener un a&ntilde;o v&aacute;lido</p>";

									echo "<label for='fecha_fin' class='titulo-campo'>Fecha l&iacute;mite:</label>
										<input type='date' id='fecha_fin' name='fecha_fin[{$alumnosId[$i]}]' value='$fechaFin'>
										<p id='fecha_fin-incorrecto' style='display:none;'>La fecha l&iacute;mite debe contener un a&ntilde;o v&aacute;lido</p>
									</article></article>";

									$i++;
								}
							}	
							else{
								echo "<article class='alumno'><h2>No hay ning&uacute; alumno registrado</h2></article>";
							}
						?>

						<input type="number" id="tarea_id" name="tarea_id" value=<?php echo $tareaId;?> style="display:none;">
					</fieldset>
				</article>

				<article class="enviar">
					<input type="submit" value="Confirmar">
				</article>
			</form>

			<script>
				document.addEventListener("DOMContentLoaded", function() {
					// Obtenemos el id de la tarea
					var tarea_id = <?php echo json_encode($tareaId); ?>;
					
					// Obtenemos los alumnos que ya tienen asignada la tarea
					var alumnosAsignados = <?php echo json_encode($tareas->obtenerAlumnosAsignados($tareaId)); ?>;
					
					// Iterar sobre los checkboxes y marcarlos si están asignados
					var checkboxes = document.querySelectorAll('input[name="alumnos_id[]"]');
					checkboxes.forEach(function(checkbox) {
						var alumno_id = checkbox.value;
						if (alumnosAsignados.some(function(alumno) { return alumno.alumno_id == alumno_id; })) {
							checkbox.checked = true;
						}
					});
				});
			</script>
		</main>

		<footer>
		</footer>
	</body>
</html>